<?php

class ControladorProveedores {

    /*=============================================
    MOSTRAR PROVEEDORES(S) (GET)
    =============================================*/
    static public function ctrMostrarProveedores($item = null, $valor = null) {
        try {
            include "../modelos/proveedores.modelo.php";
            $respuesta = ModeloProveedores::mdlMostrarProveedores("proveedores", $item, $valor);
            
            if ($item !== null && $valor !== null && !$respuesta) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "Proveedor no encontrado."
                ];
            }

            return [
                "status" => 200,
                "success" => true,
                "data" => $respuesta
            ];
            
        } catch (Exception $e) {
            error_log("Error en ctrMostrarProveedores: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    CREAR PROVEEDOR(POST)
    =============================================*/
    static public function ctrCrearProveedor($datos) {
        include "../modelos/proveedores.modelo.php";
        try {

			// Verificar si el nombre de Proveedor ya existe
            $proveedorExistente = ModeloProveedores::mdlMostrarProveedores("proveedor", "identificacion", $datos['identificacion']);
            if ($proveedorExistente) {
                return [
                    "status" => 409,
                    "success" => false,
                    "message" => "Ya existe un proveedor con esta CI o RIF"
                ];
            }

            $datosProveedor = [
                'nombres' => $datos['nombres'],
                'razon_social' => $datos['razon_social'],
                'tipo_identificacion' => $datos['tipo_identificacion'],
                'identificacion' => $datos['identificacion'],
                'direccion' => $datos['direccion'],
                'codigo_pais' => $datos['codigo_pais'],
                'telefono' => $datos['telefono'],
                'correo' => $datos['correo']
            ];

            $respuesta = ModeloProveedores::mdlCrearProveedor("proveedores", $datosProveedor);

            if ($respuesta === "ok") {
                return [
                    "status" => 201,
                    "success" => true,
                    "message" => "proveedor creado exitosamente."
                ];
            } else {
                error_log("Error en ModeloProveedores::mdlCrearProveedor: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo crear el Proveedor. Inténtalo de nuevo.",
					"error" => "Error en ModeloProveedores::mdlCrearProveedor: " . $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrCrearProveedor: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ACTUALIZAR PROVEEDOR (PUT)
    =============================================*/
    static public function ctrEditarProveedor($datos) {
        try {
            include "../modelos/Proveedores.modelo.php";

            $userIdToUpdate = isset($datos['id']) ? $datos['id'] : null;

			// Sí no se envió ningún ID a editar
            if ($userIdToUpdate === null) {
				return [
                    "status" => 400,
                    "success" => false,
                    "message" => "El ID del proveedor es requerido para la actualización."
                ];
            }
            
			// No se puede modificar el Proveedor master
            if ($userIdToUpdate == 1) {
                return [
                    "status" => 403,
                    "success" => false,
                    "message" => "No se permite modificar este Proveedor."
                ];
            }

            // Clave del elemento que deseas eliminar
            $valorARemover = 'password';

            // Verificar si la clave existe en el JSON
            if (array_key_exists($valorARemover, $datos) && ($datos[$valorARemover] === null || $datos[$valorARemover] === '')) {
                unset($datos[$valorARemover]); // Eliminar el elemento
            } 

            // Encriptar nueva contraseña
            if (isset($datos['password']) && !empty($datos['password'])) {
                $datos['password'] = password_hash($datos['password'], PASSWORD_BCRYPT);
            }

            date_default_timezone_set('America/Caracas');
            $datos['fecha_actualizacion'] = date('Y-m-d H:i:s');

            $respuesta = ModeloProveedores::mdlEditarProveedor("proveedores", $datos);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Proveedor actualizado correctamente."
                ];
            } else {
                error_log("Error en ModeloProveedores::mdlEditarProveedor: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo actualizar el Proveedor. Inténtalo de nuevo.",
                    "error" => $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEditarProveedor: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ELIMINAR PROVEEDOR (DELETE)
    =============================================*/
    static public function ctrEliminarProveedor($id) {
        try {
            include "../modelos/proveedores.modelo.php";
            if ($id == 1) {
                return [
                    "status" => 403,
                    "success" => false,
                    "message" => "No se permite eliminar este Proveedor."
                ];
            }
            
            $proveedorExistente = ModeloProveedores::mdlMostrarProveedores("proveedores", "id", $id);
            if (!$proveedorExistente) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "El Proveedor a eliminar no fue encontrado."
                ];
            }

            $respuesta = ModeloProveedores::mdlEliminarProveedor("Proveedores", $id);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Proveedor eliminado correctamente."
                ];
            } else {
                error_log("Error en ModeloProveedores::mdlEliminarProveedor: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo eliminar el Proveedor. Inténtalo de nuevo."
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEliminarProveedor: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }
}