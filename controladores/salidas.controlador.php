<?php
//require __DIR__ . '/autoload.php'; 
//use Mike42\Escpos\Printer;
//use Mike42\Escpos\EscposImage;
//use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorSalidas{

    
/*===============================================================
	CREAR REGISTRO DE ENTRADAS AL ALMACEN
===============================================================*/

	static public function ctrCrearSalida(){
		//$var_php = $_POST['printTicket'];
		//if(isset($_POST['printticket'])){
		//$dir = getcwd();
		if($_SERVER["REQUEST_METHOD"]=="POST" AND isset($_POST["idProducto"])){

			if(preg_match('/^[0-9]+$/', $_POST["numeroSalidaAlm"])){
                
				//$numSalidaAlmacen=trim($_POST["numeroSalidaAlm"]);

				// OBTIENE EL ULTIMO NUMERO DE SALIDA
				$tablaSalida = "hist_salidas";
				$item = "num_salida";
				$valor = "";
				$respuesta = ModeloSalidas::MdlAsignarNumSalida($tablaSalida, $item, $valor);
				$numSalidaAlmacen=$respuesta[0];

				if(is_null($numSalidaAlmacen)){
					$numSalidaAlmacen=1;
				}

                //EXTRAE EL NOMBRE DEL ALMACEN
				$tabla =trim(strtolower(substr($_POST['nuevaSalidaAlmacen'],strpos($_POST['nuevaSalidaAlmacen'].'-','-')+1))); 
				$tipodeventa=trim($_POST['tipodeventa']);
                
                //EXTRAE EL NUMERO DE ALMACEN
                $id_almacen=strstr($_POST['nuevaSalidaAlmacen'],'-',true);   
                
				$respuesta = ModeloSalidas::mdlIngresarSalida($tabla,filtrado($_POST["nuevoCliente"]), $_POST["fechaSalida"],$numSalidaAlmacen, $_POST["idcaja"], $_POST["espromo"], $_POST["idProducto"], $_POST["cantidad"], $_POST["precio_venta"], $id_almacen, $_POST["nuevoTipoSalida"],$_POST["nuevotipovta"], $_POST["idDeUsuario"], $_POST["pagocliente"] );

				if($respuesta == "ok"){

				 if(isset($_POST["printicket"]) && $_POST["printicket"]=="1"){
			
					// try{
					// }catch(Exception $e){/*No hacemos nada si hay error*/}

					echo '<script>  
						window.location = "salidas";	
						var idNotaSalida="'.$numSalidaAlmacen.'";		
						window.open("extensiones/tcpdf/pdf/impticket.php?codigo="+idNotaSalida,"_blank","top=100,left=500,width=350,height=500");
						//console.log("Entra aqui1")
					</script>';
					
				 }else{
					echo '<script>  
					window.location = "salidas";
					//console.log("Entra aqui2")
					</script>';

				}	//fin de printicket

				}else{
                    
					echo "<script>           
					
					Swal.fire({
						title: '¡Error!',
						text: 'Venta NO ha sido guardada!',
						icon: 'error',
						confirmButtonText: 'Entendido'
					  }).then(function(result){
						if (result) {
							window.location = 'salidas';
						}
					});
					
                    </script>"; 
                    
                }


			}else{

				echo "<script>

				Swal.fire({
					title: '¡Error!',
					text: '¡No. de Salida no puede ir vacío o llevar caracteres especiales!',
					icon: 'error',
					timer: 4000,
					confirmButtonText: 'Entendido'
				}).then(function(result){
						if (result) {
							window.location = 'inicio';
						}
					}) 
			  	</script>";

			}

		}

	} //fin 
        
    
