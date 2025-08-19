<?php

/*=============================================
   CONTROLADORES
=============================================*/

require_once "controladores/plantilla.controlador.php";
/* ADMINISTRACION */
require_once "controladores/usuarios.controlador.php";
// require_once "controladores/roles.controlador.php";

/*=============================================
   MODELOS
=============================================*/

/* ADMINISTRACION */
require_once "modelos/usuarios.modelo.php";
// require_once "modelos/roles.modelo.php";


$plantilla = new ControladorPlantilla();
$plantilla->ctrPlantilla();
