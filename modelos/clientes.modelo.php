<?php
require_once dirname( __DIR__ ).'/config/conexion.php';

class ModeloClientes{

/*=============================================
	CREAR CLIENTE
=============================================*/

	 public function mdlIngresarCliente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, rfc, email, telefono, direccion, limitecredito, estado, fecha_nacimiento, descuento, ultusuario) VALUES (:nombre, :rfc, :email, :telefono, :direccion, :limitecredito, :estado, :fecha_nacimiento, :descuento, :ultusuario)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":limitecredito", $datos["limitecredito"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
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
	MOSTRAR CLIENTES
	=============================================*/

	static public function mdlMostrarClientes($tabla, $item, $valor){
		if($item != null && $valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();
			
		}else if($valor!=null && $item == null) {

			$stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM $tabla WHERE nombre LIKE '%".$valor."%' ");

			$stmt -> execute();

			return $stmt -> fetchAll();
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}


		$stmt = null;

	}	
    
/*=============================================
	EDITAR CLIENTE
=============================================*/

	 static public function mdlEditarCliente($tabla, $datos){

	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre= :nombre, rfc= :rfc, email= :email, telefono= :telefono, direccion= :direccion, fecha_nacimiento= :fecha_nacimiento, descuento=:descuento, limitecredito=:limitecredito, estado=:estado, ultusuario=:ultusuario WHERE id= :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":limitecredito", $datos["limitecredito"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
        $stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt = null;

	}   

/*=============================================
	ABONO CLIENTE PARA ESTADO DE CUENTA
=============================================*/

static public function mdlAbonoEdoCta($tabla, $datos){
	try {
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_cliente, fecha_abono, abono, concepto_abono) VALUES (:id_cliente, :fecha_abono, :abono, :concepto_abono)");

		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_abono", $datos["fecha_abono"], PDO::PARAM_STR);
        $stmt->bindParam(":abono", $datos["abono"], PDO::PARAM_STR);
        $stmt->bindParam(":concepto_abono", $datos["concepto_abono"], PDO::PARAM_STR);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt = null;
	} catch (Exception $e) {
		echo "Failed: " . $e->getMessage();
    }
	  
}   
	
/*=============================================
	ABONO CLIENTE 
=============================================*/

static public function mdlAbonoCliente($tabla, $datos){
	try {
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET saldo=saldo-(:saldo), ultusuario=:ultusuario WHERE id= :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":saldo", $datos["saldo"], PDO::PARAM_STR);
        $stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt = null;
	} catch (Exception $e) {
		echo "Failed: " . $e->getMessage();
    }
	  
}   
    
/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function mdlEliminarCliente($tabla, $datos){
	try {
		//$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado=0 WHERE id= :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}


		$stmt = null;
	} catch (Exception $e) {
		echo "Failed: " . $e->getMessage();
    }
}

/*=============================================
	REPORTE DE ESTADO DE CUENTA
=============================================*/			
static Public function MdlReporteEdoCta($tabla, $idNumCliente, $fechavtaIni, $fechavtaFin, $idTipoMov){

	if($fechavtaIni==$fechavtaFin){
	 $where=' sal.fecha_salida="'.$fechavtaIni.'"';    
	}else{
	 $where=' sal.fecha_salida>="'.$fechavtaIni.'" AND sal.fecha_salida<="'.$fechavtaFin.'" ';
	}

	$idClie = (int) $idNumCliente;
	$where.=$idClie>0?' AND sal.id_cliente="'.$idNumCliente.'"':'';
	
	$idMovs = (int) $idTipoMov;
	$where.=$idMovs>0?' AND sal.id_tipomov = "'.$idTipoMov.'"':'';


 $where.=' GROUP BY sal.id, sal.id_producto';
	
	$sql="SELECT sal.id, sal.num_salida, sal.fecha_salida, sal.id_producto, pro.precio_compra, sal.id_cliente, sal.id_tipomov, pro.codigointerno,pro.descripcion, sum(sal.cantidad) AS cant, sum(sal.cantidad*sal.precio_venta) AS venta, SUM(IF(sal.`es_promo` = 0, sal.`cantidad`*sal.`precio_venta`,0)) AS sinpromo, SUM(IF(sal.`es_promo` = 1, sal.`precio_venta`,0)) AS promo, sal.precio_venta, sal.es_promo
	FROM hist_salidas sal
	INNER JOIN productos pro ON sal.id_producto=pro.id WHERE ".$where;
		
		$stmt = Conexion::conectar()->prepare($sql);
	
		$stmt -> execute();
	
		return $stmt -> fetchAll();      
		
		$stmt->close();
		   
		$stmt=null;
	
}


/*=============================================
	REPORTE DE ESTADO DE CUENTA
=============================================*/			
static Public function mdlAbonosdeCliente($tabla, $idNumCliente, $fechavtaIni, $fechavtaFin){

	if($fechavtaIni==$fechavtaFin){
	 $where=' fecha_abono="'.$fechavtaIni.'"';    
	}else{
	 $where=' fecha_abono>="'.$fechavtaIni.'" AND fecha_abono<="'.$fechavtaFin.'" ';
	}

	$idClie = (int) $idNumCliente;
	$where.=$idClie>0?' AND id_cliente="'.$idNumCliente.'"':'';
	

	 $where.=' GROUP BY id, id_cliente';
	
	$sql="SELECT * FROM $tabla WHERE ".$where;
		
		$stmt = Conexion::conectar()->prepare($sql);
	
		$stmt -> execute();
	
		return $stmt -> fetchAll();      
		
		$stmt->close();
		   
		$stmt=null;
	
}


			

}  //fin de la clase

/*
SELECT sal.fecha_salida, sal.id_producto, pro.precio_compra, sal.id_cliente,sal.id_tipomov, pro.codigointerno,pro.descripcion, sum(sal.cantidad) AS cant, sum(sal.cantidad*sal.precio_venta) AS venta, SUM(IF(sal.`es_promo` = 0, sal.`cantidad`*sal.`precio_venta`,0)) AS sinpromo, SUM(IF(sal.`es_promo` = 1, sal.`precio_venta`,0)) AS promo 
FROM hist_salidas sal
INNER JOIN productos pro ON sal.id_producto=pro.id
WHERE sal.fecha_salida>="2019-12-18" AND sal.fecha_salida<="2020-01-17" AND sal.id_cliente=3 AND sal.id_tipomov=3 GROUP BY sal.id, sal.id_producto*/
