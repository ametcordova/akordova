<?php

class ControladorPresupuesto{
    
/*=============================================
GUARDAR INGRESO
=============================================*/
static public function ctrIngreso($tabla, $datos){

		$respuesta = ModeloIngreso::mdlIngreso($tabla, $datos);

}

/*=============================================
GUARDAR EGRESO
=============================================*/

static public function ctrEgreso($tabla, $datos){

	$respuesta = ModeloIngreso::mdlEgreso($tabla, $datos);

}

/*=============================================
	MODIFICAR INGRESO
=============================================*/

static public function ctrModificar($tabla, $datos){
	
	return $respuesta = ModeloIngreso::mdlModificar($tabla, $datos);

}


/*=============================================
TRAER 
=============================================*/

static public function ctrMostrarReg($tabla, $item, $valor){

	return $respuesta = ModeloIngreso::mdlMostrarReg($tabla, $item, $valor);

}

/*=============================================
ELIMINAR REGISTRO INGRESO/EGRESO
=============================================*/

static public function ctrEliminar($tabla, $item, $valor){
     
	$respuesta = ModeloIngreso::mdlEliminar($tabla, $item, $valor);
}    



/*=============================================
	MOSTRAR INGRESO/EGRESO 
=============================================*/
static public function ctringresoegreso($item, $idDeCaja, $cerrado){

	$respuesta = ModeloIngreso::mdlingresoegreso($item, $idDeCaja, $cerrado);

	if($respuesta){
		return $respuesta;
	}else{
		return 0;
	}	

}


/*=============================================
	MOSTRAR CAJA CHICA
=============================================*/
static public function ctrImporteCajaChica($item, $idDeCaja, $cerrado, $fecha_actual){
	$tabla="cortes";
	
	$respuesta = ModeloIngreso::mdlImporteCajaChica($tabla, $item, $idDeCaja, $cerrado, $fecha_actual);

	if($respuesta){
		return $respuesta;
	}else{
		return 0;
	}	

}





}   //fin de la clase
