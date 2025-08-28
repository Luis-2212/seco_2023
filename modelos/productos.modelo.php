<?php

require_once "conexion.php";

class ModeloProductos {

    /*=============================================
    MOSTRAR Productos (GET)
    =============================================*/
    static public function mdlMostrarProductos($tabla, $item, $valor) {
        try {
            if ($item != null) {
                // Obtener un Productos específico
                $stmt = Conexion::conectar()->prepare(
                                                "SELECT 
                                                    p.id,
                                                    c.nombre_categoria,
                                                    m.nombre_marca,
                                                    p.nombre,
                                                    p.descripcion,
                                                    p.unidad_medida,
                                                    p.stock,
                                                    p.precio_compra,
                                                    p.precio_venta,
                                                    p.estado,
                                                    p.fecha_creacion,
                                                    p.fecha_actualizacion
                                                FROM $tabla as p
                                                LEFT JOIN categorias as c
                                                ON c.id = p.id_categoria
                                                LEFT JOIN marcas as m
                                                ON m.id = p.id_marca
                                                WHERE p.$item = :valor");
                $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);

            } else {
                // Obtener todos los Productos
                $stmt = Conexion::conectar()->prepare(
                                                "SELECT 
                                                    p.id,
                                                    c.nombre_categoria,
                                                    m.nombre_marca,
                                                    p.nombre,
                                                    p.descripcion,
                                                    p.unidad_medida,
                                                    p.stock,
                                                    p.precio_compra,
                                                    p.precio_venta,
                                                    p.estado,
                                                    p.fecha_creacion,
                                                    p.fecha_actualizacion
                                                FROM $tabla as p
                                                LEFT JOIN categorias as c
                                                ON c.id = p.id_categoria
                                                LEFT JOIN marcas as m
                                                ON m.id = p.id_marca
                                                ORDER BY p.nombre ASC");
            }

            $stmt->execute();

            if ($item != null) {
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            } else {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            }

        } catch (PDOException $e) {
            error_log("Error en mdlMostrarProductos: " . $e->getMessage());
            return $e->getMessage(); // Retorna false en caso de error
        } finally {
            if ($stmt) {
                $stmt = null; // Asegura que el statement se cierre
            }
        }
    }

    /*=============================================
    REGISTRO DE Productos (POST)
    =============================================*/
    static public function mdlCrearProducto($tabla, $datos) {
        try {
            // Consulta SQL para insertar un nuevo Productos
            $stmt = Conexion::conectar()->prepare(
                "INSERT INTO 
                $tabla (nombres, razon_social, tipo_identificacion, identificacion, direccion, codigo_pais, telefono, correo) 
                VALUES (:nombres, :razon_social, :tipo_identificacion, :identificacion, :direccion, :codigo_pais, :telefono, :correo)"
            );

            // Vincular los parámetros
            $stmt->bindParam(":nombres", $datos["nombres"], PDO::PARAM_STR);
            $stmt->bindParam(":razon_social", $datos["razon_social"], PDO::PARAM_STR);
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
                error_log("Error al crear Producto: " . implode(" ", $stmt->errorInfo()));
                return $stmt->errorInfo(); // Retornar 'error' si hubo un problema
            }

        } catch (PDOException $e) {
            error_log("Error en mdlCrearProducto: " . $e->getMessage());
            return $e->getMessage(); // Retornar 'error' en caso de excepción
        } finally {
            if ($stmt) {
                $stmt = null; // Cerrar la conexión y liberar recursos
            }
        }
    }

    /*=============================================
    ACTUALIZAR Productos (PUT)
    =============================================*/
    static public function mdlEditarProducto($tabla, $datos) {
        try {

            // Agregar "id" si no está presente
            if (!isset($datos['id'])) {
                error_log("Error en mdlEditarProducto: 'id' no está presente en los datos.");
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
                error_log("Error al actualizar Producto: " . implode(" ", $stmt->errorInfo()));
                return $stmt->errorInfo();
            }

        } catch (PDOException $e) {
            error_log("Error en mdlEditarProducto: " . $e->getMessage());
            return $e->getMessage();
        } finally {
            if ($stmt) {
                $stmt = null;
            }
        }
    }

    /*=============================================
    ELIMINAR Producto (DELETE)
    =============================================*/
    static public function mdlEliminarProducto($tabla, $id) {
        try {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            } else {
                error_log("Error al eliminar Producto: " . implode(" ", $stmt->errorInfo()));
                return "error";
            }

        } catch (PDOException $e) {
            error_log("Error en mdlEliminarProducto: " . $e->getMessage());
            return "error";
        } finally {
            if ($stmt) {
                $stmt = null;
            }
        }
    }

}