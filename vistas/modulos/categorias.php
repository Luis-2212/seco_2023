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

      <li class="breadcrumb-item active" aria-current="page">Categorías</li>

    </ol>

  </nav>

  <!--=============================================
  SECCIÓN DEL TITULO DEL MÓDULO
  =============================================-->

  <section class="content-header bg-dark py-2 px-3 rounded mb-3 shadow-lg">

    <h4 class="text-light">Administración</h4>

    <hr class="border border-2 border-warning mt-0">

    <h3 class="text-warning fw-bold">CATEGORÍAS</h3>

  </section>

  <!--=============================================
  SECCION PARA AGREGAR NUEVa Categoria
  =============================================-->

  <button class="btn btn-warning shadow-md" type="button" data-bs-toggle="collapse" data-bs-target="#seccionRegistrarCategoria" aria-expanded="false" aria-controls="seccionRegistrarCategoria">
    <i class="fa-solid fa-tags"></i> Nueva Categoria <i class="fa-solid fa-caret-down"></i>
  </button>

  <section class="content rounded shadow-lg my-3 py-3 collapse" id="seccionRegistrarCategoria">

    <form role="form" method="post" id="formCrearCategoria">

      <div class="container-fluid">

        <h5 class="h5">Nueva categoría</h5>

        <!-- NOMBRES DE LA CATEGORIA -->
        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-table-list"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm validarCategoria" id="nuevoNombreCategoria" placeholder="Nombre de la Categoría" required>
              
              <label for="nuevoNombreCategoria">Nombre de la Categoría</label>

            </div>

          </div>

        </div>
        
        <!-- DESCRIPCIÓN -->

        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-align-justify"></i></span>

            <div class="form-floating">

              <textarea type="text" class="form-control shadow-sm" id="nuevaDescripcionCategoria" maxLength="256" placeholder="Dirección"></textarea>
              
              <label for="nuevoDireccionCategoria">Descripción</label>

            </div>

          </div>

        </div>
        
        <!-- ACCIONES -->
        <div>

          <button type="submit" id="btnRegistrarCategoria" class="btn btn-warning d-flex align-items-center ms-auto shadow-sm"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Registrar</button>
          
        </div>

        <div>

          <div class="alert alert-danger my-2 alerta d-none"></div>
          
        </div>

      </div>

    </form>

  </section>

  <hr>
  
  <!--=============================================
  SECCION PARA CONSULTAR CATEGORIAS
  =============================================-->

  <section class="content py-3">

    <div class="container-fluid">

      <h4>Consultar Categorías de productos</h4>

      <div class="table-responsive p-2 rounded shadow-lg">

        <table class="table table-sm table-bordered table-striped table-light table-hover align-middle" id="tablaCategorias" width="100%">         

          <thead>         

            <tr class="table-dark">           

              <th>Categoría</th>
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

  </section>

</div>

<!-- MODAL PARA EDITAR -->

<div class="modal fade" id="modalEditarCategoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditarCategoria" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formEditarCategoria">

        <div class="modal-header text-bg-warning">

          <h1 class="modal-title fs-5"><i class="fa-solid fa-tags"></i> Editar: <span id="editarCategoria"></span></h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <!-- NOMBRES DE LA CATEGORIA -->
          <div class="d-flex gap-3">

            <div class="input-group mb-3">
              
              <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-table-list"></i></span>

              <div class="form-floating">

                <input type="text" class="form-control shadow-sm" id="editarNombreCategoria" placeholder="Nombre de la Categoría" required>
                
                <label for="editarNombreCategoria">Nombre de la Categoría</label>

              </div>

            </div>

          </div>
          
          <!-- DESCRIPCIÓN -->

          <div class="d-flex gap-3">

            <div class="input-group mb-3">
              
              <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-align-justify"></i></span>

              <div class="form-floating">

                <textarea type="text" class="form-control shadow-sm" id="editarDescripcionCategoria" maxLength="256" placeholder="Dirección"></textarea>
                
                <label for="editarDescripcionCategoria">Descripción</label>

              </div>

            </div>

          </div>
        
        </div>
          
        <div class="alert alert-danger my-2 alerta d-none"></div>
        
        <!-- ACCIONES -->

        <div class="modal-footer bg-secondary-subtle">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>

          <button type="submit" id="btnEditarCategoria" class="btn btn-warning"><i class="fa-solid fa-plus"></i> Guardar cambios</button>

        </div>

      </form>

    </div>

  </div>

</div>