/*=============================================================== */
static public function ctrProdEliminar($tabla, $item, $valor, $idUsuario){

 $respuesta = ModeloSalidas::mdlMostrarProdEliminar($tabla, $item, $valor);
 if($respuesta){
	$getUltNumCancelado=ModeloSalidas::mdlgetUltNumCancelado();
	$num_cancelacion=$getUltNumCancelado[0]["num_cancelacion"];
	if($num_cancelacion==0){
		$num_cancelacion=1;
	}

	$idcliente=$respuesta[0]["id_cliente"];
    $numsalida=$respuesta[0]["num_salida"];
    $fechasalida=$respuesta[0]["fecha_salida"];
	$idalmacen=$respuesta[0]["id_almacen"];
	$espromo=$respuesta[0]["es_promo"];
	$tablasal=trim(strtolower($respuesta[0]["nombre"]));
	$item="id_producto";
	foreach($respuesta as $key => $value){
	   
	   $espromo=$value["es_promo"];
	   $valor1=$value["id_producto"];
	   $valor2=$value["cantidad"];
	   $prevta=$value["precio_venta"];
        
        if($resp=ModeloSalidas::MdlGuardaCancelado($idcliente, $num_cancelacion, $numsalida, $fechasalida, $valor1, $valor2, $prevta, $idalmacen, $espromo, $idUsuario)){     //Guarda los productos cancelados
			$resp1=ModeloSalidas::MdlActualizaAlmacen($tablasal, $item, $valor1, $valor2, $idUsuario);   //actualiza tabla 'almacen'
		   if ($resp1){
			 $tablaprod="productos";
				$resp2=ModeloSalidas::MdlActualizaProductos($tablaprod, $valor1, $valor2, $idUsuario);	//actualiza tabla productos
		   }
			
			if($resp2){
			  $resp3 = ModeloSalidas::mdlProdEliminar($tabla, $numsalida, $valor1, $valor2 );
			}
		};   
	}  //fin del foreach	
	 return $respuesta;
 }else{	
	return false;
 }	
}

/*=============================================
VALIDA QUE NUMERO DE DOCTO NO SE REPITA
=============================================*/

	static public function ctrValidarNumSalida($item, $valor){

		$tabla = "hist_salidas";

		$respuesta = ModeloSalidas::MdlValidarNumSalida($tabla, $item, $valor);

		return $respuesta;
	
	}      

/*=============================================
	OBTENER EL ULTIMO NUMERO DE DOCTO 
=============================================*/

	static public function ctrAsignarNumSalida($item, $valor){

		$tabla = "hist_salidas";

		$respuesta = ModeloSalidas::MdlAsignarNumSalida($tabla, $item, $valor);

		return $respuesta;
	
	}      
	

/*=================MOSTRAR TIPO MOV DE SALIDA ================================ */
static public function ctrMostrarTipoMovs($tabla, $item, $valor){

	$respuesta = ModeloSalidas::MdlMostrarTipoMovs($tabla, $item, $valor);
	return $respuesta;
}

	
/*=============================================
	REPORTE NOTA DE SALIDAS
============================================*/

	static public function ctrSalidaAlm($item, $valor){

		$tabla = "hist_salidas";

		$respuesta = ModeloSalidas::MdlSalidaAlm($tabla, $item, $valor);

		return $respuesta;
	
	}  	

/*=============================================
	MOSTRAR CON CUANTO PAGO EL CLIENTE
============================================*/

static public function ctrCobroVenta($valor){

	$tabla = "cobrosdeventas";
	$item = "id_ticket";
	$respuesta = ModeloSalidas::MdlCobroVenta($tabla, $item, $valor);

	return $respuesta;

}  	

/*=============================================
	MOSTRAR SALIDAS AL ALMACEN
============================================*/

	static public function ctrMostrarSalidas($tabla, $item, $valor, $fechaSel){

		$respuesta = ModeloSalidas::MdlMostrarSalidas($tabla, $item, $valor, $fechaSel);

		return $respuesta;
	
	}  	
	
	
/*============================================================
MOSTRAR VENTAS SIN ENVASES Y SIN SERVICIOS
==============================================================*/
static public function ctrSumaTotalVentas($tabla, $item, $valor,$cerrado, $fechacutvta){

	$respuesta = ModeloSalidas::mdlSumaTotalVentas($tabla, $item, $valor, $cerrado, $fechacutvta);

	if($respuesta){
		return $respuesta;
	}else{
		return 0;
	}	
}     
/*=============================================
MOSTRAR VENTAS ENVASES
=============================================*/
static public function ctrSumTotVtasEnv($tabla, $item, $valor,$cerrado, $fechacutvta){

	$respuesta = ModeloSalidas::mdlSumTotVtasEnv($tabla, $item, $valor,$cerrado, $fechacutvta);

	if($respuesta){
		return $respuesta;
	}else{
		return 0;
	}	

}     
/*=============================================
MOSTRAR VENTAS SERVICIOS
=============================================*/
static public function ctrSumTotVtasServ($tabla, $item, $valor,$cerrado, $fechacutvta){

	$respuesta = ModeloSalidas::mdlSumTotVtasServ($tabla, $item, $valor,$cerrado, $fechacutvta);

	if($respuesta){
		return $respuesta;
	}else{
		return 0;
	}	
	

}     
/*=============================================
MOSTRAR VENTAS DE OTROS
=============================================*/
static public function ctrSumTotVtasOtros($tabla, $item, $valor,$cerrado, $fechacutvta){

	$respuesta = ModeloSalidas::mdlSumTotVtasOtros($tabla, $item, $valor,$cerrado, $fechacutvta);

	if($respuesta){
		return $respuesta;
	}else{
		return 0;
	}	
	

}     

