<?php

  if(!isset($_SESSION["logged"])) {

    return header("Location: login");
  } 

?>

<div class="content-wrapper px-2 py-3 pb-5 text-bg-light contenedor-principal">

  <nav aria-label="breadcrumb">

    <ol class="breadcrumb">

      <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>

      <li class="breadcrumb-item active" aria-current="page">Generar Venta</li>

    </ol>

  </nav>

  <!--=============================================
  SECCIÓN DEL TITULO DEL MÓDULO
  =============================================-->

  <section class="content-header bg-dark py-2 px-3 rounded mb-3 shadow-lg">

    <h4 class="text-light">Generar</h4>

    <hr class="border border-2 border-warning mt-0">

    <h3 class="text-warning fw-bold">VENTA</h3>

  </section>

  <!--=============================================
  CONSULTAR PRODUCTO
  =============================================-->

  <h3 class="text-dark text-center fw-semibold mt-4">Consultar Producto</h3>

  <div class="input-group mb-3 w-75 mx-auto">
    
    <div class="form-floating">

      <input type="search" class="form-control shadow-sm rounded-pill px-3 buscadoProducto" id="buscadorConsultarProducto" placeholder="Buscar Producto" required>
      
      <label for="buscadorConsultarProducto">Buscar Producto</label>

    </div>

  </div>

  <section class="content rounded shadow-lg my-3 py-3" id="seccionProductosConsultar"></section>

  <hr>
  
  <!--=============================================
  SECCION PARA CONSULTAR Producto
  =============================================-->

  <section class="content rounded shadow-lg my-3 py-3 d-flex">

    <div class="container-fluid">

      <h4>Lista de Productos Seleccionados</h4>

      <div id="productosSeleccionados"></div>

    </div>

    <div class="container-fluid border-start border-2 border-dark">

      <h4>Detalles de la venta</h4>

      <div>
        
        <div class="input-group mb-3 mx-auto">
          
          <div class="form-floating">

            <input type="search" class="form-control shadow-sm px-3 buscadorCliente" id="buscadorCliente" placeholder="Buscar Cliente" required>
            
            <label for="buscadorCliente">Buscar Cliente</label>

          </div>

        </div>

      </div>

    </div>

  </section>

</div>
