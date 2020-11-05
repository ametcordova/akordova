<?php
date_default_timezone_set('America/Mexico_City');
//echo dirname( __DIR__ ); = C:\xampp\htdocs\cervecentro
require_once dirname( __DIR__ ).'/config/conexion.php';

class ModeloSalidas{

/*=============================================
	REGISTRO DE PRODUCTOS AL HIST_SALIDAS Y ALMACEN
=============================================*/
static public function mdlIngresarSalida($tabla,$nuevoCliente,$fechaSalida,$numSalidaAlmacen,$id_caja, $espromo, $id_producto,$cantidad,$precio_venta,$id_almacen, $tipo_mov, $id_tipovta, $ultusuario,$pagocliente){
	//OBTIENE EL NOMBRE DEL MES ACTUAL 		
	$nombremes_actual = strtolower(date('F'));
	// NOMBRE DEL KARDEX DEL ALMACEN
	$tablakardex="kardex";

	//CAMBIAR EL FORMATO DE FECHA A yyyy-mm-dd   
	$fechSalida = explode('/', $fechaSalida); 
	$newFecha = $fechSalida[2].'-'.$fechSalida[1].'-'.$fechSalida[0];
	$totventa=0;
	$totcant=0;
	$contador = count($id_producto);    //CUANTO PRODUCTOS VIENEN PARA EL FOR
	
  //SCRIP QUE REGISTRA LA SALIDA EN HIST_SALIDA
  try{
		$stmt = Conexion::conectar()->prepare("INSERT INTO hist_salidas(id_cliente, num_salida, fecha_salida, id_producto, cantidad, precio_venta, es_promo, id_almacen, id_tipomov, id_tipovta, id_caja, ultusuario) VALUES (:id_cliente, :num_salida, :fecha_salida, :id_producto, :cantidad, :precio_venta, :es_promo, :id_almacen, :id_tipomov, :id_tipovta, :id_caja, :ultusuario)");

		for($i=0;$i<$contador;$i++) { 
			$stmt->bindParam(":id_cliente", $nuevoCliente, PDO::PARAM_INT);
			$stmt->bindParam(":num_salida", $numSalidaAlmacen, PDO::PARAM_STR);
			$stmt->bindParam(":fecha_salida", $newFecha, PDO::PARAM_STR);
			$stmt->bindParam(":id_producto", $id_producto[$i], PDO::PARAM_INT);
			$stmt->bindParam(":cantidad", $cantidad[$i], PDO::PARAM_STR);
			$stmt->bindParam(":precio_venta", $precio_venta[$i], PDO::PARAM_STR);
			$stmt->bindParam(":es_promo", $espromo[$i], PDO::PARAM_INT);
			$stmt->bindParam(":id_almacen", $id_almacen, PDO::PARAM_INT);
			$stmt->bindParam(":id_tipomov", $tipo_mov, PDO::PARAM_INT);
			$stmt->bindParam(":id_tipovta", $id_tipovta, PDO::PARAM_INT);
			$stmt->bindParam(":id_caja", $id_caja, PDO::PARAM_INT);
			$stmt->bindParam(":ultusuario", $ultusuario, PDO::PARAM_INT);
			$stmt->execute();
			if($espromo[$i]==0){
				$totventa+=($cantidad[$i]*$precio_venta[$i]);
			}else{
				$totventa+=$precio_venta[$i];
			}
			
		}      //termina ciclo 1er for 
	} catch (Exception $e) {
		echo "Failed: " . $e->getMessage();
 	}
	
	 //GRABA TOTAL VENTA Y EL IMPORTE PAGADO POR EL CLIENTE. TABLA cobrosdeventas FORMA CORTA
	 if($stmt){
		$stmt = Conexion::conectar()->prepare("INSERT INTO cobrosdeventas VALUES (DEFAULT, :id_ticket, :totalventa, :pago)");		 
		$stmt->bindParam(":id_ticket", $numSalidaAlmacen, PDO::PARAM_STR);
		$stmt->bindParam(":totalventa", $totventa, PDO::PARAM_STR);
		$stmt->bindParam(":pago", $pagocliente, PDO::PARAM_STR);
		$stmt->execute();
	 }

		if($stmt){
		  //return "ok";
		   for($i=0;$i<$contador;$i++) { 
			 //ACTUALIZA EL CANT EXISTENTE EN ALMACEN SEGUN ID 
			  $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cant=cant-(:cant), ultusuario=:ultusuario WHERE id_producto = :id_producto");
			  $stmt->bindParam(":id_producto", $id_producto[$i], PDO::PARAM_INT);
			  $stmt->bindParam(":cant", $cantidad[$i], PDO::PARAM_STR);
			  $stmt->bindParam(":ultusuario", $ultusuario, PDO::PARAM_INT);
			  $stmt->execute();
			  
				//GUARDA EN KARDEX DEL ALMACEN ELEGIDO
				$query = Conexion::conectar()->prepare("UPDATE $tablakardex SET $nombremes_actual=:$nombremes_actual-($nombremes_actual) WHERE id_producto = :id_producto");
				$query->bindParam(":id_producto", $id_producto[$i], PDO::PARAM_INT);
				$query->bindParam(":".$nombremes_actual, $cantidad[$i], PDO::PARAM_STR);
				$query->execute();


			  //ACTUALIZA EN CATALOGO DE PRODUCTOS, CANT VENDIDOS SEGUN ID
			  $stmtt = Conexion::conectar()->prepare("UPDATE productos SET ventas=:ventas+ventas WHERE id = :id");                   
			  $stmtt->bindParam(":id", $id_producto[$i], PDO::PARAM_INT);
			  $stmtt->bindParam(":ventas", $cantidad[$i], PDO::PARAM_STR);
			  $stmtt->execute();
			  
			}   //termina ciclo 2do for                    
			   //ACTUALIZA TOTAL DE VENTA SEGUN CLIENTE
			   if($stmt){
				if($tipo_mov==3){		//SI ES VENTA A CREDITO
					$stmt = Conexion::conectar()->prepare("UPDATE clientes SET ventas=:ventas+ventas, ultima_venta= :ultima_venta, saldo=:saldo+saldo, ultusuario=:ultusuario WHERE id = :id");
					
					$stmt->bindParam(":id", 			$nuevoCliente, PDO::PARAM_INT);
					$stmt->bindParam(":ventas", 		$totventa, PDO::PARAM_STR);
					$stmt->bindParam(":ultima_venta", 	$newFecha, PDO::PARAM_STR);
					$stmt->bindParam(":saldo", 			$totventa, PDO::PARAM_STR);
					$stmt->bindParam(":ultusuario", 	$ultusuario, PDO::PARAM_INT);
					$stmt->execute();   
				    return "ok";
				}else{
					$stmt = Conexion::conectar()->prepare("UPDATE clientes SET ventas=:ventas+ventas, ultima_venta= :ultima_venta, ultusuario=:ultusuario WHERE id = :id");
					
					$stmt->bindParam(":id", $nuevoCliente, PDO::PARAM_INT);
					$stmt->bindParam(":ventas", $totventa, PDO::PARAM_STR);
					$stmt->bindParam(":ultima_venta", $newFecha, PDO::PARAM_STR);
					$stmt->bindParam(":ultusuario", $ultusuario, PDO::PARAM_INT);
					$stmt->execute();   
					return "ok";
				}	   
				}else{
					 return "error";
				}
			
		}else{
		 return "error";
		}
	
	$stmt->close();
	$query=null;
	$stmt = null;

}

/*=============================================
CIERRE DE CAJA DE VENTA DEL DIA
=============================================*/
static public function mdlCierreDia($tabla, $id_caja, $id_corte, $id_fecha){	
try{       
		$item="fecha_salida";
		$valor=$id_caja;
		$campo="id_caja";
		$cerrado=0;

		$ventas=self::mdlSumaTotalVentas($tabla, $item, $valor, $cerrado,$id_fecha=null);
		$ventasgral=$ventas["sinpromo"]>0?$ventas["sinpromo"]:0;
		$ventaspromo=$ventas["promo"]>0?$ventas["promo"]:0;

		$vtaEnv = self::mdlSumTotVtasEnv($tabla, $item, $valor, $cerrado,$id_fecha=null);
		$ventasenvases=$vtaEnv["total"]>0?$vtaEnv["total"]:0;

		$vtaServ = self::mdlSumTotVtasServ($tabla, $item, $valor, $cerrado,$id_fecha=null);
		$ventasservicios=$vtaServ["total"]>0?$vtaServ["total"]:0;
						 
		$ventasaba=self::mdlSumTotVtasOtros($tabla, $item, $valor, $cerrado,$id_fecha=null);
		$ventasgralaba=$ventasaba["sinpromo"]>0?$ventasaba["sinpromo"]:0;
		$ventaspromoaba=$ventasaba["promo"]>0?$ventasaba["promo"]:0;

		$vtaCred = self::mdlSumTotVtasCred($tabla, $item, $valor, $cerrado,$id_fecha=null);
		$ventascredito=$vtaCred["sinpromo"]+$vtaCred["promo"]>0?$vtaCred["sinpromo"]+$vtaCred["promo"]:0;
		$totingyegr=self::mdlTotalingresoegreso($campo, $valor,$cerrado,$id_fecha=null);
		$ingresodia=$totingyegr["monto_ingreso"]>0?$totingyegr["monto_ingreso"]:0;
		$egresodia=$totingyegr["monto_egreso"]>0?$totingyegr["monto_egreso"]:0;
		$totVentaDia=$ventasgral+$ventaspromo+$ventasenvases+$ventasservicios+$ventasgralaba+$ventaspromoaba+$ventascredito;

		// SABER EL ID DEL CORTE PARA PONER EN HIST_SALIDAS, INGRESOS Y EGRESOS.
		$query = Conexion::conectar()->prepare("SELECT id FROM cortes WHERE fecha_venta=curdate() AND id_caja=$id_caja AND estatus=0");
	if($query->execute()){
		$idcorte = $query->fetch(PDO::FETCH_ASSOC);
		if(is_null($idcorte["id"])){
				unset($_SESSION["abierta"]);
			return true;
		}else{
			
			$numcorte= $idcorte["id"]; 
			if($numcorte>0){

				//CERRAR REGISTRO Y COLOCAR EL ID DE CORTE DE VENTA EN EL HIST_SALIDAS
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cerrado=1, id_corte=$numcorte WHERE fecha_salida=curdate() and id_caja=$id_caja AND cerrado=0");
				if($stmt->execute()){
				
					//ACTUALIZAR TABLA CORTES CON LAS VENTAS, INGRESO Y EGRESOS
					$stmt2 = Conexion::conectar()->prepare("UPDATE cortes SET ventasgral=$ventasgral, ventaspromo=$ventaspromo, ventasenvases=$ventasenvases, ventasservicios=$ventasservicios, ventasabarrotes=($ventasgralaba+$ventaspromoaba),ventascredito=$ventascredito, monto_ingreso=$ingresodia, monto_egreso=$egresodia, total_venta=$totVentaDia, estatus=1 WHERE fecha_venta=curdate() AND id_caja=$id_caja AND estatus=0");
					
					//COLOCAR EL ID DE CORTE DE VENTA EN INGRESOS E EGRESOS
					if ($stmt2->execute()){
						$query = Conexion::conectar()->prepare("UPDATE ingresos SET id_corte=$numcorte WHERE fecha_ingreso=curdate() AND id_caja=$id_caja AND id_corte=0");
						if($query->execute()){
							$query = Conexion::conectar()->prepare("UPDATE egresos SET id_corte=$numcorte WHERE fecha_egreso=curdate() AND id_caja=$id_caja AND id_corte=0");
							$query->execute();
						}
						//por el momento, despues desmarcar
						
					}
				}else{
					return false;
				};
			 unset($_SESSION["abierta"]);
			 return true;
			}else{
				return false;
			}

		}

	}else{
			return true;
			$query-> null;
			$stmt = null;
			$stmt2 = null;
	};


} catch (Exception $e) {
		echo "Failed: " . $e->getMessage();
}

		// $query->close();
		// $stmt -> close();
		// $stmt2 -> close();
}       

/*=================================================================
CIERRE DE CAJA DE VENTA FORZOSO
==================================================================*/
static public function mdlCierreForzoso($tabla, $id_caja, $id_corte, $id_fecha){	
	try{       
		   $item="fecha_salida";
		   $valor=$id_caja;
		   $campo="id_caja";
		   $cerrado=0;
   
		   $ventas=self::mdlSumaTotalVentas($tabla, $item, $valor, $cerrado, $id_fecha);
		   $ventasgral=$ventas["sinpromo"]>0?$ventas["sinpromo"]:0;
		   $ventaspromo=$ventas["promo"]>0?$ventas["promo"]:0;

		   $vtaEnv = self::mdlSumTotVtasEnv($tabla, $item, $valor, $cerrado, $id_fecha);
		   $ventasenvases=$vtaEnv["total"]>0?$vtaEnv["total"]:0;

		   $vtaServ = self::mdlSumTotVtasServ($tabla, $item, $valor, $cerrado, $id_fecha);
		   $ventasservicios=$vtaServ["total"]>0?$vtaServ["total"]:0;

		   $ventasaba=self::mdlSumTotVtasOtros($tabla, $item, $valor, $cerrado, $id_fecha);
		   $ventasgralaba=$ventasaba["sinpromo"]>0?$ventasaba["sinpromo"]:0;
		   $ventaspromoaba=$ventasaba["promo"]>0?$ventasaba["promo"]:0;
   
		   $vtaCred = self::mdlSumTotVtasCred($tabla, $item, $valor, $cerrado, $id_fecha);
		   $ventascredito=$vtaCred["sinpromo"]+$vtaCred["promo"]>0?$vtaCred["sinpromo"]+$vtaCred["promo"]:0;

		   $totingyegr=self::mdlTotalingresoegreso($campo, $valor,$cerrado, $id_fecha);
		   $ingresodia=$totingyegr["monto_ingreso"]>0?$totingyegr["monto_ingreso"]:0;
		   $egresodia=$totingyegr["monto_egreso"]>0?$totingyegr["monto_egreso"]:0;

		   $totVentaDia=$ventasgral+$ventaspromo+$ventasenvases+$ventasservicios+$ventasgralaba+$ventaspromoaba+$ventascredito;
   
			   //CERRAR REGISTRO Y COLOCAR EL ID DE CORTE DE VENTA EN EL HIST_SALIDAS
			   $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cerrado=1, id_corte=$id_corte WHERE fecha_salida='".$id_fecha."' AND id_caja=$id_caja AND cerrado=0");
			   if($stmt->execute()){
			   
				   //ACTUALIZAR TABLA CORTES CON LAS VENTAS, INGRESO Y EGRESOS
				   $stmt2 = Conexion::conectar()->prepare("UPDATE cortes SET ventasgral=$ventasgral, ventaspromo=$ventaspromo, ventasenvases=$ventasenvases, ventasservicios=$ventasservicios, ventasabarrotes=($ventasgralaba+$ventaspromoaba), ventascredito=$ventascredito, monto_ingreso=$ingresodia, monto_egreso=$egresodia, total_venta=$totVentaDia, estatus=1 WHERE fecha_venta='".$id_fecha."' AND id=$id_corte AND id_caja=$id_caja AND estatus=0");
				   
				   //COLOCAR EL ID DE CORTE DE VENTA EN INGRESOS E EGRESOS
				   if ($stmt2->execute()){
					   $query = Conexion::conectar()->prepare("UPDATE ingresos SET id_corte=$id_corte WHERE fecha_ingreso='".$id_fecha."' AND id_caja=$id_caja AND id_corte=0");
					   if($query->execute()){
						   $query = Conexion::conectar()->prepare("UPDATE egresos SET id_corte=$id_corte WHERE fecha_egreso='".$id_fecha."' AND id_caja=$id_caja AND id_corte=0");
						   $query->execute();
					   }
					   //UPDATE `hist_salidas` SET `cerrado`=0,`id_corte`=0 WHERE `fecha_salida`=2019-12-24"
					   //unset($_SESSION["abierta"]);
				   }
				return true;	 
			   }else{
				   return false;
			   }
			   $query->close();
			   $query = null;
			   $stmt -> close();
			   $stmt = null;
			   $stmt2 -> close();
			   $stmt2 = null;
			   
	   } catch (Exception $e) {
		   echo "Failed: " . $e->getMessage();
	   }
   
   }       

/*=========================== MOSTRAR PRODUCTOS A ELIMINAR =================================== */
static public function mdlMostrarProdEliminar($tabla, $item, $valor){
        $stmt=Conexion::conectar()->prepare("SELECT hs.id, hs.id_cliente, hs.num_salida, hs.fecha_salida, hs.id_producto, 
		hs.cantidad, hs.precio_venta, hs.id_almacen, hs.es_promo, al.nombre 
		FROM $tabla hs 
		INNER JOIN almacenes al ON id_almacen=al.id WHERE $item=:$item");
		
        $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
        
        if($stmt -> execute()){
		    return $stmt->fetchAll();
	    }else{
			return "error";	
		}		
		
		$stmt = null;
	
}

/*============== GUARDA REGISTRO AL ELIMINAR VENTA en CANCELA_VENTA========================================*/
static Public function MdlGuardaCancelado($idcliente, $num_cancelacion, $numsalida, $fechasalida, $valor1, $valor2, $prevta, $idalmacen, $espromo,$idUsuario){

   $stmt = Conexion::conectar()->prepare("INSERT INTO cancela_venta(id_cliente, num_cancelacion, num_salida, fecha_salida, id_producto, cantidad, precio_venta, id_almacen, es_promo, ultusuario) VALUES (:id_cliente, :num_cancelacion, :num_salida, :fecha_salida, :id_producto, :cantidad, :precio_venta, :id_almacen, :es_promo, :ultusuario)");

    $stmt->bindParam(":id_cliente", $idcliente, PDO::PARAM_INT);
    $stmt->bindParam(":num_cancelacion", $num_cancelacion, PDO::PARAM_INT);
    $stmt->bindParam(":num_salida", $numsalida, PDO::PARAM_STR);
    $stmt->bindParam(":fecha_salida", $fechasalida, PDO::PARAM_STR);
    $stmt->bindParam(":id_producto", $valor1, PDO::PARAM_INT);
    $stmt->bindParam(":cantidad", $valor2, PDO::PARAM_INT);
    $stmt->bindParam(":precio_venta", $prevta, PDO::PARAM_STR);
    $stmt->bindParam(":id_almacen", $idalmacen, PDO::PARAM_INT);
    $stmt->bindParam(":es_promo", $espromo, PDO::PARAM_INT);
    $stmt->bindParam(":ultusuario", $idUsuario, PDO::PARAM_INT);
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}

	//$stmt->close();
	$stmt = null;
    
}	

/*======================= ELIMINAR VENTA ========================================*/
static public function mdlProdEliminar($tabla, $numsalida, $valor1, $valor2){
	//OBTIENE EL NOMBRE DEL MES ACTUAL 		
	$nombremes_actual = strtolower(date('F'));
	// NOMBRE DEL KARDEX DEL ALMACEN
	$tablakardex="kardex";

	$stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE num_salida=:num_salida AND id_producto=:id_producto");

	$stmt->bindParam(":num_salida", $numsalida, PDO::PARAM_STR);
	$stmt->bindParam(":id_producto", $valor1, PDO::PARAM_INT);
	
	if($stmt -> execute()){
		//GUARDA EN KARDEX DEL ALMACEN ELEGIDO
		$query = Conexion::conectar()->prepare("UPDATE $tablakardex SET $nombremes_actual=:$nombremes_actual+$nombremes_actual WHERE id_producto = :id_producto");
		$query->bindParam(":id_producto", $valor1, PDO::PARAM_INT);
		$query->bindParam(":".$nombremes_actual, $valor2, PDO::PARAM_STR);
		$query->execute();

		return true;
	}else{
		return "error";	
	}		
	

	$stmt = null;

}
    
/*============== ACTUALIZA EXIST EN ALMACEN AL ELIMINAR VENTA ========================================*/
static Public function MdlActualizaAlmacen($tabla, $campo, $valor1, $valor2, $idUsuario){

   $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cant=cant+(:cant), ultusuario=:ultusuario WHERE id_producto = :id_producto");
   $stmt->bindParam(":id_producto", $valor1, PDO::PARAM_INT);
   $stmt->bindParam(":cant", $valor2, PDO::PARAM_INT);
   $stmt->bindParam(":ultusuario", $idUsuario, PDO::PARAM_INT);

		if($stmt->execute()){
			return true;
		}else{
			return false;
		}

		$stmt = null;

}		

/*============== ACTUALIZA VENTAS EN PRODUCTOS AL ELIMINAR VENTA ========================================*/
static Public function MdlActualizaProductos($tabla, $valor1, $valor2, $idUsuario){

   $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ventas=ventas-(:ventas), ultusuario=:ultusuario WHERE id = :id");
   $stmt->bindParam(":id", $valor1, PDO::PARAM_INT);
   $stmt->bindParam(":ventas", $valor2, PDO::PARAM_INT);
   $stmt->bindParam(":ultusuario", $idUsuario, PDO::PARAM_INT);

		if($stmt->execute()){
			return true;
		}else{
			return false;
		}

		$stmt = null;

}		

/*=============================================
	REPORTE NOTA DE SALIDAS
=============================================*/	
static Public function MdlSalidaAlm($tabla, $campo, $valor){
  try{   
     if($campo !=null){    
         
	 $sql="SELECT h.id_cliente,t.nombre AS nombrecliente,h.num_salida, h.fecha_salida, h.cantidad,h.precio_venta,h.es_promo, h.id_producto,a.descripcion,a.codigointerno, a.leyenda, a.id_medida, m.medida, h.id_almacen,b.nombre AS nombrealma,h.id_tipomov,s.nombre_tipo, h.id_tipovta, h.ultusuario,u.nombre AS nombreusuario, h.ultmodificacion FROM $tabla h INNER JOIN clientes t ON h.id_cliente=t.id	
	    INNER JOIN productos a ON h.id_producto=a.id
		INNER JOIN almacenes b ON h.id_almacen=b.id
		INNER JOIN medidas m ON a.id_medida=m.id
		INNER JOIN tipomovimiento s ON h.id_tipomov=s.id
		INNER JOIN usuarios u ON h.ultusuario=u.id
		WHERE h.$campo=:$campo ORDER BY h.id_producto ASC";
	 
        $stmt=Conexion::conectar()->prepare($sql);
		
        $stmt->bindParam(":".$campo, $valor, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->fetchAll();
        
         //if ( $stmt->rowCount() > 0 ) { do something here }
        
 	}else{

			return false;

	 }        
	} catch (Exception $e) {
		echo "Failed: " . $e->getMessage();
    }
        
        $stmt->close();
        
        $stmt=null;
	}    
	
/*=============================================
	
=============================================*/	    
static Public function MdlCobroVenta($tabla, $item, $valor){
try{   	
	if($item !=null){    
	   $stmt=Conexion::conectar()->prepare("SELECT pago FROM $tabla WHERE $item=:$item");
	   
	   $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
	   
	   $stmt->execute();
	   
	   return $stmt->fetch();
	}else{
		   return false;
	}    
	
} catch (Exception $e) {
	echo "Failed: " . $e->getMessage();
}	
	   $stmt->close();
	   $stmt=null;
}

/*=============================================
	VALIDA QUE NUMERO DE SALIDA NO SE REPITA
=============================================*/	    
 static Public function MdlValidarNumSalida($tabla, $campo, $valor){
     if($campo !=null){    
        $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:$campo");
        
        $stmt->bindParam(":".$campo, $valor, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->fetch();
 	}else{
			return false;
	 }        
        //$stmt->close();
        $stmt=null;
    }


/*=============================================
	OBTENER EL ULTIMO NUMERO CANCELADO
=============================================*/	    
static Public function mdlgetUltNumCancelado(){
	try{        
	   $stmt=Conexion::conectar()->prepare("SELECT MAX(num_cancelacion)+1 AS num_cancelacion FROM cancela_venta");

	   $stmt->execute();
	   
	   return $stmt->fetch();

	} catch (Exception $e) {
		echo "Failed: " . $e->getMessage();
    }
	   //$stmt->close();
	   
	   $stmt=null;
   }

/*=============================================
	ASIGNAR NUMERO DE SALIDA
=============================================*/	    
 static Public function MdlAsignarNumSalida($tabla, $item, $valor){
     
     if($item !=null){    
		// SELECT MAX(id) AS id FROM productos // SELECT MAX(num_salida) AS num_salida FROM hist_salidas
        //$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC limit 1");
        $stmt=Conexion::conectar()->prepare("SELECT MAX(num_salida)+1 AS num_salida FROM $tabla");

        $stmt->execute();
		
        return $stmt->fetch();
        
 	}else{

			return false;

	 }        
        
        
        $stmt=null;
    }

/*=============================================
	MOSTRAR TIPO DE MOV DE SALIDA
=============================================*/
static public function MdlMostrarTipoMovs($tabla, $item, $valor){
  if($item !=null){    
	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");

	$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

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
	REPORTE DE SALIDAS DEL ALMACEN
=============================================*/			
static Public function MdlMostrarSalidas($tabla, $campo, $valor, $fechaSel){

$where='1=1';

$idtec = (int) $valor;
$where.=($idtec>0)? ' AND id_cliente="'.$idtec.'" ' : "";

$tabla = (int) $tabla;
$where.=($tabla>0)? ' AND id_almacen="'.$tabla.'"' : "";

$where.=(!empty($fechaSel))? ' AND fecha_salida="'.$fechaSel.'"' : "";

$where.=' GROUP by num_salida,fecha_salida,id_almacen,id_cliente';

if($tabla>0 || $idtec>0 || !empty($fechaSel)){			//QUE ALMACEN MOSTRAR SALIDAS
	$sql="SELECT `id_cliente`, t.nombre AS nombrecliente, `num_salida`, `fecha_salida`, SUM(`cantidad`) AS salio, 
	SUM(IF(`es_promo` = 0, `cantidad`*`precio_venta`,0)) AS sinpromo, 
	SUM(IF(`es_promo` = 1, `precio_venta`,0)) AS promo, id_tipovta,
	`id_almacen`,a.nombre  AS almacen FROM `hist_salidas` INNER JOIN clientes t ON id_cliente=t.id 
	INNER JOIN almacenes a ON id_almacen=a.id WHERE ".$where;
	
}else{                  // TODOS LOS ALMACENES

	$sql="SELECT `id_cliente`, t.nombre AS nombrecliente, `num_salida`, `fecha_salida`, SUM(`cantidad`) AS salio, id_tipovta, `id_almacen`,a.nombre  AS almacen FROM `hist_salidas` INNER JOIN clientes t ON id_cliente=t.id 
	INNER JOIN almacenes a ON id_almacen=a.id
	GROUP by `num_salida`,`fecha_salida`,`id_almacen`,`id_cliente`";
}

        $stmt=Conexion::conectar()->prepare($sql);
		
        //$stmt->bindParam(":".$campo, $valor, PDO::PARAM_STR);
        
        if($stmt->execute()){;
        
         return $stmt->fetchAll();
        
         //if ( $stmt->rowCount() > 0 ) { do something here }
        
 	  }else{

			return false;

	   }         
        
        
        $stmt=null;
    }	
		
/*======================================================
	SUMAR EL TOTAL DE VENTAS SIN ENVASES Y SIN SERVICIOS
========================================================*/
static public function mdlSumaTotalVentas($tabla, $item, $valor, $cerrado, $fechacutvta){	
    //CAMBIAR EL FORMATO DE FECHA A yyyy-mm-dd   
    //$fechadehoy = explode('/', $valor); 
	//$valor = $fechadehoy[2].'-'.$fechadehoy[1].'-'.$fechadehoy[0];
	/*
*/
    if($fechacutvta!=null){
		$stmt = Conexion::conectar()->prepare("SELECT h.`fecha_salida`, SUM(IF(h.`es_promo` = 0, h.`cantidad`*h.`precio_venta`,0)) AS sinpromo, 
		SUM(IF(h.`es_promo` = 1, h.`precio_venta`,0)) AS promo, h.cerrado FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id 
		WHERE h.$item='".$fechacutvta."' and p.totaliza=1 and h.id_caja=$valor and h.cerrado=$cerrado AND h.id_tipomov=1");
    }else{
		$stmt = Conexion::conectar()->prepare("SELECT h.`fecha_salida`, SUM(IF(h.`es_promo` = 0, h.`cantidad`*h.`precio_venta`,0)) AS sinpromo, 
		SUM(IF(h.`es_promo` = 1, h.`precio_venta`,0)) AS promo FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id 
		WHERE h.$item=curdate() and p.totaliza=1 and h.id_caja=$valor and h.cerrado=$cerrado AND h.id_tipomov=1");
    }
        //$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
    
		$stmt -> execute();

		return $stmt -> fetch();


		$stmt = null;

}         

/*=============================================
	SUMAR EL TOTAL DE VENTAS ENVASES
=============================================*/

static public function mdlSumTotVtasEnv($tabla, $item, $valor, $cerrado, $fechacutvta){	

        if($fechacutvta!=null){
          $stmt = Conexion::conectar()->prepare("SELECT h.`fecha_salida`, sum(h.cantidad*h.precio_venta) as total FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id WHERE h.$item='".$fechacutvta."' and p.totaliza=0 and h.id_caja=$valor and h.cerrado=$cerrado AND h.id_tipomov=1");
        }else{
          $stmt = Conexion::conectar()->prepare("SELECT h.`fecha_salida`, sum(h.cantidad*h.precio_venta) as total FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id WHERE h.$item=curdate() and p.totaliza=0 and h.id_caja=$valor and h.cerrado=$cerrado AND h.id_tipomov=1");
        }
    
        //$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
    
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt = null;

}         

/*=============================================
	SUMAR EL TOTAL DE VENTAS SERVICIOS
=============================================*/
static public function mdlSumTotVtasServ($tabla, $item, $valor, $cerrado, $fechacutvta){	

	if($fechacutvta!=null){
	  $stmt = Conexion::conectar()->prepare("SELECT h.`fecha_salida`, sum(h.cantidad*h.precio_venta) as total FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id WHERE h.$item='".$fechacutvta."' and p.totaliza=2 and h.id_caja=$valor and h.cerrado=$cerrado AND h.id_tipomov=1");
	}else{
	  $stmt = Conexion::conectar()->prepare("SELECT h.`fecha_salida`, sum(h.cantidad*h.precio_venta) as total FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id WHERE h.$item=curdate() and p.totaliza=2 and h.id_caja=$valor and h.cerrado=$cerrado AND h.id_tipomov=1");
	}

	$stmt -> execute();

	return $stmt -> fetch();


	$stmt = null;

}         

/*=============================================
	SUMAR EL TOTAL DE VENTAS OTROS
=============================================*/
static public function mdlSumTotVtasOtros($tabla, $item, $valor, $cerrado, $fechacutvta){	

    if($fechacutvta!=null){
		$stmt = Conexion::conectar()->prepare("SELECT h.`fecha_salida`, SUM(IF(h.`es_promo` = 0, h.`cantidad`*h.`precio_venta`,0)) AS sinpromo, 
		SUM(IF(h.`es_promo` = 1, h.`precio_venta`,0)) AS promo, h.cerrado FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id 
		WHERE h.$item='".$fechacutvta."' and p.totaliza=3 and h.id_caja=$valor and h.cerrado=$cerrado AND h.id_tipomov=1");
    }else{
		$stmt = Conexion::conectar()->prepare("SELECT h.`fecha_salida`, SUM(IF(h.`es_promo` = 0, h.`cantidad`*h.`precio_venta`,0)) AS sinpromo, 
		SUM(IF(h.`es_promo` = 1, h.`precio_venta`,0)) AS promo FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id 
		WHERE h.$item=curdate() and p.totaliza=3 and h.id_caja=$valor and h.cerrado=$cerrado AND h.id_tipomov=1");
    }

	$stmt -> execute();

	return $stmt -> fetch();


	$stmt = null;
}         
/*======================================================
	SUMAR EL TOTAL DE VENTAS A CREDITO
========================================================*/
static public function mdlSumTotVtasCred($tabla, $item, $valor, $cerrado, $fechacutvta){	

    if($fechacutvta!=null){
		$stmt = Conexion::conectar()->prepare("SELECT h.`fecha_salida`, SUM(IF(h.`es_promo` = 0, h.`cantidad`*h.`precio_venta`,0)) AS sinpromo, 
		SUM(IF(h.`es_promo` = 1, h.`precio_venta`,0)) AS promo, h.cerrado FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id 
		WHERE h.$item='".$fechacutvta."' and h.id_caja=$valor and h.cerrado=$cerrado AND h.id_tipomov=3");
    }else{
		$stmt = Conexion::conectar()->prepare("SELECT h.`fecha_salida`, SUM(IF(h.`es_promo` = 0, h.`cantidad`*h.`precio_venta`,0)) AS sinpromo, 
		SUM(IF(h.`es_promo` = 1, h.`precio_venta`,0)) AS promo FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id 
		WHERE h.$item=curdate() and h.id_caja=$valor and h.cerrado=$cerrado AND h.id_tipomov=3");
    }
        //$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
    
		$stmt -> execute();

		return $stmt -> fetch();


		$stmt = null;

}  

/*=============================================
CANT TOTAL DE VENTAS DE PROD
=============================================*/
static public function mdlCantTotalVentas($tabla, $item, $valor){	

	$stmt = Conexion::conectar()->prepare("SELECT `fecha_salida`, sum(cantidad) as canttotal FROM $tabla WHERE fecha_salida=curdate()");
    
	$stmt -> execute();

	return $stmt -> fetch();

	$stmt -> close();

	$stmt = null;

}         
/* *********************************************************************************************** */    
/*=============================================
VENTAS ULTIMOS 7 DIAS PARA LA GRAFICA
=============================================*/
static public function mdlVtaUlt7Dias($tabla, $item, $valor){	

		$stmt = Conexion::conectar()->prepare("SELECT id, fecha_salida, round(sum(cantidad*precio_venta),2) as totalvta FROM $tabla WHERE $item=$valor GROUP BY fecha_salida ORDER BY fecha_salida DESC LIMIT 0,7");
    
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

}         
/* *********************************************************************************************** */    

/*=============================================
VENTAS ULTIMOS 7 DIAS PARA LA GRAFICA
=============================================*/
static public function mdlComprasUlt7Dias($tabla, $item, $valor){	

		$stmt = Conexion::conectar()->prepare("SELECT id, fechaentrada, round(sum(cantidad*precio_compra),2) as totalcompra FROM $tabla WHERE $item=$valor GROUP BY fechaentrada ORDER BY fechaentrada DESC LIMIT 0,7");
    
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

}         
/* *********************************************************************************************** */    

/*=============================================
VENTAS ULTIMOS 12 MESES PARA LA GRAFICA
=============================================*/
static public function mdlVtaUlt12Meses($tabla, $item, $valor){	

		$stmt = Conexion::conectar()->prepare("SELECT id, DATE_FORMAT(fecha_salida,'%m') AS fechaventa, round(sum(cantidad*precio_venta),2) as totalvta  FROM $tabla WHERE $item=$valor GROUP BY MONTH(fecha_salida) ORDER BY fecha_salida ASC LIMIT 0,12");
    
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

}         
/* *********************************************************************************************** */    
    
	/*=============================================
	RANGO FECHAS PARA LA GRAFICA
	=============================================*/	

	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT fecha_salida, round(sum(cantidad*precio_venta),2) AS totalvta FROM $tabla WHERE fecha_salida like '%$fechaFinal%'");

			$stmt -> bindParam(":fecha_salida", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$stmt = Conexion::conectar()->prepare("SELECT `fecha_salida`, round(SUM(IF(`es_promo` = 0, `cantidad`*`precio_venta`,0)),2) AS sinpromo, round(SUM(IF(`es_promo` = 1, `precio_venta`,0)),2) AS promo FROM $tabla WHERE fecha_salida BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' GROUP BY fecha_salida");

				//$stmt = Conexion::conectar()->prepare("SELECT fecha_salida, round(sum(cantidad*precio_venta),2) AS totalvta FROM $tabla WHERE fecha_salida BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' GROUP BY fecha_salida");

				//SELECT `fecha_salida`, round(SUM(IF(`es_promo` = 0, `cantidad`*`precio_venta`,0)),2) AS sinpromo, round(SUM(IF(`es_promo` = 1, `precio_venta`,0)),2) AS promo FROM hist_salidas WHERE fecha_salida BETWEEN '2019-08-01' AND '2019-12-27' GROUP BY fecha_salida

			}else{

				$stmt = Conexion::conectar()->prepare("SELECT `fecha_salida`, SUM(IF(`es_promo` = 0, `cantidad`*`precio_venta`,0)) AS sinpromo, SUM(IF(`es_promo` = 1, `precio_venta`,0)) AS promo FROM $tabla WHERE fecha_salida BETWEEN '$fechaInicial' AND '$fechaFinal' GROUP BY fecha_salida ");

				//$stmt = Conexion::conectar()->prepare("SELECT fecha_salida, round(sum(cantidad*precio_venta),2) AS totalvta FROM $tabla WHERE fecha_salida BETWEEN '$fechaInicial' AND '$fechaFinal' GROUP BY fecha_salida");

			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}    

/*=============================================
	VER INGRESO/EGRESO CONSULTA CON CROSS JOIN
=============================================*/
static public function mdlTotalingresoegreso($item, $valor, $cerrado, $id_fecha){

	if($id_fecha!=null){
		$stmt = Conexion::conectar()->prepare("SELECT ing.monto_ingreso, egr.monto_egreso FROM 
		(SELECT SUM(importe_ingreso) AS monto_ingreso FROM ingresos WHERE fecha_ingreso='".$id_fecha."' AND $item = :$item AND id_corte=:id_corte) ing 
		CROSS JOIN 
		(SELECT SUM(importe_egreso) AS monto_egreso FROM egresos WHERE fecha_egreso='".$id_fecha."' AND $item = :$item AND id_corte=:id_corte) egr"); 

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":id_corte", $cerrado, PDO::PARAM_INT);
		$stmt -> execute();
		
			return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}else{
	
		$stmt = Conexion::conectar()->prepare("SELECT ing.monto_ingreso, egr.monto_egreso FROM 
		(SELECT SUM(importe_ingreso) AS monto_ingreso FROM ingresos WHERE fecha_ingreso=curdate() AND $item = :$item AND id_corte=:id_corte) ing 
		CROSS JOIN 
		(SELECT SUM(importe_egreso) AS monto_egreso FROM egresos WHERE fecha_egreso=curdate() AND $item = :$item AND id_corte=:id_corte) egr"); 

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":id_corte", $cerrado, PDO::PARAM_INT);
		$stmt -> execute();
		
			return $stmt -> fetch();

		//$stmt -> close();

		$stmt = null;
	}
}
	
/*=============================================
	REPORTE NOTA DE SALIDAS
=============================================*/	
static Public function mdlQuerydeProductos($tabla, $item, $valor, $estado){
	try{   

		$stmt = Conexion::conectar()->prepare("SELECT unidadxcaja, datos_promocion, precio_venta, granel, ubicacion FROM $tabla WHERE $item=$valor AND estado=$estado");
		
		$stmt -> execute();

		return $stmt -> fetch();
		
	  } catch (Exception $e) {
		  echo "Failed: " . $e->getMessage();
	  }
  //$stmt->close();
  $stmt=null;
}    
  
/*=============================================
	LISTAR CANCELACIONES DE VENTA
=============================================*/
static public function mdlListarCancelaciones($tabla, $item, $valor, $orden, $fechadev1, $fechadev2){

	if($item != null){

	}else{
		$where='fecha_salida>="'.$fechadev1.'" AND fecha_salida<="'.$fechadev2.'" ';
  
		$where.=' group by cv.num_cancelacion ORDER BY cv.'.$orden.' ASC';
		//$where.='  ORDER BY '.$orden.' DESC';
  
		//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ".$where); 
		$stmt = Conexion::conectar()->prepare("SELECT cv.`id`, cv.num_cancelacion, cv.`id_cliente`,cli.nombre,cv.`num_salida`,cv.`fecha_salida`, sum(cv.`cantidad`) AS cant, SUM(IF(cv.`es_promo` = 0, cv.`cantidad`*cv.`precio_venta`,0)) AS sinpromo, SUM(IF(cv.`es_promo` = 1, cv.`precio_venta`,0)) AS promo,cv.`ultusuario`,cv.`ultmodificacion` FROM cancela_venta cv
		INNER JOIN clientes cli ON cli.id=cv.id_cliente
		WHERE ".$where); 

		$stmt -> execute();

		return $stmt -> fetchAll();

	}

	$stmt = null;

}	

/*=============================================
	REPORTE NOTA DE SALIDAS
=============================================*/	
static Public function MdlImprimirCancelacion($tabla, $campo, $valor){
	try{   
	   if($campo !=null){    
		   
	   	$sql="SELECT h.id_cliente,t.nombre AS nombrecliente,h.num_salida, h.fecha_salida, h.cantidad,h.precio_venta,h.es_promo, h.id_producto,a.descripcion,a.codigointerno, a.leyenda, a.id_medida, m.medida, h.id_almacen,b.nombre AS nombrealma,h.ultusuario,u.nombre AS nombreusuario, h.ultmodificacion FROM $tabla h INNER JOIN clientes t ON h.id_cliente=t.id	
		  INNER JOIN productos a ON h.id_producto=a.id
		  INNER JOIN almacenes b ON h.id_almacen=b.id
		  INNER JOIN medidas m ON a.id_medida=m.id
		  INNER JOIN usuarios u ON h.ultusuario=u.id
		  WHERE h.$campo=:$campo ORDER BY h.id_producto ASC";
	   
		  $stmt=Conexion::conectar()->prepare($sql);
		  
		  $stmt->bindParam(":".$campo, $valor, PDO::PARAM_STR);
		  
		  $stmt->execute();
		  
		  return $stmt->fetchAll();
		  
		   //if ( $stmt->rowCount() > 0 ) { do something here }
		  
	   }else{
  
			  return false;
  
	   }        
	  } catch (Exception $e) {
		  echo "Failed: " . $e->getMessage();
	  }
		  
		  $stmt=null;

	  }    

}       //fin de la clase

//"SELECT id, fecha_salida, round(sum(cantidad*precio_venta),2) as totalvta  FROM `hist_salidas` WHERE `fecha_salida`>='2019-04-28' and `fecha_salida`<='2019-05-04' and id_almacen=1 GROUP BY fecha_salida ORDER BY fecha_salida ASC LIMIT 0,7"

	//if(Precio>=60, 'caro','barato')SELECT h.`fecha_salida`, if(h.es_promo=1,sum(h.cantidad*h.precio_venta),sum(h.precio_venta)) as total, h.cerrado FROM hist_salidas h INNER JOIN productos p ON h.id_producto=p.id WHERE h.`fecha_salida`=curdate() and p.totaliza=1 and h.id_caja=3
	//SELECT h.`fecha_salida`, if(h.es_promo=0,sum(h.cantidad*h.precio_venta),sum(h.precio_venta)) as total, h.cerrado FROM $tabla h INNER JOIN productos p ON h.id_producto=p.id WHERE h.$item=curdate() and p.totaliza=1 and h.id_caja=$id_caja

//ventas canceladas=	SELECT cv.`id`, cv.num_cancelacion, cv.`id_cliente`,cli.nombre,cv.`num_salida`,cv.`fecha_salida`, sum(cv.`cantidad`) AS cant, SUM(IF(cv.`es_promo` = 0, cv.`cantidad`*cv.`precio_venta`,0)) AS sinpromo, SUM(IF(cv.`es_promo` = 1, cv.`precio_venta`,0)) AS promo,cv.`ultusuario`,cv.`ultmodificacion` FROM cancela_venta cv INNER JOIN clientes cli ON cli.id=cv.id_cliente WHERE cv.fecha_salida>="2019-12-01" AND cv.fecha_salida<="2020-01-31" group by cv.num_cancelacion ORDER BY cv.id ASC

/*
ALTER TABLE hist_salidas CHANGE `ultmodificacion` `ultmodificacion` timestamp NOT NULL default CURRENT_TIMESTAMP; para quitar ON_UPDATE_TIMESTAMP
*/ 
