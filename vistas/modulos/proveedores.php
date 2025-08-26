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

      <li class="breadcrumb-item active" aria-current="page">Proveedores</li>

    </ol>

  </nav>

  <!--=============================================
  SECCIÓN DEL TITULO DEL MÓDULO
  =============================================-->

  <section class="content-header bg-dark py-2 px-3 rounded mb-3 shadow-lg">

    <h4 class="text-light">Administración</h4>

    <hr class="border border-2 border-warning mt-0">

    <h3 class="text-warning fw-bold">PROVEEDORES</h3>

  </section>

  <!--=============================================
SECCION PARA AGREGAR NUEVO PROVEEDOR
  =============================================-->

  <button class="btn btn-warning shadow-md" type="button" data-bs-toggle="collapse" data-bs-target="#seccionRegistrarProveedor" aria-expanded="false" aria-controls="seccionRegistrarProveedor">
    <i class="fa-solid fa-person-circle-plus"></i> Nuevo Proveedor <i class="fa-solid fa-caret-down"></i>
  </button>

  <section class="content rounded shadow-lg my-3 py-3 collapse" id="seccionRegistrarProveedor">

    <form role="form" method="post" id="formCrearProveedor">

      <div class="container-fluid">

        <h5 class="h5">Nuevo proveedor</h5>

        <!-- NOMBRES COMPLETO -->
        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-address-card"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="nuevoNombresProveedor" placeholder="Nombre completo" required>
              
              <label for="nuevoNombresProveedor">Nombre completo</label>

            </div>

          </div>

        </div>
        
        <!-- RAZON SOCIAL -->
        
        <div class="input-group mb-3">
          
          <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-industry"></i></span>

          <div class="form-floating">

            <input type="text" class="form-control shadow-sm" id="nuevoRazonSocial" placeholder="Nombre completo">
            
            <label for="nuevoRazonSocial">Razón social de la empresa (opcional)</label>

          </div>

        </div>

        <!-- IDENTIFICACION y TELEFONO -->

        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-id-card"></i></span>

            <div class="form-floating" style="max-width: 4rem;">

              <select class="form-select shadow-sm selectMostrarTipoIdentificacion" id="nuevoTipoIdentificacion" name="nuevoTipoIdentificacion" required>

                <option default value="V">V</option>
                <option  value="P">P</option>
                <option  value="E">E</option>
                <option  value="J">J</option>
                <option  value="G">G</option>
                <option  value="C">C</option>

              </select>

              <label for="nuevoTipoIdentificacion">Tipo</label>

            </div>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm validarProveedor" id="nuevoIdentificacion" placeholder="Cédula o RIF" inputmode="numeric" required>
              
              <label for="nuevoIdentificacion">Cédula o RIF</label>

            </div>

          </div>

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-mobile-screen"></i></span>

            <div class="input-group-text" style="max-width: 8rem;">
            
              <input type="tel" class="form-control shadow-sm codigo-pais h-100" id="nuevoCodigoPais" value="+58" required>

            </div>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="nuevoTelefono" placeholder="Teléfono e.g: 4241234567" inputmode="numeric" required>
              
              <label for="nuevoTelefono">Teléfono e.g: 4241234567</label>

            </div>

          </div>

        </div>

        <!-- CORREO -->

        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-at"></i></span>

            <div class="form-floating">

              <input type="email" class="form-control shadow-sm" id="nuevoCorreo" placeholder="Correo electrónico" required>
              
              <label for="nuevoCorreo">Correo electrónico</label>

            </div>

          </div>

        </div>

        <!-- CONTRASEÑA -->
        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-map-location"></i></span>

            <div class="form-floating">

              <textarea type="text" class="form-control shadow-sm" id="nuevoDireccion" placeholder="Dirección"></textarea>
              
              <label for="nuevoCorreo">Dirección</label>

            </div>

          </div>

        </div>
        
        <!-- ACCIONES -->
        <div>

          <button type="submit" id="btnRegistrarProveedor" class="btn btn-warning d-flex align-items-center ms-auto shadow-sm"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Registrar</button>
          
        </div>

        <div>

          <div class="alert alert-danger my-2 alerta d-none"></div>
          
        </div>

      </div>

    </form>

  </section>

  <hr>
  
  <!--=============================================
  SECCION PARA CONSULTAR PROVEEDORES
  =============================================-->

  <section class="content py-3">

    <div class="container-fluid">

      <h4>Consultar proveedores</h4>

      <div class="table-responsive p-2 rounded shadow-lg">

        <table class="table table-sm table-bordered table-striped table-light table-hover align-middle" id="tablaProveedor" width="100%">         

          <thead>         

            <tr class="table-dark">           

              <th>Nombres</th>
              <th>Razon Social</th>
              <th>Tipo</th>
              <th>Ci/RIF</th>
              <th>Dirección</th>
              <th>Cod.</th>
              <th>Teléfono</th>
              <th>Email</th>
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

<div class="modal fade" id="modalEditarProveedor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditarProveedor" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formEditarProveedor">

        <div class="modal-header text-bg-warning">

          <h1 class="modal-title fs-5"><i class="fa-solid fa-user-pen"></i> Editar: <span id="editarProveedor"></span></h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <!-- NOMBRES -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-address-card"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="editarNombresProveedor" placeholder="Nombre del proveedor" required>
              
              <label for="editarNombresProveedor">Nombre del proveedor</label>

            </div>

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

          <button type="submit" id="btnEditarProveedor" class="btn btn-warning"><i class="fa-solid fa-plus"></i> Guardar cambios</button>

        </div>

      </form>

      <?php

      ?>

    </div>

  </div>

</div>
