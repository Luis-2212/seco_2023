<?php

  if(!isset($_SESSION["logged"]) || $_SESSION["rol"] != 1) {

    return header("Location: login");
  } 

?>

<div class="content-wrapper px-5 py-3 pb-5 text-bg-light contenedor-principal">

  <section class="content-header bg-warning py-2 px-3 rounded mb-3 shadow-lg">

    <h3 class="text-dark">Administración</h3>

    <hr class="border border-2 border-dark mt-0">

    <h4 class="text-dark fw-bold">USUARIOS</h4>

  </section>

  <section class="content py-3">

    <form role="form" method="post" id="formCrearUsuario">

      <div class="container-fluid">

        <h5 class="h5">Nuevo usuario</h5>

        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-address-card"></i></span>
            
            <input type="text" name="nuevoNombres" aria-label="Nombres" placeholder="Nombres" class="form-control shadow-sm" required>

          </div>

        </div>

        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center border"><i class="fa-solid fa-envelope"></i></span>
            
            <input type="email" name="nuevoEmail" aria-label="Email" placeholder="Email" class="form-control shadow-sm" required>

          </div>

        </div>

        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-at"></i></span>
            
            <input type="text" name="nuevoUsuario" id="nuevoUsuario" aria-label="Usuario" placeholder="Usuario" class="form-control shadow-sm" required>

          </div>

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-briefcase"></i></span>

            <select class="form-select shadow-sm" id="selectMostrarRoles" name="selectMostrarRoles" required>

              <option default value="">Seleccionar Rol de Usuario</option>

            </select>

              <button class="btn btn-primary shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalAgregarRol"><i class="fa-solid fa-plus"></i></button>
              
          </div>

        </div>

        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-lock"></i></span>
            
            <input type="password" name="nuevoPassword" aria-label="Contraseña" placeholder="Contraseña" class="form-control shadow-sm pass" minlength="5" required>

          </div>

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-lock"></i></span>
            
            <input type="password" aria-label="Confirmar Contraseña" placeholder="Confirmar Contraseña" class="form-control shadow-sm confirmarPass" minlength="5" required>

          </div>
          
        </div>
            
        <div>

          <button type="submit" id="btnRegistrarUsuario" class="btn btn-warning d-flex align-items-center ms-auto shadow-sm" disabled><i class="fa-solid fa-floppy-disk"></i>&nbsp;Registrar</button>
          
        </div>
            
        <div>

          <div id="alerta" class="alert alert-warning my-2 d-none"></div>
          
        </div>

      </div>

    </form>

  </section>

  <section class="content py-3">

    <div class="container-fluid">

      <h5 class="h5">Consultar usuario</h5>

      <div class="table-responsive">

        <table class="table table-bordered table-striped table-warning table-sm table-hover align-middle DataTable" id="tablaUsuarios" width="100%">         

          <thead>         

            <tr class="table-dark">           

              <!-- <th style="width:50px">#</th> -->
              <th>Rol</th>
              <th>Nombre de usuario</th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Último login</th>

            </tr> 

          </thead>

          <tbody>

          <?php

          ?>   

          </tbody>

        </table>

      </div>

    </div>

  </section>

</div>

<!-- MODAL PARA EDITAR -->

<div class="modal fade" id="modalEditarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditarUsuario" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <div class="modal-header text-bg-warning">

          <h1 class="modal-title fs-5" id="EditarUsuario"><i class="fa-solid fa-user-pen"></i> Editar Usuario</h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-address-card"></i></span>

            <input type="text" name="editarNombres" id="editarNombres" class="form-control shadow-sm" required>

            <input type="hidden" name="idUsuario" id="idUsuario"required>

          </div>

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-envelope"></i></span>

            <input type="text" name="editarEmail" id="editarEmail" class="form-control shadow-sm" required>

          </div>

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-at"></i></span>

            <input type="text" name="editarUsuario" id="editarUsuario" class="form-control shadow-sm" required>

          </div>

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-briefcase"></i></span>

            <select class="form-select shadow-sm" id="editarRoles" name="editarRoles" required>

              <option value="" default>Seleccione un Rol</option>

            </select>

          </div>

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-lock"></i></span>

            <input type="text" name="editarPassword" id="editarPassword" placeholder="Nueva Contraseña" class="form-control shadow-sm">

            <input type="hidden" name="passwordActual" id="passwordActual">

          </div>

        </div>

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


<div class="modal fade" id="modalAgregarRol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="AgregarRol" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <div class="modal-header text-bg-primary">

          <h1 class="modal-title fs-5" id="agregarRol"><i class="fa-solid fa-briefcase"></i> Agregar nuevo Rol</h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-primary ancho d-flex justify-content-center"><i class="fa-solid fa-list-check"></i></span>

            <input type="text" name="nuevoRol" id="nuevoRol" class="form-control shadow-sm" placeholder="nuevo Rol de usuario" required>

          </div>

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-primary ancho d-flex justify-content-center"><i class="fa-solid fa-list-check"></i></span>

            <textarea type="text" name="nuevaDescripcionRol" id="nuevaDescripcionRol" class="form-control shadow-sm" placeholder="Descripción del Rol" required></textarea>

          </div>

        </div>

        <div class="modal-footer bg-secondary-subtle">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>

          <button type="submit" id="btnAgregarRol" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Crear nueva Rol</button>

        </div>

      </form>

      <?php

      // $CrearRol = new ControladorRoles();
      // $CrearRol->ctrCrearRol();

      ?>

    </div>

  </div>

</div>