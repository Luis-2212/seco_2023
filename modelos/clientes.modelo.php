<?php

require_once "conexion.php";

class ModeloClientes {

    /*=============================================
    MOSTRAR CLIENTES (GET)
    =============================================*/
    static public function mdlMostrarClientes($tabla, $item, $valor) {
        try {
            if ($item != null) {
                // Obtener un Cliente específico
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");
                $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            } else {
                // Obtener todos los Clientes
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY nombres ASC");
            }

            $stmt->execute();

            if ($item != null) {
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            } else {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            }

        } catch (PDOException $e) {
            error_log("Error en mdlMostrarClientes: " . $e->getMessage());
            return $e->getMessage(); // Retorna false en caso de error
        } finally {
            if ($stmt) {
                $stmt = null; // Asegura que el statement se cierre
            }
        }
    }

    /*=============================================
    CONSULTAR CLIENTES (GET)
    =============================================*/
    static public function mdlConsultarClientes($tabla, $valor) {
        try {

            // Obtener todos los CLIENTES
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE (identificacion LIKE '%$valor%')");

        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 

        } catch (PDOException $e) {
            error_log("Error en mdlConsultarClientes: " . $e->getMessage());
            return $e->getMessage(); // Retorna false en caso de error
        } finally {
            if ($stmt) {
                $stmt = null; // Asegura que el statement se cierre
            }
        }
    }

    /*=============================================
    REGISTRO DE CLIENTE (POST)
    =============================================*/
    static public function mdlCrearCliente($tabla, $datos) {
        try {
            // Consulta SQL para insertar un nuevo Cliente
            $stmt = Conexion::conectar()->prepare(
                "INSERT INTO 
                $tabla (nombres, tipo_identificacion, identificacion, direccion, codigo_pais, telefono, correo) 
                VALUES (:nombres, :tipo_identificacion, :identificacion, :direccion, :codigo_pais, :telefono, :correo)"
            );

            // Vincular los parámetros
            $stmt->bindParam(":nombres", $datos["nombres"], PDO::PARAM_STR);
            $stmt->bindParam(":tipo_identificacion", $datos["tipo_identificacion"], PDO::PARAM_STR);
            $stmt->bindParam(":identificacion", $datos["identificacion"], PDO::PARAM_INT);
            $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
            $stmt->bindParam(":codigo_pais", $datos["codigo_pais"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_INT);
            $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);

            // Ejecutar la consulta SQL
            if ($stmt->execute()) {
                return "ok"; // Retornar 'ok' si la inserción fue exitosa
            } else {
                error_log("Error al crear Cliente: " . implode(" ", $stmt->errorInfo()));
                return $stmt->errorInfo(); // Retornar 'error' si hubo un problema
            }

        } catch (PDOException $e) {
            error_log("Error en mdlCrearCliente: " . $e->getMessage());
            return $e->getMessage(); // Retornar 'error' en caso de excepción
        } finally {
            if ($stmt) {
                $stmt = null; // Cerrar la conexión y liberar recursos
            }
        }
    }

    /*=============================================
    ACTUALIZAR CLIENTE (PUT)
    =============================================*/
    static public function mdlEditarCliente($tabla, $datos) {
        try {

            // Agregar "id" si no está presente
            if (!isset($datos['id'])) {
                error_log("Error en mdlEditarCliente: 'id' no está presente en los datos.");
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
                error_log("Error al actualizar Cliente: " . implode(" ", $stmt->errorInfo()));
                return $stmt->errorInfo();
            }

        } catch (PDOException $e) {
            error_log("Error en mdlEditarCliente: " . $e->getMessage());
            return $e->getMessage();
        } finally {
            if ($stmt) {
                $stmt = null;
            }
        }
    }

    /*=============================================
    ELIMINAR CLIENTE (DELETE)
    =============================================*/
    static public function mdlEliminarCliente($tabla, $id) {
        try {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                error_log("Error al eliminar Cliente: " . implode(" ", $stmt->errorInfo()));
                return "error";
            }

        } catch (PDOException $e) {
            error_log("Error en mdlEliminarCliente: " . $e->getMessage());
            return "error";
        } finally {
            if ($stmt) {
                $stmt = null;
            }
        }
    }

}