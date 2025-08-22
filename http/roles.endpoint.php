<?php
require_once "../controladores/roles.controlador.php";

// Configurar cabeceras para respuestas JSON
header('Content-Type: application/json; charset=utf-8');

// Obtener método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Procesar datos de entrada (JSON)
$entrada = json_decode(file_get_contents('php://input'), true);

// if (!isset($_SESSION["logged"])) {
//     http_response_code(401);
//     echo json_encode([
//         "status" => 401,
//         "success" => false,
//         "message" => "No autenticado. Por favor, inicie sesión."
//     ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//     exit;
// }

/*=========================================
MANEJO DE MÉTODOS HTTP PARA /roles
==========================================*/
switch ($metodo) {

    /*=========================================
    OBTENER ROL(ES)
    ==========================================*/
    case 'GET':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $respuesta = ControladorRoles::ctrMostrarRoles($id ? "user_id" : null, $id);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    /*=========================================
    REGISTRAR ROL
    ==========================================*/
    case 'POST':
        try {
            if (empty($entrada['rol']) || empty($entrada['descripcion'])) {
                echo json_encode(["mensaje" => "Todos los campos son obligatorios"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                exit;
            }

            $respuesta = ControladorRoles::ctrCrearRol($entrada);
            http_response_code($respuesta['status']);
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        
        break;

    /*=========================================
    EDITAR ROL
    ==========================================*/
    case 'PUT':
        $respuesta = ControladorRoles::ctrEditarRol($entrada);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    /*=========================================
    ELIMINAR ROL
    ==========================================*/
    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "success" => false,
                "message" => "Se requiere el ID para eliminar un rol."
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        }
        $respuesta = ControladorRoles::ctrEliminarRol($id);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;
    
    /*=========================================
    ACTUALIZAR ROL
    ==========================================*/
    case 'PATCH':
        $id = $entrada['id'] ?? null;
        $status = $entrada['status'] ?? null;

        if ($id === null || $status === null) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "success" => false,
                "message" => "Se requiere 'id' y 'status' para actualizar el estado del rol."
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        }

        $respuesta = ControladorRoles::ctrActualizarStatusRol($id, $status);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    /*=========================================
    MÉTODO NO PERMITIDO
    ==========================================*/
    default:
        http_response_code(405);
        echo json_encode([
            "status" => 405,
            "success" => false,
            "message" => "Método no permitido para esta ruta."
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;
}