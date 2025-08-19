<div class="content-wrapper px-5 py-3 pb-5 text-bg-light contenedor-principal">

  <section class="content-header">

    <h3><b class="text-primary">Panel</b> de inicio</h3>

  </section>

  <section class="content">

    <div class="row py-3 px-auto">

      <a href="productos" class="card col-md-2 col-sm-8 mx-3 text-reset text-decoration-none text-bg-info shadow">
        <div class="card-header text-center"><i class="fa-solid fa-shapes iconos"></i></div>
        <div class="card-body fw-semibold text-center">Admin. Productos</div>
      </a>

      <a href="clientes" class="card col-md-2 col-sm-8 mx-3 text-reset text-decoration-none text-bg-danger shadow">
        <div class="card-header text-center"><i class="fa-solid fa-people-group iconos"></i></div>
        <div class="card-body fw-semibold text-center">Admin. Clientes</div>
      </a>

      <a href="crear-venta" class="card col-md-2 col-sm-8 mx-3 text-reset text-decoration-none text-bg-warning shadow">
        <div class="card-header text-center"><i class="fa-solid fa-cash-register iconos"></i></div>
        <div class="card-body fw-semibold text-center">Procesar Venta</div>
      </a>

      <?php if ($_SESSION["perfil"] == 1): ?>
        
        <a href="panel-administrativo" class="card col-md-2 col-sm-8 mx-3 text-reset text-decoration-none text-bg-dark shadow">
          <div class="card-header text-center"><i class="fa-solid fa-user-tie iconos"></i></div>
          <div class="card-body fw-semibold text-center">Panel Administrativo</div>
        </a>
        
      <?php endif; ?>

    </div>

  </section>

</div>
