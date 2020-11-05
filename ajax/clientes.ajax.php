<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

switch ($_GET["op"]){

	case 'guardarAbono':
		require_once "../controladores/control-presupuesto.controlador.php";
		require_once "../modelos/control-presupuesto.modelo.php";
		
        if(isset($_POST["importeAbono"])){
            $tabla="ingresos";

            $datos = array(
                "fecha_ingreso"         =>$_POST["fechaAbono"],
                "concepto_ingreso"      =>strtoupper($_POST["conceptoAbono"]),
                "descripcion_ingreso"   =>strtoupper($_POST["descripcionAbono"]),
                "importe_ingreso"       =>$_POST["importeAbono"],
                "id_caja"       		=>$_POST["idcajaAbono"],
                "ultusuario"            =>$_POST["idDeUsuario"],
                );

			$respuesta = ControladorPresupuesto::ctrIngreso($tabla, $datos);
			
			//if($respuesta){
				$tabla="clientes";
				$datos = array(
					"id"       	  =>$_POST["idClienteAbo"],
					"saldo"       =>$_POST["importeAbono"],
					"ultusuario"  =>$_POST["idDeUsuario"],
					);
	
				$respuesta1 = ControladorClientes::ctrAbonoCliente($tabla, $datos);
			//}

			$tabla="abonoscliente";
			$datos = array(
				"id_cliente"  		=>$_POST["idClienteAbo"],
				"fecha_abono" 		=>$_POST["fechaAbono"],
				"abono"       		=>$_POST["importeAbono"],
				"concepto_abono"	=>strtoupper($_POST["conceptoAbono"])
				);

			$respuesta2 = ControladorClientes::ctrAbonoEdoCta($tabla, $datos);

            echo json_encode($respuesta2);

        };
 	break;
	
	case 'mostrarClie':
        if(isset($_POST["idCliente"])){
			$item = "id";
			$valor = $_POST["idCliente"];

			$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);

			echo json_encode($respuesta);

        };
 	break;
	
}