<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Pedidos</title>
    <link rel="stylesheet" href="reportes.css">
        
</head>
<body>
    <header>
        <div class="logo">
            <img src="../imagenes/seco_icon.png" alt="Logo del sistema de pedidos, icono de caja con checklist en azul" />
            <h1>Sistema de Control de Ventas</h1>

            <h5><a href="../inicio/inicio.php">inicio</a></h5>
            <h5><a href="../clientes/clientes.php">Clientes</a></h5>
            <h5><a href="../productos/productos.php">Productos</a></h5>
            <h5><a href="../reportes/reportes.php">Reportes</a></h5>
            <h5><a href="../pedidos/pedidos.php">Pedidos</a></h5>
            <h5><a href="../index.php">Salir</a></h5>
        
        </div>
    </header>