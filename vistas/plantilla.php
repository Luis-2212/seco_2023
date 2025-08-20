<?php

session_start();

?>

<!DOCTYPE html>

<html>

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>SECO 2023</title>

  <!--=====================================
  PLUGINS DE CSS
  ======================================-->

  <!-- CSS CUSTOM -->
  <link rel="stylesheet" href="public/css/style.css">
  <link rel="stylesheet" href="public/css/custom.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">

  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="node_modules/google-fonts/css2?family=Roboto:wght@300;400;500;700&display=swap"> -->

</head>

<!--=====================================
CUERPO DOCUMENTO
======================================-->

<body class="hold-transition overflow-x-hidden overflow-y-hidden bg-dark">

  <?php

  if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {

    echo '<div class="wrapper">';

    /*=============================================
    CABEZOTE
    =============================================*/

    include "modulos/cabezote.php";

    /*=============================================
    CONTENIDO
    =============================================*/

    if (isset($_GET["ruta"])) {

      if (

        /* ADMINISTRACION */
        // USUARIOS               
        $_GET["ruta"] == "usuarios"                   ||                  
        /* GENERAL */                 
        $_GET["ruta"] == "inicio"
      ) {


        include "modulos/" . $_GET["ruta"] . ".php";
      } else {

        include "modulos/404.php";
      }
    } else {

      include "modulos/inicio.php";
    }

    /*=============================================
    FOOTER
    =============================================*/

    include "modulos/footer.php";

    echo '</div>';

  } else {

    include "modulos/login.php";
    exit;

  }

  ?>

<!--=====================================
PLUGINS DE JAVASCRIPT
======================================-->
<!-- jQuery v3.7.1 -->
<script src="public/js/jquery.js"></script>

<!-- DataTables -->
<script src="node_modules/datatables.net/js/dataTables.min.js"></script>

<!--=============================================
LLAMADA A LOS ARCHIVOS JS
=============================================-->

<script src="public/js/plantilla.js"></script>
<!--   GESTIÓN DE USUARIOS   -->
<script src="public/js/login.js"></script>
<script src="public/js/logout.js"></script>
<script src="public/js/usuarios.js"></script>
<script src="public/js/roles.js"></script>

</body>

</html>
