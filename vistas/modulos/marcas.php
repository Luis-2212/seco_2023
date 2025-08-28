<?php

  if(!isset($_SESSION["logged"])) {

    return header("Location: login");
  } 

  if( $_SESSION["rol"] != 1) {

    return header("Location: inicio");
  } 

?>

<div class="content-wrapper px-2 py-3 pb-5 text-bg-light contenedor-principal">

  <nav aria-label="breadcrumb">

    <ol class="breadcrumb">

      <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>

      <li class="breadcrumb-item active" aria-current="page">Marcas</li>

    </ol>

  </nav>

  <!--=============================================
  SECCIÓN DEL TITULO DEL MÓDULO
  =============================================-->

  <section class="content-header bg-dark py-2 px-3 rounded mb-3 shadow-lg">

    <h4 class="text-light">Administración</h4>

    <hr class="border border-2 border-warning mt-0">

    <h3 class="text-warning fw-bold">MARCAS</h3>

  </section>

  <!--=============================================
  SECCION PARA AGREGAR NUEVA MARCA
  =============================================-->

  <button class="btn btn-warning shadow-md" type="button" data-bs-toggle="collapse" data-bs-target="#seccionRegistrarMarca" aria-expanded="false" aria-controls="seccionRegistrarMarca">
    <i class="fa-brands fa-font-awesome"></i> Nueva Marca <i class="fa-solid fa-caret-down"></i>
  </button>

  <section class="content rounded shadow-lg my-3 py-3 collapse" id="seccionRegistrarMarca">

    <form role="form" method="post" id="formCrearMarca">

      <div class="container-fluid">

        <h5 class="h5">Nueva Marca</h5>

        <!-- NOMBRES DE LA MARCA -->
        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-table-list"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm validarMarca" id="nuevoNombreMarca" placeholder="Nombre de la Marca" required>
              
              <label for="nuevoNombreMarca">Nombre de la Marca</label>

            </div>

          </div>

        </div>
        
        <!-- ACCIONES -->
        <div>

          <button type="submit" id="btnRegistrarMarca" class="btn btn-warning d-flex align-items-center ms-auto shadow-sm"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Registrar</button>
          
        </div>

        <div>

          <div class="alert alert-danger my-2 alerta d-none"></div>
          
        </div>

      </div>

    </form>

  </section>

  <hr>
  
  <!--=============================================
  SECCION PARA CONSULTAR MARCAS
  =============================================-->

  <section class="content py-3">

    <div class="container-fluid">

      <h4>Consultar marcas de productos</h4>

      <div class="table-responsive p-2 rounded shadow-lg">

        <table class="table table-sm table-bordered table-striped table-light table-hover align-middle" id="tablaMarcas" width="100%">         

          <thead>         

            <tr class="table-dark">           

              <th>Marca</th>
              <th>Fecha creación</th>
              <th>Fecha Actualización</th>
              <th>Acciones</th>

            </tr> 

          </thead>

          <tbody></tbody>

        </table>

      </div>

    </div>

  </section>

</div>

<!-- MODAL PARA EDITAR -->

<div class="modal fade" id="modalEditarMarca" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditarMarca" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formEditarMarca">

        <div class="modal-header text-bg-warning">

          <h1 class="modal-title fs-5"><i class="fa-brands fa-font-awesome"></i> Editar: <span id="editarMarca"></span></h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <!-- NOMBRES DE LA MARCA -->
          <div class="d-flex gap-3">

            <div class="input-group mb-3">
              
              <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-table-list"></i></span>

              <div class="form-floating">

                <input type="text" class="form-control shadow-sm" id="editarNombreMarca" placeholder="Nombre de la Marca" required>
                
                <label for="editarNombreMarca">Nombre de la Marca</label>

              </div>

            </div>

          </div>
        
        </div>
        
        <div class="alert alert-danger my-2 alerta d-none"></div>
        
        <!-- ACCIONES -->

        <div class="modal-footer bg-secondary-subtle">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>

          <button type="submit" id="btnEditarMarca" class="btn btn-warning"><i class="fa-solid fa-plus"></i> Guardar cambios</button>

        </div>

      </form>

    </div>

  </div>

</div>
