<?php

$_SESSION["logged"] = null;
$_SESSION["id"] = null;
$_SESSION["rol"] = null;
$_SESSION["nombres"] = null;
$_SESSION["usuario"] = null;
$_SESSION["perfil"] = null;

session_destroy();

return header("Location: login");