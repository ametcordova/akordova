<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

require_once "../controladores/medidas.controlador.php";
require_once "../modelos/medidas.modelo.php";

class AjaxProductos{


  /*=============================================
  VERIFICAR CÓDIGO 
  =============================================*/
  public $codigointerno;

  public function ajaxVerificaCodigo(){

  	$item = "codigointerno";
  	$valor = $this->codigointerno;

  	$respuesta = ControladorProductos::ctrVerificaCodigo($item, $valor);

    //$respuesta ? array('estado' => 'ok') : array('estado' => 'false');
    echo json_encode($respuesta);

  }



  /*=============================================
  GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
  =============================================*/
  public $idCategoria;

  public function ajaxCrearCodigoProducto(){

  	$item = "id_categoria";
  	$valor = $this->idCategoria;
    $orden = "id";
    $estado=1;

  	$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden, $estado);

  	echo json_encode($respuesta);

  }

 /*=============================================
  EDITAR PRODUCTO
  =============================================*/ 

  public $idProducto;
  public $traerProductos;
  public $nombreProducto;
  public $nombrealmacen;

  public function ajaxEditarProducto(){

    if($this->traerProductos == "ok"){

      $item = null;
      $valor = null;
      $orden = "id";
	    $estado=1;

      $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden, $estado);

      echo json_encode($respuesta);


    }else if($this->nombreProducto != ""){

      $item = "descripcion";
      $valor = $this->nombreProducto;
      $orden = "id";
	    $estado=1;

      $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden, $estado);

      echo json_encode($respuesta);

    }else{

      $item = "id";
      $valor = $this->idProducto;
      $orden = "id";
	    $estado=1;

      $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden, $estado);

      echo json_encode($respuesta);

    }

  }

}       //fin de la clase

/*=============================================
GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
=============================================*/	
if(isset($_POST["idCategoria"])){

	$codigoProducto = new AjaxProductos();
	$codigoProducto -> idCategoria = $_POST["idCategoria"];
	$codigoProducto -> ajaxCrearCodigoProducto();

}

/*=============================================
EDITAR PRODUCTO
=============================================*/ 
if(isset($_POST["idProducto"])){

  $editarProducto = new AjaxProductos();
  $editarProducto -> idProducto = $_POST["idProducto"];
  $editarProducto -> ajaxEditarProducto();

}

/*=============================================
TRAER PRODUCTO POR EL ID
=============================================*/ 
if(isset($_POST["traerProductos"])){

  $traerProductos = new AjaxProductos();
  $traerProductos -> traerProductos = $_POST["traerProductos"];
  $traerProductos -> ajaxEditarProducto();

}

/*=============================================
TRAER PRODUCTO POR EL NOMBRE
=============================================*/ 

if(isset($_POST["nombreProducto"])){

  $traerProductos = new AjaxProductos();
  $traerProductos -> nombreProducto = $_POST["nombreProducto"];
  $traerProductos -> ajaxEditarProducto();

}

/*=============================================
EDITAR PRODUCTO POR GET
=============================================*/ 

if(isset($_GET["idProducto"])){

  $editarProducto = new AjaxProductos();
  $editarProducto -> idProducto = $_GET["idProducto"];
  $editarProducto -> ajaxEditarProducto();

}


/*=============================================
CHECA CODIGO INTERNO
=============================================*/ 

if(isset($_POST["idcodinterno"])){

  $verificaCodigo = new AjaxProductos();
  $verificaCodigo -> codigointerno = $_POST["idcodinterno"];
  $verificaCodigo -> ajaxVerificaCodigo();

}

/*=============================================
BUSCAR PRODUCTO Y TRAER EXIT
=============================================*/ 
/*
if(isset($_POST["nomalmacen"])){

    $item = "id";
    $idproducto = $_POST["idproducto"];
    $tabla1 = "productos";
	$tabla2 = $_POST["nomalmacen"];

    $respuesta = ControladorProductos::ctrMostrarProdExist($tabla1, $tabla2, $item, $idproducto);    
    
    echo json_encode($respuesta);
}
*/