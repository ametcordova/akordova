<?php
require_once "../../../controladores/salidas.controlador.php";
require_once "../../../modelos/salidas.modelo.php";
include "../../../config/parametros.php";

require __DIR__ . '/autoload.php'; 
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class imprimirTicket{

public $codigo;

public function traerImpresionTicket(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemSalida = "num_salida";
$numdeSalida = $_GET["codigo"];

//salidas.controlador.php
$respuestaAlmacen = ControladorSalidas::ctrSalidaAlm($itemSalida, $numdeSalida);

$nomCliente=$respuestaAlmacen[0]["nombrecliente"];
$usuario=$respuestaAlmacen[0]["nombreusuario"];
$fechaSalida=date("d-m-Y H:i:s", strtotime($respuestaAlmacen[0]["ultmodificacion"]));

    if($respuestaAlmacen){

	//$impresora = "EC-PM-5890X";		//HERNAN
    //$impresora = "XP-58";
    //$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
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
    $printer -> text("RFC:".RFC." TEL:".TELEFONO."\n");//tel de la empresa

    $printer -> text("F.Venta:".$fechaSalida."\n");//Fecha de venta

    $printer -> text("Ticket #".$numdeSalida."\n");//Número de ticket

    $printer -> feed(1); //Alimentamos el papel 1 vez*/

    $printer -> text("Cliente: ".$nomCliente."\n");//Nombre del cliente

    $printer -> text("Vendedor: ".$usuario."\n");//Nombre del vendedor
    $printer->text("-------------------------------\n");

$cantSalida=$granTotal=$sumtotal=0;
foreach ($respuestaAlmacen as $row) {
    
    //$sumatotal=number_format($row["cantidad"]*$row["precio_venta"],2);
    if($row["es_promo"]==0){
        $sumtotal=($row["cantidad"]*$row["precio_venta"]); 
        $descripcion=trim(substr($row["descripcion"],0,36));
    }else{
        $sumtotal=$row["precio_venta"];   
        $descripcion=trim(substr($row["descripcion"],0,36)."*");
    }
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text($descripcion."\n");       //Nombre del producto
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text($row["cantidad"]." x $".$row["precio_venta"]." = $".number_format($sumtotal,2)."\n");
    if(strlen($row["leyenda"])>0){
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer -> setEmphasis(true);
        $printer->text($row["leyenda"]."\n");
        $printer -> setEmphasis(false);
    }
    $granTotal+=$sumtotal;
}
        
    //$printer -> feed(1); //Alimentamos el papel 1 vez	
    //$printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"],2)."\n"); //ahora va el neto
    //$printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"],2)."\n"); //ahora va el impuesto
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text("---------\n");
    $printer->text("TOTAL: $ ".number_format($granTotal,2)."\n");
        
    $printer -> feed(1); 
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer->text(FOOTER."\n"); //Podemos poner también un pie de página

    $printer -> feed(1); //Alimentamos el papel 3 veces
    $printer->text(LEYENDA."\n"); 
    $printer -> feed(3); 
    $printer -> cut(); 
    $printer -> close();

    }
  }
}
    
$ticket = new imprimirTicket();
$ticket -> codigo = $_GET["codigo"];
$ticket -> traerImpresionTicket();
?>    

<?php
function acortar($cadena, $limite, $corte=" ", $pad="...") {
    if(strlen($cadena) <= $limite)
        return $cadena;
    if(false !== ($breakpoint = strpos($cadena, $corte, $limite))) {
        if($breakpoint < strlen($cadena) - 1) {
            $cadena = substr($cadena, 0, $breakpoint) . $pad;
        }
    }
    return $cadena;
}
?>
<script>
    window.close();
</script>