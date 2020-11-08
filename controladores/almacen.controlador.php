<?php

class ControladorAlmacen{

	/*=============================================
	REPORTE DE ENTRADAS
	============================================*/

	static public function ctrMostrarAlmacen($tabla, $item, $valor){


		$respuesta = ModeloAlmacen::MdlMostrarAlmacen($tabla, $item, $valor);

		return $respuesta;
	
	}  
		
	/*=============================================
	MOSTRAR ENTRADAS AL ALMACEN
	============================================*/

	static public function ctrMostrarEntradas($tabla, $fechaini, $fechafin, $claveFam, $claveCat, $claveProd){


		$respuesta = ModeloAlmacen::MdlMostrarEntradas($tabla, $fechaini, $fechafin, $claveFam, $claveCat, $claveProd);

		return $respuesta;
	
	}  

	/*=============================================
	MOSTRAR CATEGORIAS
	============================================*/

	static public function ctrMostrarCategory($tabla, $item, $valor){

		$respuesta = ModeloAlmacen::MdlMostrarCategory($tabla, $item, $valor);

		return $respuesta;
	
	}  
    
	/*=============================================
	MOSTRAR PRODUCTOS
	============================================*/

	static public function ctrMostrarProducts($tabla, $item1, $item2, $valor1, $valor2){
	
		$respuesta = ModeloAlmacen::MdlMostrarProducts($tabla, $item1, $item2, $valor1, $valor2);

		return $respuesta;
	
	}  

	/*=============================================
	REPORTE DE ENTRADAS CON RANGO DE FECHAS
	============================================*/

	static public function ctrReporteEntradas($tabla, $claveAlm, $claveFam, $claveCat, $claveProd, $fechaVta1, $fechaVta2){
	
		$respuesta = ModeloAlmacen::MdlReporteEntradas($tabla, $claveAlm, $claveFam, $claveCat, $claveProd, $fechaVta1, $fechaVta2);

		return $respuesta;
	
	}  
    

	
}	//fin de la clase
