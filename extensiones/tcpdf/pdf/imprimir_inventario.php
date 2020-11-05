<?php

require_once "../../../controladores/reporteinventario.controlador.php";
require_once "../../../modelos/reporteinventario.modelo.php";
//include "../../../config/parametros.php";

require __DIR__ . '/autoload.php'; 
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class imprimirInventario{

public function traerImpresionInventario(){

//TRAEMOS LA INFORMACIÓN 
$tabla=$_GET["idNomAlma"];
$campoFam = "id_familia";
$claveFam = $_GET["idNumFam"];

//TRAER LOS DATOS DEL ALMACEN SELECCIONADO
$respuestaInventario = ControladorInventario::ctrReporteInventario($tabla, $campoFam, $claveFam);

    if($respuestaInventario){
    //$impresora = "EC-PM-5890X";		//HERNAN
    //$impresora = "XP-58";	
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

    $printer->text(date("d-m-Y H:i:s") . "\n");

    $printer -> feed(1); //Alimentamos el papel 1 vez*/

    $printer -> text("Exist. de Inventario Valorizados"."\n");
    $printer -> text("Almacén: ".$tabla."\n");

    $printer->text("--------------------------------\n");
    $printer->text("PRODUCTO   CANT  PRECIO  IMPORTE");//Nombre del producto    
    $printer->text("--------------------------------\n");
        
    $cantExist=$totExiste=$importeExist=0;
    foreach ($respuestaInventario as $row) {    
        $totExiste=$row["precio_venta"]*$row["cant"];
        $printer -> setPrintLeftMargin(0);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        //$printer -> setPrintWidth(390);
        $printer->text(trim(substr($row["descripcion"],0,38))."\n");   //Nombre del producto
        //$printer -> setPrintWidth(50);
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text(" - ".$row["cant"]);            //cant del producto
        $printer->text(" x ".$row["precio_venta"]);            //cant del producto
        $printer->text(" = $".number_format($totExiste,2,'.',',')."\n");            //cant del producto
                              
        $cantExist+=$row["cant"];
        $importeExist+=$totExiste;
    }
    
    $printer -> setPrintLeftMargin(0);
    $printer->text("--------------------------------\n");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text("Exist. -".$cantExist."- Total $".number_format($importeExist,2,'.',',')."\n");
            
    $printer -> feed(3); 
    $printer -> cut(); 
    $printer -> close();
        
    //$printer->text("12345678901234567890123456789012\n");    
    }
}

}   //FIN DE LA CLASE

$inventario = new imprimirInventario();
$inventario -> nameAlma = $_GET["idNomAlma"];
$inventario -> nameFami = $_GET["idNumFam"];
$inventario -> traerImpresionInventario();

?>

<script>
    window.close();
</script>
