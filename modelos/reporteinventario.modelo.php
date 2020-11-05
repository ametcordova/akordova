<?php
date_default_timezone_set('America/Mexico_City');
require_once dirname( __DIR__ ).'/config/conexion.php';
class ModeloInventario{

//FUNCION PARA VISUALIZAR CON DATATABLE
static Public function MdlMostrarInventario($tabla, $campo, $valor){

$where='alm.cant IS NOT NULL';      //SI NO EXISTE EN ALM, NO LO MUESTRE
    
$idFam = (int) $valor;
    //CONVIERTE EL ARRAY EN UN STRING
    $valor = isset($valor)?implode(",", $valor):null;

	$where.=$idFam>0?' AND prod.'.$campo.' IN ('.$valor.')':'';
	
$where.=' ORDER BY `id_familia`';
    
	$sql="SELECT prod.id, prod.id_familia, prod.id_categoria, cat. categoria, prod.id_medida, med.medida, prod.codigointerno, prod.descripcion, prod.stock, alm.cant, (alm.cant-prod.stock) AS surtir, alm.precio_venta, prod.precio_compra FROM productos prod
	INNER JOIN categorias cat ON prod.id_categoria=cat.id
	INNER JOIN medidas med ON prod.id_medida=med.id
	LEFT JOIN $tabla alm ON prod.id=alm.id_producto
	WHERE ".$where;

	$stmt = Conexion::conectar()->prepare($sql);

	//$stmt -> bindParam(":$campo", $valor, PDO::PARAM_STR);

	$stmt -> execute();

	return $stmt -> fetchAll();      
    
    $stmt->close();
    $stmt=null;

}		

//FUNCION PARA REPORTE EN TCPDF
static Public function MdlReporteInventario($tabla, $campo, $valor){
    
	$where='alm.cant IS NOT NULL';      //SI NO EXISTE EN ALM, NO LO MUESTRE
		
	$idFam = (int) $valor;

	$where.=$idFam>0?' AND prod.id_familia IN ('.$valor.')':'';

	$where.=' ORDER BY `id_familia`';
    
    
	$sql="SELECT prod.id, prod.id_familia, fa.familia, prod.id_categoria, cat. categoria, prod.id_medida, med.medida, prod.codigointerno, prod.descripcion, prod.stock, alm.cant, prod.unidadxcaja,(alm.cant-prod.stock) AS surtir, prod.precio_compra, prod.precio_venta FROM productos prod
    LEFT JOIN familias fa ON prod.id_familia=fa.id
	INNER JOIN categorias cat ON prod.id_categoria=cat.id
	INNER JOIN medidas med ON prod.id_medida=med.id
	LEFT JOIN $tabla alm ON prod.id=alm.id_producto
	WHERE ".$where;

	$stmt = Conexion::conectar()->prepare($sql);

	//$stmt -> bindParam(":$campo", $valor, PDO::PARAM_STR);

	$stmt -> execute();

	return $stmt -> fetchAll();      
    
    $stmt->close();
       
    $stmt=null;

}		
    
//PRODUCTOS BAJO STOCK
static Public function MdlProductosBajoStock($tabla, $campo, $valor){
    
$sql="select pri.id_producto, (pri.cant-pro.stock) AS surtir from $tabla pri
INNER JOIN productos pro ON pri.id_producto=pro.id where (pri.cant-pro.stock)<1";

	$stmt = Conexion::conectar()->prepare($sql);

	$stmt -> execute();

	return $stmt -> fetchAll();      
    
    $stmt->close();
       
    $stmt=null;

}		
    

}       //fin de la clase


/*
SELECT prod.id, prod.id_categoria, cat. categoria, prod.id_medida, med.medida, prod.codigointerno, prod.descripcion, prod.minimo,alm.cant, (alm.cant-prod.minimo) AS surtir, alm.precio_compra FROM productos prod
INNER JOIN categorias cat ON prod.id_categoria=cat.id
INNER JOIN medidas med ON prod.id_medida=med.id
LEFT JOIN alm_villah alm ON prod.id=alm.id_producto  
ORDER BY `surtir`

QUERY PARA EL REPORTE
SELECT prod.id, prod.id_familia, fa.familia, prod.id_categoria, cat. categoria, prod.id_medida, med.medida, prod.codigointerno, prod.descripcion, prod.stock,
			 alm.cant, (alm.cant-prod.stock) AS surtir, alm.precio_compra FROM productos prod
             LEFT JOIN familias fa ON prod.id_familia=fa.id
			 INNER JOIN categorias cat ON prod.id_categoria=cat.id
			 INNER JOIN medidas med ON prod.id_medida=med.id
			 LEFT JOIN principal alm ON prod.id=alm.id_producto
			 WHERE alm.cant IS NOT NULL
			 ORDER BY surtir
             
             WHERE alm.cant IS NOT NULL AND prod.$campo=$valor
PRODUCTOS BAJO STOCK
select pri.id_producto, (pri.cant-pro.stock) AS surtir from principal pri
INNER JOIN productos pro ON pri.id_producto=pro.id where (pri.cant-pro.stock)<0
*/    
