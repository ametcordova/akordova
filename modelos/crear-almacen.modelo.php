<?php
require_once dirname( __DIR__ ).'/config/conexion.php';

class ModeloAlmacenes{

	/*=============================================
	CREAR ALMACEN
	=============================================*/

	 static public function mdlIngresarAlmacen($tabla, $datos){

	 $crear_tb_almacen = Conexion::conectar()->prepare('
	 CREATE TABLE IF NOT EXISTS '.$datos["nombre"].' (
	 id int(5) NOT NULL AUTO_INCREMENT,
	 id_producto int(5) NOT NULL,
	 codigointerno varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	 cant float(10,2) NOT NULL DEFAULT 0,
	 precio_compra float(10,2) NOT NULL default 0.00,
	 margen_utilidad float(6,2) NOT NULL default 0.00,
	 precio_venta float(10,2) NOT NULL default 0.00,
	 fecha_entrada date NOT NULL,
	 ultmodificacion timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	 ultusuario tinyint(1) DEFAULT NULL,
	 PRIMARY KEY (id)
	 )ENGINE=InnoDB DEFAULT CHARSET=utf8;');
	 
	 if($crear_tb_almacen->execute()){
	 
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, ubicacion, responsable, telefono, email, ultusuario) VALUES (:nombre, :ubicacion, :responsable, :telefono, :email, :ultusuario)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":ubicacion", $datos["ubicacion"], PDO::PARAM_STR);
		$stmt->bindParam(":responsable", $datos["responsable"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

	 }else{
		return "error"; 
	 }
		$stmt->close();
		$stmt = null;
		return true;

	}

/*=============================================
	MOSTRAR ALMACENES
	=============================================*/

	static public function mdlMostrarAlmacenes($tabla, $item, $valor){

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
	EDITAR CLIENTE
	=============================================*/

	 static public function mdlEditarAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ubicacion= :ubicacion, responsable= :responsable, email= :email, telefono= :telefono, ultusuario= :ultusuario WHERE id= :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":ubicacion", $datos["ubicacion"], PDO::PARAM_STR);
		$stmt->bindParam(":responsable", $datos["responsable"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
        
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}   
    
    
/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function mdlEliminarAlmacen($tabla, $datos){

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
    

}  //fin de la clase