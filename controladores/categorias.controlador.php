<?php

class ControladorCategorias{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	public function ctrCrearCategoria(){

		if(isset($_POST["nuevaCategoria"])){

			if(preg_match('/^[\`\'\"\#\.\,\-\/a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaCategoria"])){

				$tabla = "categorias";

				$datos = strtoupper($_POST["nuevaCategoria"]);
                
                $datos = array("categoria" => $_POST["nuevaCategoria"],
                               "ultusuario"=>$_POST["idDeUsuario"],
							   "id_familia" => $_POST["nuevaFamilia"]);                

				$respuesta = ModeloCategorias::mdlIngresarCategoria($tabla, $datos);

				if($respuesta == "ok"){

	                echo '<script>                
                        swal.fire({
						position: "top-end",
                        title: "¡La categoría a sido guardado correctamente!",
						icon: "success",
						timer: 2000
                       }).then(function(result){
                        if(result.value){
                            window.location = "categorias";
                        }else{
							window.location = "categorias";
                        }
                        });                    
                    </script>'; 
				}else{

					echo'<script>
						var varjs="'.$respuesta.'";		//convierte variable PHP a JS
						swal.fire({
							  title: "¡La categoría no se Guardó!",
							  text: "Error: "+varjs,
							  icon:"error",
							  }).then(function(result){
								if (result) {
									window.location = "categorias";
								}
							})
					  </script>';
	
				}

			}else{

				echo'<script>

					swal.fire({
						  title: "error",
						  text: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  icon:"error",
						  timer:3000
						  }).then(function(result){
							if (result) {
                                window.location = "categorias";
							}
						})
			  	</script>';

			}

        }

	}

    
/*=============================================
MOSTRAR CATEGORIAS
============================================*/

	static public function ctrMostrarCategorias($item, $valor){

		$tabla = "categorias";

		$respuesta = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor);

		return $respuesta;
	
	}    
    
/*=============================================
	EDITAR CATEGORIA
=============================================*/

	public function ctrEditarCategoria(){

		if(isset($_POST["editarCategoria"])){

			if(preg_match('/^[\`\'\"\#\.\,\-\/a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCategoria"])){

				$tabla = "categorias";

				$datos = array("categoria"=>strtoupper($_POST["editarCategoria"]),
						"id_familia"=>$_POST["editFamilia"],
						"ultusuario"=>$_POST["idDeUsuario"],
						"id"=>$_POST["idCategoria"]);

				$respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);

				if($respuesta == "ok"){

/*  					echo "<script>
					Swal.fire({
					 title: 'Error!',
					 text: 'Do you want to continue',
					 icon: 'error',
					 confirmButtonText: 'Cool'
					}).then(function(result){
                        if(result){
                            window.location = 'categorias';
                        }
				   });
				   </script>"; */

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
					title: 'La categoría esta sido cambiada. Espere!! '
				  })
				   	setTimeout(function(){
						window.location = 'categorias';
					}, 2000);                
				  	
				  </script>"; 

				}else{

					echo'<script>
						var varjs="'.$respuesta.'";		//convierte variable PHP a JS
						swal.fire({
							  title: "¡La categoría no se Guardó!",
							  text: "Error: "+varjs,
							  icon:"error",
							  }).then(function(result){
								if (result.value) {
									window.location = "categorias";
								}
							})
					  </script>';
	
				}

			}else{

				echo'<script>

					swal.fire({
						  title: "error",
						  text: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  icon: "warning",
						  }).then(function(result){
							if (result.value) {
								window.location = "categorias";
							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	 public function ctrBorrarCategoria(){

		if(isset($_GET["idCategoria"])){

			$tabla ="Categorias";
			$datos = $_GET["idCategoria"];

			$respuesta = ModeloCategorias::mdlBorrarCategoria($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal.fire({
						  title: "Realizado!",
						  text: "La categoría ha sido borrada correctamente",
						  icon: "success",
						  timer: 3000
						  }).then(function(result){
								if (result.value) {
									window.location = "categorias";
								}
							})

					</script>';
			}else{
				echo'<script>

					swal.fire({
						  title: "error",
						  text: "¡No se puedo eliminar categoria",
						  icon: "warning",
						  }).then(function(result){
							if (result.value) {
								window.location = "categorias";
							}
						})

			  	</script>';

			} 
		}
		
	}    
    
    
}   //fin de la clase