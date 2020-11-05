<?php

class ControladorProductos{

	/*=============================================
	CREAR PRODUCTO
	=============================================*/

	static public function ctrCrearProducto(){

		if(isset($_POST["nuevaDescripcion"])){

			if(preg_match('/^[\`\'\"\_\#\.\,\-\/a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&	
			   preg_match('/^[0-9]+$/', $_POST["nuevoMinimo"]) &&	
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompra"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])){     //que acepte numero y . decimal
			   
			   $totaliza=1;		//SI ES ENVASE ES 0, SI ES VENTA NORMAL 1, SI ES SERVICIO ES 2, SI ES OTROS ES 3
			   if(isset($_POST['nuevoEnvase'])){
				$totaliza=0;
			   };
			   if(isset($_POST['nuevoServicio'])){
				$totaliza=2;
			   };

			   if(isset($_POST['nuevoOtros'])){
				$totaliza=3;
			   };

			   if(isset($_POST['nuevoGranel'])){
				$vtaGranel=$_POST['nuevoGranel'];
			   }else{
				$vtaGranel=0;
			   };

			   if(isset($_POST['nuevoUnidadxCaja'])){
				$nuevoUnidadxCaja=$_POST['nuevoUnidadxCaja'];
			   }else{
				$nuevoUnidadxCaja=0;
			   };

			   if(!isset($_POST['nuevoHectolitros']) or empty($_POST['nuevoHectolitros']) ){
					$hectolitros=0.00;
			   }else{
					$hectolitros=$_POST['nuevoHectolitros'];
			   }

		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/

			   	// $ruta = "vistas/img/productos/default/anonymous.png";

				// if(isset($_FILES["nuevaImagen"]["tmp_name"]) && !empty($_FILES["nuevaImagen"]["tmp_name"])){

				// 	list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);

				// 	$nuevoAncho = 500;
				// 	$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					// $directorio = "vistas/img/productos/".$_POST["nuevoCodigo"];

					// mkdir($directorio, 0755);

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					// if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){

					// 	/*=============================================
					// 	GUARDAMOS LA IMAGEN EN EL DIRECTORIO
					// 	=============================================*/

					// 	$aleatorio = mt_rand(100,999);

					// 	$ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".jpg";

					// 	$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);						

					// 	$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					// 	imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					// 	imagejpeg($destino, $ruta);

					// }

					// if($_FILES["nuevaImagen"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

					// 	$aleatorio = mt_rand(100,999);

					// 	$ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".png";

					// 	$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);						

					// 	$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					// 	imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					// 	imagepng($destino, $ruta);

					// }

				//}  //fin de subir imagen

				$tabla = "productos";
				/*=============================================
				CREAR JSON DE PRODUCTOS CON PROMOCION
				=============================================*/
				$datosjson = array(); //creamos un array para el JSON
				
				if(isset($_POST["idProducto"])){
					foreach ($_POST["idProducto"] as $clave=>$valor){
						$datosjson[]=array(
									"id_producto" => $_POST["idProducto"][$clave],
									"cantidad"	  => $_POST["cantidad"][$clave],
									"precio"	  => $_POST["precio_promo"][$clave]
									);
					};	
				};
				
				if(empty($datosjson)){
					$datos_promocion=NULL;
				}else{
					$datos_promocion=json_encode($datosjson);	//Creamos el JSON
				}
				
				/*=============================================
				ARRAY PARA GUARDAR PRODUCTO
				=============================================*/
				$datos = array("id_categoria" 		=> $_POST["nuevaCategoria"],
							   "id_medida" 			=> $_POST["nuevaMedida"],
							   "id_familia" 		=> $_POST["nuevaFamilia"],
							   "codigo" 			=> $_POST["nuevoCodigo"],
							   "ultusuario" 		=> $_POST["idDeUsuario"],
							   "codigointerno" 		=> $_POST["nuevoCodInterno"],
							   "descripcion" 		=> strtoupper($_POST["nuevaDescripcion"]),
							   "stock" 				=> $_POST["nuevoStock"],
							   "minimo" 			=> $_POST["nuevoMinimo"],
							   "unidadxcaja"		=> $nuevoUnidadxCaja,
							   "hectolitros" 		=> $hectolitros,
							   "precio_compra" 		=> $_POST["nuevoPrecioCompra"],
							   "margen" 			=> $_POST["nuevoMargen"],
							   "precio_venta" 		=> $_POST["nuevoPrecioVenta"],
							   "leyenda" 			=> $_POST["nuevaLeyenda"],
							   "ubicacion" 			=> $_POST["nuevoPasillo"].$_POST["nuevoAnaquel"].$_POST["nuevaGaveta"],
							   "totaliza" 			=> $totaliza,
							   "granel" 			=> $vtaGranel,
							   "datos_promocion" 	=> $datos_promocion);
							   //"imagen" 		 	=> $ruta);

				$respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

						swal.fire({
							position: "top-end",
							icon: "success",
							title: "El producto ha sido guardado correctamente",
							showConfirmButton: false,
							timer: 2000
						})
							  .then((result)=>{
									if(result) {
										//$(".tablaProductos").DataTable().ajax.reload(null, false);
										window.location = "productos";
									}
								})

						</script>';

				}else{
					echo'<script>

						swal.fire({
							  icon: "warning",
							  title: "El producto no ha sido guardado!!",
							  }).then(function(result){
										if (result) {
										//$(".tablaProductos").DataTable().ajax.reload(null, false);
										window.location = "productos";

										}
									})

						</script>';                    
                }


			}else{

				echo'<script>

					swal.fire({
						  icon: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  }).then(function(result){
							if (result.value) {
								window.location = "productos";
							}
						})

			  	</script>';
			}
		}

	}    
    
    
/*=============================================
	EDITAR PRODUCTO
	=============================================*/

