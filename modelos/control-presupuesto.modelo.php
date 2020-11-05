<?php
date_default_timezone_set('America/Mexico_City');
require_once dirname( __DIR__ ).'/config/conexion.php';
class ModeloIngreso{

/*=============================================
	INSERTAR INGRESOS
=============================================*/
static public function mdlIngreso($tabla, $datos){
 try {
        
	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(fecha_ingreso, concepto_ingreso, descripcion_ingreso, importe_ingreso, id_caja, ultusuario) VALUES (:fecha_ingreso, :concepto_ingreso, :descripcion_ingreso, :importe_ingreso, :id_caja, :ultusuario)");

		$stmt->bindParam(":fecha_ingreso", $datos["fecha_ingreso"], PDO::PARAM_STR);
		$stmt->bindParam(":concepto_ingreso", $datos["concepto_ingreso"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion_ingreso", $datos["descripcion_ingreso"], PDO::PARAM_STR);
		$stmt->bindParam(":importe_ingreso", $datos["importe_ingreso"], PDO::PARAM_STR);
		$stmt->bindParam(":id_caja", $datos["id_caja"], PDO::PARAM_INT);
        $stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
		if($stmt->execute()){
            
			 return "ok";
            
        }else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

 } catch (Exception $e) {
  echo "Failed: " . $e->getMessage();
 }
        
}

/*=============================================
	INSERTAR EGRESOS
=============================================*/
static public function mdlEgreso($tabla, $datos){
	try {
		   
	   $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(fecha_egreso, concepto_egreso, descripcion_egreso, importe_egreso, id_caja, ultusuario) VALUES (:fecha_egreso, :concepto_egreso, :descripcion_egreso, :importe_egreso, :id_caja, :ultusuario)");
   
		   $stmt->bindParam(":fecha_egreso", $datos["fecha_egreso"], PDO::PARAM_STR);
		   $stmt->bindParam(":concepto_egreso", $datos["concepto_egreso"], PDO::PARAM_STR);
		   $stmt->bindParam(":descripcion_egreso", $datos["descripcion_egreso"], PDO::PARAM_STR);
		   $stmt->bindParam(":importe_egreso", $datos["importe_egreso"], PDO::PARAM_STR);
		   $stmt->bindParam(":id_caja", $datos["id_caja"], PDO::PARAM_INT);
		   $stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
		   if($stmt->execute()){
			   
				return "ok";
			   
		   }else{
   
			   return "error";
		   
		   }
   
		   $stmt->close();
		   $stmt = null;
   
	} catch (Exception $e) {
	 echo "Failed: " . $e->getMessage();
	}
		   
   }
  

/*=============================================
	EDITAR CAJA
=============================================*/

static public function mdlModificar($tabla, $datos){
	
	try{
		if($tabla=="ingresos"){
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET concepto_ingreso =:concepto_ingreso, descripcion_ingreso=:descripcion_ingreso, importe_ingreso=:importe_ingreso, id_caja=:id_caja, ultusuario=:ultusuario WHERE id=:id");

			$stmt -> bindParam(":concepto_ingreso", $datos["concepto_ingreso"], PDO::PARAM_STR);
			$stmt -> bindParam(":descripcion_ingreso", $datos["descripcion_ingreso"], PDO::PARAM_STR);
			$stmt -> bindParam(":importe_ingreso", $datos["importe_ingreso"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_caja", $datos["id_caja"], PDO::PARAM_INT);
			$stmt -> bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
			$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
	
			$stmt->execute(); 
			
			if($stmt==true){
				return true;
			}else{
				return false;
			}
		}else{
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET concepto_egreso =:concepto_egreso, descripcion_egreso=:descripcion_egreso, importe_egreso=:importe_egreso, id_caja=:id_caja, ultusuario=:ultusuario WHERE id=:id");

			$stmt -> bindParam(":concepto_egreso", $datos["concepto_egreso"], PDO::PARAM_STR);
			$stmt -> bindParam(":descripcion_egreso", $datos["descripcion_egreso"], PDO::PARAM_STR);
			$stmt -> bindParam(":importe_egreso", $datos["importe_egreso"], PDO::PARAM_STR);
			$stmt->bindParam(":id_caja", $datos["id_caja"], PDO::PARAM_INT);
			$stmt -> bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
			$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
	
			$stmt->execute(); 
			
			if($stmt==true){
				return true;
			}else{
				return false;
			}

		}

		$stmt = null;

	}catch(Exception $e) {
		die($e->getMessage());
	}
}
	   
/*=============================================
	MOSTRAR CAJAS
=============================================*/
static public function mdlMostrarReg($tabla, $item, $valor){
	if(trim($tabla)=="ingresos"){
		//$importe="importe_ingreso";
		$item="fecha_ingreso";
	}else{
		//$importe="importe_egreso";
		$item="fecha_egreso";
	}
	try {
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item='".$valor."' order BY id");
		$stmt -> execute();
		return $stmt -> fetchAll();

		$stmt = null;

	} catch (Exception $e) {
		die($e->getMessage());
	}

}  
  
/*=============================================
	ELIMINAR INGRESO
=============================================*/
	static public function mdlEliminar($tabla, $item, $valor){
	try {  
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
        
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
        
		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	} catch (Exception $e) {
		echo "Failed: " . $e->getMessage();
	}


	}
  
/*=============================================
	VER INGRESO/EGRESO CONSULTA CON CROSS JOIN
===============================================*/
static public function mdlingresoegreso($item, $valor, $cerrado){

	$stmt = Conexion::conectar()->prepare("SELECT ing.monto_ingreso, egr.monto_egreso FROM 
	(SELECT SUM(importe_ingreso) AS monto_ingreso FROM ingresos WHERE fecha_ingreso=curdate() AND $item = :$item AND id_corte=:id_corte) ing 
	CROSS JOIN 
	(SELECT SUM(importe_egreso) AS monto_egreso FROM egresos WHERE fecha_egreso=curdate() AND $item = :$item AND id_corte=:id_corte) egr"); 

	$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
	$stmt -> bindParam(":id_corte", $cerrado, PDO::PARAM_INT);
	$stmt -> execute();
	
		return $stmt -> fetch();

	$stmt -> close();

	$stmt = null;

}

/*=============================================
	VER INGRESO/EGRESO CONSULTA CON CROSS JOIN
===============================================*/
static public function mdlImporteCajaChica($tabla, $item, $valor, $cerrado, $fecha_actual){

	$stmt = Conexion::conectar()->prepare("SELECT cajachica FROM $tabla WHERE $item = :$item AND fecha_venta= :fecha_venta AND estatus=:estatus"); 

	$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
	$stmt -> bindParam(":fecha_venta", $fecha_actual, PDO::PARAM_STR);
	$stmt -> bindParam(":estatus", $cerrado, PDO::PARAM_INT);
	$stmt -> execute();
	
		return $stmt -> fetch();

	$stmt -> close();

	$stmt = null;

}

} //fin de la clase SELECT i.ingreso, e.egreso FROM 

