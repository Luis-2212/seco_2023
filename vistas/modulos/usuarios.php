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

      <li class="breadcrumb-item active" aria-current="page">Usuarios</li>

    </ol>

  </nav>

  <!--=============================================
  SECCIÓN DEL TITULO DEL MÓDULO
  =============================================-->

  <section class="content-header bg-dark py-2 px-3 rounded mb-3 shadow-lg">

    <h4 class="text-light">Administración</h4>

    <hr class="border border-2 border-warning mt-0">

    <h3 class="text-warning fw-bold">USUARIOS</h3>

  </section>

  <!--=============================================
  SECCION PARA AGREGAR NUEVO USUARIO
  =============================================-->

  <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#seccionRegistrarUsuario" aria-expanded="false" aria-controls="seccionRegistrarUsuario">
    Nuevo Usuario <i class="fa-solid fa-caret-down"></i>
  </button>

  <section class="content rounded shadow-lg my-3 py-3 collapse" id="seccionRegistrarUsuario">

    <form role="form" method="post" id="formCrearUsuario">

      <div class="container-fluid">

        <h5 class="h5">Nuevo usuario</h5>

        <!-- NOMBRES Y APELLIDOS -->
        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-address-card"></i></span>
            
            <input type="text" name="nuevoNombres" id="nuevoNombres" aria-label="Nombres" placeholder="Nombres" class="form-control shadow-sm" required>

          </div>

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-address-card"></i></span>
            
            <input type="text" name="nuevoApellidos" id="nuevoApellidos" aria-label="Apellidos" placeholder="Apellidos" class="form-control shadow-sm" required>

          </div>

        </div>
        
        <!-- USUARIO Y CARGO -->
        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-at"></i></span>
            
            <input type="text" name="nuevoUsername" id="nuevoUsername" aria-label="Usuario" placeholder="Usuario" class="form-control shadow-sm validarUsuario" minlength="4" required>

          </div>

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-briefcase"></i></span>

            <select class="form-select shadow-sm selectMostrarRoles" id="selectMostrarRoles" name="selectMostrarRoles" required>

              <option default value="">Seleccionar Cargo</option>

            </select>

            <button class="btn btn-success shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalAgregarRol"><i class="fa-solid fa-plus"></i></button>
              
          </div>

        </div>

        <!-- CONTRASEÑA -->
        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-lock"></i></span>
            
            <input type="password" name="nuevoPassword" id="nuevoPassword" aria-label="Contraseña" placeholder="Contraseña" class="form-control shadow-sm pass" minlength="8" required>

          </div>

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-lock"></i></span>
            
            <input type="password" aria-label="Confirmar Contraseña" placeholder="Confirmar Contraseña" class="form-control shadow-sm confirmarPass" minlength="8" required>

          </div>
          
        </div>
        
        <!-- ACCIONES -->
        <div>

          <button type="submit" id="btnRegistrarUsuario" class="btn btn-warning d-flex align-items-center ms-auto shadow-sm" disabled><i class="fa-solid fa-floppy-disk"></i>&nbsp;Registrar</button>
          
        </div>

        <div>

          <div class="alert alert-danger my-2 alerta d-none"></div>
          
        </div>

      </div>

    </form>

  </section>

  <hr>
  
  <!--=============================================
  SECCION PARA CONSULTAR USUARIOS
  =============================================-->

  <section class="content py-3">

    <div class="container-fluid">

      <h4>Consultar usuarios</h4>

      <div class="table-responsive p-2 rounded shadow-lg">

        <table class="table table-sm table-bordered table-striped table-light table-hover align-middle" id="tablaUsuarios" width="100%">         

          <thead>         

            <tr class="table-dark">           

              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Nombre de usuario</th>
              <th>Cargo</th>
              <th>Último ingreso</th>
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

<div class="modal fade" id="modalEditarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditarUsuario" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formEditarUsuario">

        <div class="modal-header text-bg-warning">

          <h1 class="modal-title fs-5"><i class="fa-solid fa-user-pen"></i> Editar: <span id="editarUsuario"></span></h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <!-- NOMBRES -->

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-address-card"></i></span>

            <input type="text" name="editarNombres" id="editarNombres" class="form-control shadow-sm" required>

          </div>

          <!-- APELLIDOS -->

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-address-card"></i></span>

            <input type="text" name="editarApellidos" id="editarApellidos" class="form-control shadow-sm" required>

          </div>

          <!-- CARGO -->

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-briefcase"></i></span>

            <select class="form-select shadow-sm selectMostrarRoles" id="editarRoles" name="editarRoles" required></select>

          </div>

          <!-- NOMBRE DE USUARIO -->

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-at"></i></span>

            <input type="text" name="editarUsername" id="editarUsername" class="form-control shadow-sm validarUsuario" required>

          </div>

          <!-- PASSWORD -->

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-lock"></i></span>

            <input type="text" name="editarPassword" id="editarPassword" placeholder="Nueva Contraseña" class="form-control shadow-sm">

            <input type="hidden" name="passwordActual" id="passwordActual">

          </div>

        </div>
          
        <div class="alert alert-danger my-2 alerta d-none"></div>
        
        <!-- ACCIONES -->

        <div class="modal-footer bg-secondary-subtle">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>

          <button type="submit" id="btnEditarUsuario" class="btn btn-warning"><i class="fa-solid fa-plus"></i> Guardar cambios</button>

        </div>

      </form>

      <?php

      ?>

    </div>

  </div>

</div>

<!-- MODAL PARA AGREGAR ROL -->

<div class="modal fade" id="modalAgregarRol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="AgregarRol" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formCrearRol">

        <div class="modal-header text-bg-dark">

          <h1 class="modal-title fs-5" id="agregarRol"><i class="fa-solid fa-briefcase"></i> Agregar nuevo Cargo</h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <!-- NOMBRE DEL ROL/CARGO -->

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-dark ancho d-flex justify-content-center"><i class="fa-solid fa-briefcase"></i></span>

            <input type="text" name="nuevoRol" id="nuevoRol" class="form-control shadow-sm validarRol" placeholder="Nuevo Cargo" required>

          </div>

          <!-- DESCRIPCIÓN DEL ROL/CARGO -->

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-dark ancho d-flex justify-content-center"><i class="fa-solid fa-bars"></i></span>

            <textarea type="text" name="nuevaDescripcion" id="nuevaDescripcion" class="form-control shadow-sm" placeholder="Descripción del Cargo" required></textarea>

          </div>

          <div class="alert alert-danger my-2 alertaRoles d-none"></div>
          
        </div>

        <div class="modal-footer bg-secondary-subtle">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>

          <button type="submit" id="btnAgregarRol" class="btn btn-dark">Crear nuevo Cargo <i class="fa-solid fa-plus" ></i></button>

        </div>

      </form>

    </div>

  </div>

</div>