<?php

// Configurar cabeceras para respuestas JSON
header('Content-Type: application/json; charset=utf-8');

// Obtener método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Procesar datos de entrada (JSON)
$entrada = json_decode(file_get_contents('php://input'), true);

if ($metodo === 'POST') {

    if (!isset($_SESSION["logged"]) || $_SESSION["logged"] !== true) {
        http_response_code(403);
        echo json_encode([
            "status" => 403,
            "success" => false,
            "message" => "Acceso denegado. Debes iniciar sesión primero."
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    
    $respuesta = ControladorUsuarios::ctrCerrarSesion();
    
    http_response_code($respuesta['status']);
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} else {

    // Si no es un método POST, responder con error 405
    http_response_code(405);
    echo json_encode([
        "status" => 405,
        "success" => false,
        "message" => "Método no permitido para esta ruta."
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}