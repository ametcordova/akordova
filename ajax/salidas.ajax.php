<?php
session_start();
require_once "../controladores/salidas.controlador.php";
require_once "../modelos/salidas.modelo.php";
/*=============================================
	VALIDA QUE NUMERO DE SALIDA NO SE REPITA
=============================================*/	 
if(isset( $_GET["numDocto"])){

    $numeroDocto=$_GET['numDocto'];
    
    $item = "num_salida";
	$valor = $_GET['numDocto'];

    $respuesta = ControladorSalidas::ctrValidarNumSalida($item, $valor);

    echo $respuesta ? "Núm. ya Existe" : 0;

}



    