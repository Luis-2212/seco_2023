<?php
ob_start();
error_reporting(E_ALL & ~E_NOTICE);

require_once('vendor/autoload.php');

if (!defined('K_TCPDF_EXTERNAL_CONFIG')) {
    define('K_TCPDF_EXTERNAL_CONFIG', true);
}
if (!defined('K_PATH_MAIN')) {
    define('K_PATH_MAIN', 'vendor/tecnickcom/tcpdf/');
}

include __DIR__ .'/../../controladores/ventas.controlador.php';

class imprimirFactura {

    public $codigo;

    public function imprimirRecibo() {

        $codigo = $_GET["codigo"] ?? NULL;

        // Validar que se reciba un código para buscar
        if (empty($codigo)) {
            // Manejar el caso donde no hay código, por ejemplo, mostrar un error
            echo "Error: Código de recibo no especificado.";
            return;
        }

        $respuestaVenta = ControladorVentas::ctrMostrarVentas("codigo_recibo", $codigo);

        // Verificar si la respuesta fue exitosa y contiene datos
        if ($respuestaVenta['success'] && !empty($respuestaVenta['data'])) {

            $codigoNotaEntrega = $codigo;
            $fecha = date('d/m/Y', strtotime(($respuestaVenta["data"]["fecha_creacion"])));
            $productos = json_decode($respuestaVenta["data"]["lista_productos"], true);
            $total_neto = number_format($respuestaVenta["data"]["valor_neto"], 2);
            $total = number_format($respuestaVenta["data"]["valor_total"], 2);
            $clienteNombre = $respuestaVenta["data"]["nombres_cliente"];
            $clienteCI = $respuestaVenta["data"]["identificacion"];

            // CREAR INSTANCIA DE TCPDF
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->startPageGroup();
            
            $pdf->AddPage();

            $img_file = __DIR__.'/seco.jpg';
            // Obtener las dimensiones de la página
            $page_width = $pdf->getPageWidth();
            $page_height = $pdf->getPageHeight();

            // Calcular la posición central de la imagen
            // Ajusta estos valores según el tamaño y la posición deseada
            $x_pos = ($page_width - 180) / 2;
            $y_pos = ($page_height - 180) / 2;

            // Establecer la transparencia
            $pdf->SetAlpha(0.1); // El valor 0.2 es un 20% de opacidad, puedes ajustarlo

            // Agregar la imagen de marca de agua en el fondo de la página
            $pdf->Image($img_file, $x_pos, $y_pos, 180, 180, '', '', '', false, 300, '', false, false, 0, false, false, false);

            // Reajustar la opacidad a 1 para el resto del contenido
            $pdf->SetAlpha(1);

            if (!file_exists($img_file)) {
                die('La imagen no se encontró en la ruta especificada.');
            }

            // CÓDIGO DE DISEÑO DEL PDF
            $bloque1 = <<<EOF
            <br><br>
            <table background="">
                <tr>
                    <td style="width:540px; text-align:right; color:red"><b><br>ENTREGA N° </b>$codigoNotaEntrega</td>
                </tr>
                <tr>
                    <td style="width:340px; font-size:8.5px; text-align:left; line-height:15px">
                        <b>SELLA Y CONSTRUYE 2023, C.A.</b>
                        <br>
                        RIF: J-50413704-9
                    </td> 
                </tr>
                <tr>
                    <td style="width:540px; font-size:11px; text-align:right; line-height:15px">
                        <h4>+58 4127654321</h4>
                    </td>
                </tr>
            </table>
EOF;

            $pdf->writeHTML($bloque1, false, false, false, false, '');

            $bloque2 = <<<EOF
            <table style="font-size:10px; padding:3px 10px; border: 1px solid #000">
                <tr>
                    <td style="width:73px; border-bottom: 1px solid #000">
                        <strong>Cliente:</strong> 
                    </td>
                    <td style="border-right: 1px solid #000; width:197px; border-bottom: 1px solid #000; vertical-align: middle;">$clienteNombre</td>

                    <td style="width:70px; border-bottom: 1px solid #000">
                        <strong>Fecha:</strong> 
                    </td>
                    <td style="border-bottom: 1px solid #000; width:197px">$fecha</td>
                </tr>
                <tr>
                    <td style="width:73px; border-bottom: 1px solid #000">
                        <strong>Tipo Recibo:</strong> 
                    </td>
                    <td style="border-right: 1px solid #000; width:197px; vertical-align: middle; border-bottom: 1px solid #000">Nota de entrega</td>
                </tr>
                <tr>
                    <td style="width:73px">
                        <strong>CI / RIF:</strong> 
                    </td>
                    <td style="width:197px; border-right: 1px solid #000">$clienteCI</td>
                    <td style="width:70px">
                        <br>
                    </td>
                    <td style="width:200px">
                        <br>
                    </td>
                </tr>
            </table>
            <br><br>
EOF;

            $pdf->writeHTML($bloque2, false, false, false, false, '');
            
            $bloque3 = <<<EOF
            <table style="font-size:10px; padding:5px 10px;">
                <tr>
                    <td style="border: 1px solid #666; width:270px"><h4>Productos</h4></td>
                    <td style="border: 1px solid #666; width:70px; text-align:center"><h4>Cantidad</h4></td>
                    <td style="border: 1px solid #666; width:100px; text-align:center"><h4>Valor Unit.</h4></td>
                    <td style="border: 1px solid #666; width:100px; text-align:center"><h4>Valor Total</h4></td>
                </tr>
            </table>
EOF;

            $pdf->writeHTML($bloque3, false, false, false, false, '');
            
            foreach ($productos as $item) {
                $valorUnitario = number_format(floatval($item["precio"]) / $item["cantidad"], 2);
                $precioTotal = number_format(floatval($item["precio"]), 2);
                
                $bloque4 = <<<EOF
                <table style="font-size:10px; padding:5px 10px;">
                    <tr>
                        <td style="border: 1px solid #666; color:#333; width:270px">{$item['nombre']}</td>
                        <td style="border: 1px solid #666; color:#333; width:70px; text-align:center">{$item['cantidad']}</td>
                        <td style="border: 1px solid #666; color:#333; width:100px; text-align:center">$ $valorUnitario</td>
                        <td style="border: 1px solid #666; color:#333; width:100px; text-align:center">$ $precioTotal</td>
                    </tr>
                </table>
EOF;
                $pdf->writeHTML($bloque4, false, false, false, false, '');
            }
            
            $bloque5 = <<<EOF
            <br><br>
            <table style="font-size:10px; padding:5px 10px;">
                <tr>
                    <td style="color:#333; width:340px; text-align:center"></td>
                    <td style="border-bottom: 1px solid #666; width:100px; text-align:center"></td>
                    <td style="border-bottom: 1px solid #666; color:#333; width:100px; text-align:center"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #666; width:440px"><h4>Neto:</h4></td>
                    <td style="border: 1px solid #666; color:#333; width:100px; text-align:right">$ $total_neto</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #666; width:440px"><h4>IVA:</h4></td>
                    <td style="border: 1px solid #666; color:#333; width:100px; text-align:right">16%</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #666; width:440px"><h4>Total:</h4></td>
                    <td style="border: 1px solid #666; color:#333; width:100px; text-align:right">$ $total</td>
                </tr>
                <tr>
                    <td style="width:540px">
                        Nota de entrega emitida por SELLA Y CONSTRUYE 2023 C.A.
                        <b>RIF: J-50413704-9</b> 
                    </td>
                </tr>
            </table>
EOF;

            $pdf->writeHTML($bloque5, false, false, false, false, '');

            ob_end_clean();
            
            // SALIDA DEL ARCHIVO
            $pdf->Output('nota_N.'.$codigo.'.pdf', 'I');
            
        } else {
            // Manejar el caso donde la venta no fue encontrada.
            header("Location: ". "recibo?codigo=".$codigo);
            exit;
            // echo "Error: Venta con código **{$codigo}** no encontrada.";
        }
    }
}

// INSTANCIAR Y LLAMAR AL MÉTODO
$factura = new imprimirFactura();
$factura->codigo = $_GET["codigo"];
$factura->imprimirRecibo();
?>