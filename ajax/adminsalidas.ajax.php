<?php
 session_start();
 
require_once "../controladores/salidas.controlador.php";
require_once "../modelos/salidas.modelo.php";
require_once "../controladores/permisos.controlador.php";
require_once "../modelos/permisos.modelo.php";

require_once '../funciones/funciones.php';


/* ***********************  CANCELACION ************************************* */
//ACTUALIZAR  ALMACEN, PRODUCTOS, HIST_SALIDAS, CANCELA_VENTAS, CLIENTES
if(isset( $_POST["idNotaSalida"])){
	$idUsuario=$_POST["idUsuario"];
	$item="num_salida";
  $valor=$_POST["idNotaSalida"];
  $tabla="hist_salidas";
	$respuesta = ControladorSalidas::ctrProdEliminar($tabla, $item, $valor, $idUsuario);
    //var_dump($respuesta);
}

/* ******************************************************************* */
if(isset( $_GET["almacenSel"])){

  $tabla="usuarios";
  $usuario=$_SESSION['id'];
  $module="adminventas";
  $campo="administracion";
  $acceso=accesomodulo($tabla, $usuario, $module,$campo);


  $item = "id_cliente";
  $valor = trim($_GET['clienteSel']);
  $valor2 = $_GET['fechaSel'];
  $tabla = trim($_GET['almacenSel']);
  //$fechaSel = date('Y-m-d', strtotime($_GET['fechaSel']));
  //$fechaSel = date('Y-m-d', strtotime("21/07/2019"));
  if(!empty($valor2)){
    $fechaSel =date('Y-m-d', strtotime(str_replace('/', '-', $valor2) ));
  }else{
    $fechaSel ="";
  }
      $respuesta = ControladorSalidas::ctrMostrarSalidas($tabla, $item, $valor, $fechaSel);
    
    //var_dump($respuesta);
				
    $data= Array();
    foreach ($respuesta as $key => $value) {
            $fechaSalio = date('d/m/Y', strtotime($value["fecha_salida"]));
			//$totalVta=number_format($value["promo"]+$value["sinpromo"],2);
      $totalVta=number_format($value["promo"]+$value["sinpromo"],2);
      $entragaen=$value["id_tipovta"]==0?'<i class="fa fa-shopping-bag" aria-hidden="true" title="Entregado en mostrador"></i>':'<i class="fa fa-bicycle" aria-hidden="true" title="Entregado a domicilio"></i>';

	//if(trim($_SESSION["perfil"])=="Administrador"){
     $boton='<td class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Acción
                  </button>
                  <div class="dropdown-menu">';
                  $boton1 = getAccess($acceso, ACCESS_SELECT)?'<a class="dropdown-item btnImprimirNotSal text-success bg-light" idNumSalida="'.$value["num_salida"].'" href="#" title="Generar salida en PDF "><i class="fa fa-file-pdf-o"></i> &nbspImprimir Repor</a>':'';
                  $boton2 = getAccess($acceso, ACCESS_PRINTER)?'<a class="dropdown-item btnPrintTicket text-primary bg-light" href="#" idNumSalida="'.$value["num_salida"].'" title="Imprimir Ticket"><i class="fa fa-ticket"></i> Imprimir Ticket</a>':'';
                  $boton3 = getAccess($acceso, ACCESS_DELETE)?'<div class="dropdown-divider"></div>
                    <a class="dropdown-item btnEliminarVenta text-danger bg-light" href="#" idNumSalida="'.$value["num_salida"].'" title="Eliminar Venta"><i class="fa fa-eraser"></i> Cancelar Venta</a>':'';
                  $boton4='</div>
                </td>';
                $botones=$boton.$boton1.$boton2.$boton3.$boton4;
	//}else{
/*    
      <a class="dropdown-item btnVerTicket text-info bg-light" href="#" idNumSalida="'.$value["num_salida"].'" title="ver Ticket"><i class="fa fa-eye"></i> ver Ticket</a>
      <a class="dropdown-item btnImprimirTicket text-primary bg-light" href="#" idNumSalida="'.$value["num_salida"].'" title="Imprimir Ticket"><i class="fa fa-ticket"></i> Imprimir Ticket</a>

	};			*/
	
			$data[]=array(
 				"0"=>'<td style="width:10px;">'.($key+1).'</td>',
 				"1"=>'<td style="width:10px;">'.$value["id_cliente"].'</td>',
 				"2"=>'<td style="width:10px;">'.$value["nombrecliente"].'</td>',
 				"3"=>'<td style="width:390px;">'.$value["num_salida"].'</td>',
 				"4"=>'<td style="width:50px;">'.$fechaSalio.'</td>',
 				"5"=>$value["salio"],
 				"6"=>'$'.$totalVta,
 				"7"=>$entragaen,
				"8"=>'<td style="text-align:right; width:80px;">'.$value["almacen"].'</td>',
 				"9"=>$botones,
            );        
    }
    
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
    
 		echo json_encode($results);
    
    
}



//echo $respuesta ? "Núm. de Docto. ya Existe" : 0;
    //"7"=>'<button class="btn btn-success btn-sm btnImprimirNotSal" idNumSalida="'.$value["num_salida"].'" title="Generar salida en PDF "><i class="fa fa-file-pdf-o"></button>',
    
  //  <button class="btn btn-success btn-sm btnImprimirNotSal" idNumSalida="'.$value["num_salida"].'" title="Generar salida en PDF "><i class="fa fa-file-pdf-o"></i></button>
    //            <button class="btn btn-primary btn-sm btnImprimirTicket" idNumSalida="'.$value["num_salida"].'" title="Imprimir Ticket"><i class="fa fa-ticket"></i></button>