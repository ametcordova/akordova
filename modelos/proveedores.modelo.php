<?php
require_once dirname( __DIR__ ).'/config/conexion.php';

class ModeloProveedores{

	/*=============================================
	CREAR CLIENTE
	=============================================*/

	 static public function mdlIngresarProveedor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, rfc, direccion, codpostal, ciudad, email, telefono, contacto, tel_contacto, email_contacto, ultusuario, estatus) VALUES (:nombre, :rfc, :direccion, :codpostal, :ciudad, :email, :telefono, :contacto, :tel_contacto, :email_contacto, :ultusuario, :estatus)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":codpostal", $datos["codpostal"], PDO::PARAM_INT);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":contacto", $datos["contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":tel_contacto", $datos["tel_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":email_contacto", $datos["email_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":estatus", $datos["estatus"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

    /*=============================================
	MOSTRAR PROVEEDORES
	=============================================*/

	static public function mdlMostrarProveedores($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}	


    /*=============================================
	ACTUALIZAR PROVEEDOR
	=============================================*/

	 static public function mdlEditarProveedor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre= :nombre, rfc= :rfc, direccion= :direccion, codpostal= :codpostal, ciudad= :ciudad, email= :email, telefono= :telefono, contacto= :contacto, tel_contacto= :tel_contacto, email_contacto= :email_contacto, ultusuario=:ultusuario, estatus= :estatus WHERE id= :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":codpostal", $datos["codpostal"], PDO::PARAM_INT);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":contacto", $datos["contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":tel_contacto", $datos["tel_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":email_contacto", $datos["email_contacto"], PDO::PARAM_STR);
        $stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":estatus", $datos["estatus"], PDO::PARAM_INT);
        
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}       

	/*=============================================
	ELIMINAR CLIENTE PROVEEDOR
	=============================================*/

	static public function mdlEliminarProveedor($tabla, $datos){

		//$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estatus=0 WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}	
    

/*=============================================
	MOSTRAR PROVEEDORES
=============================================*/

static public function mdlContarProveedores($tabla, $item, $valor){

	$stmt = Conexion::conectar()->prepare("SELECT count(id) AS totalprov FROM $tabla WHERE estatus=1");

    $stmt -> execute();
	return $stmt -> fetch();

	$stmt -> close();

	$stmt = null;

}	

    
}  //fin de la clase