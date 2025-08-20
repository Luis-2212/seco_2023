<?php

class ControladorUsuarios {
    
    /*=============================================
    INICIAR SESIÓN (POST)
    =============================================*/
    static public function ctrIniciarSesion($datos) {
        try {
            include "../modelos/usuarios.modelo.php";
            $_SESSION['logged'] = false;
			$username = isset($datos['username']) ? trim($datos['username']) : '';
			$password = isset($datos['password']) ? trim($datos['password']) : '';

            // SI EL USUARIO ESTÁ LOGUEADO, NO PERMITIR INICIAR SESIÓN NUEVAMENTE
            if (!$_SESSION['logged']) {

				// AUTENTICACIÓN POR USUARIO/CONTRASEÑA.
				if (empty($username) || empty($password)) {
					return [
						"status" => 400,
						"success" => false,
						"message" => "El usuario y la contraseña son requeridos."
					];
				}
				
				$usuario = ModeloUsuarios::mdlMostrarUsuarios("usuarios", "username", $username);

				if ($usuario && password_verify($password, $usuario['password'])) {
					session_start();
					$_SESSION['logged'] = true;
					$_SESSION['id'] = $usuario['id'];
					$_SESSION['rol'] = $usuario['id_rol'];
					$_SESSION['username'] = $usuario['username'];
					$_SESSION['nombres'] = $usuario['nombres'];
					$_SESSION['apellidos'] = $usuario['apellidos'];

					return [
						"status" => 200,
						"success" => true,
						"message" => "Autenticación exitosa. Se ha generado un nuevo token.",
						"id" => $usuario['id'],
						"data" => [
							"username" => $usuario['username'],
							"nombres" => $usuario['nombres'],
							"apellidos" => $usuario['apellidos']
						]
					];
				} else {
					// Credenciales incorrectas
					return [
						"status" => 401,
						"success" => false,
						"message" => "Credenciales incorrectas. Por favor, verifica tu usuario y contraseña."
					];
				}
            } else {
				return [
					"status" => 403,
					"success" => false,
					"message" => "Ya has iniciado sesión. Por favor, cierra sesión antes de iniciar sesión nuevamente."
				];
			}
        } catch (Exception $e) {
            error_log("Error en ctrIniciarSesion: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado. Inténtalo de nuevo más tarde."
            ];
        }
    }

    /*=============================================
    CERRAR SESIÓN (POST)
    =============================================*/

    static public function ctrCerrarSesion() {
        include "../modelos/usuarios.modelo.php";

		// Destruir la sesión
		// session_unset();
		session_destroy();
		
		// Limpiar las variables de sesión
		$_SESSION['logged'] = false;
		$_SESSION['id'] = '';
		$_SESSION['id_rol'] = '';
		$_SESSION['nombres'] = '';
		$_SESSION['apellidos'] = '';
        
		// Enviar respuesta al cliente
		return [
            "status" => 200,
            "success" => true,
            "message" => "Sesion cerrada."
        ];
    }

    /*=============================================
    MOSTRAR USUARIO(S) (GET)
    =============================================*/
    static public function ctrMostrarUsuarios($item = null, $valor = null) {
        try {
            $respuesta = ModeloUsuarios::mdlMostrarUsuarios("usuarios", $item, $valor);
            
            if ($item !== null && $valor !== null && !$respuesta) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "Usuario no encontrado."
                ];
            }

            return [
                "status" => 200,
                "success" => true,
                "data" => $respuesta
            ];
            
        } catch (Exception $e) {
            error_log("Error en ctrMostrarUsuarios: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    CREAR USUARIO (POST)
    =============================================*/
    static public function ctrCrearUsuario($datos) {
        include "../modelos/usuarios.modelo.php";
        try {
			// Validar campos requeridos
            $camposRequeridos = ['id_rol', 'username', 'password', 'nombres', 'apellidos'];
            foreach ($camposRequeridos as $campo) {
                if (empty($datos[$campo])) {
                    return [
                        "status" => 400,
                        "success" => false,
                        "message" => "El campo '$campo' es requerido."
                    ];
                }
            }

			// Verificar si el nombre de usuario ya existe
            $usuarioExistente = ModeloUsuarios::mdlMostrarUsuarios("usuarios", "username", $datos['username']);
            if ($usuarioExistente) {
                return [
                    "status" => 409,
                    "success" => false,
                    "message" => "El nombre de usuario ya está en uso. Por favor, elige otro."
                ];
            }

			// Encriptar la contraseña antes de guardarla
            $datos['password'] = password_hash($datos['password'], PASSWORD_BCRYPT);

            $datosUsuario = [
                'id_rol' => $datos['id_rol'],
                'nombres' => $datos['nombres'],
                'apellidos' => $datos['apellidos'],
                'username' => $datos['username'],
                'password' => $datos['password']
            ];

            $respuesta = ModeloUsuarios::mdlCrearUsuario("usuarios", $datosUsuario);

            if ($respuesta === "ok") {
                return [
                    "status" => 201,
                    "success" => true,
                    "message" => "Usuario creado exitosamente."
                ];
            } else {
                error_log("Error en ModeloUsuarios::mdlCrearUsuario: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo crear el usuario. Inténtalo de nuevo.",
					"error" => "Error en ModeloUsuarios::mdlCrearUsuario: " . $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrCrearUsuario: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    ACTUALIZAR USUARIO (PUT)
    =============================================*/
    static public function ctrEditarUsuario($datos) {
        try {
            $userIdToUpdate = isset($datos['user_id']) ? $datos['user_id'] : (isset($datos['id']) ? $datos['id'] : null);

			// Sí no se envió ningún ID a editar
            if ($userIdToUpdate === null) {
				return [
                    "status" => 400,
                    "success" => false,
                    "message" => "El ID del usuario es requerido para la actualización."
                ];
            }
            
			// No se puede modificar el usuario master
            if ($userIdToUpdate == 1) {
                return [
                    "status" => 403,
                    "success" => false,
                    "message" => "No se permite modificar este usuario."
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