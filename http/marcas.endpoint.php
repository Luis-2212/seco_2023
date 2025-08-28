<?php
require_once "../controladores/marcas.controlador.php";

// Configurar cabeceras para respuestas JSON
header('Content-Type: application/json; charset=utf-8');

// Obtener método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Procesar datos de entrada (JSON)
$entrada = json_decode(file_get_contents('php://input'), true);

/*=========================================
MANEJO DE MÉTODOS HTTP PARA /marcas
==========================================*/
switch ($metodo) {

    /*=========================================
    OBTENER MARCA(S) (GET)
    ==========================================*/
    case 'GET':
        $item = null;
        $valor = null;
        
        if(isset($_GET["id"])) {
            
            $item = "id";
            $valor = $_GET["id"];
        }
        
        if(isset($_GET["nombre_marca"])) {
            
            $item = "nombre_marca";
            $valor = $_GET["nombre_marca"];
        }

        $respuesta = ControladorMarcas::ctrMostrarMarcas($item, $valor);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    /*=========================================
    REGISTRAR MARCA (POST)
    ==========================================*/
    case 'POST':
        try {
            $camposRequeridos = ['nombre_marca'];
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

            $respuesta = ControladorMarcas::ctrCrearMarca($entrada);
            http_response_code($respuesta['status']);
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        
        break;

    /*=========================================
    EDITAR MARCA (PUT)
    ==========================================*/
    case 'PUT':
        $respuesta = ControladorMarcas::ctrEditarMarca($entrada);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    /*=========================================
    ELIMINAR MARCA (DELETE)
    ==========================================*/
    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "success" => false,
                "message" => "Se requiere el ID para eliminar un Marca."
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        }
        $respuesta = ControladorMarcas::ctrEliminarMarca($id);
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
            "message" => "Método no permitido para la ruta de Marcas."
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;
}