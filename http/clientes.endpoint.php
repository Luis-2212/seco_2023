<?php
require_once "../controladores/clientes.controlador.php";

// Configurar cabeceras para respuestas JSON
header('Content-Type: application/json; charset=utf-8');

// Obtener método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Procesar datos de entrada (JSON)
$entrada = json_decode(file_get_contents('php://input'), true);

/*=========================================
MANEJO DE MÉTODOS HTTP PARA /clientes
==========================================*/
switch ($metodo) {

    /*=========================================
    OBTENER CLIENTE(S) (GET)
    ==========================================*/
    case 'GET':
        $item = null;
        $valor = null;
        
        if(isset($_GET["id"])) {
            
            $item = "id";
            $valor = $_GET["id"];
        }
        
        if(isset($_GET["identificacion"])) {
            
            $item = "identificacion";
            $valor = $_GET["identificacion"];
        }

        $respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    /*=========================================
    REGISTRAR CLIENTE (POST)
    ==========================================*/
    case 'POST':
        try {
            $camposRequeridos = ['nombres', 'direccion','tipo_identificacion', 'identificacion', 'codigo_pais', 'telefono', 'correo'];
            foreach ($camposRequeridos as $campo) {
                if (empty($entrada[$campo])) {
                    echo json_encode([
                        "status" => 400,
                        "success" => false,
                        "message" => "El campo '$campo' es requerido."
                    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    exit;
                }
            }

            $respuesta = ControladorClientes::ctrCrearCliente($entrada);
            http_response_code($respuesta['status']);
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        
        break;

    /*=========================================
    EDITAR CLIENTE (PUT)
    ==========================================*/
    case 'PUT':
        $respuesta = ControladorClientes::ctrEditarCliente($entrada);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    /*=========================================
    ELIMINAR CLIENTE (DELETE)
    ==========================================*/
    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "success" => false,
                "message" => "Se requiere el ID para eliminar un Cliente."
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        }
        $respuesta = ControladorClientes::ctrEliminarCliente($id);
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
            "message" => "Método no permitido para la ruta de Clientes."
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;
}