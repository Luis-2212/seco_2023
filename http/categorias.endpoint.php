<?php
require_once "../controladores/categorias.controlador.php";

// Configurar cabeceras para respuestas JSON
header('Content-Type: application/json; charset=utf-8');

// Obtener método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Procesar datos de entrada (JSON)
$entrada = json_decode(file_get_contents('php://input'), true);

/*=========================================
MANEJO DE MÉTODOS HTTP PARA /categorias
==========================================*/
switch ($metodo) {

    /*=========================================
    OBTENER Categoria(S) (GET)
    ==========================================*/
    case 'GET':
        $item = null;
        $valor = null;
        
        if(isset($_GET["id"])) {
            
            $item = "id";
            $valor = $_GET["id"];
        }
        
        if(isset($_GET["nombre_categoria"])) {
            
            $item = "nombre_categoria";
            $valor = $_GET["nombre_categoria"];
        }

        $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    /*=========================================
    REGISTRAR Categoria (POST)
    ==========================================*/
    case 'POST':
        try {
            $camposRequeridos = ['nombre_categoria', 'descripcion'];
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

            $respuesta = ControladorCategorias::ctrCrearCategoria($entrada);
            http_response_code($respuesta['status']);
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        
        break;

    /*=========================================
    EDITAR Categoria (PUT)
    ==========================================*/
    case 'PUT':
        $respuesta = ControladorCategorias::ctrEditarCategoria($entrada);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    /*=========================================
    ELIMINAR Categoria (DELETE)
    ==========================================*/
    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "success" => false,
                "message" => "Se requiere el ID para eliminar un Categoria."
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        }
        $respuesta = ControladorCategorias::ctrEliminarCategoria($id);
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
            "message" => "Método no permitido para la ruta de Categorias."
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;
}