<?php
// ob_start();
error_reporting(E_ALL & ~E_NOTICE);
// ini_set('display_errors', 0);

require_once('vendor/autoload.php');

if (!defined('K_TCPDF_EXTERNAL_CONFIG')) {
    define('K_TCPDF_EXTERNAL_CONFIG', true);
}
if (!defined('K_PATH_MAIN')) {
    define('K_PATH_MAIN', 'vendor/tecnickcom/tcpdf/');
}

include __DIR__ .'/../../controladores/ventas.controlador.php';
// include ROOT_PATH .'/controladores/productos.controlador.php';

class imprimirFactura {

    public $codigo;

    public function imprimirRecibo() {

        $codigo = $_GET["codigo"] ?? NULL;

        // $respuestaVenta = ControladorVentas::mdlMostrarVentas("codigo_recibo", $_GET["codigo"]);
        $respuestaVenta = ControladorVentas::mdlMostrarVentas("id", 2);
        
        // $respuestaCliente = ControladorClientes::ctrMostrarClientes("id", $respuestaVenta["id_cliente"]);

        $codigoNotaEntrega = $codigo;
        $fecha = date('d/m/Y H:i:s', strtotime(($respuestaVenta["fecha_creacion"])));
        $productos = json_decode($respuestaVenta["lista_productos"], true);
        $total_neto = number_format($respuestaVenta["valor_neto"], 2);
        $total = number_format($respuestaVenta["valor_total"], 2);
        $clienteNombre = $respuestaVenta["nombres_cliente"];
        $clienteCI = $respuestaVenta["identificacion"];

        // CREAR INSTANCIA DE TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->AddPage();
        
        // CÓDIGO DE DISEÑO DEL PDF
        $bloque1 = <<<EOF
        <br><br>
        <table background="">
            <tr>
                <td style="width:540px; text-align:right; color:red"><b><br>ENTREGA N° </b>$codigoNotaEntrega</td>
            </tr>
            <tr>
                <td style="width:340px; font-size:8.5px; text-align:left; line-height:15px">
                    <b>SELLA Y CONSTRUYE 2023, C.A.</b> Nota de entrega
                    <br>
                    Productos para impermeabilizar techos
                    <br>
                    J-50413704-9
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
                <td style="width:73px">
                    <h4>Cliente:</h4> 
                </td>
                <td style="border-right: 1px solid #000; width:197px">$clienteNombre</td>
                <td style="width:70px">
                    <h4>CI o RIF:</h4> 
                </td>
                <td style="width:200px">$clienteCI</td>
            </tr>
            <tr>
                <td style="width:73px">
                    <h4>Tipo Fact.:</h4> 
                </td>
                <td style="border-right: 1px solid #000; width:197px">factura digital</td>
            </tr>
            <tr>
                <td style="width:73px">
                    <h4>Fecha:</h4> 
                </td>
                <td style="border-right: 1px solid #000; width:197px">$fecha</td>
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
            $valorUnitario = number_format($item["total"] / $item["cantidad"], 2);
            $precioTotal = number_format($item["total"], 2);
            
            $bloque4 = <<<EOF
            <table style="font-size:10px; padding:5px 10px;">
                <tr>
                    <td style="border: 1px solid #666; color:#333; width:270px">{$item['producto']}</td>
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
                <td style="border: 1px solid #666;; width:440px"><h4>Neto:</h4></td>
                <td style="border: 1px solid #666; color:#333; width:100px; text-align:right">$ $total_neto</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:440px"><h4>Total:</h4></td>
                <td style="border: 1px solid #666; color:#333; width:100px; text-align:right">$ $total_neto</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:440px"><h4>IVA:</h4></td>
                <td style="border: 1px solid #666; color:#333; width:100px; text-align:right">16%</td>
            </tr>
            <tr>
                <td style="border: 1px solid #666; width:440px"><h4>Total BS:</h4></td>
                <td style="border: 1px solid #666; color:#333; width:100px; text-align:right">BS $total</td>
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
    }
}

// INSTANCIAR Y LLAMAR AL MÉTODO

$factura = new imprimirFactura();
$factura->codigo = $_GET["codigo"];
$factura->imprimirRecibo();
?>