	static public function ctrEditarProducto(){

		if(isset($_POST["editarDescripcion"])){

			if(preg_match('/^[\`\'\"\_\#\.\,\-\/a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarStock"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarMinimo"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompra"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioVenta"])){

				$totaliza=1;
				if(isset($_POST['editarEnvase'])){
				 $totaliza=0;
				};
				if(isset($_POST['editarServicio'])){
				 $totaliza=2;
				};
				if(isset($_POST['editarOtros'])){
					$totaliza=3;
				};

				if(isset($_POST['editarGranel'])){
					$vtaGranel=$_POST['editarGranel'];
				   }else{
					$vtaGranel=0;
			    };
	
			   if(isset($_POST['editarUnidadxCaja'])){
					$editarUnidadxCaja=$_POST['editarUnidadxCaja'];
				   }else{
					$editarUnidadxCaja=0;
			   };
	
		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/
			   	// $ruta = isset($_POST["imagenActual"])?$_POST["imagenActual"]:"vistas/img/productos/default/default.jpg";
 
			   	// if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){

				// 	list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

				// 	$nuevoAncho = 500;
				// 	$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					// $directorio = "vistas/img/productos/".$_POST["editarCodigo"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					// if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/default.jpg"){

					// 	unlink($_POST["imagenActual"]);

					// }else{

					// 	mkdir($directorio, 0755);	
					
					// }
					
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

//					if($_FILES["editarImagen"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

					// 	$aleatorio = mt_rand(100,999);

					// 	$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";

					// 	$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);						

					// 	$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					// 	imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					// 	imagejpeg($destino, $ruta);

					// }

					// if($_FILES["editarImagen"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

					// 	$aleatorio = mt_rand(100,999);

					// 	$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".png";

					// 	$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);						

					// 	$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					// 	imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					// 	imagepng($destino, $ruta);

					// }

				//}
				/*=============================================
				ARRAY PARA GUARDAR PRODUCTO MODIFICADO
				=============================================*/
				$tabla = "productos";
				
				$datosjson = array(); //creamos un array para el JSON
				$datos_promocion = NULL; 

				if(isset($_POST['idProducto'])){

					if(!empty($_POST['idProducto'])){
						foreach ($_POST["idProducto"] as $clave=>$valor){
					
							$datosjson[]=array(
										"id_producto" => $_POST["idProducto"][$clave],
										"cantidad"	  => $_POST["cantidad"][$clave],
										"precio"	  => $_POST["precio_promo"][$clave]
										);
						};	
						$datos_promocion=json_encode($datosjson);	//Creamos el JSON				
					}
					
				};


				$datos = array("id" 			=> $_POST["id_de_Producto"],
							   "id_categoria" 	=> $_POST["editarCategoria"],
							   "id_familia" 	=> $_POST["editarFamilia"],
							   "id_medida" 		=> $_POST["editarMedida"],
							   "codigo" 		=> $_POST["editarCodigo"],
							   "ultusuario" 	=> $_POST["idDeUsuario"],
							   "codigointerno" 	=> $_POST["editarCodInterno"],
							   "descripcion" 	=> strtoupper($_POST["editarDescripcion"]),
							   "stock" 			=> $_POST["editarStock"],
							   "minimo" 		=> $_POST["editarMinimo"],
							   "unidadxcaja"	=> $editarUnidadxCaja,
							   "hectolitros" 	=> $_POST["editarHectolitros"],
							   "precio_compra" 	=> $_POST["editarPrecioCompra"],
							   "margen" 		=> $_POST["editarNuevoMargen"],
							   "precio_venta" 	=> $_POST["editarPrecioVenta"],
							   "leyenda" 		=> $_POST["editarLeyenda"],
							   "ubicacion" 		=> $_POST["editarPasillo"].$_POST["editarAnaquel"].$_POST["editarGaveta"],
							   "totaliza" 		=> $totaliza,
							   "granel" 		=> $vtaGranel,
							   "datos_promocion"=> $datos_promocion);
							   //"imagen"			=> $ruta);

				$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);

				if($respuesta == "ok"){
					echo'<script>

						swal.fire({
							position: "top-end",
							icon: "success",
							title: "El producto ha sido editado correctamente",
							showConfirmButton: false,
							timer: 2000
						})
						.then((result)=>{
							if (result) {
							//$(".tablaProductos").DataTable().ajax.reload(null, false);
								window.location = "productos";
							}else{
								window.location = "productos";
							}
						})

					</script>';

				}


			}else{

				echo'<script>

					swal.fire({
						  icon: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  }).then((result)=>{
							if (result) {

							window.location = "productos";

							}
						})

			  	</script>';
			}
		}

	}    

    
/*=============================================
	BORRAR PRODUCTO
	=============================================*/
	static public function ctrEliminarProducto(){

		if(isset($_GET["idProducto"])){

			$tabla ="productos";
			$datos = $_GET["idProducto"];
            
            /*
            //DESCOMENTAR SI SE NECESITA BORRAR EL DIRECTORIO DE LA IMAGEN
			if($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png"){

				unlink($_GET["imagen"]);
				rmdir('vistas/img/productos/'.$_GET["codigo"]);

			}
            */
            
			$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);

			if($respuesta == "ok"){
				echo"<script>

					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						onOpen: (toast) => {
						toast.addEventListener('mouseenter', Swal.stopTimer)
						toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					})
					
					Toast.fire({
						icon: 'success',
						title: 'Producto ha sido borrado correctamente. Espere...'
					}).then((result)=>{
						if(result) {
							window.location = 'productos';
						}
					})

			</script>";

			}else {
				echo'<script>
				swal.fire({
					  icon: "error",
					  title: "ha habido un error",
					  }).then((result)=>{
								if(result) {
									window.location = "productos";
								}
							})

				</script>';

			}
		}


	}    
 
	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

	static public function ctrMostrarProductos($item, $valor, $orden, $estado){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $orden, $estado);

		return $respuesta;

	}

/*=============================================
	LISTAR PRODUCTOS
	=============================================*/

	static public function ctrListaProductos($item, $valor, $orden, $estado){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlListaProductos($tabla, $item, $valor, $orden, $estado);

		return $respuesta;
}		

	/*=============================================
	VERIFICA CODIGO INTERNO
	=============================================*/

	static public function ctrVerificaCodigo($item, $valor){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlVerificaCodigo($tabla, $item, $valor);

		return $respuesta;

	}

	
    
	/*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/

	static public function ctrMostrarSumaVentas(){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarSumaVentas($tabla);

		return $respuesta;

	}
	

	/*=============================================
	MOSTRAR PRODUCTOS MENOS VENDIDOS
	=============================================*/

	static public function ctrMostrarProductosMenosVta($item, $valor, $orden){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductosMenosVta($tabla, $item, $valor, $orden, $cerrado=1);

		return $respuesta;

	}
	


	
} //FIN DE LA CLASE