<?php

class ControladorInventario{


/*=============================================
DATATABLE DE INVENTARIO
============================================*/

static public function ctrMostrarInventario($tabla, $item, $valor){

	$respuesta = ModeloInventario::MdlMostrarInventario($tabla, $item, $valor);
    
	return $respuesta;
	
}  
		
/*=============================================
REPORTE DE INVENTARIO DE ALMACEN
============================================*/

static public function ctrReporteInventario($tabla, $item, $valor){

	$respuesta = ModeloInventario::MdlReporteInventario($tabla, $item, $valor);
    
	return $respuesta;
	
}  

/*=============================================
REPORTE DE INVENTARIO DE ALMACEN
============================================*/

static public function ctrProductosBajoStock($tabla, $item, $valor){

	$respuesta = ModeloInventario::MdlReporteInventario($tabla, $item, $valor);
    
	return $respuesta;
	
}  

				
	
}	//fin de la clase
