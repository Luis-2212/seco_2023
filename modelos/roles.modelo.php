<?php

require_once "conexion.php";

class ModeloRoles{

	/*=============================================
	CREAR ROL
	=============================================*/

	static public function mdlIngresarRol($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("		INSERT INTO $tabla (rol) VALUES (:rol)");

		$stmt->bindParam(":rol", $datos["rol"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";	

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR ROLES
	=============================================*/

	static public function mdlMostrarRoles($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR ROL
	=============================================*/

	static public function mdlEditarRol($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET rol = :rol WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":rol", $datos["rol"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";		

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR ROL
	=============================================*/

	static public function mdlBorrarRol($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;


	}

}	