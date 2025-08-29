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

      <li class="breadcrumb-item active" aria-current="page">Productos</li>

    </ol>

  </nav>

  <!--=============================================
  SECCIÓN DEL TITULO DEL MÓDULO
  =============================================-->

  <section class="content-header bg-dark py-2 px-3 rounded mb-3 shadow-lg">

    <h4 class="text-light">Administración</h4>

    <hr class="border border-2 border-warning mt-0">

    <h3 class="text-warning fw-bold">PRODUCTOS</h3>

  </section>

  <!--=============================================
  SECCION PARA AGREGAR NUEVO Productos
  =============================================-->

  <button class="btn btn-warning shadow-md" type="button" data-bs-toggle="collapse" data-bs-target="#seccionRegistrarProducto" aria-expanded="false" aria-controls="seccionRegistrarProducto">
    <i class="fa-solid fa-boxes-stacked"></i> Nuevo Producto <i class="fa-solid fa-caret-down"></i>
  </button>

  <section class="content rounded shadow-lg my-3 py-3 collapse" id="seccionRegistrarProducto">

    <form role="form" method="post" id="formCrearProducto">

      <div class="container-fluid">

        <h5 class="h5">Nuevo producto</h5>

        <!-- NOMBRE PRODUCTO -->

        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-font"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm validarProducto" id="nuevoNombreProducto" placeholder="Nombre del producto" required>
              
              <label for="nuevoNombreProducto">Nombre del producto</label>

            </div>

          </div>

        </div>

        <!-- UNIDAD DE MEDIDA Y STOCK -->

        <div class="d-flex gap-3">
          
          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-ruler"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="nuevoUnidadMedida" placeholder="Unidad de medida" required>

              <label for="nuevoUnidadMedida">Unidad de medida e.g.: KG, L, Unidad</label>

            </div>

          </div>

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-boxes-stacked"></i></span>

            <div class="form-floating">

              <input type="number" class="form-control shadow-sm" id="nuevoStock" placeholder="Cantidad" required>

              <label for="nuevoStock">Cantidad</label>

            </div>

          </div>

        </div>

        <!-- CATEGORIAS Y MARCAS -->

        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-tags"></i></span>

            <div class="form-floating">

              <select class="form-select shadow-sm selectMostrarCategorias" id="nuevoIdCategoria" name="nuevoIdCategoria" required>

                <option default value="">Seleccionar Categoría</option>

              </select>

              <label for="nuevoIdCategoria">Categoría</label>

            </div>

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria"><i class="fa-solid fa-plus"></i></button>

          </div>

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-brands fa-font-awesome"></i></span>

            <div class="form-floating">

              <select class="form-select shadow-sm selectMostrarMarcas" id="nuevoIdMarca" name="nuevoIdMarca" required>

                <option default value="">Seleccionar Marca</option>

              </select>

              <label for="nuevoIdMarca">Marca</label>

            </div>

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarMarca"><i class="fa-solid fa-plus"></i></button>

          </div>

        </div>

        <!-- PRECIOS DE COMPRA Y VENTA -->

        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-hand-holding-dollar"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="nuevoPrecioCompra" placeholder="Precio de compra" required>

              <label for="nuevoPrecioCompra">Precio de compra</label>

            </div>

          </div>

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-circle-dollar-to-slot"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="nuevoPrecioVenta" placeholder="Precio de venta" required>

              <label for="nuevoPrecioVenta">Precio de venta</label>

            </div>

          </div>

        </div>

        <!-- DIRECCIÓN -->

        <div class="d-flex gap-3">

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-align-justify"></i></span>

            <div class="form-floating">

              <textarea rows="10" class="form-control shadow-sm" id="nuevoDescripcionProducto" maxLength="256" placeholder="Descripción del producto"></textarea>

              <label for="nuevoDescripcionProducto">Descripción</label>

            </div>

          </div>

        </div>
        
        <!-- ACCIONES -->
        <div>

          <button type="submit" id="btnRegistrarProducto" class="btn btn-warning d-flex align-items-center ms-auto shadow-sm"><i class="fa-solid fa-floppy-disk"></i>&nbsp;Registrar</button>
          
        </div>

        <div>

          <div class="alert alert-danger my-2 alerta d-none"></div>
          
        </div>

      </div>

    </form>

  </section>

  <hr>
  
  <!--=============================================
  SECCION PARA CONSULTAR Producto
  =============================================-->

  <section class="content py-3">

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

  </section>

</div>

<!-- MODAL PARA EDITAR -->

