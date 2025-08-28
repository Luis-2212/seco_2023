
<div class="offcanvas offcanvas-start text-bg-dark" data-bs-scroll="true" tabindex="-1" id="menuNavegacion" aria-labelledby="menuNavegacionLabel">

    <div class="offcanvas-header justify-content-between">
        
        <h4 class="offcanvas-title" id="menuNavegacionLabel"><i class="fa-solid fa-bars"></i> Menú de navegación</h4>

        <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas" aria-label="Close">X</button>
        
    </div>

    <div class="offcanvas-body">

        <ul class="navbar-nav">

            <li class="nav-item p-1 align-middle">

                <a class="nav-link btn btn-secondary fw-semibold" href="inicio"><i class="fa-solid fa-house"></i> Inicio</a>

            </li>

            <li class="nav-item p-1 align-middle">

                <a class="nav-link btn btn-secondary fw-semibold" href="clientes"><i class="fa-solid fa-users"></i> Clientes</a>

            </li>

            <li class="nav-item p-1 align-middle">

                <a class="nav-link btn btn-secondary fw-semibold" href="crear-venta"><i class="fa-solid fa-cash-register"></i> Generar venta</a>

            </li>

            <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === 1): ?>

                <li class="nav-item p-1 align-middle">

                    <a class="nav-link btn btn-secondary fw-semibold" href="usuarios"><i class="fa-solid fa-user-tie"></i> Usuarios</a>

                </li>

                <li class="nav-item p-1 align-middle">

                    <a class="nav-link btn btn-secondary fw-semibold" href="proveedores"><i class="fa-solid fa-truck"></i> Proveedores</a>

                </li>

                <li class="nav-item p-1 align-middle">

                    <a class="nav-link btn btn-secondary fw-semibold" href="productos"><i class="fa-solid fa-boxes-stacked"></i> Productos</a>

                </li>

                <li class="nav-item p-1 align-middle">

                    <a class="nav-link btn btn-secondary fw-semibold" href="marcas"><i class="fa-brands fa-font-awesome"></i> Marcas</a>

                </li>

                <li class="nav-item p-1 align-middle">

                    <a class="nav-link btn btn-secondary fw-semibold" href="categorias"><i class="fa-solid fa-tags"></i> Categorías</a>

                </li>

            <?php endif; ?>

        </ul>

    </div>

</div>