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
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY rol ASC");
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
                $tabla (rol, descripcion) 
                VALUES (:rol, :descripcion)"
            );

            // Vincular los parámetros
            $stmt->bindParam(":rol", $datos["rol"], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

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
        } finally {
            if ($stmt) {
                $stmt = null; // Cerrar la conexión y liberar recursos
            }
        }
    }

}