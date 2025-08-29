<?php

class ControladorProductos {

    /*=============================================
    MOSTRAR PRODUCTO(S) (GET)
    =============================================*/
    static public function ctrMostrarProductos($item = null, $valor = null) {
        try {
            include "../modelos/productos.modelo.php";
            $respuesta = ModeloProductos::mdlMostrarProductos("productos", $item, $valor);
            
            if ($item !== null && $valor !== null && !$respuesta) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "Producto no encontrado."
                ];
            }

            return [
                "status" => 200,
                "success" => true,
                "data" => $respuesta
            ];
            
        } catch (Exception $e) {
            error_log("Error en ctrMostrarProductos: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    CONSULTAR PRODUCTOS (GET)
    =============================================*/
    static public function ctrConsultarProductos($valor = null) {
        try {
            include "../modelos/productos.modelo.php";
            $respuesta = ModeloProductos::mdlConsultarProductos("productos", $valor);
            
            if (!$respuesta) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "Producto no encontrado."
                ];
            }

            return [
                "status" => 200,
                "success" => true,
                "data" => $respuesta
            ];
            
        } catch (Exception $e) {
            error_log("Error en ctrConsultarProductos: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    CREAR Producto (POST)
    =============================================*/
    static public function ctrCrearProducto($datos) {
        include "../modelos/productos.modelo.php";
        try {

            $datosProducto = [
                'nombre' => $datos['nombre'],
                'id_categoria' => $datos['id_categoria'],
                'id_marca' => $datos['id_marca'],
                'descripcion' => $datos['descripcion'],
                'unidad_medida' => $datos['unidad_medida'],
                'stock' => $datos['stock'],
                'precio_compra' => $datos['precio_compra'],
                'precio_venta' => $datos['precio_venta'],
                'estado' => $datos['estado']
            ];

            $respuesta = ModeloProductos::mdlCrearProducto("productos", $datosProducto);

            if ($respuesta === "ok") {
                return [
                    "status" => 201,
                    "success" => true,
                    "message" => "Producto creado exitosamente."
                ];
            } else {
                error_log("Error en ModeloProductos::mdlCrearProducto: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo crear el Producto. Inténtalo de nuevo.",
					"error" => "Error en ModeloProductos::mdlCrearProducto: " . $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrCrearProducto: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ACTUALIZAR PRODUCTO (PUT)
    =============================================*/
    static public function ctrEditarProducto($datos) {
        try {
            include "../modelos/productos.modelo.php";

            $userIdToUpdate = isset($datos['id']) ? $datos['id'] : null;

			// Sí no se envió ningún ID a editar
            if ($userIdToUpdate === null) {
				return [
                    "status" => 400,
                    "success" => false,
                    "message" => "El ID del Producto es requerido para la actualización."
                ];
            }
            
            date_default_timezone_set('America/Caracas');
            $datos['fecha_actualizacion'] = date('Y-m-d H:i:s');

            $respuesta = ModeloProductos::mdlEditarProducto("productos", $datos);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Producto actualizado correctamente."
                ];
            } else {
                error_log("Error en ModeloProductos::mdlEditarProducto: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo actualizar el Producto. Inténtalo de nuevo.",
                    "error" => $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEditarProducto: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ELIMINAR PRODUCTO (DELETE)
    =============================================*/
    static public function ctrEliminarProducto($id) {
        try {
            include "../modelos/productos.modelo.php";
            
            $productosExistente = ModeloProductos::mdlMostrarProductos("productos", "id", $id);
            if (!$productosExistente) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "El Producto a eliminar no fue encontrado."
                ];
            }

            $respuesta = ModeloProductos::mdlEliminarProducto("productos", $id);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Producto eliminado correctamente."
                ];
            } else {
                error_log("Error en ModeloPRoductos::mdlEliminarProducto: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo eliminar el Producto. Inténtalo de nuevo."
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEliminarProducto: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }
}