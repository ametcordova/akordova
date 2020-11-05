<?php
require_once "../controladores/almacen.controlador.php";
require_once "../modelos/almacen.modelo.php";

if(isset( $_GET["almacenSel"])){

    $item = null;
	$valor = null;
	$tabla = trim(strtolower($_GET['almacenSel']));

    $respuesta = ControladorAlmacen::ctrMostrarAlmacen($tabla,$item, $valor);
    
    //var_dump($respuesta);
    $data= Array();
    foreach ($respuesta as $key => $value) {
	  	/*=============================================
 	 		STOCK
  			=============================================*/ 
			$minimo=round($value["minimo"],0); 
			$stock=round($value["stock"],0); 
			$media=($value["stock"]/2);

			if($value["cant"] <= $media){

  				$exist = "<button class='btn btn-danger btn-sm' title='Mínimo $minimo'>".$value["cant"]."</button>";

  			}else if($value["cant"] > $media && $value["cant"] <= $minimo){

  				$exist = "<button class='btn btn-warning btn-sm' title='Mínimo $minimo'>".$value["cant"]."</button>";

  			}else{

  				$exist = "<button class='btn btn-success btn-sm' title='Mínimo $minimo'>".$value["cant"]."</button>";

  			}
  			
            $fechaEntro = date('d-m-Y', strtotime($value["fecha_entrada"]));
			$data[]=array(
 				"0"=>$value["id"],
 				"1"=>'<td style="width:10px;">'.$value["id_producto"].'</td>',
 				"2"=>'<td style="width:10px;">'.$value["codigointerno"].'</td>',
 				"3"=>'<td style="width:390px;">'.$value["descripcion"].'</td>',
 				"4"=>'<td style="width:50px;">'.$value["medida"].'</td>',
 				"5"=>'<td style="width:100px; text-align: center;">'.$exist.'</td>',
 				"6"=>'<button class="btn btn-default btn-sm" style="text-align:center;">'.$stock.'</button>',
 				"7"=>'<td class="text-right" style="width:80px;">'.$value["precio_compra"].'</td>',
 				"8"=>'<td style="width:50px;">'.$fechaEntro.'</td>',
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