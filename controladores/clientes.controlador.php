<?php

class ControladorClientes{

/*=============================================
CREAR CLIENTES
=============================================*/

	public function ctrCrearCliente(){

		if(isset($_POST["nuevoCliente"])){

			if(preg_match('/^[\\/&\=\()\_\-\#\.\,\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCliente"]) &&
               preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"])){

			   	$tabla = "clientes";
				
				$vienede=isset($_POST["scriptSource"])? $_POST["scriptSource"]:"clientes";
				
                //$newDate = date("Y-d-m", strtotime($_POST["nuevaFechaNacimiento"]));
			   	$datos = array("nombre"			=> strtoupper($_POST["nuevoCliente"]),
					           "rfc"			=> strtoupper($_POST["nuevoDocumento"]),
					           "email"			=> $_POST["nuevoEmail"],
					           "telefono"		=> $_POST["nuevoTelefono"],
							   "direccion"		=> strtoupper($_POST["nuevaDireccion"]),
					           "limitecredito"	=> $_POST["nvoLimitecredito"],
					           "descuento"		=> $_POST["nuevoDescuento"],
					           "estado"			=> $_POST["nvoestadoCliente"],
                               "ultusuario" 	=> $_POST["idDeUsuario"],
					           "fecha_nacimiento"=>$_POST["nuevaFechaNacimiento"]);
                
			   	$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>
					var varjs="'.$vienede.'";		//convierte variable PHP a JS
					swal.fire({
						position: "top-end",
						icon: "success",
						title: "El cliente ha sido guardado correctamente",
						timer: 2000
						  }).then((result)=>{
									if (result) {

									window.location = varjs;

									}
								})

					</script>';

				}else{
                    echo '<script>                
                        swal.fire({
                        title: "Error",
                        text: "¡Cliente no ha sido guardado correctamente!",
                        icon: "warning",
                       }).then((result)=>{
                        if(result){
                            window.location = varjs;
                        }
                        });                    
                    </script>'; 
                }

			}else{

				echo'<script>

					swal({
						  icon: "error",
						  title: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
						  timer: 4000
						  }).then((result)=>{
							if (result) {

							window.location = varjs;

							}
						})

			  	</script>';



			}

		}

	}

/*=============================================
	MOSTRAR CLIENTES
=============================================*/

	static public function ctrMostrarClientes($item, $valor){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);

		return $respuesta;

	}	
    
/*=============================================
	ABONO CLIENTES
=============================================*/

static public function ctrAbonoCliente($tabla, $datos){

	//$tabla = "clientes";

	$respuesta = ModeloClientes::mdlAbonoCliente($tabla, $datos);

	return $respuesta;

}	

/*=============================================
	ABONO A ESTADO DE CUENTA
=============================================*/

static public function ctrAbonoEdoCta($tabla, $datos){

	$respuesta = ModeloClientes::mdlAbonoEdoCta($tabla, $datos);

	return $respuesta;

}	
    
/*=============================================
	TRAER ABONOS DEL CLIENTE 
=============================================*/

static public function ctrAbonosdeCliente($idNumCliente, $fechavtaIni, $fechavtaFin){
	$tabla = "abonoscliente";
	$respuesta = ModeloClientes::mdlAbonosdeCliente($tabla, $idNumCliente, $fechavtaIni, $fechavtaFin);

	return $respuesta;

}	

/*=============================================
	EDITAR CLIENTE
=============================================*/

	static public function ctrEditarCliente(){

		if(isset($_POST["EditarCliente"])){

			if(preg_match('/^[\\/&\=\()\_\-\#\.\,\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["EditarCliente"]) &&
               preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["EditarEmail"])){

			   	$tabla = "clientes";

				$vienede=isset($_POST["scriptSource"])? $_POST["scriptSource"]:"clientes";    //SI VIENE DE CREAR-VENTA O DE CLIENTES
                
                //$nuevaFecha = date("Y-m-d", strtotime($_POST["EditarFechaNacimiento"]));
                //var_dump($nuevaFecha);
                
			   	$datos = array("id"=>$_POST["idCliente"],
			   				   "nombre"=>   strtoupper($_POST["EditarCliente"]),
					           "rfc"=>      strtoupper($_POST["EditarDocumento"]),
					           "email"=>               $_POST["EditarEmail"],
					           "telefono"=>            $_POST["EditarTelefono"],
					           "direccion"=>strtoupper($_POST["EditarDireccion"]),
							   "limitecredito"=>	   $_POST["EditarLimitecredito"],
							   "descuento"=>			$_POST["EditarDescuento"],
					           "estado"=>	   		   $_POST["EditarestadoCliente"],
                               "ultusuario" =>         $_POST["idDeUsuario"],
					           "fecha_nacimiento"=>    $_POST["EditarFechaNacimiento"]);

			   	$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);
				
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
					 title: 'El cliente ha sido cambiado correctamente!! '
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
						  text: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
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
	ELIMINAR CLIENTE
	=============================================*/
static public function ctrEliminarCliente(){

		if(isset($_GET["idCliente"])){

			$tabla ="clientes";
			$datos = $_GET["idCliente"];

			$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal.fire({
					  icon: "success",
					  title: "El cliente ha sido borrado correctamente",
					  }).then(function(result){
							if (result) {
								window.location = "clientes";
							}
						})

				</script>';

			}		

		}

	}    
	
static public function ctrReporteEdoCta($idNumCliente, $fechavtaIni, $fechavtaFin){
	$tabla="hist_salidas";
	if($idNumCliente==1){
		$idTipoMov=1;
	}else{
		$idTipoMov=3;
	}
	
	$respuesta=ModeloClientes::MdlReporteEdoCta($tabla, $idNumCliente, $fechavtaIni, $fechavtaFin, $idTipoMov);
	return $respuesta;
}


} //fin de la clase

