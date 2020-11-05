<?php
date_default_timezone_set("America/Mexico_City");

require_once "../controladores/permisos.controlador.php";
require_once "../modelos/permisos.modelo.php";

switch ($_GET["op"]){

	case 'guardarPermisoAdmin':
	
		if(isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"]) ){

				$campo="administracion";

				$usuario=intval($_POST["idUsuario"]);

                $permisos=json_decode($_POST['miArray']);
				
				$tabla = "usuarios";

				if( !empty($permisos) && is_array($permisos) ){

					//TAMBIEN FUNCIONA
					//$datajson = array(); //creamos un array para el JSON
					//$datosjson[]=array("id" => $clave,"valor"=> $valor);

					$accesos=0;
					$data=array();
					$opcion="sinopcion";
					
				 	foreach ($permisos as $clave=>$valor){
						$value=$valor[0];

						if($value=="ventas"){
							$opcion="ventas";
							$accesos=256;

						}else if($value=="compras"){
							$data+=[$opcion => $accesos];
							$opcion="compras";
							$accesos=256;

						}else if($value=="adminventas"){
							$data+=[$opcion => $accesos];
							$opcion="adminventas";
							$accesos=256;

						}else if($value=="controlefectivo"){
							$data+=[$opcion => $accesos];
							$opcion="controlefectivo";
							$accesos=256;

						}else if($value=="ajusteinv"){
							$data+=[$opcion => $accesos];
							$opcion="ajusteinv";
							$accesos=256;

						}else if($value=="respaldo"){
							$data+=[$opcion => $accesos];
							$opcion="respaldo";
							$accesos=256;

						}

						$accesos=valordeacceso($value, $accesos);

					};	//fin del foreach


					$data+=[$opcion => $accesos];
					$datajson=json_encode($data);
			
					$rspta = ControladorPermisos::ctrGuardarPermisos($tabla, $datajson, $usuario, $campo);
					//$rspta=true;
					if($rspta){
						$rspta=array('usuario' => $permisos,'data:'=>$datajson );
						echo json_encode($rspta);
					}else{
						$rspta=array('error' => $_POST["idUsuario"],'tabla:'=>$tabla);
						echo json_encode($rspta);
					}					

				}else{
					$rspta = ControladorPermisos::ctrGuardarPermisos($tabla, $datajson=null, $usuario, $campo);
					$datajson = array('array vacio' => "error");		
					echo json_encode($datajson);
				}
				
            
		}else{
            $arr = array('error' => $_POST["idUsuario"]);
			echo json_encode($arr);

        };
			
	break;

	case 'guardarPermisoCata':
	
		if(isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"]) ){

				$campo="catalogo";

				$usuario=intval($_POST["idUsuario"]);

                $permisos=json_decode($_POST['miArray']);
				
				$tabla = "usuarios";
				

				if( !empty($permisos) && is_array($permisos) ){

					$accesos=0;
					$data=array();
					$opcion="sinopcion";
				 	foreach ($permisos as $clave=>$valor){
						$value=$valor[0];

						if($value=="productos"){
							$opcion="productos";
							$accesos=256;

						 }else if($value=="categorias"){
							$data+=[$opcion => $accesos];
							$opcion="categorias";
							$accesos=256;

						}else if($value=="familias"){
							$data+=[$opcion => $accesos];
							$opcion="familias";
							$accesos=256;

						}else if($value=="medidas"){
							$data+=[$opcion => $accesos];
							$opcion="medidas";
							$accesos=256;

						}else if($value=="proveedores"){
							$data+=[$opcion => $accesos];
							$opcion="proveedores";
							$accesos=256;
						
						}else if($value=="clientes"){
							$data+=[$opcion => $accesos];
							$opcion="clientes";
							$accesos=256;
						 
						}else if($value=="almacenes"){
							$data+=[$opcion => $accesos];
							$opcion="almacenes";
							$accesos=256;

						}else if($value=="cajaventas"){
							$data+=[$opcion => $accesos];
							$opcion="cajaventas";
							$accesos=256;

						}else if($value=="tiposmov"){
							$data+=[$opcion => $accesos];
							$opcion="tiposmov";
							$accesos=256;

						}

						$accesos=valordeacceso($value, $accesos);
			
					};	


					$data+=[$opcion => $accesos];
					$datajson=json_encode($data);
			
					$rspta = ControladorPermisos::ctrGuardarPermisos($tabla, $datajson, $usuario, $campo);

					if($rspta){
						$rspta=array('usuario' => $permisos,'data:'=>$datajson );
						echo json_encode($rspta);
					}else{
						$rspta=array('error' => $_POST["idUsuario"],'tabla:'=>$tabla);
						echo json_encode($rspta);
					}					

				}else{
					$rspta = ControladorPermisos::ctrGuardarPermisos($tabla, $datajson=null, $usuario, $campo);
					$datajson = array('array vacio' => "error");		
					echo json_encode($datajson);
				}
				
            
		}else{
            $arr = array('error' => $_POST["idUsuario"]);
			echo json_encode($arr);

        };
			
	break;

	case 'guardarPermisoRep':
	
		if(isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"]) ){

				$campo="reportes";

				$usuario=intval($_POST["idUsuario"]);

                $permisos=json_decode($_POST['miArray']);
				
				$tabla = "usuarios";
				

				if( !empty($permisos) && is_array($permisos) ){

					$accesos=0;
					$data=array();
					$opcion="sinopcion";
				 	foreach ($permisos as $clave=>$valor){
						$value=$valor[0];

						if($value=="rvtas"){
							$opcion="rvtas";
							$accesos=256;

						 }else if($value=="rcompras"){
							$data+=[$opcion => $accesos];
							$opcion="rcompras";
							$accesos=256;

						}else if($value=="rinv"){
							$data+=[$opcion => $accesos];
							$opcion="rinv";
							$accesos=256;

						}else if($value=="rcortes"){
							$data+=[$opcion => $accesos];
							$opcion="rcortes";
							$accesos=256;

						}else if($value=="rkardex"){
							$data+=[$opcion => $accesos];
							$opcion="rkardex";
							$accesos=256;
						
						}else if($value=="rsugerido"){
							$data+=[$opcion => $accesos];
							$opcion="rsugerido";
							$accesos=256;
						 
						}else if($value=="rcancela"){
							$data+=[$opcion => $accesos];
							$opcion="rcancela";
							$accesos=256;

						}

						$accesos=valordeacceso($value, $accesos);
			
					};	

					$data+=[$opcion => $accesos];
					$datajson=json_encode($data);
			
					$rspta = ControladorPermisos::ctrGuardarPermisos($tabla, $datajson, $usuario, $campo);

					if($rspta){
						$rspta=array('usuario' => $permisos,'data:'=>$datajson );
						echo json_encode($rspta);
					}else{
						$rspta=array('error' => $_POST["idUsuario"],'tabla:'=>$tabla);
						echo json_encode($rspta);
					}					

				}else{
					$rspta = ControladorPermisos::ctrGuardarPermisos($tabla, $datajson=null, $usuario, $campo);
					$datajson = array('array vacio' => "error");		
					echo json_encode($datajson);
				}
				
            
		}else{
            $arr = array('error' => $_POST["idUsuario"]);
			echo json_encode($arr);

        };
			
	break;	

	case 'guardarPermisoConfig':
	
		if(isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"]) ){

				$campo="configura";

				$usuario=intval($_POST["idUsuario"]);

                $permisos=json_decode($_POST['miArray']);
				
				$tabla = "usuarios";
				

				if( !empty($permisos) && is_array($permisos) ){

					$accesos=0;
					$data=array();
					$opcion="sinopcion";
				 	foreach ($permisos as $clave=>$valor){
						$value=$valor[0];

						if($value=="usuarios"){
							$opcion="usuarios";
							$accesos=256;

						 }else if($value=="permisos"){
							$data+=[$opcion => $accesos];
							$opcion="permisos";
							$accesos=256;

						}else if($value=="empresa"){
							$data+=[$opcion => $accesos];
							$opcion="empresa";
							$accesos=256;

						}

						$accesos=valordeacceso($value, $accesos);
			
					};	

					$data+=[$opcion => $accesos];
					$datajson=json_encode($data);
			
					$rspta = ControladorPermisos::ctrGuardarPermisos($tabla, $datajson, $usuario, $campo);

					if($rspta){
						$rspta=array('usuario' => $permisos,'data:'=>$datajson );
						echo json_encode($rspta);
					}else{
						$rspta=array('error' => $_POST["idUsuario"],'tabla:'=>$tabla);
						echo json_encode($rspta);
					}					

				}else{
					$rspta = ControladorPermisos::ctrGuardarPermisos($tabla, $datajson=null, $usuario, $campo);
					$datajson = array('array vacio' => "error");		
					echo json_encode($datajson);
				}
				
            
		}else{
            $arr = array('error' => $_POST["idUsuario"]);
			echo json_encode($arr);

        };
			
	break;		

	case 'getPermisos':
		if(isset($_GET["user"]) && !empty($_GET["user"]) ){
			$modulo=$_GET["modulo"];
			$usuario = htmlspecialchars($_GET["user"]);
			$tabla = "usuarios";
			$rspta = ControladorPermisos::ctrGetPermisos($tabla, $usuario, $modulo);

			//$arr = array('datos' => $rspta);

			echo json_encode($rspta);

		}else{

            $arr = array('sin dato' => $_GET["user"]);
			echo json_encode($arr);
		}
    break;

	// case 'getPermisosCat':
	// 	if(isset($_GET["user"]) && !empty($_GET["user"]) ){

	// 		$usuario = htmlspecialchars($_GET["user"]);
	// 		$tabla = "usuarios";
	// 		$rspta = ControladorPermisos::ctrGetPermisosCat($tabla, $usuario);

	// 		//$arr = array('datos' => $rspta);

	// 		echo json_encode($rspta);

	// 	}else{

    //         $arr = array('sin dato' => $_GET["user"]);
	// 		echo json_encode($arr);
	// 	}
    // break;


}  //FIN DE SWITCH  

