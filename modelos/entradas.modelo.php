<?php
date_default_timezone_set('America/Mexico_City');
require_once dirname( __DIR__ ).'/config/conexion.php';
class ModeloEntradas{

	/*=============================================
	REGISTRO DE PRODUCTO
	=============================================*/
	static public function mdlIngresarEntrada($tabla,$nuevoProveedor,$fechaDocto,$numeroDocto,$nombreRecibe,$id_producto,$codigointerno,$cantidad,$precio_compra,$precio_venta,$fechaEntrada,$nuevoTipoEntrada,$id_almacen,$ultusuario){
        //NOMBRE DEL MES ACTUAL        
		$nombremes_actual = strtolower(date('F'));
		$tablakardex="kardex";

        //CAMBIAR EL FORMATO DE FECHA A yyyy-mm-dd   
        $fechDocto = explode('/', $fechaDocto); 
        $newfecha = $fechDocto[2].'-'.$fechDocto[1].'-'.$fechDocto[0];

        $fechEntra = explode('/', $fechaEntrada); 
        $newDate = $fechEntra[2].'-'.$fechEntra[1].'-'.$fechEntra[0];
        $totcompras=0;   //INICIALIZA VARIABLE DE COMPRA
        $contador = count($id_producto);    //CUANTO PRODUCTOS VIENEN PARA EL FOR
        
    for($i=0;$i<$contador;$i++) { 
	  $cuantosReg=0;
	  $id_articulo=$id_producto[$i];
      $margen_utilidad=($precio_venta[$i]-$precio_compra[$i]);
      //CHECA SI EXISTE EL PRODUCTO
	  $consulta = Conexion::conectar()->prepare("SELECT id_producto FROM $tabla WHERE id_producto=:id_producto");
	  $consulta->bindParam(":id_producto", $id_articulo, PDO::PARAM_INT);
	  $consulta->execute();

	 if ($consulta) {   
		$cuantosReg = $consulta->fetchAll();
       if (count($cuantosReg) > 0) {    //SI EXISTE PROD.    ACTUALIZA EXISTENCIA EN EL ALMACEN SELECCIONADO
        
        //GUARDA EN EL ALMACEN ELEGIDO principal;
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cant=:cant+cant, precio_compra=:precio_compra, precio_venta=:precio_venta, margen_utilidad=:margen_utilidad, fecha_entrada=:fecha_entrada, ultusuario=:ultusuario WHERE id_producto = :id_producto");
						
        $stmt->bindParam(":id_producto", $id_producto[$i], PDO::PARAM_INT);
		$stmt->bindParam(":cant", $cantidad[$i], PDO::PARAM_INT);
		$stmt->bindParam(":precio_compra", $precio_compra[$i], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $precio_venta[$i], PDO::PARAM_STR);
		$stmt->bindParam(":margen_utilidad", $margen_utilidad, PDO::PARAM_STR);
		$stmt->bindParam(":fecha_entrada", $newDate, PDO::PARAM_STR);
		$stmt->bindParam(":ultusuario", $ultusuario, PDO::PARAM_INT);
        $stmt->execute();

		//GUARDA EN KARDEX DEL ALMACEN ELEGIDO
		$query = Conexion::conectar()->prepare("UPDATE $tablakardex SET $nombremes_actual=:$nombremes_actual+$nombremes_actual WHERE id_producto = :id_producto");
		$query->bindParam(":id_producto", $id_producto[$i], PDO::PARAM_INT);
		$query->bindParam(":".$nombremes_actual, $cantidad[$i], PDO::PARAM_STR);
		$query->execute();

	  }else{        //DE LO CONTRARIO INSERTA
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_producto, codigointerno, cant, precio_compra, precio_venta, margen_utilidad, fecha_entrada, ultusuario) VALUES (:id_producto, :codigointerno, :cant, :precio_compra, :precio_venta, :margen_utilidad, :fecha_entrada, :ultusuario)");
        $stmt->bindParam(":id_producto", $id_producto[$i], PDO::PARAM_INT);
		$stmt->bindParam(":codigointerno", $codigointerno[$i], PDO::PARAM_STR);
		$stmt->bindParam(":cant", $cantidad[$i], PDO::PARAM_INT);
		$stmt->bindParam(":precio_compra", $precio_compra[$i], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $precio_venta[$i], PDO::PARAM_STR);
        $stmt->bindParam(":margen_utilidad", $margen_utilidad, PDO::PARAM_STR);
		$stmt->bindParam(":fecha_entrada", $newDate, PDO::PARAM_STR);
		$stmt->bindParam(":ultusuario", $ultusuario, PDO::PARAM_INT);
        $stmt->execute();

		//GUARDA EN KARDEX DEL ALMACEN ELEGIDO
		$query = Conexion::conectar()->prepare("INSERT INTO $tablakardex (id_producto, $nombremes_actual) VALUES (:id_producto, :$nombremes_actual)");
		$query->bindParam(":id_producto", $id_producto[$i], PDO::PARAM_INT);
		$query->bindParam(":".$nombremes_actual, $cantidad[$i], PDO::PARAM_STR);
		$query->execute();
        
	  }	
	 }else{
	   $stmt=false;
	 }
	 
    }	//TERMINA EL FOR
	
