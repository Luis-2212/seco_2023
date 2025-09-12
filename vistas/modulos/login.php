<section class="d-flex justify-content-center align-items-center w-100 sectionLogin" style="height: 100vh;">

    <form method="post" role="form" id="formIniciarSesion" class="mx-auto d-flex flex-column justify-contente-center align-items-center rounded-4 px-5 py-3 shadow-lg">
        
        <div class="mb-4">

            <img src="public/img/seco.png" alt="SECO" width="150">

        </div>

        <h3 class="text-center fw-semibold text-wrap mb-2">Bienvenido/a</h3>

        <div class="input-group my-2">

            <input type="text" name="ingUsuario" id="ingUsuario" aria-label="nombre usuario" placeholder="usuario" class="form-control form-control-lg border-1 border-dark">

        </div>

        <div class="input-group my-2">

            <input type="password" name="ingPassword" id="ingPassword" aria-label="password" placeholder="Contraseña" class="form-control form-control-lg border-1 border-dark">

        </div>

        <div class="input-group my-3 w-100">
            
            <button type="submit" id="btnIniciarSesion" class="btn btn-outline-warning mx-auto">Iniciar sesión&nbsp;<i class="fa-solid fa-right-to-bracket"></i></button>
        
        </div>

        
        <div class="alert alert-danger my-2 alertaLogin d-none"></div>

    </form>

</section>