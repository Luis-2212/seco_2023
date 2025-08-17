<?php
session_start();

if(!empty($_POST["ingresar"])) {
    if (!empty($_POST["usuario"]) and !empty($_POST["contra"])) { 
        $usuario=$_POST["usuario"];
        $contraseña=$_POST["contra"];
        $sql=$conexion->query(" select * from login where usuario='$usuario' and contraseña='$contraseña' ");
        if ($datos=$sql->fetch_object()) {
            $_SESSION["id"]=$datos->id;
            $_SESSION["nombre"]=$datos->nombre;
            $_SESSION["apellido"]=$datos->apellido;
            header("location: inicio/inicio.php");
            

            
        } else {
            echo "Ingreso Alguna Credencial Incorrecta";
        }
        

    } else {
        echo "Campos Vacios";
    }
    
    
}
?>