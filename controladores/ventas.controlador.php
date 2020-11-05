<?php
class ControladorVentas{

    
/*===============================================================
	CREAR REGISTRO DE ENTRADAS AL ALMACEN
===============================================================*/

	static public function ctrCrearVenta(){
		//$var_php = $_POST['printTicket'];
		//if(isset($_POST['printticket'])){
		if(isset($_POST["idProducto"])){

			if(preg_match('/^[_\#\.\,\-\/a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["numeroSalidaAlm"])){
                
				//$numSalidaAlmacen=trim($_POST["numeroSalidaAlm"]);

				// OBTIENE EL ULTIMO NUMERO DE SALIDA
				$tablaSalida = "hist_salidas";
				$item = "num_salida";
				$valor = "";
				$respuesta = ModeloSalidas::MdlAsignarNumSalida($tablaSalida, $item, $valor);
				$numSalidaAlmacen=$respuesta[0];
				
                //EXTRAE EL NOMBRE DEL ALMACEN
				$tabla =trim(substr($_POST['nuevaSalidaAlmacen'],strpos($_POST['nuevaSalidaAlmacen'].'-','-')+1)); 
                
                //EXTRAE EL NUMERO DE ALMACEN
                $id_almacen=strstr($_POST['nuevaSalidaAlmacen'],'-',true);   
                
				$respuesta = ModeloSalidas::mdlIngresarSalida($tabla,filtradodata($_POST["nuevoCliente"]), $_POST["fechaSalida"], $numSalidaAlmacen, $_POST["idcaja"], $_POST["espromo"], $_POST["idProducto"], $_POST["cantidad"], $_POST["precio_venta"], $id_almacen, $_POST["nuevoTipoSalida"], $_POST["idDeUsuario"] );

				if($respuesta == "ok"){

				if(isset($_POST["printticket"]) &&  $_POST["printticket"]=="1"){
				 	echo '<script>  
				 	(async () => {
						//console.time("Slept for")
						var numTicket="'.$numSalidaAlmacen.'";		//convierte variable PHP a JS
						console.log("Num:",numTicket)
						//await wait(1000);
						//console.timeEnd("Slept for")
				 		await window.open("extensiones/tcpdf/pdf/imprimir_ticket.php?codigo="+numTicket,"_blank","top=200,left=450,width=400,height=400");
				 		//window.location = "salidas";
					 })();  //fin del async	

					 async function wait(ms) {
						return new Promise(resolve => {
						  setTimeout(resolve, ms);
						});
					  }
				 	</script>';
				   }

				//   else{
                //     echo '<script>  
                //     	var varjs="'.$numSalidaAlmacen.'";		//convierte variable PHP a JS
                //         swal({
                //         title: "Guardado! Ticket No. "+varjs,
                //         text: "Venta a sido guardado correctamente!",
                //         icon: "vistas/img/logoaviso.png",
				// 		button: "Cerrar",
				// 		timer: 6000,
                //         })
                //         .then((aceptado) => {
                //           if (aceptado) {
                //               window.location = "salidas";
                //           }else{
                //               window.location = "salidas";
                //           }
                //         }); 
                //     </script>';
                //   }  
				}else{
                    
                    echo '<script>                
                        swal({
                        title: "Error",
                        text: "Venta NO a sido guardado!",
                        icon: "warning",
                        button: "Cerrar",
                       }).then(function(result){
                        if(result){
                            window.location = "salidas";
                        }
                        });                    
                    </script>'; 
                    
                }


			}else{

				echo'<script>

					swal({
						  title: "error",
						  text: "¡No. de Salida no puede ir vacío o llevar caracteres especiales!",
						  icon:"error",
						  button: "Cerrar"
						  }).then(result)=>{
							if (result) {
                                //window.location = "inicio";
							}
						})
			  	</script>';

			}

		}

	} //fin 
        
    
/*=============================================================== */
static public function ctrProdEliminar($tabla, $item, $valor, $idUsuario){

 $respuesta = ModeloSalidas::mdlMostrarProdEliminar($tabla, $item, $valor);
 if($respuesta){
	$idcliente=$respuesta[0]["id_cliente"];
    $numsalida=$respuesta[0]["num_salida"];
    $fechasalida=$respuesta[0]["fecha_salida"];
	$idalmacen=$respuesta[0]["id_almacen"];
	$tablasal=trim($respuesta[0]["nombre"]);
	$item="id_producto";
	foreach($respuesta as $key => $value){
	   
	   $valor1=$value["id_producto"];
	   $valor2=$value["cantidad"];
	   $prevta=$value["precio_venta"];
        
        if($resp=ModeloSalidas::MdlGuardaCancelado($idcliente, $numsalida, $fechasalida, $valor1, $valor2, $prevta, $idalmacen, $idUsuario)){     //Guarda los productos cancelados
			$resp1=ModeloSalidas::MdlActualizaAlmacen($tablasal, $item, $valor1, $valor2, $idUsuario);   //actualiza tabla 'almacen'
		   if ($resp1){
			 $tablaprod="productos";
				$resp2=ModeloSalidas::MdlActualizaProductos($tablaprod, $valor1, $valor2, $idUsuario);	//actualiza tabla productos
		   }
			
			if($resp2){
			  $resp3 = ModeloSalidas::mdlProdEliminar($tabla, $numsalida, $valor1 );
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
	MOSTRAR SALIDAS AL ALMACEN
============================================*/

	static public function ctrMostrarSalidas($tabla, $item, $valor, $fechaSel){

		$respuesta = ModeloSalidas::MdlMostrarSalidas($tabla, $item, $valor, $fechaSel);

		return $respuesta;
	
	}  	
	
	
/*============================================================
MOSTRAR VENTAS SIN ENVASES Y SIN SERVICIOS
==============================================================*/
static public function ctrSumaTotalVentas($tabla, $item, $valor,$cerrado){

	$respuesta = ModeloSalidas::mdlSumaTotalVentas($tabla, $item, $valor, $cerrado);

	return $respuesta;

}     

/*=============================================
MOSTRAR VENTAS ENVASES
=============================================*/
static public function ctrSumTotVtasEnv($tabla, $item, $valor,$cerrado){

	$respuesta = ModeloSalidas::mdlSumTotVtasEnv($tabla, $item, $valor,$cerrado);

	return $respuesta;

}     

/*=============================================
MOSTRAR VENTAS SERVICIOS
=============================================*/
static public function ctrSumTotVtasServ($tabla, $item, $valor,$cerrado){

	$respuesta = ModeloSalidas::mdlSumTotVtasServ($tabla, $item, $valor,$cerrado);

	return $respuesta;

}     

/*============================================================
MOSTRAR VENTAS A CREDITO
==============================================================*/
static public function ctrSumTotVtasCred($tabla, $item, $valor,$cerrado){

	$respuesta = ModeloSalidas::mdlSumTotVtasCred($tabla, $item, $valor, $cerrado);

	return $respuesta;

}     

/*=============================================
MOSTRAR TOTAL VENTAS DE PROC
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
static public function ctrCierreDia($tabla, $id_caja){

    $respuesta = ModeloSalidas::mdlCierreDia($tabla,$id_caja);

	return $respuesta;

}     
   

}	//fin de la clase	

function filtradata($datos){
    $datos = trim($datos); // Elimina espacios antes y después de los datos
    $datos = stripslashes($datos); // Elimina backslashes \
    $datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
    return $datos;
}   

/*
var varjs="'.$numSalidaAlmacen.'";		//convierte variable PHP a JS
swal({
title: "Guardado! Ticket No. "+varjs,
text: "Venta a sido guardado correctamente!",
icon: "vistas/img/logoaviso.png",
buttons: ["Cerrar", "Imprimir Ticket"],
timer: 8000,
})
.then((aceptado) => {
if (aceptado) {
window.open("extensiones/tcpdf/pdf/imprimir_ticket.php?codigo="+varjs, "_blank","top=200,left=500,width=400,height=400");
window.location = "salidas";
}else{
window.location = "salidas";
}
}); 
*/