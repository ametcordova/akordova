<?php
session_start();
require_once "../controladores/control-presupuesto.controlador.php";
require_once "../modelos/control-presupuesto.modelo.php";

switch ($_GET["op"]){
	
	case 'guardarIngreso':
        if(isset($_POST["importeIngreso"])){
            $tabla="ingresos";

            $datos = array(
                "fecha_ingreso"         =>$_POST["fechaIngreso"],
                "concepto_ingreso"      =>strtoupper($_POST["conceptoIngreso"]),
                "descripcion_ingreso"   =>strtoupper($_POST["descripcionIngreso"]),
                "importe_ingreso"       =>$_POST["importeIngreso"],
                "id_caja"               =>$_POST["idcaja"],
                "ultusuario"            =>$_POST["idDeUsuario"],
                );

            $respuesta = ControladorPresupuesto::ctrIngreso($tabla, $datos);

            echo json_encode($respuesta);

        };
 	break;

     case 'guardarEgreso':
     if(isset($_POST["importeEgreso"])){
         $tabla="egresos";

         $datos = array(
             "fecha_egreso"         =>$_POST["fechaEgreso"],
             "concepto_egreso"      =>strtoupper($_POST["conceptoEgreso"]),
             "descripcion_egreso"   =>strtoupper($_POST["descripcionEgreso"]),
             "importe_egreso"       =>$_POST["importeEgreso"],
             "id_caja"              =>$_POST["idcaja"],
             "ultusuario"           =>$_POST["idDeUsuario"],
             );

         $respuesta = ControladorPresupuesto::ctrEgreso($tabla, $datos);

         echo json_encode($respuesta);

     };
     break;
  
  	case 'obtenerRegistros':
        if(isset($_GET["tabla"])){
            $tabla = $_GET["tabla"];
            $item = null;
            $valor = $_GET["fechalistar"];

            $respuesta = ControladorPresupuesto::ctrMostrarReg($tabla, $item, $valor);

			if($respuesta===null){
                $mirsp = array(null);
				echo json_encode(null);
			}else{
				echo json_encode($respuesta);
			}
        };
 	break;

     case 'modificarIngreso':
     if(isset($_POST["edit_id"])){
         $tabla = "ingresos";
         
         $datos = array(
            "id"                    =>$_POST["edit_id"], 
            "concepto_ingreso"      =>strtoupper($_POST["editconceptoIngreso"]),
            "descripcion_ingreso"   =>strtoupper($_POST["editdescripcionIngreso"]),
            "importe_ingreso"       =>$_POST["editimporteIngreso"],
            "id_caja"               =>$_POST["idcaja"],
            "ultusuario"            =>$_POST["idDeUsuario"],
            );

             $rspta = ControladorPresupuesto::ctrModificar($tabla, $datos);

             echo $rspta ? true : "Registro no se pudo actualizar";

     }
     break;

     case 'modificarEgreso':
        if(isset($_POST["editid"])){
            $tabla = "egresos";
            
            $datos = array(
               "id"                    =>$_POST["editid"], 
               "concepto_egreso"       =>strtoupper($_POST["editconceptoEgreso"]),
               "descripcion_egreso"    =>strtoupper($_POST["editdescripcionEgreso"]),
               "importe_egreso"        =>$_POST["editimporteEgreso"],
               "id_caja"               =>$_POST["idcaja"],
               "ultusuario"            =>$_POST["idDeUsuario"],
               );
   
                $rspta = ControladorPresupuesto::ctrModificar($tabla, $datos);
   
                echo $rspta ? true : "Registro no se pudo actualizar";
   
        }
     break;


     case 'eliminar':
     if(isset($_POST["id"])){
         $item = "id";
         $valor = $_POST["id"];
         $tabla = $_POST["tabla"];

         $respuesta = ControladorPresupuesto::ctrEliminar($tabla, $item, $valor);

         echo json_encode($respuesta);

     };
     break;

}  //FIN DE SWITCH  
