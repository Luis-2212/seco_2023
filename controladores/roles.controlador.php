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
		require_once "../modelos/roles.modelo.php";
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

}