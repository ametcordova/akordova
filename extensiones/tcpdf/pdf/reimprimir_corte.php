<?php
session_start();

require_once "../../../controladores/cajas.controlador.php";
require_once "../../../modelos/cajas.modelo.php";
//include "../../../config/parametros.php";

require __DIR__ . '/autoload.php'; 
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class reimprimirCorte{

public function traerReimpresionCorte(){

$operador=$_SESSION['nombre'];    
//TRAEMOS LA INFORMACIÓN 
$tabla="hist_salidas";
$campo = "id_corte";
$valor = $_POST["idcorte"];
$fechaventa = $_POST["fechaventa"];
$credito = $_POST["creditocut"];
$egresov = $_POST["egresocut"];
$ingresov = $_POST["ingresocut"];
$cajachica = $_POST["cajachica"];

//TRAER LOS DATOS DEL ALMACEN SELECCIONADO
$respuestaCortex = ControladorCajas::ctrReporteCortex($tabla, $campo, $valor, $fechaventa);

   if($respuestaCortex){
    $fechadecorte=$respuestaCortex[0]['ultmodificacion'];
    $cajadecorte=$respuestaCortex[0]['id_caja'];
    //$impresora = "EC-PM-5890X";		//HERNAN
    //impresora = "XP-58";	
    $impresora=defined('IMPRESORA')?IMPRESORA:'';

    $conector = new WindowsPrintConnector($impresora);
    $printer = new Printer($conector);
        
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> setTextSize(1, 2);
    $printer -> setEmphasis(true);  
        
    $printer -> text(RAZON_SOCIAL."\n");//Nombre de la empresa
        
    $printer -> setEmphasis(false);
    $printer -> setTextSize(1, 1);
        
    $printer -> text(DIRECCION."\n");//Dirección de la empresa
    $printer -> text(TELEFONO."\n");//tel de la empresa

    $printer->text('Fecha:'.$fechadecorte. "\n");

    //$printer->text('Operador: '.$operador. "\n");

    $printer -> feed(1); //Alimentamos el papel 1 vez*/

    $printer -> text("Corte de Venta #$valor Caja$cajadecorte"."\n");
    //$printer -> text("Almacén: ".$tabla."\n");

    $printer->text("--------------------------------\n");
    $printer->text("PRODUCTO   CANT  PRECIO  IMPORTE");//Nombre del producto    
    $printer->text("--------------------------------\n");
        
    $cantExist=$totalCorte=$sumtotalEnv=$servicio=$abarrotes=0;
    foreach ($respuestaCortex as $row) {    
        
        if($row["es_promo"]==0){
            $sumtotal=$row["sinpromo"]; 
            $descripcion=trim(substr($row["descripcion"],0,38));
        }else{
            $sumtotal=$row["promo"];   
            $descripcion=trim(substr($row["descripcion"],0,38)."*");
        }

        if($row["totaliza"]==0){
            $sumtotalEnv+=$sumtotal; 
        }

        if($row["totaliza"]==2){
            $servicio+=$sumtotal; 
        }

        if($row["totaliza"]==3){
            $abarrotes+=$sumtotal; 
        }

        $printer -> setPrintLeftMargin(0);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        //$printer -> setPrintWidth(390);
        $printer->text($descripcion."\n");   //Nombre del producto
        //$printer -> setPrintWidth(50);
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text(" - ".$row["cant"]);                                 //cant del producto
        $printer->text(" x ".$row["precio_venta"]);                         //importe del producto
        $printer->text(" = $".number_format($sumtotal,2,'.',',')."\n"); //importe total de venta
                              
        $cantExist+=$row["cant"];
        $totalCorte+=$sumtotal;
    }
    
    $printer -> setPrintLeftMargin(0);
    $printer->text("--------------------------------\n");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    
    //$printer->text("Prod: -".$cantExist."- Venta $".number_format($totalCorte-$sumtotalEnv,2,'.',',')."\n");
    $printer->text("Prod: -".$cantExist."- Venta $".number_format($totalCorte,2,'.',',')."\n");
    $printer->text("Envases: $".number_format($sumtotalEnv,2,'.',',')."\n");
    $printer->text("Servicios:$".number_format($servicio,2,'.',',')."\n");
    $printer->text("Abarrotes:$".number_format($abarrotes,2,'.',',')."\n");
    $printer->text("- A crédito:$".number_format($credito,2,'.',',')."\n");
    if($ingresov>0){
        $printer->text("+ Ingreso:  $".number_format($ingresov,2,'.',',')."\n");
    }
    if($egresov>0){
        $printer->text("- Egreso:   $".number_format($egresov,2,'.',',')."\n");
    }
    
    $printer->text("Total Efectivo: $".number_format(($totalCorte+$ingresov)-($egresov+$credito),2,'.',',')."\n");
    $printer->text("Caja Chica:$".number_format($cajachica,2,'.',',')."\n");
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> setPrintLeftMargin(0);
    $printer->text("--------------------------------\n");
    $printer->text("Si los datos no coinciden, verique cancelaciones, modificaciones a ingreso y egresos. \n");

    $printer -> feed(3); 
    $printer -> cut(); 
    $printer -> close();
        
    //$printer->text("12345678901234567890123456789012\n");    
    echo "ok";
   }else{
   // echo json_encode($_POST['idcorte']);
    echo json_encode($respuestaCortex);
   }
}

}   //FIN DE LA CLASE

$corte = new reimprimirCorte();
$corte -> traerReimpresionCorte();

?>

