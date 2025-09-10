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
  SECCION PARA CONSULTAR PRODUCTOS Y DETALLES DE LA VENTA
  =============================================-->

  <section class="content rounded shadow-lg m-3 py-3 row">

    <!-- LISTA DE PRODUCTO -->

    <div class="container-fluid col-12 col-lg-6">

      <h4 class="p-2 fw-semibold border-bottom border-top border-2 border-warning">Lista de Productos</h4>

      <h3 class="text-dark text-center fs-5 fw-semibold mt-2">Consultar Producto</h3>

      <div class="input-group mb-3 w-75 mx-auto">
        
        <div class="form-floating">

          <input type="search" class="form-control shadow-sm rounded-pill px-3 buscadoProducto" id="buscadorConsultarProducto" placeholder="Buscar Producto">
          
          <label for="buscadorConsultarProducto">Buscar Producto</label>

        </div>

      </div>

      <div class="position-relative">

        <section class="content w-75 border border-dark rounded-4 bg-white shadow-lg d-none position-absolute top-0" id="seccionProductosConsultar"></section>
      
      </div>

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

    <!-- da -->
    
    <form id="formCrearVenta" class="container-fluid col-12 col-lg-6 border-start border-2 border-warning">

      <h4 class="p-2 fw-semibold border-bottom border-top border-2 border-warning">Detalles de la venta</h4>

      <div>

        <h5 class="fs-6">Datos del Cliente</h5>
        
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

          <input type="text" class="form-control shadow-sm px-3 mb-3 border-2 border-danger" id="identificacionClienteSeleccionado" placeholder="Identificación" disabled required>
          
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

<!-- MODAL PARA EDITAR -->

<div class="modal modal-lg fade" id="modalIngresarClienteVenta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Ingresar Cliente" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formIngresarClienteVenta">

        <div class="modal-header text-bg-dark">

          <h1 class="modal-title fs-5"><i class="fa-solid fa-user-plus"></i> Nuevo Cliente</h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <!-- NOMBRES -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-dark ancho d-flex justify-content-center"><i class="fa-solid fa-address-card"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="nuevoNombresClienteVenta" placeholder="Nombre del cliente" required>
              
              <label for="nuevoNombresClienteVenta">Nombre del cliente</label>

            </div>

          </div>


          <!-- IDENTIFICACION -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-dark ancho d-flex justify-content-center"><i class="fa-solid fa-id-card"></i></span>

            <div class="form-floating" style="max-width: 4rem;">

              <select class="form-select shadow-sm selectMostrarTipoIdentificacion" id="nuevoTipoIdentificacionVenta" name="nuevoTipoIdentificacionVenta" required>

                <option default value="V">V</option>
                <option  value="P">P</option>
                <option  value="E">E</option>
                <option  value="J">J</option>
                <option  value="G">G</option>
                <option  value="C">C</option>
                <option  value="N">N</option>

              </select>

              <label for="nuevoTipoIdentificacionVenta">Tipo</label>

            </div>

            <div class="form-floating">

              <input type="number" min = "100000" max = "999999999" class="form-control shadow-sm validarCliente" id="nuevoIdentificacionVenta" placeholder="Cédula o RIF" inputmode="numeric" required>
              
              <label for="nuevoIdentificacionVenta">Cédula o RIF</label>

            </div>

          </div>

          <!-- TELEFONO -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-dark ancho d-flex justify-content-center"><i class="fa-solid fa-mobile-screen"></i></span>

            <div class="input-group-text">
            
              <input type="tel" class="form-control shadow-sm codigo-pais h-100" id="nuevoCodigoPaisVenta" value="+58" style="max-width: 12rem;" required>

            </div>

            <div class="form-floating">

              <input type="number" class="form-control shadow-sm" id="nuevoTelefonoVenta" placeholder="Teléfono e.g: 4241234567" inputmode="numeric" required>
              
              <label for="nuevoTelefonoVenta">Teléfono e.g: 4241234567</label>

            </div>

          </div>

          <!-- CORREO -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-dark ancho d-flex justify-content-center"><i class="fa-solid fa-at"></i></span>

            <div class="form-floating">

              <input type="email" class="form-control shadow-sm" id="nuevoCorreoVenta" placeholder="Correo electrónico" required>
              
              <label for="nuevoCorreoVenta">Correo electrónico</label>

            </div>

          </div>

          <!-- DIRECCION -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-dark ancho d-flex justify-content-center"><i class="fa-solid fa-map-location"></i></span>

            <div class="form-floating">

              <textarea type="text" class="form-control shadow-sm" id="nuevoDireccionVenta" placeholder="Dirección"></textarea>
              
              <label for="nuevoDireccionVenta">Dirección</label>

            </div>

          </div>

        </div>
          
        <div class="alert alert-danger my-2 alerta d-none"></div>
        
        <!-- ACCIONES -->

        <div class="modal-footer bg-secondary-subtle">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>

          <button type="submit" id="btnIngresarClienteVenta" class="btn btn-dark"><i class="fa-solid fa-plus"></i> Ingresar nuevo cliente</button>

        </div>

      </form>

      <?php

      ?>

    </div>

  </div>

</div>
