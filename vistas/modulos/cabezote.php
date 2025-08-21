<?php


if ($_SESSION["rol"] == 1) {
	$accesoAdmin = "";
} else {
	$accesoAdmin = "d-none";
}
        

?>

<header class="container-fluid d-flex flex-column bg-warning align-items-center p-0">

	<!--=====================================
	NAV BAR
	======================================-->

	<nav class="navbar navbar-expand-lg text-bg-warning w-100" data-bs-theme="info">
    
		<div class="container-fluid">
			
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavLinks" aria-controls="navbarNavLinks" aria-label="Toggle navigation">
				
				<span class="navbar-toggler-icon"></span>
			
			</button>
			
			<div class="collapse navbar-collapse" id="navbarNavLinks">
				
				<ul class="navbar-nav d-flex align-items-center">

					<li class="nav-item px-1 align-middle">

						<a class="nav-link" href="inicio">
							<img src="public/logo_bw.png" width="50" height="50" alt="logo">
						</a>

					</li>

					<li class="nav-item px-1 align-middle">

						<a class="nav-link btn btn-secondary fw-semibold" href="productos">Productos</a>

					</li>

					<li class="nav-item px-1 align-middle">

						<a class="nav-link btn btn-secondary fw-semibold" href="clientes">Clientes</a>

					</li>

					<li class="nav-item px-1 align-middle">

						<a class="nav-link btn btn-secondary fw-semibold" href="crear-venta">Generar venta</a>

					</li>

					<li class="nav-item px-1 align-middle <?php echo $accesoAdmin ?>">

						<a class="nav-link btn btn-light fw-semibold" href="panel-administrativo">Administrativo</a>

					</li>

				</ul>

				<ul class="navbar-nav ms-auto px-5">
					
					<li class="nav-item active dropdown">
						
						<button class="nav-link btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							
							<i class="fa-solid fa-user-tie"></i> <?php echo $_SESSION["nombres"]; ?>
							
						</button>
						
						<ul class="dropdown-menu p-0">
							
							<li class="bg-danger">
								<a href="logout" class="btn btn-danger"type="button">Cerrar sesión <i class="fa-solid fa-right-from-bracket"></i></a>
							</li>
							
						</ul>
					</li>
						
				</ul>

			</div>
			
		</div>

	</nav>

</header>