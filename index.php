<?php
define('ROOT_PATH', __DIR__);

require_once "controladores/plantilla.controlador.php";

$plantilla = new ControladorPlantilla();
$plantilla->ctrPlantilla();
