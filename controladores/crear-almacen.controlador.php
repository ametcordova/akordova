<?php

class ControladorAlmacenes{

	/*=============================================
	CREAR ALMACEN
	=============================================*/

	   static public function ctrCrearAlmacen(){

		if(isset($_POST["nuevoAlmacen"]) &&  $_POST["nuevoAlmacen"]!="almacenes" && $_POST["nuevoAlmacen"]!="ALMACENES"){
			
			if(preg_match('/^[_\-a-zA-Z0-9 ]+$/', trim($_POST["nuevoAlmacen"])) &&
               preg_match('/^[,\#\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaUbicacion"]) &&
               preg_match('/^[,\#\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoResponsable"]) &&
               preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"]) &&
			   preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoTelefono"]) ){

			   	$tabla = "almacenes";
				
			   	$datos = array("nombre"=>strtoupper($_POST["nuevoAlmacen"]),
							   "ultusuario"=>$_POST["idDeUsuario"],
							   "ubicacion"=>strtoupper($_POST["nuevaUbicacion"]),
					           "responsable"=>strtoupper($_POST["nuevoResponsable"]),
					           "telefono"=>$_POST["nuevoTelefono"],
							   "email"=>$_POST["nuevoEmail"]);
					           
              			   	$respuesta = ModeloAlmacenes::mdlIngresarAlmacen($tabla, $datos);
				
				
				
			   	if($respuesta == "ok"){

					echo'<script>
					swal.fire({
						position: "top-end",
						icon: "success",
						title: "Almacen ha sido creado correctamente",
						timer: 3000,
						  }).then((result)=>{
								if (result) {

									window.location = "crear-almacen";

								}
							})

					</script>';

				}else{
                    echo '<script>                
                        swal.fire({
                        title: "Error!",
                        text: "¡Almacen no ha sido guardado correctamente!",
                        icon: "warning",
                        button: "Cerrar",
                       }).then(function(result){
                        if(result){
                            window.location = "crear-almacen";
                        }
                        });                    
                    </script>'; 
                }

			}else{

				echo'<script>

					swal.fire({
						  icon: "error",
						  title: "¡El nombre de Almacen no puede ir vacío o llevar caracteres especiales!",
						  timer: 4000
						  }).then((result)=>{
							if (result) {
								window.location = "crear-almacen";
							}
						})

			  	</script>';

			}

		}else{
				echo'<script>
				console.log("No entra")
			  	</script>';			
		}
			

	}

/*=============================================
	MOSTRAR ALMACENES
	=============================================*/

	static public function ctrMostrarAlmacenes($item, $valor){
	
		$tabla = "almacenes";

		$respuesta = ModeloAlmacenes::mdlMostrarAlmacenes($tabla, $item, $valor);

		return $respuesta;

	}	
    
    
    
    /*=============================================
	EDITAR CLIENTE
	=============================================*/

	static public function ctrEditarAlmacen(){

		if(isset($_POST["editarAlmacen"])){

			if(preg_match('/^[#\.\,\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarResponsable"]) &&
               preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editarEmail"]) &&
			   preg_match('/^[()\-0-9 ]+$/', $_POST["editarTelefono"]) &&
			   preg_match('/^[#\.\,\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarUbicacion"]) ){

			   	$tabla = "almacenes";

				$vienede=isset($_POST["scriptSource"])? $_POST["scriptSource"]:"crear-almacen";    //SI VIENE DE CREAR-VENTA O DE CLIENTES
                
			   	$datos = array("id"=>$_POST["idAlmacen"],
							   "ultusuario"=>$_POST["idDeUsuario"],
					           "ubicacion"=>strtoupper($_POST["editarUbicacion"]),
							   "responsable"=>strtoupper($_POST["editarResponsable"]),
					           "email"=>$_POST["editarEmail"],
					           "telefono"=>$_POST["editarTelefono"]);

			   	$respuesta = ModeloAlmacenes::mdlEditarAlmacen($tabla, $datos);
				
			   	if($respuesta == "ok"){

					echo "<script>
					var varjs='".$vienede."';		//convierte variable PHP a JS

					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
						onOpen: (toast) => {
						  toast.addEventListener('mouseenter', Swal.stopTimer)
						  toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					  })
					  
					  Toast.fire({
						icon: 'success',
						title: 'Almacen ha sido cambiado correctamente!! '
					  })
						   setTimeout(function(){
							   window.location = varjs;
						}, 2000);                

					   </script>";

				}

			}else{

				echo'<script>

					swal.fire({
						  icon: "error",
						  text: "¡Nombre no puede ir vacío o llevar caracteres especiales!",
						  timer: 4000
						  }).then(function(result){
							if (result) {

								window.location = varjs;

							}
						})

			  	</script>';

			}

		}

	}    

    
/*=============================================
	ELIMINAR ALMACEN -- DESARROLLAR
=============================================*/

	static public function ctrEliminarAlmacen(){

		if(isset($_GET["idCliente"])){

			$tabla ="clientes";
			$datos = $_GET["idCliente"];

			$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal.fire({
					  icon: "success",
					  title: "El cliente ha sido borrado correctamente",
					  timer: 4000,
					  }).then((result)=>{
							if (result) {
								window.location = "crear-almacen";
							}
						})

				</script>';
			}else {
				echo'<script>
				swal.fire({
					  icon: "error",
					  title: "ha habido un error",
					  }).then((result)=>{
							if (result) {
								window.location = "crear-almacen";
							}
						})

				</script>';

			}		

		}

	}    
    
} //fin de la clase

