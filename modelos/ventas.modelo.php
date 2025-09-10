<?php

require_once "conexion.php";

class ModeloVentas {

    /*=============================================
    MOSTRAR VENTA(S) (GET)
    =============================================*/
    static public function mdlMostrarVentas($tabla, $item, $valor) {
        try {
            if ($item != null) {
                // Obtener un Venta específico
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");
                $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            } else {
                // Obtener todos los Venta
                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha_creacion DESC");
            }

            $stmt->execute();

            if ($item != null) {
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            } else {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            }

        } catch (PDOException $e) {
            error_log("Error en mdlMostrarVentas: " . $e->getMessage());
            return $e->getMessage(); // Retorna false en caso de error
        } finally {
            if ($stmt) {
                $stmt = null; // Asegura que el statement se cierre
            }
        }
    }

    /*=============================================
    GENERAR VENTA (POST)
    =============================================*/
    static public function mdlGenerarVenta($tabla, $datos) {
        try {
            // Consulta SQL para insertar un nuevo Venta
            $stmt = Conexion::conectar()->prepare(
                "INSERT INTO 
                $tabla (id_usuario, id_cliente, lista_productos, codigo_recibo, impuesto, valor_neto, valor_total) 
                VALUES (:id_usuario, :id_cliente, :lista_productos, :codigo_recibo, :impuesto, :valor_neto, :valor_total)"
            );

            // Vincular los parámetros
            $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
            $stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
            $stmt->bindParam(":lista_productos", $datos["lista_productos"], PDO::PARAM_STR);
            $stmt->bindParam(":codigo_recibo", $datos["codigo_recibo"], PDO::PARAM_STR);
            $stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
            $stmt->bindParam(":valor_neto", $datos["valor_neto"], PDO::PARAM_STR);
            $stmt->bindParam(":valor_total", $datos["valor_total"], PDO::PARAM_STR);

            // Ejecutar la consulta SQL
            if ($stmt->execute()) {
                return "ok"; // Retornar 'ok' si la inserción fue exitosa
            } else {
                error_log("Error al crear Venta: " . implode(" ", $stmt->errorInfo()));
                return $stmt->errorInfo(); // Retornar 'error' si hubo un problema
            }

        } catch (PDOException $e) {
            error_log("Error en mdlGenerarVenta: " . $e->getMessage());
            return $e->getMessage(); // Retornar 'error' en caso de excepción
        } finally {
            if ($stmt) {
                $stmt = null; // Cerrar la conexión y liberar recursos
            }
        }
    }

}