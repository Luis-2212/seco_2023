<?php
require_once "../controladores/ventas.controlador.php";

// Configurar cabeceras para respuestas JSON
header('Content-Type: application/json; charset=utf-8');

// Obtener método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Procesar datos de entrada (JSON)
$entrada = json_decode(file_get_contents('php://input'), true);

/*=========================================
MANEJO DE MÉTODOS HTTP PARA /ventas
==========================================*/
switch ($metodo) {

    /*=========================================
    OBTENER VENTA(S) (GET)
    ==========================================*/
    case 'GET':
        $item = null;
        $valor = null;
        
        if(isset($_GET["id"])) {
            
            $item = "id";
            $valor = $_GET["id"];
        }
        
        if(isset($_GET["codigo_recibo"])) {
            
            $item = "codigo_recibo";
            $valor = $_GET["codigo_recibo"];
        }

        $respuesta = ControladorVentas::ctrMostrarVentas($item, $valor);
        http_response_code($respuesta['status']);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;

    /*=========================================
    REGISTRAR VENTA (POST)
    ==========================================*/
    case 'POST':
        try {
            $camposRequeridos = ['id_cliente', 'lista_productos', 'impuesto', 'valor_neto', 'valor_total'];
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

            $respuesta = ControladorVentas::ctrGenerarVenta($entrada);
            http_response_code($respuesta['status']);
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        
        break;

    /*=========================================
    MÉTODO NO PERMITIDO
    ==========================================*/
    default:
        http_response_code(405);
        echo json_encode([
            "status" => 405,
            "success" => false,
            "message" => "Método no permitido para la ruta de Productos."
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        break;
}