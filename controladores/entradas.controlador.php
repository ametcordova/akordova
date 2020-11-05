<?php

class ControladorEntradas{

	/*=============================================
	CREAR REGISTRO DE ENTRADAS AL ALMACEN
	=============================================*/

	static public function ctrCrearEntrada(){

		if(isset($_POST["idProducto"])){

			if(preg_match('/^[_\#\.\,\-\/a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["numeroDocto"])){
                
                //EXTRAE EL NOMBRE DEL ALMACEN
				$tabla =trim(strtolower(substr($_POST['nuevoAlmacen'],strpos($_POST['nuevoAlmacen'].'-','-')+1))); 
                
                //EXTRAE EL NUMERO DE ALMACEN
                $id_almacen=strstr($_POST['nuevoAlmacen'],'-',true);   
                
                //extrae el numero de almacen
                //$id_almacen=substr($_POST['nuevoAlmacen'],0, strpos($_POST['nuevoAlmacen'], '-',1));
                
				$respuesta = ModeloEntradas::mdlIngresarEntrada($tabla,$_POST["nuevoProveedor"],$_POST["fechaDocto"],$_POST["numeroDocto"],$_POST["nombreRecibe"],$_POST["idProducto"],$_POST["codigointerno"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"],$_POST["fechaEntrada"],$_POST["NuevoTipoEntrada"],$id_almacen,$_POST["idDeUsuario"] );
                //$whatpre=$_POST["precio_compra"][0];
				
				if($respuesta == "ok"){
                    
                    echo '<script>                
					 var varjs="'.$tabla.'";		//convierte variable PHP a JS

                        Swal.fire({
                        title: "Guardado en "+varjs,
                        text: "Entrada a sido guardado correctamente!",
                        icon: "success",
						timer: 3000,
						confirmButtonText: "Entendido"
					   })
					   .then((result)=>{
                        if(result.value){
                            window.location = "entradas";
                        }
						});                    
						
                    </script>'; 
				}else{

					echo '<script>                
					   var varjs="'.$respuesta.'";		//convierte variable PHP a JS
                        Swal.fire({
                        title: "Error"+varjs,
                        text: "Entrada no a sido guardado!",
                        icon: "warning",
                        confirmButtonText: "Entendido"
					   })
					   .then(function(result){
                        if(result.value){
                            window.location = "entradas";
                        }
                        });                    
                    </script>'; 
                    
                }


			}else{

				echo'<script>

					Swal.fire({
						  title: "error",
						  text: "¡NO. de Documento no puede ir vacío o llevar caracteres especiales!",
						  icon:"error",
						  confirmButtonText: "Entendido"
						  })
						  .then(result)=>{
							if (result.value) {
                                //window.location = "entradas";
							}
						})

			  	</script>';

			}

		}

	}
	
	/*=============================================
	VALIDA QUE NUMERO DE DOCTO NO SE REPITA
	============================================*/

	static public function ctrValidarDocto($item, $valor){

		$tabla = "hist_entrada";

		$respuesta = ModeloEntradas::MdlValidarDocto($tabla, $item, $valor);

		return $respuesta;
	
	}  
	
	
	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

	static public function ctrDatosProducto($item, $valor, $nomalmacen){

		$tabla = "productos";

		$respuesta = ModeloEntradas::mdlMostrarProducto($tabla, $item, $valor, $nomalmacen);

		return $respuesta;

	}
	

    /*=============================================
	MOSTRAR PROVEEDORES
	=============================================*/

	static public function ctrMostrarProv($item, $valor){

		$tabla = "proveedores";

		$respuesta = ModeloEntradas::mdlMostrarProv($tabla, $item, $valor);

		return $respuesta;

	}	
    
	/*=============================================
	REPORTE DE ENTRADAS
	============================================*/

	static public function ctrEntradaAlm($item, $valor){

		$tabla = "hist_entrada";

		$respuesta = ModeloEntradas::MdlEntradaAlm($tabla, $item, $valor);

		return $respuesta;
	
	}  
		
	
	
}	//fin de la clase
