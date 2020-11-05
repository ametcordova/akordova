<?php
session_start();
require_once "../controladores/almacen.controlador.php";
require_once "../modelos/almacen.modelo.php";
require_once "../controladores/permisos.controlador.php";
require_once "../modelos/permisos.modelo.php";

require_once '../funciones/funciones.php';

if(isset( $_GET["almacenSel"])){

//VALIDA ACCESO
    $tabla="usuarios";
    $module="rcompras";
    $campo="reportes";
    
    $acceso=accesomodulo($tabla, $_SESSION['id'], $module, $campo);


//TRAEMOS LA INFORMACIÓN 
    $item = null;
    $valor = null;
    $fechaini=$_GET["fechainientra"];
    $fechafin=$_GET["fechafinentra"];
    $claveFam = isset($_GET["id_familia"])? $_GET["id_familia"]:null;
    $claveCat = isset($_GET["id_categoria"]) ? $_GET["id_categoria"]:null;
    $claveProd = isset($_GET["id_producto"]) ? $_GET["id_producto"]:null;
    
	$tabla = trim($_GET['almacenSel']);

    $respuesta = ControladorAlmacen::ctrMostrarEntradas($tabla, $fechaini, $fechafin, $claveFam, $claveCat,$claveProd);
    
    //var_dump($respuesta);
    $data= Array();
    foreach ($respuesta as $key => $value) {
            $fechaEntro = date('d-m-Y', strtotime($value["fechaentrada"]));
            $boton=getAccess($acceso, ACCESS_PRINTER)?'<button class="btn btn-success btn-sm btnImprimir" idNumDocto="'.$value["numerodocto"].'" title="Generar entrada en PDF "><i class="fa fa-file-pdf-o"></button>':'';

			$data[]=array(
 				"0"=>'<td style="width:10px;">'.($key+1).'</td>',
 				"1"=>'<td style="width:10px;">'.$value["id_proveedor"].'</td>',
 				"2"=>'<td style="width:10px;">'.$value["nombre"].'</td>',
 				"3"=>'<td style="width:390px;">'.$value["numerodocto"].'</td>',
 				"4"=>'<td style="width:50px;">'.$fechaEntro.'</td>',
 				"5"=>'<td style="width:100px; text-align: center;">'.$value["entro"].'</td>',
				"6"=>'<td style="text-align:right; width:80px;">'.$value["almacen"].'</td>',
 				"7"=>$boton,
 				);        
    }
    
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
    
 		echo json_encode($results);
    
    //echo $respuesta ? "Núm. de Docto. ya Existe" : 0;

}

// MOSTRAR EN EL SELECT LAS CATEGORIAS SEGUN SELECT FAMILIA 
if(isset( $_POST["id_familia"])){
 
    $item = "id_familia";
    $valor = $_POST["id_familia"];
    $tabla = "categorias";

		$respuesta = ControladorAlmacen::ctrMostrarCategory($tabla,$item, $valor);    
    
    $html= "<option value='0'>Sel. Categoría</option>";
        foreach ($respuesta as $key => $value) {
          $html.= "<option value='".$value['id']."'>".$value['categoria']."</option>";  
        }
    
    echo $html;
}


// MOSTRAR EN EL SELECT LOS PRODUCTOS SEGUN CATEGORIAS Y SEGUN  FAMILIA 
if(isset( $_POST["idfamilia"])){
 
    $item1 = "id_familia";
    $item2 = "id_categoria";
    $valor1 = $_POST["idfamilia"];
    $valor2 = $_POST["id_categoria"];
    $tabla = "productos";

    $respuesta = ControladorAlmacen::ctrMostrarProducts($tabla, $item1, $item2, $valor1, $valor2);    
    
    $html2= "<option value=''>Productos</option>";
        foreach ($respuesta as $key => $value) {
            if(is_null($value["datos_promocion"])){	//VALIDA QUE PRODUCTO NO SEA PROMOCION
                $html2.='<option value="'.$value["id"].'">'.$value["codigointerno"]." - ".$value["descripcion"].'</option>';
            }    
        }
    
    echo $html2;
}