<div class="content-wrapper px-5 py-3 pb-5 text-bg-light contenedor-principal" style="background-image: url('public/img/background.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;">

  <section class="content-header bg-dark py-2 px-3 rounded mb-3 shadow-lg">

    <h3 class="text-warning">Bienvenido</h3>

    <hr class="border border-2 border-warning mt-0">

    <h4 class="text-light"><?php echo $_SESSION["nombres"] ." ". $_SESSION["apellidos"] ?></h4>

  </section>

  <?php if ($_SESSION["rol"] === 1 || $_SESSION["rol"] === 2): ?>
    
    <section class="content-header bg-light py-2 px-3 rounded mb-3 shadow-lg">

      <h3 class="text-dark fw-semibold font-monospace">Acceso de ventas</h3>

      <hr class="border border-2 border-dark mt-0">

      <div class="row py-3 px-auto g-3">

        <a href="crear-venta" class="btn btn-dark col-md-2 col-sm-4 mx-3 text-light text-decoration-none shadow">
          <div class="card-header text-center"><i class="fa-solid fa-cash-register iconos"></i></div>
          <div class="card-body fw-semibold text-center">Generar venta</div>
        </a>

      </div>

    </section>

  <?php endif; ?>

  <?php if ($_SESSION["rol"] === 1 || $_SESSION["rol"] === 3): ?>
    
    <section class="content-header bg-light py-2 px-3 rounded mb-3 shadow-lg">

      <h3 class="text-dark fw-semibold font-monospace">Gestión productos</h3>

      <hr class="border border-2 border-dark mt-0">

      <div class="row py-3 px-auto g-3">

        <a href="productos" class="btn btn-dark col-md-2 col-sm-4 mx-3 text-light text-decoration-none shadow">
          <div class="card-header text-center"><i class="fa-solid fa-boxes-stacked iconos"></i></div>
          <div class="card-body fw-semibold text-center">Productos</div>
        </a>
        
        <a href="marcas" class="btn btn-dark col-md-2 col-sm-4 mx-3 text-light text-decoration-none shadow">
          <div class="card-header text-center"><i class="fa-brands fa-font-awesome iconos"></i></div>
          <div class="card-body fw-semibold text-center">Marcas</div>
        </a>
        
        <a href="categorias" class="btn btn-dark col-md-2 col-sm-4 mx-3 text-light text-decoration-none shadow">
          <div class="card-header text-center"><i class="fa-solid fa-tags iconos"></i></div>
          <div class="card-body fw-semibold text-center">Categorias</div>
        </a>
        
      </div>

    </section>

  <?php endif; ?>

  <?php if ($_SESSION["rol"] === 1): ?>
    
    <section class="content-header bg-light py-2 px-3 rounded mb-3 shadow-lg">

      <h3 class="text-dark fw-semibold font-monospace">Gestión Administrativa</h3>

      <hr class="border border-2 border-dark mt-0">

      <div class="row py-3 px-auto g-3">

        <a href="usuarios" class="btn btn-dark col-md-2 col-sm-4 mx-3 text-light text-decoration-none shadow">
          <div class="card-header text-center"><i class="fa-solid fa-user-tie iconos"></i></div>
          <div class="card-body fw-semibold text-center">Usuarios</div>
        </a>
        
        <a href="clientes" class="btn btn-dark col-md-2 col-sm-4 mx-3 text-light text-decoration-none shadow">
          <div class="card-header text-center"><i class="fa-solid fa-users iconos"></i></div>
          <div class="card-body fw-semibold text-center">Clientes</div>
        </a>
        
        <a href="proveedores" class="btn btn-dark col-md-2 col-sm-4 mx-3 text-light text-decoration-none shadow">
          <div class="card-header text-center"><i class="fa-solid fa-truck iconos"></i></div>
          <div class="card-body fw-semibold text-center">Proveedores</div>
        </a>
        
        <a href="ventas" class="btn btn-dark col-md-2 col-sm-4 mx-3 text-light text-decoration-none shadow">
          <div class="card-header text-center"><i class="fa-solid fa-file-invoice iconos"></i></div>
          <div class="card-body fw-semibold text-center">Reportes</div>
        </a>
        
      </div>

    </section>

  <?php endif; ?>

</div>
