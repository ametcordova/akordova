<?php

class ControladorProveedores{

	/*=============================================
	CREAR PROVEEDOR
	=============================================*/

	   public function ctrCrearProveedor(){

		if(isset($_POST["NuevoNombre"])){

			if(preg_match('/^[()\#\.\,\-\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["NuevoNombre"]) &&
               preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["NuevoEmail"]) &&                
			   preg_match('/^[()\-0-9 ]+$/', $_POST["NuevoTelefono1"]) ){

			   	$tabla = "proveedores";
               
			   	$datos = array("nombre"=>strtoupper($_POST["NuevoNombre"]),
					           "rfc"=>strtoupper($_POST["NuevoRfc"]),
                               "direccion"=>strtoupper($_POST["NuevaDireccion"]),
                               "codpostal"=>$_POST["NuevoCp"],
                               "ciudad"=>strtoupper($_POST["NuevaCiudad"]),
					           "email"=>$_POST["NuevoEmail"],
					           "telefono"=>$_POST["NuevoTelefono1"],
					           "contacto"=>strtoupper($_POST["NuevoContacto"]),
                               "tel_contacto"=>$_POST["NuevoTelefono2"],
					           "email_contacto"=>$_POST["NuevoEmail2"],
					           "ultusuario" =>   $_POST["idDeUsuario"],
					           "estatus"=>$_POST["NuevoEstado"]);
                
                
			   	$respuesta = ModeloProveedores::mdlIngresarProveedor($tabla, $datos);
                
			   	if($respuesta == "ok"){

					echo'<script>

					swal.fire({
						position: "top-end",
						icon: "success",
						title: "El proveedor ha sido guardado correctamente",
						timer: 3000
						}).then(function(result){
								if (result.value) {
									window.location = "proveedores";
								}else{
									window.location = "proveedores";
								}
							})

					</script>';

				}else{
                    echo '<script>                
                        swal.fire({
                        title: "AVISO!!",
                        text: "¡Proveedor no ha sido guardado correctamente!",
                        icon: "error",
                       }).then(function(result){
                        if(result){
                            window.location = "proveedores";
                        }
                        });                    
                    </script>'; 
                }

			}else{

				echo'<script>

					swal.fire({
						  icon: "error",
						  title: "¡El Proveedor no puede ir vacío o llevar caracteres especiales!",
						  timer: 4000
						  }).then(function(result){
							if (result) {
								window.location = "proveedores";
							}
						})

			  	</script>';
			}

		}else{
            
        }

	}


    /*=============================================
	MOSTRAR PROVEEDORES
	=============================================*/

	static public function ctrMostrarProveedores($item, $valor){

		$tabla = "proveedores";

		$respuesta = ModeloProveedores::mdlMostrarProveedores($tabla, $item, $valor);

		return $respuesta;

	}	
        
    /*=============================================
	EDITAR PROVEEDOR
	=============================================*/   
    static public function ctrEditarProveedor(){
    
    if(isset($_POST["EditarNombre"])){

			if(preg_match('/^[()\#\.\,\-\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["EditarNombre"]) &&
               preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["EditarEmail"]) &&                
			   preg_match('/^[()\-0-9 ]+$/', $_POST["EditarTelefono1"]) ){

			   	$tabla = "proveedores";
               
			   	$datos = array("nombre"=>strtoupper($_POST["EditarNombre"]),
					           "rfc"=>strtoupper($_POST["EditarRfc"]),
                               "direccion"=>strtoupper($_POST["EditarDireccion"]),
                               "codpostal"=>$_POST["EditarCp"],
                               "ciudad"=>strtoupper($_POST["EditarCiudad"]),
					           "email"=>$_POST["EditarEmail"],
					           "telefono"=>$_POST["EditarTelefono1"],
					           "contacto"=>strtoupper($_POST["EditarContacto"]),
                               "tel_contacto"=>$_POST["EditarTelefono2"],
					           "email_contacto"=>$_POST["EditarEmail2"],
                               "ultusuario" =>   $_POST["idDeUsuario"],
					           "estatus"=>$_POST["EditarEstado"],
					           "id"=>$_POST["idProveedor"]);
    
                $respuesta = ModeloProveedores::mdlEditarProveedor($tabla, $datos);
                
               
			   	if($respuesta == "ok"){

					echo'<script>

					Swal.fire({
						icon: "success",
						title: "El Proveedor ha sido cambiado correctamente",
						timer: 3000 
						  }).then(function(result){
								if (result.value) {
									window.location = "proveedores";
								}else{
									window.location = "proveedores";
								}
							})

					</script>';

				}elseif ($respuesta=="error"){
					echo'<script>
						swal.fire("Error!", "No fue posible Actualizar Proveedor!");
					</script>';
				}

			}else{

				echo'<script>

					swal.fire({
						  icon: "error",
						  title: "¡El proveedor no puede ir vacío o llevar caracteres especiales!",
						  }).then(function(result){
							if (result.value) {
								window.location = "proveedores";
							}
						})

			  	</script>';

			}

		}
    
     }
    
	/*=============================================
	ELIMINAR PROVEEDOR
	=============================================*/

	static public function ctrEliminarProveedor(){

		if(isset($_GET["idProveedor"])){

			$tabla ="proveedores";
			$datos = $_GET["idProveedor"];

			$respuesta = ModeloProveedores::mdlEliminarProveedor($tabla, $datos);

			if($respuesta == "ok"){

				echo "<script>
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
				 title: 'Proveedor ha sido Borrado. Espere..!! '
			   })
					setTimeout(function(){
					 window.location = 'proveedores';
				 }, 2000);                
				   
			   </script>"; 

			}else{
				echo'<script>

				swal.fire({
					  icon: "error",
					  title: "El Proveedor no ha sido borrado correctamente",
					  button: "Cerrar",
					  }).then(result)=>{
								if (result.value) {
									window.location = "proveedores";
								}
							})

				</script>';

			}		

		}

	}   
    
    
/*=============================================
	CONTAR PROVEEDORES
=============================================*/

static public function ctrContarProveedores($tabla, $item, $valor){

	$respuesta = ModeloProveedores::mdlContarProveedores($tabla, $item, $valor);
	return $respuesta;

}	
    
    
} //fin de la clase