        //SCRIP QUE REGISTRA LA ENTRADA EN HIST_ENTRADA
		if($stmt){

        $stmt = Conexion::conectar()->prepare("INSERT INTO hist_entrada(id_proveedor, fechadocto, numerodocto, fechaentrada, recibio, id_producto, cantidad, precio_compra, id_almacen, id_tipomov, ultusuario) VALUES (:id_proveedor,:fechadocto, :numerodocto, :fechaentrada, :recibio, :id_producto, :cantidad, :precio_compra, :id_almacen, :id_tipomov, :ultusuario)");
            
         for($i=0;$i<$contador;$i++) { 
            $stmt->bindParam(":id_proveedor", $nuevoProveedor, PDO::PARAM_INT);
            $stmt->bindParam(":fechadocto", $newfecha, PDO::PARAM_STR);
            $stmt->bindParam(":numerodocto", $numeroDocto, PDO::PARAM_STR);
            $stmt->bindParam(":fechaentrada", $newDate, PDO::PARAM_STR);
            $stmt->bindParam(":recibio", $nombreRecibe, PDO::PARAM_STR);
            $stmt->bindParam(":id_producto", $id_producto[$i], PDO::PARAM_INT);
            $stmt->bindParam(":cantidad", $cantidad[$i], PDO::PARAM_INT);
            $stmt->bindParam(":precio_compra", $precio_compra[$i], PDO::PARAM_STR);
            $stmt->bindParam(":id_almacen", $id_almacen, PDO::PARAM_INT);
            $stmt->bindParam(":id_tipomov", $nuevoTipoEntrada, PDO::PARAM_INT);
            $stmt->bindParam(":ultusuario", $ultusuario, PDO::PARAM_INT);
            $stmt->execute();
             
             $totcompras+=($cantidad[$i]*$precio_compra[$i]);
         }
            if($stmt){
                $stmt = Conexion::conectar()->prepare("UPDATE proveedores SET compras=compras+:compras, ultusuario=:ultusuario WHERE id = :id");
                $stmt->bindParam(":id", $nuevoProveedor, PDO::PARAM_INT);
                $stmt->bindParam(":compras", $totcompras, PDO::PARAM_INT);
                $stmt->bindParam(":ultusuario", $ultusuario, PDO::PARAM_INT);
                $stmt->execute();   
                
                return "ok";
            }else{

			return "error";
		
		   }

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

  }
    
/*=============================================
	VALIDA QUE NUMERO DE ENTRADA NO SE REPITA
=============================================*/	    
  static Public function MdlValidarDocto($tabla, $campo, $valor){
     
     if($campo !=null){    
        $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:$campo");
        
        $stmt->bindParam(":".$campo, $valor, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->fetch();
        
         //if ( $stmt->rowCount() > 0 ) { do something here }
        
 	}else{

			return false;

	 }        
        
        $stmt->close();
        
        $stmt=null;
    }
	
/*=============================================
	REPORTE DE ENTRADAS 
=============================================*/	
static Public function MdlEntradaAlm($tabla, $campo, $valor){
     
     if($campo !=null){    
         
	 $sql="SELECT h.id_proveedor,p.nombre AS nombreprov,h.fechadocto,h.numerodocto, h.fechaentrada, h.recibio,h.cantidad,h.precio_compra,h.id_producto,a.descripcion,a.codigointerno, a.id_medida, m.medida, a.hectolitros, a.unidadxcaja, h.id_almacen,b.nombre 
		FROM $tabla h INNER JOIN proveedores p ON h.id_proveedor=p.id	
	    INNER JOIN productos a ON h.id_producto=a.id
		INNER JOIN almacenes b ON h.id_almacen=b.id
		INNER JOIN medidas m ON a.id_medida=m.id
		WHERE h.$campo=:$campo";
	 
        $stmt=Conexion::conectar()->prepare($sql);
		
        $stmt->bindParam(":".$campo, $valor, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->fetchAll();
        
         //if ( $stmt->rowCount() > 0 ) { do something here }
        
 	}else{

		return false;

	 }        
        
        //$stmt->close();
        
        $stmt=null;
    }
		
/*=============================================
	MOSTRAR PRODUCTO
=============================================*/
static Public function mdlMostrarProducto($tabla, $item, $valor, $nomalmacen){
$estado=1;
$stmt = Conexion::conectar()->prepare("SELECT pro.id, alm.cant, pro.precio_venta, pro.precio_compra FROM $tabla pro
LEFT JOIN $nomalmacen alm ON alm.id_producto=pro.id WHERE pro.$item = :$item AND pro.estado=:estado");
	$stmt -> bindParam(":$item", $valor, PDO::PARAM_STR);
	$stmt -> bindParam(":estado", $estado, PDO::PARAM_INT);
	
	$stmt -> execute();
	
	return $stmt -> fetch();
	
	//SELECT pro.id, alm.cant, pro.precio_compra FROM PRODUCTOS pro INNER JOIN principal alm ON alm.id_producto=pro.id WHERE pro.ID = 1 AND pro.estado=1

}
/*=============================================*/

/*=============================================
MOSTRAR PROVEEDORES
=============================================*/

static public function mdlMostrarProv($tabla, $item, $valor){

	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
	$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
	
    $stmt -> execute();
    
    return $stmt -> fetchAll();

    $stmt -> close();

	$stmt = null;

}		
    
		
/*
SELECT h.id_proveedor,p.nombre,h.fechadocto,h.numerodocto, h.fechaentrada, h.recibio,h.cantidad,h.precio_compra,h.id_producto,a.descripcion,a.codigointerno,h.id_almacen,b.nombre FROM hist_entrada h INNER JOIN proveedores p ON h.id_proveedor=p.id 
INNER JOIN productos a ON h.id_producto=a.id
INNER JOIN almacenes b ON h.id_almacen=b.id
WHERE h.numerodocto=8
*/
    
    

}       //fin de la clase