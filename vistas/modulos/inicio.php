<div class="content-wrapper px-5 py-3 pb-5 text-bg-light contenedor-principal" style="background-image: url('public/img/backgroup.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;">

  <section class="content-header bg-dark py-2 px-3 rounded mb-3 shadow-lg">

    <h3 class="text-warning">Bienvenido</h3>

    <hr class="border border-2 border-warning mt-0">

    <h4 class="text-light"><?php echo $_SESSION["nombres"] ." ". $_SESSION["apellidos"] ?></h4>

  </section>

  <section class="content">

    <div class="row py-3 px-auto">

      <?php if ($_SESSION["rol"] == 1): ?>
        
        <a href="usuarios" class="btn btn-dark col-md-2 col-sm-8 mx-3 text-light text-decoration-none shadow">
          <div class="card-header text-center"><i class="fa-solid fa-user-tie iconos"></i></div>
          <div class="card-body fw-semibold text-center">Usuarios</div>
        </a>
        
      <?php endif; ?>

    </div>

  </section>

</div>
