<header class="container-fluid d-flex flex-column bg-warning align-items-center p-0">

	<!--=====================================
	NAV BAR
	======================================-->

	<nav class="navbar navbar-expand-lg text-bg-warning w-100" data-bs-theme="info">
    
		<div class="container-fluid gap-3">
			
			<button class="btn btn-outline-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuNavegacion" aria-controls="menuNavegacion"><i class="fa-solid fa-bars"></i></button>

			<div class="d-flex align-items-center gap-3">

				<a class="nav-link" href="inicio">
					<img src="public/img/seco.png" width="40" height="40" alt="logo">
				</a>

				<h2 class="d-none d-lg-block fw-bold">Sistema de Gestión de Ventas de SECO 2023</h2>

			</div>

			<ul class="navbar-nav ms-auto px-5">
				
				<li class="nav-item active dropdown">
					
					<button class="nav-link btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
						
						<i class="fa-solid fa-user-tie"></i> <?php echo $_SESSION["nombres"] .' '. $_SESSION["apellidos"]; ?>
						
					</button>
					
					<ul class="dropdown-menu p-0">
						
						<li class="bg-danger px-0 text-center">
							<a href="logout" class="btn btn-danger"type="button">Cerrar sesión <i class="fa-solid fa-right-from-bracket"></i></a>
						</li>
						
					</ul>
				</li>
					
			</ul>

		</div>

	</nav>

</header>