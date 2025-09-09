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

  <!-- <section class="content-header bg-dark py-2 px-3 rounded mb-3 shadow-lg">

    <h4 class="text-light">Generar</h4>

    <hr class="border border-2 border-warning mt-0">

    <h3 class="text-warning fw-bold">VENTA</h3>

  </section> -->

  <!--=============================================
  CONSULTAR PRODUCTO
  =============================================-->

  <h3 class="text-dark text-center fs-5 fw-semibold mt-4">Consultar Producto</h3>

  <div class="input-group mb-3 w-75 mx-auto">
    
    <div class="form-floating">

      <input type="search" class="form-control shadow-sm rounded-pill px-3 buscadoProducto" id="buscadorConsultarProducto" placeholder="Buscar Producto">
      
      <label for="buscadorConsultarProducto">Buscar Producto</label>

    </div>

  </div>

  <section class="content w-50 rounded bg-white shadow-lg my-3 mx-auto d-none" id="seccionProductosConsultar"></section>

  <!--=============================================
  SECCION PARA CONSULTAR Producto
  =============================================-->

  <section class="content rounded shadow-lg my-3 py-3 d-flex">

    <div class="container-fluid">

      <h4 class="pb-2 fw-semibold border-bottom border-2 border-warning">Lista de Productos Seleccionados</h4>

      <div class="table-responsive">
        <table class="table table-sm table-striped-columns">
          <thead class="table-dark">
            <tr class="text-center">
              <th><i class="fa-solid fa-square-check"></i></th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th class="text-end">Precio $</th>
            </tr>
          </thead>
          <tbody id="productosSeleccionados" class="align-middle text-center table-sm"></tbody>
        </table>
      </div>
    </div>

    <form id="formCrearVenta" class="container-fluid border-start border-4 border-warning">

      <h4 class="pb-2 fw-semibold border-bottom border-2 border-warning">Detalles de la venta</h4>

      <div>

        <h5 class="fs-6">Seleccionar Cliente</h5>
        
        <div class="input-group mb-3 mx-auto">
          
          <div class="form-floating">

            <input type="search" class="form-control shadow-sm px-3 rounded-pill buscadorCliente" id="buscadorCliente" placeholder="Buscar Cliente por identificación e.g: 18331857">
            
            <label for="buscadorCliente">Buscar Cliente por identificación e.g: 18331857</label>

            <ul class="position-absolute overflow-y-auto list-group d-none" id="resultadosClientes"></ul>
            
          </div>

        </div>
        
      </div>

      <div class="input-group input-group-sm mb-3 mx-auto d-none">
        
        <div class="form-floating">

          <input type="number" class="form-control shadow-sm px-3" id="idClienteSeleccionado" placeholder="id cliente" readonly required>
          
          <label for="idClienteSeleccionado">id cliente</label>

        </div>

      </div>

      <div class="input-group input-group-sm mb-3 mx-auto">
        
        <div class="form-floating">

          <input type="text" class="form-control shadow-sm px-3 border-2 border-danger" id="nombreClienteSeleccionado" placeholder="Nombre del cliente" disabled required>
          
          <label for="nombreClienteSeleccionado">Nombre del cliente</label>

        </div>

      </div>

      <div class="input-group input-group-sm mb-3 mx-auto">
        
        <div class="form-floating">

          <input type="text" class="form-control shadow-sm px-3 border-2 border-danger" id="identificacionClienteSeleccionado" placeholder="Identificación" disabled required>
          
          <label for="identificacionClienteSeleccionado">Identificación</label>

        </div>

      </div>
      
      <h5 class="fs-6">Datos de la venta</h5>

      <div class="d-flex gap-2">

        <div class="input-group input-group-sm mb-3 mx-auto">
          
          <div class="form-floating">

            <input type="number" class="form-control shadow-sm px-3 border-2 border-warning" id="ivaVenta" placeholder="IVA %" value="16" disabled required>
            
            <label for="ivaVenta">IVA %</label>

          </div>

        </div>
        
        <div class="input-group input-group-sm mb-3 mx-auto">
          
          <div class="form-floating">

            <input type="text" class="form-control shadow-sm px-3 border-2 border-danger-subtle" id="totalNetoVenta" placeholder="Neto USD $" readonly required>
            
            <label for="totalNetoVenta">Neto USD $</label>

          </div>

        </div>
        
      </div>

      <div class="input-group input-group-sm mb-3 mx-auto">
        
        <div class="form-floating">

          <input type="text" class="form-control shadow-sm px-3 border-2 border-danger" id="totalVenta" placeholder="Total USD $" readonly required>
          
          <label for="totalVenta">Total USD $</label>

        </div>

      </div>

      <div class="button-group text-center">

        <button type="submit" id="btnCrearVenta" class="btn btn-success" disabled>Crear Venta</button>

      </div>
        
    </form>

  </section>

</div>