<div class="modal fade" id="modalEditarProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditarProducto" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formEditarProducto">

        <div class="modal-header text-bg-warning">

          <h1 class="modal-title fs-5"><i class="fa-solid fa-pen-to-square"></i> Editar: <span id="editarProducto"></span></h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <!-- NOMBRE PRODUCTO -->

          <div class="d-flex gap-3">

            <div class="input-group mb-3">
              
              <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-font"></i></span>

              <div class="form-floating">

                <input type="text" class="form-control shadow-sm validarProducto" id="editarNombreProducto" placeholder="Nombre del producto" required>
                
                <label for="editarNombreProducto">Nombre del producto</label>

              </div>

            </div>

          </div>

          <!-- UNIDAD DE MEDIDA Y STOCK -->

          <div class="d-flex gap-3">
            
            <div class="input-group mb-3">
              
              <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-ruler"></i></span>

              <div class="form-floating">

                <input type="text" class="form-control shadow-sm" id="editarUnidadMedida" placeholder="Unidad de medida" required>

                <label for="editarUnidadMedida">Unidad de medida e.g.: KG, L, Unidad</label>

              </div>

            </div>

            <div class="input-group mb-3">
              
              <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-boxes-stacked"></i></span>

              <div class="form-floating">

                <input type="number" class="form-control shadow-sm" id="editarStock" placeholder="Cantidad" required>

                <label for="editarStock">Cantidad</label>

              </div>

            </div>

          </div>

          <!-- CATEGORIAS Y MARCAS -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-tags"></i></span>

            <div class="form-floating">

              <select class="form-select shadow-sm selectMostrarCategorias" id="editarIdCategoria" name="editarIdCategoria" required>

                <option default value="">Seleccionar Categoría</option>

              </select>

              <label for="editarIdCategoria">Categoría</label>

            </div>

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarCategoria"><i class="fa-solid fa-plus"></i></button>

          </div>

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-brands fa-font-awesome"></i></span>

            <div class="form-floating">

              <select class="form-select shadow-sm selectMostrarMarcas" id="editarIdMarca" name="editarIdMarca" required>

                <option default value="">Seleccionar Marca</option>

              </select>

              <label for="editarIdMarca">Marca</label>

            </div>

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarMarca"><i class="fa-solid fa-plus"></i></button>

          </div>

          <!-- PRECIOS DE COMPRA Y VENTA -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-hand-holding-dollar"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="editarPrecioCompra" placeholder="Precio de compra" required>

              <label for="editarPrecioCompra">Precio de compra</label>

            </div>

          </div>

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-circle-dollar-to-slot"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="editarPrecioVenta" placeholder="Precio de venta" required>

              <label for="editarPrecioVenta">Precio de venta</label>

            </div>

          </div>

          <!-- DIRECCIÓN -->

          <div class="d-flex gap-3">

            <div class="input-group mb-3">
              
              <span class="input-group-text shadow-sm text-bg-warning ancho d-flex justify-content-center"><i class="fa-solid fa-align-justify"></i></span>

              <div class="form-floating">

                <textarea rows="10" class="form-control shadow-sm" id="editarDescripcionProducto" maxLength="256" placeholder="Descripción del producto"></textarea>

                <label for="editarDescripcionProducto">Descripción</label>

              </div>

            </div>

          </div>
          
        </div>
          
        <div class="alert alert-danger my-2 alerta d-none"></div>
        
        <!-- ACCIONES -->

        <div class="modal-footer bg-secondary-subtle">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>

          <button type="submit" id="btnEditarProducto" class="btn btn-warning"><i class="fa-solid fa-plus"></i> Guardar cambios</button>

        </div>

      </form>

      <?php

      ?>

    </div>

  </div>

</div>

<!-- MODAL PARA AGREGAR CATEGORÍA -->

<div class="modal fade" id="modalAgregarCategoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="AgregarCategoria" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formCrearCategoriaProducto">

        <div class="modal-header text-bg-dark">

          <h1 class="modal-title fs-5" id="agregarCategoriaProducto"><i class="fa-solid fa-tags"></i> Agregar nueva Categoría</h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <!-- NOMBRE CATEGORÍA -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-dark ancho d-flex justify-content-center"><i class="fa-solid fa-tags"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="nuevoCategoriaProducto" placeholder="Nombre de la Categoría" required>
              
              <label for="nuevoCategoriaProducto">Nombre de la Categoría</label>

            </div>

          </div>

          <!-- DESCRIPCIÓN DE LA CATEGORÍA -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-dark ancho d-flex justify-content-center"><i class="fa-solid fa-align-justify"></i></span>

            <div class="form-floating">

              <textarea type="text" class="form-control shadow-sm" id="nuevaDescripcionProducto" placeholder="Descripción"></textarea>
              
              <label for="nuevaDescripcionProducto">Descripción</label>

            </div>

          </div>

          <div class="alert alert-danger my-2 alertaCategoria d-none"></div>
          
        </div>

        <div class="modal-footer bg-secondary-subtle">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>

          <button type="submit" id="btnAgregarCategoriaProducto" class="btn btn-dark">Crear nueva Categoría <i class="fa-solid fa-plus"></i></button>

        </div>

      </form>

    </div>

  </div>

</div>

<!-- MODAL PARA AGREGAR MARCA -->

<div class="modal fade" id="modalAgregarMarca" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="AgregarMarca" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formCrearMarcaProducto">

        <div class="modal-header text-bg-dark">

          <h1 class="modal-title fs-5" id="agregarMarcaProducto"><i class="fa-solid fa-font-awesome"></i> Agregar nueva Marca</h1>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

          <!-- NOMBRE DE LA MARCA -->

          <div class="input-group mb-3">
            
            <span class="input-group-text shadow-sm text-bg-dark ancho d-flex justify-content-center"><i class="fa-solid fa-font-awesome"></i></span>

            <div class="form-floating">

              <input type="text" class="form-control shadow-sm" id="nuevoMarcaProducto" placeholder="Nombre de la Categoría" required>
              
              <label for="nuevoMarcaProducto">Nombre de la Marca</label>

            </div>

          </div>

          <div class="alert alert-danger my-2 alertaMarcas d-none"></div>
          
        </div>

        <div class="modal-footer bg-secondary-subtle">

          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>

          <button type="submit" id="btnAgregarMarcaProducto" class="btn btn-dark">Crear nueva Marca <i class="fa-solid fa-plus" ></i></button>

        </div>

      </form>

    </div>

  </div>

</div>