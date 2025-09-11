<?php
define('ROOT_PATH', __DIR__);

require_once "controladores/plantilla.controlador.php";
// require_once "controladores/ventas.controlador.php";
// require_once "modelos/ventas.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla->ctrPlantilla();
