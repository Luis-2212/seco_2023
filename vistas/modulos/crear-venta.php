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

  <h5 class="text-dark fw-semibold mt-4">Consultar Producto</h5>

  <div class="input-group mb-3">
    
    <div class="form-floating">

      <input type="search" class="form-control shadow-sm buscadoProducto" id="buscadorConsultarProducto" placeholder="Buscar Producto" required>
      
      <label for="buscadorConsultarProducto">Buscar Producto</label>

    </div>

    <button type="button" class="btn btn-success shadow" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria">Buscar</button>

  </div>

  <section class="content rounded shadow-lg my-3 py-3" id="seccionProductosConsultar"></section>

  <hr>
  
  <!--=============================================
  SECCION PARA CONSULTAR Producto
  =============================================-->

  <!-- <section class="content py-3">

    <div class="container-fluid">

      <h4>Consultar Productos</h4>

      <div class="table-responsive p-2 rounded shadow-lg">

        <table class="table table-sm table-bordered table-striped table-light table-hover align-middle" id="tablaProductos" width="100%">         

          <thead>         

            <tr class="table-dark">           

              <th>Estado</th>
              <th>Nombre</th>
              <th>Categoría</th>
              <th>Marca</th>
              <th>Stock</th>
              <th>Medida</th>
              <th>Precio Compra $</th>
              <th>Precio Venta $</th>
              <th>Descripción</th>
              <th>Fecha creación</th>
              <th>Fecha Actualización</th>
              <th>Acciones</th>

            </tr> 

          </thead>

          <tbody></tbody>

        </table>

      </div>

    </div>

  </section> -->

</div>
