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
    <link rel="stylesheet" href="inicio.css">
        
</head>
<body>
    <header>
        <div class="logo">
            <img src="../imagenes/seco_icon.png" alt="" />
            <h1>Sistema de Control de Ventas</h1>
        </div>
        <div class="navbar">

            <h5><a href="../inicio/inicio.php">Inicio</a></h5>
            <h5><a href="../clientes/clientes.php">Clientes</a></h5>
            <h5><a href="../productos/productos.php">Productos</a></h5>
            <h5><a href="../reportes/reportes.php">Reportes</a></h5>
            <h5><a href="../pedidos/pedidos.php">Pedidos</a></h5>
            <h5><a href="..//controlador/controlador_cerrarsecccion.php">Salir</a></h5>
        
        </div>

    </header>

    <div class="Mensaje">
        <?php 
        $_SESSION["nombre"];
        
        
        ?>

        <h2>Hola, Bienvenido al Sistema de Gestion de Ventas de Seco 2023...</h2></br>
        <h3>Saludos <?php 
        echo $_SESSION["nombre"]. " " . $_SESSION["apellido"] . "!";
        
        
        ?></h3></br>
        
    </div>

        

    
    
    
    
    

</body>