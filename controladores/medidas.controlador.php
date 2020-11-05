<?php

class ControladorMedidas{

	/*=============================================
	CREAR UNIDAD DE MEDIDA
	=============================================*/

	static public function ctrCrearMedida(){

		if($_SERVER["REQUEST_METHOD"]=="POST" AND isset($_POST["nuevaMedida"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaMedida"])){

				$tabla = "medidas";

				$datos = strtoupper($_POST["nuevaMedida"]);

				$respuesta = ModeloMedidas::mdlIngresarMedida($tabla, $datos);

				if($respuesta == "ok"){

	                echo '<script>                
                        swal.fire({
						position: "top-end",
                        title: "¡Unidad de medida a sido guardado correctamente!",
						icon: "success",
						timer: 3000
                       }).then(function(result){
                        if(result.value){
                            window.location = "medidas";
                        }
                        });                    
					</script>'; 
					
				}else{
					echo'<script>
		
					swal.fire({
						  title: "error",
						  text: "¡Unidad de medida no se Guardo!\nUnidad Duplicada o con errores.",
						  icon:"warning",
						  timer: 3000,
						  }).then(function(result){
							if (result.value) {
								window.location = "medidas";
							}
						})
				  </script>';
		
				}


			}else{

				echo'<script>

					swal.fire({
						  title: "error",
						  text: "¡Unidad de Med. no puede ir vacía o llevar caracteres especiales!",
						  icon:"error",
						  }).then(function(result){
							if (result) {
                                window.location = "medidas";
							}
						})
			  	</script>';

			}

		}

	}

    
/*=============================================
MOSTRAR UNIDAD DE MEDIDA
============================================*/

	static public function ctrMostrarMedidas($item, $valor){

		$tabla = "medidas";

		$respuesta = ModeloMedidas::mdlMostrarMedidas($tabla, $item, $valor);

		return $respuesta;
	
	}    
    
/*=============================================
	EDITAR UNIDAD DE MEDIDA
=============================================*/

	static public function ctrEditarMedida(){

		if($_SERVER["REQUEST_METHOD"]=="POST" AND isset($_POST["editarMedida"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarMedida"])){

				$tabla = "medidas";

				$datos = array("medida"=>$_POST["editarMedida"],
							   "id"=>$_POST["idMedida"]);

				$respuesta = ModeloMedidas::mdlEditarMedida($tabla, $datos);

				if($respuesta == "ok"){
					
					echo'<script>
					swal.fire({
						  title: "Realizado",
						  text: "La Unidad de Med. ha sido cambiada correctamente",
						  icon: "success",
						  timer: 3000,
						  }).then(function(result){
									if (result) {
									   window.location = "medidas";
									}
								})

					</script>';
				}else{
					echo'<script>
					var varjs="'.$respuesta.'";		//convierte variable PHP a JS
					swal.fire({
						  title: "¡Unidad de medida no se Guardó!",
						  text: "Error: "+varjs,
						  icon:"warning",
						  }).then(function(result){
							if (result) {
								window.location = "medidas";
							}
						})
				  </script>';
				}


			}else{

				echo'<script>

					swal.fire({
						  title: "error",
						  text: "¡La Unidad de Med. no puede ir vacía o llevar caracteres especiales!",
						  icon: "warning",
						  timer: 3000,
						  }).then(function(result){
							if (result) {
								window.location = "medidas";
							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR UNIDAD DE MEDIDA
	=============================================*/

	 static public function ctrBorrarMedida(){

		if($_SERVER["REQUEST_METHOD"]=="GET" AND isset($_GET["idMedida"])){

			$tabla ="medidas";
			$datos = $_GET["idMedida"];

			$respuesta = ModeloMedidas::mdlBorrarMedida($tabla, $datos);

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
				 title: 'Unidad de Medida ha sido borrada. Espere!! '
			   })
					setTimeout(function(){
					 window.location = 'medidas';
				 }, 2000);                
				   
			   </script>"; 

			}else{
				echo'<script>

					swal.fire({
						  title: "error",
						  text: "¡No se puedo eliminar U de med.!",
						  icon: "warning",
						  }).then(function(result){
							if (result.value) {
								window.location = "medidas";
							}
						})

			  	</script>';

			}
		}
		
	}    
    
    
}   //fin de la clase