<script>
var cerrar=true;
</script>
<?php
ob_clean();
require_once "../../../controladores/salidas.controlador.php";
require_once "../../../modelos/salidas.modelo.php";
//include "../../../config/parametros.php";

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
$entregaen=$respuestaAlmacen[0]["id_tipovta"]==0?"Entrega en: Mostrador":"Entrega a: Domicilio";
$fechaSalida=date("d-m-Y H:i:s", strtotime($respuestaAlmacen[0]["ultmodificacion"]));

    if($respuestaAlmacen){

        $respuestacobro = ControladorSalidas::ctrCobroVenta($numdeSalida);
        if($respuestacobro){
            $pagocon=$respuestacobro['pago'];
        }else{
            $pagocon=0;
        }
    

	//$impresora = "EC-PM-5890X";		//HERNAN
    //$impresora = "XP-58";
    //$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
    $impresora=defined('IMPRESORA')?IMPRESORA:'';

    $conector = new WindowsPrintConnector($impresora);
    $printer = new Printer($conector);

        
    $printer -> setJustification(Printer::JUSTIFY_CENTER);

    try{
        $logo = EscposImage::load("../../../config/logoticket.png", false);
        //$printer->bitImage($log);
        //$printer -> feed(1); //Alimentamos el papel 1 vez*/

        $printer -> bitImage($logo, Printer::IMG_DOUBLE_WIDTH);
        //$printer -> text("Wide Tux (bit image).\n");
        $printer -> feed();
        
        //$printer -> bitImage($logo, Printer::IMG_DOUBLE_HEIGHT);
        //$printer -> text("Tall Tux (bit image).\n");
        //$printer -> feed();
        
        //$printer -> bitImage($logo, Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT);
        //$printer -> text("Large Tux in correct proportion (bit image).\n");        
    }catch(Exception $e){/*No hacemos nada si hay error*/}

    $printer -> setTextSize(1, 2);
    $printer -> setEmphasis(true);  
        
    $printer -> text(RAZON_SOCIAL."\n");//Nombre de la empresa
        
    $printer -> setEmphasis(false);
    $printer -> setTextSize(1, 1);
        
    $printer -> text(DIRECCION."\n");//Dirección de la empresa
    $printer -> text("RFC:".RFC."\n");//tel de la empresa
    $printer -> text("TEL:".TELEFONO."\n");//tel de la empresa
    if(SLOGAN!=""){
        $printer -> text(SLOGAN."\n");	//
    }
    $printer -> text("F.Venta:".$fechaSalida."\n");//Fecha de venta

    $printer -> text("Ticket #".$numdeSalida."\n");//Número de ticket

    $printer -> feed(1); //Alimentamos el papel 1 vez*/

    $printer -> text("Cliente: ".$nomCliente."\n");//Nombre del cliente

    $printer -> text("Atendio: ".$usuario."\n");//Nombre del vendedor
    $printer->text("-------------------------------\n");

$cantSalida=$granTotal=$sumtotal=0;
$nombre_tipo=$respuestaAlmacen[0]["nombre_tipo"];
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
    $cambiode=$pagocon<>0?($pagocon-$granTotal):0;
    //$printer -> feed(1); //Alimentamos el papel 1 vez	
    //$printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"],2)."\n"); //ahora va el neto
    //$printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"],2)."\n"); //ahora va el impuesto
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text("---------\n");
    $printer->text("TOTAL: $ ".number_format($granTotal,2)."\n");
    $printer->text(" PAGO: $ ".number_format($pagocon,2)." = CAMBIO: $".number_format($cambiode,2)."\n");
    //$printer->text(" PAGO: $ ".number_format($pagocon,2)."\n");
    //$printer->text("CAMBIO:$ ".number_format($cambiode,2)."\n");

    
        
    $printer -> feed(1); 
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer->text(FOOTER."\n"); //Podemos poner también un pie de página

    $printer -> feed(1); //Alimentamos el papel 1 veces
    $printer->text(LEYENDA."\n"); 
    $printer -> feed(1); //Alimentamos el papel 1 veces
    $printer->text($nombre_tipo); 
    $printer -> feed(1); //Alimentamos el papel 1 veces
    $printer->text($entregaen."\n"); 
    //$printer -> feed(2); //Alimentamos el papel 1 veces
    //$printer->text($dir."\n"); 
    //$printer -> feed(2);   //habilitar
    $printer -> cut(); 
    try{
        $printer -> close();
    }catch(Exception $e){
        echo "</br>";
        ?>
         <script>
           cerrar=false;
           document.write('¡ERROR DE IMPRESORA!');
         </script>
        <?php
        /*si hay error*/
        echo "</br>";
        echo "Revise si esta encendida su impresora.\n Cierre esta ventana e intente nuevamente.";
        echo "</br>";
        echo "Si continua el error llame a soporte técnico. 961-248-0768";

    }	

    //$printer -> close();

    }
  }
}
    
$ticket = new imprimirTicket();
$ticket -> codigo = $_GET["codigo"];
$ticket -> traerImpresionTicket();
?>
  <script>
   //if(cerrar){
    window.close(); 
   //}
</script>

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
