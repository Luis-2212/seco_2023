<?php

if(!empty($_POST["continuar"])) {
    if (!empty($_POST["usuario"])) { 
        $usuario=$_POST["usuario"];
        $sql=$conexion->query(" select * from login where user='$usuario'");
        if ($datos=$sql->fetch_object()) {
            header("location: login_usuario/login_usuario.php");
            
        } else {
            echo "";
        }
        

    } else {
        echo "campos vacios";
    }
    
    
}


if(!empty($_POST["cancelar"])){
        header("location: ../index.php");
}
?>