function valordeacceso($value, $access){
	$addpermiso=substr($value, 0, 3);  		 
	$access += ($addpermiso == "vie" ? 1 :  	//visualizar
	($addpermiso == "adi" ? 2 :				//edicionar/agregar
	($addpermiso == "edi" ? 4 :				//editar
	($addpermiso == "del" ? 8 :  				//borrar
	($addpermiso == "pri" ? 16 :				//imprimir/reporte
	($addpermiso == "act" ? 32 :				//activar
	($addpermiso == "sel" ? 64 :				//seleccionar
	($addpermiso == "pay" ? 128 :				//abonar/pagar
	($addpermiso == "acc" ? 256 :				//accesar
	($addpermiso == "roo" ? 512 : 0))))))))));	//libre?
	return $access;
}


/*
						$addpermiso=substr($valor[0], 0, 3);  		 
						$accesos += ($addpermiso == "vie" ? 1 :  	//visualizar
						($addpermiso == "adi" ? 2 :				//edicionar/agregar
						($addpermiso == "edi" ? 4 :				//editar
						($addpermiso == "del" ? 8 :  				//borrar
						($addpermiso == "pri" ? 16 :				//imprimir/reporte
						($addpermiso == "act" ? 32 :				//activar
						($addpermiso == "sel" ? 64 :				//seleccionar
						($addpermiso == "pay" ? 128 :				//abonar/pagar
						($addpermiso == "acc" ? 256 :				//accesar
						($addpermiso == "roo" ? 512 : 0))))))))));	//libre?

*/