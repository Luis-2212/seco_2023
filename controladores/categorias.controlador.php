<?php

class ControladorCategorias {

    /*============================================
    MOSTRAR CATEGORIA(S) (GET)
    =============================================*/
    static public function ctrMostrarCategorias($item = null, $valor = null) {
        try {
            include "../modelos/categorias.modelo.php";
            $respuesta = ModeloCategorias::mdlMostrarCategorias("categorias", $item, $valor);
            
            if ($item !== null && $valor !== null && !$respuesta) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "Categoria no encontrado."
                ];
            }

            return [
                "status" => 200,
                "success" => true,
                "data" => $respuesta
            ];
            
        } catch (Exception $e) {
            error_log("Error en ctrMostrarCategorias: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    CREAR Categoria (POST)
    =============================================*/
    static public function ctrCrearCategoria($datos) {
        include "../modelos/categorias.modelo.php";
        try {

			// Verificar si el nombre de Categoria ya existe
            $categoriaExistente = ModeloCategorias::mdlMostrarCategorias("categorias", "nombre_categoria", $datos['nombre_categoria']);
            if ($categoriaExistente) {
                return [
                    "status" => 409,
                    "success" => false,
                    "message" => "Ya existe esta categoría."
                ];
            }

            $datosCategoria = [
                'nombre_categoria' => $datos['nombre_categoria'],
                'descripcion' => $datos['descripcion'],
            ];

            $respuesta = ModeloCategorias::mdlCrearCategoria("categorias", $datosCategoria);

            if ($respuesta === "ok") {
                return [
                    "status" => 201,
                    "success" => true,
                    "message" => "Categoría creada exitosamente."
                ];
            } else {
                error_log("Error en ModeloCategorias::mdlCrearCategoria: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo crear la Categoria. Inténtalo de nuevo.",
					"error" => "Error en ModeloCategorias::mdlCrearCategoria: " . $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrCrearCategoria: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ACTUALIZAR Categoria (PUT)
    =============================================*/
    static public function ctrEditarCategoria($datos) {
        try {
            include "../modelos/categorias.modelo.php";

            $userIdToUpdate = isset($datos['id']) ? $datos['id'] : null;

			// Sí no se envió ningún ID a editar
            if ($userIdToUpdate === null) {
				return [
                    "status" => 400,
                    "success" => false,
                    "message" => "El ID del Categoria es requerido para la actualización."
                ];
            }
            
            date_default_timezone_set('America/Caracas');
            $datos['fecha_actualizacion'] = date('Y-m-d H:i:s');

            $respuesta = ModeloCategorias::mdlEditarCategoria("categorias", $datos);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Categoría actualizada correctamente."
                ];
            } else {
                error_log("Error en ModeloCategorias::mdlEditarCategoria: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo actualizar la Categoria. Inténtalo de nuevo.",
                    "error" => $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEditarCategoria: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ELIMINAR Categoria (DELETE)
    =============================================*/
    static public function ctrEliminarCategoria($id) {
        try {
            include "../modelos/categorias.modelo.php";
            
            $categoriaExistente = ModeloCategorias::mdlMostrarCategorias("categorias", "id", $id);
            if (!$categoriaExistente) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "El Categoria a eliminar no fue encontrado."
                ];
            }

            $respuesta = ModeloCategorias::mdlEliminarCategoria("categorias", $id);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Categoria eliminado correctamente."
                ];
            } else {
                error_log("Error en ModeloCategorias::mdlEliminarCategoria: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo eliminar el Categoria. Inténtalo de nuevo."
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEliminarCategoria: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }
}