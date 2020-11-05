<?php
require_once dirname( __DIR__ ).'/config/conexion.php';

class ModeloCategorias{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

static public function mdlIngresarCategoria($tabla, $datos){
	try{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(categoria, id_familia, ultusuario) VALUES (:categoria, :id_familia, :ultusuario)");

		$stmt->bindParam(":categoria",  $datos["categoria"], PDO::PARAM_STR);
        $stmt->bindParam(":id_familia", $datos["id_familia"], PDO::PARAM_INT);
		$stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	}catch(Exception $e) {
		return $e->getMessage() ;
    }
		$stmt->close();
		$stmt = null;

}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

static public function mdlMostrarCategorias($tabla, $item, $valor){
	try{
		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT cat.id, cat.id_familia, cat.categoria, cat.fecha,fam.familia FROM $tabla cat INNER JOIN familias fam ON cat.id_familia=fam.id");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
	}catch(Exception $e) {
		return $e->getMessage() ;
    }
		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	public function mdlEditarCategoria($tabla, $datos){
    try{
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET categoria = :categoria, id_familia= :id_familia, ultusuario = :ultusuario WHERE id = :id");

		$stmt -> bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_familia", $datos["id_familia"], PDO::PARAM_INT);
		$stmt -> bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
    }catch(Exception $e) {
		return $e->getMessage() ;
    }
		$stmt->close();
		$stmt = null;

}
	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	public function mdlBorrarCategoria($tabla, $datos){

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

