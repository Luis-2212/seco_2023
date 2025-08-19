<?php

class ControladorRoles{

	/*=============================================
	CREAR ROL DESDE MODULO DE USUARIOS
	=============================================*/

	static public function ctrCrearRol(){

		if(isset($_POST["nuevoRol"])){

			   	$tabla = "roles";

			   	$datos = array("rol"=>$_POST["nuevoRol"]);

			   	$respuesta = ModeloRoles::mdlIngresarRol($tabla, $datos);

			   	if($respuesta == "ok"){

					echo '<script>

					Swal.fire({
						icon: "success",
						title: "Nuevo Rol ingresado con éxito!",
						timer: 1500,
						timerProgressBar: true,
						didOpen: () => {
							Swal.showLoading();
						}
					}).then((result) => {
						if (result.dismiss === Swal.DismissReason.timer) {
							window.location = "usuarios";
						}
					});

				</script>';

			}else{

				echo '<script>

					Swal.fire({
						icon: "error",
						title: "¡Error al crear el nuevo Rol!",
						timer: 2000,
						timerProgressBar: true,
						didOpen: () => {
							Swal.showLoading();
						}
					}).then((result) => {
						if (result.dismiss === Swal.DismissReason.timer) {
							window.location = "usuarios";
						}
					});

				</script>';
			}

		}

	}

	/*=============================================
	MOSTRAR ROLES
	=============================================*/

	static public function ctrMostrarRoles($item, $valor){

		$tabla = "roles";

		$respuesta = ModeloRoles::mdlMostrarRoles($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	EDITAR ROL
	=============================================*/

	/* static public function ctrEditarRol(){

		if(isset($_POST["editarRol"])){

			   	$tabla = "roles";

			   	$datos = array("id"=>$_POST["idRol"],
			   				   "rol"=>$_POST["editarRol"]);

			   	$respuesta = ModeloRoles::mdlEditarRol($tabla, $datos);

			   	if($respuesta == "ok"){

					echo '<script>

					Swal.fire({
						icon: "success",
						title: "¡Rol guardado con éxito!",
						confirmButtonText: "Ok",
					}).then((result) => {
						
						if (result.isConfirmed) {
							window.location = "usuarios";
						}
					});

				</script>';

			}else{

				echo '<script>

					Swal.fire({
						icon: "error",
						title: "¡Error al guardar!",
						confirmButtonText: "Ok",
					}).then((result) => {
						
						if (result.isConfirmed) {
							window.location = "usuarios";
						}
					});

				</script>';
			}

		}

	} */

	/*=============================================
	BORRAR ROL
	=============================================*/

	/* static public function ctrBorrarRol(){

		if(isset($_GET["idRol"])){

			$tabla ="roles";
			$datos = $_GET["idRol"];

			$respuesta = ModeloRoles::mdlBorrarRol($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El Rol ha sido Eliminado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {

								window.location = "roles";

								}
							})

				</script>';

			}		

		}

	} */

	
}



