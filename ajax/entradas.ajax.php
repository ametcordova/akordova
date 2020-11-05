<?php
require_once "../controladores/entradas.controlador.php";
require_once "../modelos/entradas.modelo.php";

if(isset( $_GET["numDocto"])){

    $numeroDocto=$_GET['numDocto'];
    
    $item = "numerodocto";
	$valor = $_GET['numDocto'];

    $respuesta = ControladorEntradas::ctrValidarDocto($item, $valor);

    echo $respuesta ? "Núm. de Docto. ya Existe" : 0;

}

if(isset( $_GET["idProducto"])){

    $idProducto=$_GET['idProducto'];
    
    $item = "id";
	$valor = $_GET['idProducto'];
	$nomalmacen = trim(strtolower($_GET['nomAlmacen']));

    $respuesta = ControladorEntradas::ctrDatosProducto($item, $valor,$nomalmacen);

    echo json_encode($respuesta);

}