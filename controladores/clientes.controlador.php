<?php

class ControladorClientes {

    /*=============================================
    MOSTRAR CLIENTE(S) (GET)
    =============================================*/
    static public function ctrMostrarClientes($item = null, $valor = null) {
        try {
            include "../modelos/clientes.modelo.php";
            $respuesta = ModeloClientes::mdlMostrarClientes("clientes", $item, $valor);
            
            if ($item !== null && $valor !== null && !$respuesta) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "Cliente no encontrado."
                ];
            }

            return [
                "status" => 200,
                "success" => true,
                "data" => $respuesta
            ];
            
        } catch (Exception $e) {
            error_log("Error en ctrMostrarClientes: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    CREAR CLIENTE (POST)
    =============================================*/
    static public function ctrCrearCliente($datos) {
        include "../modelos/clientes.modelo.php";
        try {

			// Verificar si el nombre de Cliente ya existe
            $clienteExistente = ModeloClientes::mdlMostrarClientes("clientes", "identificacion", $datos['identificacion']);
            if ($clienteExistente) {
                return [
                    "status" => 409,
                    "success" => false,
                    "message" => "Ya existe un cliente con esta CI o RIF"
                ];
            }

            $datosCliente = [
                'nombres' => $datos['nombres'],
                'razon_social' => $datos['razon_social'],
                'tipo_identificacion' => $datos['tipo_identificacion'],
                'identificacion' => $datos['identificacion'],
                'direccion' => $datos['direccion'],
                'codigo_pais' => $datos['codigo_pais'],
                'telefono' => $datos['telefono'],
                'correo' => $datos['correo']
            ];

            $respuesta = ModeloClientes::mdlCrearCliente("clientes", $datosCliente);

            if ($respuesta === "ok") {
                return [
                    "status" => 201,
                    "success" => true,
                    "message" => "Cliente creado exitosamente."
                ];
            } else {
                error_log("Error en ModeloClientes::mdlCrearCliente: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo crear el Cliente. Inténtalo de nuevo.",
					"error" => "Error en ModeloClientes::mdlCrearCliente: " . $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrCrearCliente: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ACTUALIZAR CLIENTE (PUT)
    =============================================*/
    static public function ctrEditarCliente($datos) {
        try {
            include "../modelos/clientes.modelo.php";

            $userIdToUpdate = isset($datos['id']) ? $datos['id'] : null;

			// Sí no se envió ningún ID a editar
            if ($userIdToUpdate === null) {
				return [
                    "status" => 400,
                    "success" => false,
                    "message" => "El ID del Cliente es requerido para la actualización."
                ];
            }
            
            date_default_timezone_set('America/Caracas');
            $datos['fecha_actualizacion'] = date('Y-m-d H:i:s');

            $respuesta = ModeloClientes::mdlEditarCliente("clientes", $datos);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Cliente actualizado correctamente."
                ];
            } else {
                error_log("Error en ModeloClientes::mdlEditarCliente: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo actualizar el Cliente. Inténtalo de nuevo.",
                    "error" => $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEditarCliente: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ELIMINAR CLIENTE (DELETE)
    =============================================*/
    static public function ctrEliminarCliente($id) {
        try {
            include "../modelos/clientes.modelo.php";
            
            $clienteExistente = ModeloClientes::mdlMostrarClientes("clientes", "id", $id);
            if (!$clienteExistente) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "El Cliente a eliminar no fue encontrado."
                ];
            }

            $respuesta = ModeloClientes::mdlEliminarCliente("clientes", $id);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Cliente eliminado correctamente."
                ];
            } else {
                error_log("Error en ModeloClientes::mdlEliminarCliente: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo eliminar el Cliente. Inténtalo de nuevo."
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEliminarCliente: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }
}