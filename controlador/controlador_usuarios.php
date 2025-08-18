<?php

require_once "../conexion.php";

// Configurar cabeceras para respuestas JSON
header('Content-Type: application/json; charset=utf-8');

// Obtener método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Procesar datos de entrada (JSON)
$entrada = json_decode(file_get_contents('php://input'), true);

class ControladorUsuarios {

    private $conexion;

    // El constructor recibe la conexión como un argumento.
    public function __construct($db_conexion) {
        $this->conexion = $db_conexion;
    }

    // Obtener Usuarios
    public function obtenerUsuarios($item, $value) {
        // Ahora usamos $this->conexion en lugar de $conexion
        try {
            if ($item != null) {
                // Obtener un usuario específico
                $stmt = $this->conexion->prepare("SELECT * FROM login WHERE $item = ?");
                $stmt->bind_param("s", $value); //s para string, i para int
                $stmt->execute();
                $resultado = $stmt->get_result();
                $datos = $resultado->fetch_assoc();
            } else {
                // Obtener todos los usuarios
                $stmt = $this->conexion->prepare("SELECT * FROM login ORDER BY id ASC");
                $stmt->execute();
                $resultado = $stmt->get_result();
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            }
            
            http_response_code(200);
            return json_encode([
                "status" => 200,
                "success" => true,
                "data" => $datos
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
            
        } catch (\Throwable $th) {
            http_response_code(500);
            return json_encode([
                "status" => 500,
                "success" => false,
                "mensaje" => "Ocurrió un error al obtener usuarios",
                "error" => $th->getMessage() // Capturar el mensaje de error para más detalles
            ], JSON_UNESCAPED_CODE | JSON_PRETTY_PRINT);
        }
    }

    // Crear un usuario
    public function crearUsuario($datos) {
        try {
            
            // Validamos que los campos requeridos no esten vacios
            if (!isset($datos['nombre']) || !isset($datos['usuario']) || !isset($datos['password'])) {
                http_response_code(400);
                return json_encode([
                    "status" => 400,
                    "success" => false,
                    "mensaje" => "Faltan datos obligatorios para crear el usuario."
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }

            // Encriptar la contraseña usando el algoritmo de hash predeterminado
            $passwordEncriptada = password_hash($datos['password'], PASSWORD_DEFAULT);

            // Preparar la consulta
            $stmt = $this->conexion->prepare("INSERT INTO login (nombre, usuario, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $datos['nombre'], $datos['usuario'], $passwordEncriptada); //s para string, i para int

            // Ejecutar la consulta
            if ($stmt->execute()) {
                http_response_code(201); // Created
                return json_encode([
                    "status" => 201,
                    "success" => true,
                    "mensaje" => "Usuario creado exitosamente.",
                    "data" => [
                        "id" => $stmt->insert_id,
                        "nombre" => $datos['nombre'],
                        "usuario" => $datos['usuario']
                    ]
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } else {
                throw new Exception("Error al insertar el usuario: " . $stmt->error);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            return json_encode([
                "status" => 500,
                "success" => false,
                "mensaje" => "Ocurrió un error al crear el usuario.",
                "error" => $th->getMessage()
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}

// Ahora, para usar la clase, creas una instancia y le pasas la conexión.
$controlador = new ControladorUsuarios($conexion);

// Basado en el método recibido se condicionan las funciones
switch ($metodo) {
    case 'GET':
        $item = null;
        $value = null;

        if (isset($_GET["item"]) && $_GET["item"] != "null"){
            $item = $_GET["item"];
            $value = $_GET["value"];
        }

        echo $controlador->obtenerUsuarios($item, $value);
        break;

    case 'POST':
        echo $controlador->crearUsuario($entrada);
        break;
    
    default:
        http_response_code(500);
        return json_encode([
            "status" => 500,
            "success" => false,
            "mensaje" => "Método no valido para esta ruta",
        ], JSON_UNESCAPED_CODE | JSON_PRETTY_PRINT);
        break;
}