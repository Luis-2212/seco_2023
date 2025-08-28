<?php

require_once "conexion.php";

class ModeloCategorias {

    /*=============================================
    MOSTRAR CategoriaS (GET)
    =============================================*/
    static public function mdlMostrarCategorias($tabla, $item, $valor) {
        try {
            if ($item != null) {
                // Obtener un Categoria específico
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");
                $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            } else {
                // Obtener todos los Categorias
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY nombre_categoria ASC");
            }

            $stmt->execute();

            if ($item != null) {
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            } else {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            }

        } catch (PDOException $e) {
            error_log("Error en mdlMostrarCategorias: " . $e->getMessage());
            return $e->getMessage(); // Retorna false en caso de error
        } finally {
            if ($stmt) {
                $stmt = null; // Asegura que el statement se cierre
            }
        }
    }

    /*=============================================
    REGISTRO DE Categoria (POST)
    =============================================*/
    static public function mdlCrearCategoria($tabla, $datos) {
        try {
            // Consulta SQL para insertar un nuevo Categoria
            $stmt = Conexion::conectar()->prepare(
                "INSERT INTO 
                $tabla (nombre_categoria, descripcion) 
                VALUES (:nombre_categoria, :descripcion)"
            );

            // Vincular los parámetros
            $stmt->bindParam(":nombre_categoria", $datos["nombre_categoria"], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

            // Ejecutar la consulta SQL
            if ($stmt->execute()) {
                return "ok"; // Retornar 'ok' si la inserción fue exitosa
            } else {
                error_log("Error al crear Categoria: " . implode(" ", $stmt->errorInfo()));
                return $stmt->errorInfo(); // Retornar 'error' si hubo un problema
            }

        } catch (PDOException $e) {
            error_log("Error en mdlCrearCategoria: " . $e->getMessage());
            return $e->getMessage(); // Retornar 'error' en caso de excepción
        } finally {
            if ($stmt) {
                $stmt = null; // Cerrar la conexión y liberar recursos
            }
        }
    }

    /*=============================================
    ACTUALIZAR Categoria (PUT)
    =============================================*/
    static public function mdlEditarCategoria($tabla, $datos) {
        try {

            // Agregar "id" si no está presente
            if (!isset($datos['id'])) {
                error_log("Error en mdlEditarCategoria: 'id' no está presente en los datos.");
                return "error_no_id";
            }

            // Iniciar la construcción de la cláusula SET
            $setClauses = [];
            $bindParams = [];
            
            // Añadir los campos que vienen en $datos (excluyendo id)
            foreach ($datos as $key => $value) {
                if ($key !== 'id') {
                    $setClauses[] = "$key = :$key";
                    $bindParams[":$key"] = $value;
                }
            }

            // Si no hay campos para actualizar además del ID y fecha_actualizar, salir.
            if (empty($setClauses) && !isset($datos['fecha_actualizar'])) {
                return "no_data";
            }

           // Construir la consulta SQL
            $sql = "UPDATE $tabla SET " . implode(", ", $setClauses) . " WHERE id = :id";
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
                error_log("Error al actualizar Categoria: " . implode(" ", $stmt->errorInfo()));
                return $stmt->errorInfo();
            }

        } catch (PDOException $e) {
            error_log("Error en mdlEditarCategoria: " . $e->getMessage());
            return $e->getMessage();
        } finally {
            if ($stmt) {
                $stmt = null;
            }
        }
    }

    /*=============================================
    ELIMINAR Categoria (DELETE)
    =============================================*/
    static public function mdlEliminarCategoria($tabla, $id) {
        try {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                error_log("Error al eliminar Categoria: " . implode(" ", $stmt->errorInfo()));
                return "error";
            }

        } catch (PDOException $e) {
            error_log("Error en mdlEliminarCategoria: " . $e->getMessage());
            return "error";
        } finally {
            if ($stmt) {
                $stmt = null;
            }
        }
    }

}