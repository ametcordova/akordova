<?php
date_default_timezone_set('America/Mexico_City');
require_once dirname( __DIR__ ).'/config/conexion.php';
class ModeloAlmacen{
	

	
/*==============================================================*/
static Public function MdlMostrarAlmacen($tabla, $campo, $valor){

  if($valor != null){
			//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $campo = :$campo");
			$stmt = Conexion::conectar()->prepare("SELECT a.*,p.precio_venta AS precventa, p.unidadxcaja, p.granel, p.id_medida,m.medida FROM $tabla a 
            INNER JOIN productos p ON a.id_producto=p.id
            INNER JOIN medidas m ON p.id_medida=m.id
            WHERE $campo = :$campo");

			$stmt -> bindParam(":$campo", $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();      
  }else{
	 $sql="SELECT a.id, a.id_producto, a.codigointerno, p.descripcion, p.id_medida, m.medida, a.cant, p.stock, p.minimo, a.precio_compra,a.fecha_entrada 
	 FROM $tabla a 
	 INNER JOIN productos p ON a.id_producto=p.id 
	 INNER JOIN medidas m ON p.id_medida=m.id ";
	 
        $stmt=Conexion::conectar()->prepare($sql);
		
        //$stmt->bindParam(":".$campo, $valor, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return $stmt->fetchAll();
        
         //if ( $stmt->rowCount() > 0 ) { do something here }
  }
    
      if($stmt){

 	  }else{
 		return false;
      }         
        
        //$stmt->close();
        
        $stmt=null;
}


static Public function MdlMostrarEntradas($tabla, $fechaini, $fechafin, $claveFam=null, $claveCat=null, $claveProd=null){
//var_dump($claveFam);

if($tabla>0){			//QUE ALMACEN MOSTRAR ENTRADAS

    $tabla=trim($tabla);
    $idFam = (int) $claveFam;
    $idCat = (int) $claveCat;
    $idProd =(int) $claveProd;
    //prod.id IN (192,193)

    //CONVIERTE EL ARRAY EN UN STRING
    $prods = isset($claveProd)?implode(",", $claveProd):null;
	$fams = isset($claveFam)?implode(",", $claveFam):null;

    $where='h.id_almacen="'.$tabla.'"';
    //$where.=$idFam>0?' AND prod.id_familia="'.$idFam.'"':'';
    $where.=$idFam>0?' AND prod.id_familia IN ('.$fams.')':'';
    $where.=$idCat>0?' AND prod.id_categoria="'.$idCat.'"':'';
    $where.=$idProd>0?' AND h.id_producto IN ('.$prods.')':'';
    $where.=' AND h.fechaentrada>="'.$fechaini.'" AND h.fechaentrada<="'.$fechafin.'"';
    $where.=' GROUP by `numerodocto`,`fechaentrada`,`id_almacen`,`id_proveedor`';


    $sql='SELECT h.`numerodocto`,h.`fechaentrada`, sum(h.`cantidad`) AS entro,h.`id_proveedor`,prov.nombre,h.`id_almacen`,alm.nombre as almacen,prod.id_familia,fam.familia FROM hist_entrada h
	INNER JOIN proveedores prov ON id_proveedor=prov.id
	INNER JOIN almacenes alm ON id_almacen=alm.id 
    INNER JOIN productos prod ON prod.id=h.id_producto
    INNER JOIN familias fam ON fam.id=prod.id_familia
    INNER JOIN categorias cat ON cat.id=prod.id_categoria
	WHERE '.$where;    

}else{                  // TODOS LOS ALMACENES

	$sql="SELECT h.`numerodocto`,h.`fechaentrada`, sum(h.`cantidad`) AS entro,h.`id_proveedor`,prov.nombre,h.`id_almacen`,alm.nombre as almacen FROM hist_entrada h
	INNER JOIN proveedores prov ON id_proveedor=prov.id
	INNER JOIN almacenes alm ON id_almacen=alm.id
	GROUP by `numerodocto`,`fechaentrada`,`id_almacen`,`id_proveedor`";
}
        $stmt=Conexion::conectar()->prepare($sql);
		
        //$stmt->bindParam(":".$campo, $valor, PDO::PARAM_STR);
        
        if($stmt->execute()){;
        
         return $stmt->fetchAll();
        
         //if ( $stmt->rowCount() > 0 ) { do something here }
        
 	  }else{

			return false;

	   }         
        
        $stmt->close();
        
        $stmt=null;
    }	
    

// MOSTRAR LAS CATEGORIAS EN EL SELECT SEGUN FAMILIA SELECCIONADA
static Public function MdlMostrarCategory($tabla, $item, $valor){

$idFam = (int) $valor;

    $where=$idFam>0?"$item=:$item":1;

	 $sql="SELECT id, id_familia, categoria FROM $tabla WHERE ".$where;
	 
        $stmt=Conexion::conectar()->prepare($sql);
		
		$stmt->bindParam(":".$item, $idFam, PDO::PARAM_INT);
		
        $stmt->execute();

        return $stmt->fetchAll();
    
        $stmt=null;
}    


// MOSTRAR LAS CATEGORIAS EN EL SELECT SEGUN FAMILIA Y CATEGORIA SELECCIONADA
static Public function MdlMostrarProducts($tabla, $item1, $item2, $valor1, $valor2){

$idFam = (int) $valor1;
$idCat = (int) $valor2;

$where="estado=1";

//$where.=$idFam>0?" AND $item1=$idFam":'';
//CONVIERTE EL ARRAY FAMILIA EN UN STRING SEPARADO POR COMA
$familys = isset($valor1)?implode(",", $valor1):null;
$where.=$idFam>0?' AND id_familia IN ('.$familys.')':'';

$where.=$idCat>0?" AND $item2=$idCat":'';
		
	 $sql="SELECT id, codigo, codigointerno, descripcion, datos_promocion, estado FROM $tabla WHERE ".$where;
           
     $stmt=Conexion::conectar()->prepare($sql);
		
		//$stmt->bindParam(":".$item1, $idFam, PDO::PARAM_INT);
		
        $stmt->execute();

        return $stmt->fetchAll();
    
        $stmt->close();
        
        $stmt=null;

}    
    
// REPORTE DE ENTRADAS POR UN RANGO DE FECHAS
static Public function MdlReporteEntradas($tabla, $claveAlm, $claveFam, $claveCat, $claveProd, $fechaVta1, $fechaVta2){
$tabla=trim($tabla);
$idAlm = (int) $claveAlm;
$idFam = (int) $claveFam;
$idCat = (int) $claveCat;
$idProd =(int) $claveProd;
//prod.id IN (192,193)

//$where.=$idFam>0?" AND $item1=:$item1":'';
//$where.=$idCat>0?" AND $item2=:$item2":'';

$where='he.id_almacen="'.$idAlm.'"';
//$where.=$idFam>0?' AND pro.id_familia="'.$idFam.'"':'';
$where.=$idFam>0?' AND pro.id_familia IN ('.$claveFam.')':'';

$where.=$idCat>0?' AND pro.id_categoria="'.$idCat.'"':'';
//$where.=$idProd>0?' AND pro.id="'.$idProd.'"':'';
$where.=$idProd>0?' AND pro.id IN ('.$claveProd.')':'';
$where.=' AND he.fechaentrada>="'.$fechaVta1.'" AND he.fechaentrada<="'.$fechaVta2.'"';
$where.=' GROUP BY pro.id_familia, pro.id';
		
$sql="SELECT he.id_producto, pro.id_familia, fa.familia, pro.id_categoria, cat.categoria, 
pro.codigointerno, pro.descripcion, pro.id_medida, me.medida, pro.precio_compra, pro.precio_venta,
he.cantidad, sum(he.cantidad) AS tot_entro, round(sum(he.cantidad*pro.precio_compra),2) AS tot_compra,
round(sum(he.cantidad*pro.precio_venta),2) AS tot_venta, pro.hectolitros, pro.unidadxcaja
FROM `hist_entrada` he
INNER JOIN productos pro ON pro.id=he.id_producto 
INNER JOIN familias fa ON fa.id=pro.id_familia
INNER JOIN categorias cat ON cat.id=pro.id_categoria
INNER JOIN medidas me ON me.id=pro.id_medida 
WHERE ".$where;

    
//WHERE he.id_almacen=1 AND pro.id_familia=1 AND pro.id_categoria=5 AND he.fechaentrada>="2019-05-01" AND he.fechaentrada<="2019-05-15" AND pro.id=22    
	 
        $stmt=Conexion::conectar()->prepare($sql);
		
		//$stmt->bindParam(":".$item1, $idFam, PDO::PARAM_INT);
		//$stmt->bindParam(":".$item2, $idCat, PDO::PARAM_INT);
		
        $stmt->execute();

        return $stmt->fetchAll();
    
        $stmt->close();
        
        $stmt=null;

}  
    
    
/*
SELECT h.id_proveedor,p.nombre,h.fechadocto,h.numerodocto, h.fechaentrada, h.recibio,h.cantidad,h.precio_compra,h.id_producto,a.descripcion,a.codigointerno,h.id_almacen,b.nombre FROM hist_entrada h INNER JOIN proveedores p ON h.id_proveedor=p.id 
INNER JOIN productos a ON h.id_producto=a.id
INNER JOIN almacenes b ON h.id_almacen=b.id
WHERE h.numerodocto=8

	 $sql="SELECT `id`, `id_familia`, `id_categoria`, `codigo`, `codigointerno`, `descripcion`, `estado` 
		   FROM $tabla WHERE $item1=$valor1 and $item2=$valor2 and `estado`=1";
           
SELECT ID, ARTICULO, TOTAL_INGRESO
FROM (SELECT a.id AS ID, a.id_familia, a.descripcion AS ARTICULO, (SELECT sum(he.cantidad) FROM hist_entrada he WHERE a.id=he.id_producto and he.id_almacen=1) AS TOTAL_INGRESO 
      FROM PRODUCTOS a WHERE a.id=39) QA        
      
SELECT idprod, idfam, idcat, fa.familia, ca.categoria, ARTICULO, TOTAL_INGRESO
FROM (SELECT a.id AS idprod, a.id_familia AS idfam, a.id_categoria AS idcat, a.descripcion AS ARTICULO, (SELECT IFNULL(sum(he.cantidad),0) FROM hist_entrada he WHERE a.id=he.id_producto and he.id_almacen=1 AND he.fechaentrada>="2019-04-01" and he.fechaentrada<="2019-05-15" ) AS TOTAL_INGRESO FROM PRODUCTOS a) QA 
INNER JOIN familias fa ON QA.idfam=fa.id
INNER JOIN categorias ca ON QA.idcat=ca.id


SELECT he.id_producto, pro.id_familia, fa.familia, pro.id_categoria, cat.categoria, pro.codigointerno, pro.descripcion, pro.id_medida, me.medida, sum(he.cantidad) AS tot_entro, round(sum(he.cantidad*he.precio_compra),2) AS tot_compra FROM `hist_entrada` he
INNER JOIN productos pro ON pro.id=he.id_producto 
INNER JOIN familias fa ON fa.id=pro.id_familia
INNER JOIN categorias cat ON cat.id=pro.id_categoria
INNER JOIN medidas me ON me.id=pro.id_medida
WHERE he.id_almacen=1 AND pro.id_familia=1 AND pro.id_categoria=5 AND he.fechaentrada>="2019-05-01" AND he.fechaentrada<="2019-05-15" AND pro.id=22 
GROUP by pro.id

SELECT prod.id, prod.descripcion,fam.familia FROM `productos` prod
INNER JOIN familias fam ON fam.id=prod.id_familia
WHERE fam.id=prod.id_familia and prod.id IN (192,193)

$sql='SELECT h.`numerodocto`,h.`fechaentrada`, sum(h.`cantidad`) AS entro,h.`id_proveedor`,prov.nombre,h.`id_almacen`,alm.nombre as almacen,prod.id_familia,fam.familia FROM hist_entrada h
	INNER JOIN proveedores prov ON id_proveedor=prov.id
	INNER JOIN almacenes alm ON id_almacen=alm.id 
    INNER JOIN productos prod ON prod.id=h.id_producto
    INNER JOIN familias fam ON fam.id=prod.id_familia
    INNER JOIN categorias cat ON cat.id=prod.id_categoria
	WHERE h.id_almacen="'.$tabla.'" AND h.fechaentrada>="'.$fechaini.'" AND h.fechaentrada<="'.$fechafin.'" AND prod.id_familia="'.$claveFam.'" AND prod.id_categoria="'.$claveCat.'"
	GROUP by `numerodocto`,`fechaentrada`,`id_almacen`,`id_proveedor`';  
*/

    
    

}       //fin de la clase