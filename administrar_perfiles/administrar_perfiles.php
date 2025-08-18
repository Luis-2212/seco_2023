<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: ../index.php");
}
// require_once "../controlador/controlador_usuarios.php"

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Pedidos</title>
    <link rel="stylesheet" href="./administrar_perfiles.css">
        
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

    <h2 class="tituloModulo">Módulo de Usuarios</h2>

    <section class="contenedorFormAgregarUsuario">

        <h3>Agregar usuario</h3>

        <form method="post" id="formAgregarUsuario">
        
            <div class="entradasHorizontal">
                <div class="entradasTexto">
                    <label for="agregarNombre">Nombre</label>
                    <input type="text" id="agregarNombre" placeholder="Ej.: Luis" required>
                </div>
                <div class="entradasTexto">
                    <label for="agregarApellido">Apellido</label>
                    <input type="text" id="agregarApellido" placeholder="Ej.: Rojas" required>
                </div>
                <div class="entradasTexto">
                    <label for="agregarUsername">Nombre de Usuario</label>
                    <input type="text" id="agregarUsername" placeholder="Ej.: luis1234" required>
                </div>
            </div>
        
            <div class="entradasHorizontal">
                <div class="entradasTexto">
                    <label for="agregarPassword">Contraseña</label>
                    <input type="password" id="agregarPassword" placeholder="ingresar contraseña" required>
                </div>
                <div class="entradasTexto">
                    <label for="agregarConfirmarPassword">Confirmar Contraseña</label>
                    <input type="password" id="agregarConfirmarPassword" placeholder="confirmar contraseña" required>
                </div>
            </div>

            <div class="contenedorBotonAgregarUsuario">
                <button type="submit" id="btnAgregarUsuario">Agregar usuario</button>
            </div>

        </form>

    </section>

    <hr>

    <section class="contenedorMostrarUsuarios">

        <h3>Tabla de usuarios</h3>

        <div class="contenedorTablaUsuarios">
        
            <table id="tablaUsuarios">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td  colspan="4">
                            Sin resultados
                        </td>
                    </tr>
                </tbody>

            </table>

        </div>
        
    </section>

        

    
    
    
    
    <script type="module" src="../public/assets/js/usuarios.js"></script>

</body>