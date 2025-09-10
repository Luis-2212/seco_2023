<?php

class ControladorVentas {

    /*=============================================
    MOSTRAR VENTA(S) (GET)
    =============================================*/
    static public function ctrMostrarVentas($item = null, $valor = null) {
        try {
            include "../modelos/ventas.modelo.php";
            $respuesta = ModeloVentas::mdlMostrarVentas("ventas", $item, $valor);
            
            if ($item !== null && $valor !== null && !$respuesta) {
                return [
                    "status" => 404,
                    "success" => false,
                    "message" => "venta no encontrada."
                ];
            }

            return [
                "status" => 200,
                "success" => true,
                "data" => $respuesta
            ];
            
        } catch (Exception $e) {
            error_log("Error en ctrMostrarVentas: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error al procesar la solicitud."
            ];
        }
    }

    /*=============================================
    GENERAR VENTA (POST)
    =============================================*/
    static public function ctrGenerarVenta($datos) {
        include "../modelos/ventas.modelo.php";
        try {

            $fechaActual = date("Y-m-d");
            $horaActual = date("h:i:s");
            $fechaCodigo = str_replace("-", "", $fechaActual);
            $horaCodigo = str_replace(":", "", $horaActual);

            session_start();
            $nombreSession = ucfirst($_SESSION['nombres'][0]);
            $apellidoSession = ucfirst($_SESSION['apellidos'][0]);

            $codigoRecibo = $nombreSession.$apellidoSession.'-'.$_SESSION['id'].'-'.$datos["id_cliente"].'-'.$fechaCodigo.$horaCodigo;

            $jsonProductos = json_encode($datos['lista_productos'], JSON_UNESCAPED_UNICODE);

            $datosVenta = [
                'id_usuario' => $_SESSION["id"],
                'id_cliente' => $datos['id_cliente'],
                'lista_productos' => $jsonProductos,
                'codigo_recibo' => $codigoRecibo,
                'impuesto' => $datos['impuesto'],
                'valor_neto' => $datos['valor_neto'],
                'valor_total' => $datos['valor_total']
            ];

            $respuesta = ModeloVentas::mdlGenerarVenta("ventas", $datosVenta);

            if ($respuesta === "ok") {
                return [
                    "status" => 201,
                    "success" => true,
                    "message" => "Producto creado exitosamente."
                ];
            } else {
                error_log("Error en ModeloVentas::mdlGenerarVenta: " . $respuesta);
                return [
                    "status" => 500,
                    "success" => false,
                    "message" => "No se pudo crear el Producto. Inténtalo de nuevo.",
					"error" => "Error en ModeloVentas::mdlGenerarVenta: " . $respuesta
                ];
            }
        } catch (Exception $e) {
            error_log("Error en ctrGenerarVenta: " . $e->getMessage());
            return [
                "status" => 500,
                "success" => false,
                "message" => "Ocurrió un error inesperado al procesar la solicitud."
            ];
        }
    }

}