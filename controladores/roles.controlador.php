<?php


class ControladorRoles {
	
	/*=============================================
    MOSTRAR ROL(ES) (GET)
    =============================================*/
    static public function ctrMostrarRoles($item = null, $valor = null) {
		require_once "../modelos/roles.modelo.php";
		try {
            $respuesta = ModeloRoles::mdlMostrarRoles("roles", $item, $valor);
            
            if ($item !== null && $valor !== null && !$respuesta) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "Rol no encontrado."
                ];
            }

            return [
                "status" => 200,
                "success" => true,
                "data" => $respuesta
            ];
            
        } catch (Exception $e) {
            error_log("Error en ctrMostrarRoles: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    CREAR ROL (POST)
    =============================================*/
    static public function ctrCrearRol($datos) {
        try {
			// Validar campos requeridos
            $camposRequeridos = ['rol', 'descripcion'];
            foreach ($camposRequeridos as $campo) {
                if (empty($datos[$campo])) {
                    return [
                        "status" => 400,
                        "success" => false,
                        "message" => "El campo '$campo' es requerido."
                    ];
                }
            }

			// Verificar si el nombre de roles ya existe
            $rolesExistente = ModeloRoles::mdlMostrarRoles("roles", "rol", $datos['rol']);
            if ($rolesExistente) {
                return [
                    "status" => 409,
                    "success" => false,
                    "message" => "El nombre de roles ya está en uso. Por favor, elige otro."
                ];
            }

            $datosRol = [
                'rol' => $datos['rol'],
                'descripcion' => $datos['descripcion']
            ];

            $respuesta = ModeloRoles::mdlCrearRol("roles", $datosRol);

            if ($respuesta === "ok") {
                return [
                    "status" => 201,
                    "success" => true,
                    "message" => "Rol creado exitosamente."
                ];
            } else {
                error_log("Error en ModeloRoles::mdlCrearRol: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo crear el Rol. Inténtalo de nuevo.",
					"error" => "Error en ModeloRoles::mdlCrearRol: " . $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrCrearRol: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ACTUALIZAR ROL (PUT)
    =============================================*/
    static public function ctrEditarRol($datos) {
        try {
            $userIdToUpdate = isset($datos['id']) ? $datos['id'] : null;

			// Sí no se envió ningún ID a editar
            if ($userIdToUpdate === null) {
				return [
                    "status" => 400,
                    "success" => false,
                    "message" => "El ID del Rol es requerido para la actualización."
                ];
            }
            
			// No se puede modificar el Rol master
            if ($userIdToUpdate == 1) {
                return [
                    "status" => 403,
                    "success" => false,
                    "message" => "No se permite modificar este Rol."
                ];
            }

            // Sólo el Administrador (master) puede editar usuarios
            if ($GLOBALS['user_id'] != 1) {
				return [ "status" => 403, "success" => false, "message" => "No tienes permiso para editar este usuario."];
            }

            if (isset($datos['password']) && !empty($datos['password'])) {
                $datos['password'] = password_hash($datos['password'], PASSWORD_BCRYPT);
            }

            if (isset($datos['id'])) {
                $datos['user_id'] = $datos['id'];
                unset($datos['id']);
            }
            
            date_default_timezone_set('America/Caracas');
            $datos['updated_at'] = date('Y-m-d H:i:s');

            $respuesta = ModeloUsuarios::mdlEditarUsuario("users", $datos);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Usuario actualizado correctamente."
                ];
            } else {
                error_log("Error en ModeloUsuarios::mdlEditarUsuario: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo actualizar el usuario. Inténtalo de nuevo. $respuesta"
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEditarUsuario: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ACTUALIZAR STATUS (PATCH)
    =============================================*/
    static public function ctrActualizarStatusUsuario($user_id, $status) {
        try {
            if ($user_id == 1) {
                return [
                    "status" => 403,
                    "success" => false,
                    "message" => "No se permite modificar este usuario."
                ];
            }

            if (!in_array($status, ["0", "1"])) {
                return [
                    "status" => 400,
                    "success" => false,
                    "message" => "El valor para el status no es válido."
                ];
            }

            date_default_timezone_set('America/Caracas');
            $datosActualizar = [
                'user_id' => $user_id,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $respuesta = ModeloUsuarios::mdlEditarUsuario("users", $datosActualizar);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Estado del usuario actualizado correctamente."
                ];
            } else {
                error_log("Error en ModeloUsuarios::mdlEditarUsuario (status): " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo actualizar el estado del usuario. Inténtalo de nuevo."
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrActualizarStatusUsuario: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ELIMINAR USUARIO (DELETE)
    =============================================*/
    static public function ctrEliminarUsuario($user_id) {
        try {
            if ($user_id == 1) {
                return [
                    "status" => 403,
                    "success" => false,
                    "message" => "No se permite eliminar este usuario."
                ];
            }
            
            $usuarioExistente = ModeloUsuarios::mdlMostrarUsuarios("users", "user_id", $user_id);
            if (!$usuarioExistente) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "El usuario a eliminar no fue encontrado."
                ];
            }

            $respuesta = ModeloUsuarios::mdlEliminarUsuario("users", $user_id);

            if ($respuesta === "ok") {
                return [
                    "status" => 200,
                    "success" => true,
                    "message" => "Usuario eliminado correctamente."
                ];
            } else {
                error_log("Error en ModeloUsuarios::mdlEliminarUsuario: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo eliminar el usuario. Inténtalo de nuevo."
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrEliminarUsuario: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }
}