
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="seco_icon.png" >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Seccion</title>
</head>
<body>
    <div class="logo">
        <img src="./imagenes/seco.png" alt="">
    </div>
    
    <form method="post" class="login"  action="">
        <h3>BIENVENIDOS</h3>
        <input class="contenedores" type="text" name="usuario" placeholder="Usuario" >
        
        <input class="contenedores" type= "password" name="contra" placeholder="Contraseña" >

        <input class="boton" type="submit" name="ingresar" value="INGRESAR">

        <p><a href="./cambio_contraseña/cambio_contraseña.php" target="_blank" title="cambio de contraseña">¿Quieres Cambiar Contraseña?</a></p>

        <?php
    include "conexion.php";
    include "controlador/controlador.php";
    ?>
    

    </form>
    
</body>
</html>