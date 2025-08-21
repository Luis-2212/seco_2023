<section class="container d-flex justify-content-center align-items-center" style="height: 100vh;">

    <form method="post" role="form" id="formIniciarSesion" class="w-75 mx-auto d-flex flex-column justify-contente-center align-items-center rounded px-5 py-3 shadow text-bg-warning ">

        <h3 class="text-center text-wrap mb-4">Bienvenido/a</h3>

        <div class="input-group my-2">

            <span class="input-group-text border-1 border-dark bg-secondary-subtle fw-semibold"><i class="fa-solid fa-at"></i></span>

            <input type="text" name="ingUsuario" id="ingUsuario" aria-label="nombre usuario" placeholder="usuario" class="form-control form-control-lg border-1 border-dark">

        </div>

        <div class="input-group my-2">

            <span class="input-group-text border-1 border-dark bg-secondary-subtle"><i class="fa-solid fa-key"></i></span>

            <input type="password" name="ingPassword" id="ingPassword" aria-label="password" placeholder="Contraseña" class="form-control form-control-lg border-1 border-dark">

        </div>

        <div class="input-group my-3 w-100">
            
            <button type="submit" id="btnIniciarSesion" class="btn btn-primary mx-auto">Iniciar sesión&nbsp;<i class="fa-solid fa-right-to-bracket"></i></button>
        
        </div>

    </form>

</section>