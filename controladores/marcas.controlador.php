<?php

class ControladorMarcas {

    /*============================================
    MOSTRAR MARCA(S) (GET)
    =============================================*/
    static public function ctrMostrarMarcas($item = null, $valor = null) {
        try {
            include "../modelos/marcas.modelo.php";
            $respuesta = ModeloMarcas::mdlMostrarMarcas("marcas", $item, $valor);
            
            if ($item !== null && $valor !== null && !$respuesta) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "Marca no encontrado."
                ];
            }

            return [
                "status" => 200,
                "success" => true,
                "data" => $respuesta
            ];
            
        } catch (Exception $e) {
            error_log("Error en ctrMostrarMarca: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    CREAR MARCA (POST)
    =============================================*/
    static public function ctrCrearMarca($datos) {
        include "../modelos/marcas.modelo.php";
        try {

			// Verificar si el nombre de la Marca ya existe
            $marcaExistente = ModeloMarcas::mdlMostrarMarcas("marcas", "nombre_marca", $datos['nombre_marca']);
            if ($marcaExistente) {
                return [
                    "status" => 409,
                    "success" => false,
                    "message" => "Ya existe esta marca."
                ];
            }

            $datosMarca = [
                'nombre_marca' => $datos['nombre_marca'],
            ];

            $respuesta = ModeloMarcas::mdlCrearMarca("marcas", $datosMarca);

            if ($respuesta === "ok") {
                return [
                    "status" => 201,
                    "success" => true,
                    "message" => "Marca creada exitosamente."
                ];
            } else {
                error_log("Error en ModeloMarcas::mdlCrearMarca: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo crear la Marca. Inténtalo de nuevo.",
					"error" => "Error en ModeloMarcas::mdlCrearMarca: " . $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrCrearMarca: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ACTUALIZAR MARCA (PUT)
    =============================================*/
    static public function ctrEditarMarca($datos) {
        try {
            include "../modelos/marcas.modelo.php";

            $userIdToUpdate = isset($datos['id']) ? $datos['id'] : null;

			// Sí no se envió ningún ID a editar
            if ($userIdToUpdate === null) {
				return [
                    "status" => 400,
                    "success" => false,
                    "message" => "El ID del Marca es requerido para la actualización."
                ];
            }
            
            date_default_timezone_set('America/Caracas');
            $datos['fecha_actualizacion'] = date('Y-m-d H:i:s');

            $respuesta = ModeloMarcas::mdlEditarMarca("marcas", $datos);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Marca actualizada correctamente."
                ];
            } else {
                error_log("Error en ModeloMarcas::mdlEditarMarca: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo actualizar la Marca. Inténtalo de nuevo.",
                    "error" => $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEditarMarca: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ELIMINAR MARCA (DELETE)
    =============================================*/
    static public function ctrEliminarMarca($id) {
        try {
            include "../modelos/marcas.modelo.php";
            
            $MarcaExistente = ModeloMarcas::mdlMostrarMarcas("marcas", "id", $id);
            if (!$MarcaExistente) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "El Marca a eliminar no fue encontrado."
                ];
            }

            $respuesta = ModeloMarcas::mdlEliminarMarca("marcas", $id);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Marca eliminado correctamente."
                ];
            } else {
                error_log("Error en ModeloMarcas::mdlEliminarMarca: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo eliminar el Marca. Inténtalo de nuevo."
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEliminarMarca: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }
}