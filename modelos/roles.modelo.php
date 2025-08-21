<?php

require_once "conexion.php";

class ModeloRoles {

    /*=============================================
    MOSTRAR ROLES (GET)
    =============================================*/
    static public function mdlMostrarRoles($tabla, $item, $valor) {
        try {
            if ($item != null) {
                // Obtener un Rol específico
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");
                $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
            } else {
                // Obtener todos los Roles
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");
            }

            $stmt->execute();

            if ($item != null) {
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            } else {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            }

        } catch (PDOException $e) {
            error_log("Error en mdlMostrarRoles: " . $e->getMessage());
            return false; // Retorna false en caso de error
        } finally {
            if ($stmt) {
                $stmt = null; // Asegura que el statement se cierre
            }
        }
    }

    /*=============================================
    REGISTRO DE ROL (POST)
    =============================================*/
    static public function mdlCrearRol($tabla, $datos) {
        try {
            // Consulta SQL para insertar un nuevo Rol
            $stmt = Conexion::conectar()->prepare(
                "INSERT INTO 
                $tabla (rol, decripcion) 
                VALUES (:rol, :decripcion)"
            );

            // Vincular los parámetros
            $stmt->bindParam(":rol", $datos["rol"], PDO::PARAM_INT);
            $stmt->bindParam(":decripcion", $datos["decripcion"], PDO::PARAM_STR);

            // Ejecutar la consulta SQL
            if ($stmt->execute()) {
                return "ok"; // Retornar 'ok' si la inserción fue exitosa
            } else {
                error_log("Error al crear Rol: " . implode(" ", $stmt->errorInfo()));
                return "error"; // Retornar 'error' si hubo un problema
            }

        } catch (PDOException $e) {
            error_log("Error en mdlCrearRol: " . $e->getMessage());
            return "error"; // Retornar 'error' en caso de excepción
            // return "error"; // Retornar 'error' en caso de excepción
        } finally {
            if ($stmt) {
                $stmt = null; // Cerrar la conexión y liberar recursos
            }
        }
    }

    /*=============================================
    ACTUALIZAR ROL (PUT)
    =============================================*/
    static public function mdlEditarRol($tabla, $datos) {
        try {

            // Agregar "user_id" si no está presente
            if (!isset($datos['user_id'])) {
                error_log("Error en mdlEditarRol: 'user_id' no está presente en los datos.");
                return "error_no_user_id";
            }

            // Iniciar la construcción de la cláusula SET
            $setClauses = [];
            $bindParams = [];
            
            // Añadir los campos que vienen en $datos (excluyendo user_id)
            foreach ($datos as $key => $value) {
                if ($key !== 'user_id') {
                    $setClauses[] = "$key = :$key";
                    $bindParams[":$key"] = $value;
                }
            }

            // Si no hay campos para actualizar además del ID y updated_at, salir.
            if (empty($setClauses) && !isset($datos['updated_at'])) {
                return "no_data";
            }

           // Construir la consulta SQL
            $sql = "UPDATE $tabla SET " . implode(", ", $setClauses) . " WHERE user_id = :user_id";
            $stmt = Conexion::conectar()->prepare($sql);

            // Vincular los parámetros dinámicamente
            foreach ($bindParams as $param => $value) {
                $paramType = PDO::PARAM_STR;
                if (is_int($value)) {
                    $paramType = PDO::PARAM_INT;
                } elseif (is_bool($value)) {
                    $paramType = PDO::PARAM_BOOL;
                } elseif (is_null($value)) {
                    $paramType = PDO::PARAM_NULL;
                }
                $stmt->bindValue($param, $value, $paramType);
            }

            // Vincular 'id' 
            $stmt->bindValue(":id", $datos['id'], PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return "ok";
            } else {
                error_log("Error al actualizar Rol: " . implode(" ", $stmt->errorInfo()));
                return "error";
            }

        } catch (PDOException $e) {
            error_log("Error en mdlEditarRol: " . $e->getMessage());
            return "error";
        } finally {
            if ($stmt) {
                $stmt = null;
            }
        }
    }

    /*=============================================
    ELIMINAR ROL (DELETE)
    =============================================*/
    static public function mdlEliminarRol($tabla, $id) {
        try {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                error_log("Error al eliminar Rol: " . implode(" ", $stmt->errorInfo()));
                return "error";
            }

        } catch (PDOException $e) {
            error_log("Error en mdlEliminarRol: " . $e->getMessage());
            return "error";
        } finally {
            if ($stmt) {
                $stmt = null;
            }
        }
    }

}