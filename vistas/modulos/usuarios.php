<?php

  if(isset($_SESSION["iniciarSesion"]) != "ok" || $_SESSION["perfil"] != 1) {

    return header("Location: login");
  } 

?>

<div class="content-wrapper px-5 py-3 pb-5 text-bg-light contenedor-principal" style="background: linear-gradient(to top, #FFFFFF,rgba(11, 87, 36, 0.19));">

  <section class="content-header">

    <h3><b class="text-success" style="text-shadow: 2px 2px 3px rgb(77, 77, 77);">Administrar</b> Usuarios</h3>

  </section>

  <section class="content py-3">

    <form role="form" method="post">

      <div class="container-fluid">

        <h5 class="h5">Nuevo usuario</h5>

        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-success ancho d-flex justify-content-center"><i class="fa-solid fa-address-card"></i></span>
            
            <input type="text" name="nuevoNombres" aria-label="Nombres" placeholder="Nombres" class="form-control shadow-sm" required>

          </div>

        </div>

        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-success ancho d-flex justify-content-center border"><i class="fa-solid fa-envelope"></i></span>
            
            <input type="email" name="nuevoEmail" aria-label="Email" placeholder="Email" class="form-control shadow-sm" required>

          </div>

        </div>

        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-success ancho d-flex justify-content-center"><i class="fa-solid fa-at"></i></span>
            
            <input type="text" name="nuevoUsuario" id="nuevoUsuario" aria-label="Usuario" placeholder="Usuario" class="form-control shadow-sm" required>

          </div>

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-success ancho d-flex justify-content-center"><i class="fa-solid fa-briefcase"></i></span>

            <select class="form-select shadow-sm" id="nuevoRolUsuario" name="nuevoRolUsuario" required>

              <option default value="">Seleccionar Rol de Usuario</option>

              <?php

              $itemRoles = null;
              $valorRoles = null;

              $respuestaRoles = ControladorRoles::ctrMostrarRoles($itemRoles, $valorRoles);

              foreach ($respuestaRoles as $key => $valueRoles) {

                echo '<option value="' . $valueRoles["id"] . '">' . $valueRoles["rol"] . '</option>';
              }

              ?>

            </select>

              <button class="btn btn-primary shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalAgregarRol"><i class="fa-solid fa-plus"></i></button>
              
          </div>

        </div>

        <div class="d-flex gap-3">

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-success ancho d-flex justify-content-center"><i class="fa-solid fa-lock"></i></span>
            
            <input type="password" name="nuevoPassword" aria-label="Contraseña" placeholder="Contraseña" class="form-control shadow-sm pass" minlength="5" required>

          </div>

          <div class="input-group mb-3">

            <span class="input-group-text shadow-sm text-bg-success ancho d-flex justify-content-center"><i class="fa-solid fa-lock"></i></span>
            
            <input type="password" aria-label="Confirmar Contraseña" placeholder="Confirmar Contraseña" class="form-control shadow-sm confirmarPass" minlength="5" required>

          </div>
          
        </div>
            
        <div>

          <button type="submit" id="btnRegistrarUsuario" class="btn btn-success d-flex align-items-center ms-auto shadow-sm" disabled><i class="fa-solid fa-floppy-disk"></i>&nbsp;Registrar</button>
          
        </div>
            
        <div>

          <div id="alerta" class="alert alert-warning my-2 d-none"></div>
          
        </div>

      </div>

    </form>

    <?php

      $nuevoRegistro = new ControladorUsuarios();
      $nuevoRegistro->ctrCrearUsuario();

    ?> 

  </section>

  <section class="content py-3">

    <div class="container-fluid">

      <h5 class="h5">Consultar usuario</h5>

      <table class="table table-bordered table-striped dt-responsive table-sm table-hover align-middle DataTable" width="100%">         

        <thead>         

          <tr class="table-success">           

            <th style="width:50px">#</th>
            <th>Nombre de usuario</th>
            <th>Nombres</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Último login</th>
            <th>Acciones</th>

          </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $usuario = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

          foreach ($usuario as $key => $value) { 
            
            $ultimoLogin = date('d/m/Y H:i:s', strtotime($value["ultimo_login"]));

            echo '<tr>

              <td class="text-end">'.($key+1).'</td>

              <td>'.$value["usuario"].'</td>

              <td>'.$value["nombres"].'</td>

              <td>'.$value["email"].'</td>

              <td>'.$value["rol"].'</td>

              <td>'.$ultimoLogin.'</td>

              <td class="text-center">';

              if ($value['rol'] != "administrador") {

                echo '<div class="btn-group">

                  <button class="btn btn-warning" id="btnEditarUsuario" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario" idUsuario="'.$value["id"].'"><i class="fa fa-pencil"></i></button>

                  <button class="btn btn-danger" id="btnEliminarUsuario" idEliminarUsuario="'.$value["id"].'"><i class="fa fa-trash-can"></i></button>

                </div>';

              }

              echo '</td>

            </tr>';          

          }

        ?>   

        </tbody>

      </table>

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

              <?php

              $itemRoles = null;
              $valorRoles = null;

              $respuestaRoles = ControladorRoles::ctrMostrarRoles($itemRoles, $valorRoles);

              foreach ($respuestaRoles as $key => $valueRoles) {

                echo '<option value="' . $valueRoles["id"] . '">' . $valueRoles["rol"] . '</option>';
              }

              ?>

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

      $editarUsuario = new ControladorUsuarios();
      $editarUsuario->ctrEditarUsuario();

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

        </div>

        <div class="modal-footer bg-secondary-subtle">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>

          <button type="submit" id="btnAgregarRol" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Crear nueva Rol</button>

        </div>

      </form>

      <?php

      $CrearRol = new ControladorRoles();
      $CrearRol->ctrCrearRol();

      ?>

    </div>

  </div>

</div>