<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio de Contraseña</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post" action="">
    <div  class="gestionUsuarios">
        <h3>GESTION DE USUARIOS</h3>
        <h5>Cambio de Contraseña</h5>
        <input name="user" class="inpuptext" type="text" placeholder="Ingrese Usuario">
        <input name="cancelar" class="inpupbotton" type="submit" value="Cancelar">
        <input name="continuar" class="inpupbotton" type="submit" value="Continuar">

        
    </div>
    <?php
    include "../controlador/controlador_cambio_contra.php";
    ?>
    </form>
</body>
</html>