/*============================================================
MOSTRAR VENTAS A CREDITO
==============================================================*/
static public function ctrSumTotVtasCred($tabla, $item, $valor,$cerrado, $fechacutvta){

	$respuesta = ModeloSalidas::mdlSumTotVtasCred($tabla, $item, $valor, $cerrado, $fechacutvta);

	if($respuesta){
		return $respuesta;
	}else{
		return 0;
	}	

}     

/*=============================================
MOSTRAR CANT TOTAL VENTAS 
=============================================*/
static public function ctrCantTotalVentas($tabla, $item, $valor){

	$respuesta = ModeloSalidas::mdlCantTotalVentas($tabla, $item, $valor);

	return $respuesta;

}     

/*=============================================
VENTAS ULTIMOS 7 DIAS
=============================================*/
static public function ctrVtaUlt7Dias($tabla, $item, $valor){

	$respuesta = ModeloSalidas::mdlVtaUlt7Dias($tabla, $item, $valor);

	return $respuesta;

}     

/*=============================================
COMPRAS ULTIMOS 7 DIAS
=============================================*/
static public function ctrComprasUlt7Dias($tabla, $item, $valor){

	$respuesta = ModeloSalidas::mdlComprasUlt7Dias($tabla, $item, $valor);

	return $respuesta;

}     
/*=============================================

/*=============================================
VENTAS ULTIMOS 12 MESES 
=============================================*/
static public function ctrVtaUlt12Meses($tabla, $item, $valor){

	$respuesta = ModeloSalidas::mdlVtaUlt12Meses($tabla, $item, $valor);

	return $respuesta;

}     

/*=============================================
RANGO FECHAS
=============================================*/	

static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal){

	$tabla = "hist_salidas";

	$respuesta = ModeloSalidas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

	return $respuesta;
		
}
    
/*=============================================
CIERRE DE CAJA DE VENTA DEL DIA
=============================================*/
static public function ctrCierreDia($tabla, $id_caja, $id_corte, $id_fecha){

    $respuesta = ModeloSalidas::mdlCierreDia($tabla, $id_caja, $id_corte, $id_fecha);

	return $respuesta;

}     
   
/*=============================================
CIERRE DE CAJA DE VENTA DEL DIA FORZOSO
=============================================*/
static public function ctrCierreForzoso($tabla, $id_caja, $id_corte, $id_fecha){

    $respuesta = ModeloSalidas::mdlCierreForzoso($tabla, $id_caja, $id_corte, $id_fecha);

	return $respuesta;

}     

/*=============================================
TRAER PRODUCTOS
=============================================*/
static public function ctrQuerydeProductos($tabla, $item, $valor, $estado){

    $respuesta = ModeloSalidas::mdlQuerydeProductos($tabla, $item, $valor, $estado);

	return $respuesta;

}     

/*=============================================
    LISTAR CANCELACIONES
============================================*/
static public function ctrListarCancelaciones($item, $valor, $orden, $fechadev1, $fechadev2){

	$tabla = "cancela_ventas";

	$respuesta = ModeloSalidas::mdlListarCancelaciones($tabla, $item, $valor, $orden, $fechadev1, $fechadev2);

	return $respuesta;

}    
/*=============================================*/

/*=============================================
	REPORTE DE CANCELACIONES DE VENTA
============================================*/

static public function ctrImprimirCancelacion($campo, $valor){

	$tabla = "cancela_venta";

	$respuesta = ModeloSalidas::MdlImprimirCancelacion($tabla, $campo, $valor);

	return $respuesta;

}  	


/*============================================================
MOSTRAR VENTAS SIN ENVASES Y SIN SERVICIOS
==============================================================*/
static public function ctrSumaTotales($tabla, $item, $valor,$cerrado, $fechacutvta){

	$respuesta = ModeloSalidas::mdlSumaTotales($tabla, $item, $valor, $cerrado, $fechacutvta);

	if($respuesta){
		return $respuesta;
	}else{
		return 0;
	}	
}     



}	//fin de la clase	


function filtrado($datos){
    $datos = trim($datos); // Elimina espacios antes y después de los datos
    $datos = stripslashes($datos); // Elimina backslashes \
    $datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
    return $datos;
}   

