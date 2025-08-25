<?php
require_once "../controladores/roles.controlador.php";

// Configurar cabeceras para respuestas JSON
header('Content-Type: application/json; charset=utf-8');

// Obtener método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Procesar datos de entrada (JSON)
$entrada = json_decode(file_get_contents('php://input'), true);

/*=========================================
MANEJO DE MÉTODOS HTTP PARA /roles
==========================================*/
switch ($metodo) {

    /*=========================================
    OBTENER ROL(ES)
    ==========================================*/
    case 'GET':
        $item = null;
        $valor = null;
        
        if(isset($_GET["id"])) {
            
            $item = "id";
            $valor = $_GET["id"];
        }
        
        if(isset($_GET["rol"])) {
            
            $item = "rol";
            $valor = $_GET["rol"];
        }

        $respuesta = ControladorRoles::ctrMostrarRoles($item, $valor);
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

}