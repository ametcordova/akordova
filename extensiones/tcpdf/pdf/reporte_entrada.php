<?php
ob_clean();
require_once "../../../controladores/almacen.controlador.php";
require_once "../../../modelos/almacen.modelo.php";
//include "../../../config/parametros.php";


// 540 max de la fila P y 745 L

class imprimirRepEntrada{

//public $nameAlma;
//public $nameFami;

public function traerImpresionEntrada(){

$fechahoy=fechaHoraMexico(date("d-m-Y G:i:s"));
$hoy1 = date("Ymd");    
$hoy2 = date("His");
$fecha_elabora=$hoy1.$hoy2;

//PARAMETROS DE ENCABEZADO DEL REPORTE
$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
$direccion=defined('DIRECCION')?DIRECCION:'SIN DATO DE DIRECCION';
$colonia=defined('COLONIA')?COLONIA:'SIN DATO DE COLONIA';
$ciudad=defined('CIUDAD')?CIUDAD:'SIN DATO DE CIUDAD';
$telefono=defined('TELEFONO')?TELEFONO:'SIN DATO DE TELEFONO';
$correo=defined('CORREO')?CORREO:'SIN DATO DE CORREO';

//TRAEMOS LA INFORMACIÓN 
$tabla="hist_entrada";
$claveAlm = $_GET["idbodega"];
$claveFam = $_GET["idfamilia"];
$claveCat = $_GET["idcategoria"];
$claveProd = $_GET["idproducto"];
$fechaVta1 = $_GET["idfechaentra1"];
$fechaVta2 = $_GET["idfechaentra2"];

//CAMBIAR EL FORMATO DE FECHA A yyyy-mm-dd Y SI ESTA VACIA TOMA FECHA ACTUAL
$fechavtaI = explode('-', $fechaVta1);
$fechavtaF = explode('-', $fechaVta2);
if(count($fechavtaI) == 3){
  $fecha1 = $fechavtaI[2].'-'.$fechavtaI[1].'-'.$fechavtaI[0];
  $fecha2 = $fechavtaF[2].'-'.$fechavtaF[1].'-'.$fechavtaF[0];
}

//TRAER LOS DATOS DEL ALMACEN SELECCIONADO
$respuesta = ControladorAlmacen::ctrReporteEntradas($tabla, $claveAlm, $claveFam, $claveCat, $claveProd, $fechaVta1, $fechaVta2);

//if($respuestaVentaxdia){

//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');

$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->startPageGroup();

$pdf->AddPage();
    
// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
    
			<td style="width:65px"><img src="../../../config/logotipo.png"></td>


            <td style="background-color:white; width:350px">
				<div style="font-size:9px; text-align:center; line-height:15px;">
					$direccion, $colonia, $ciudad
				</div>
			</td>

			<td style="background-color:white; width:350px">
				<div style="font-size:9px; text-align:center; line-height:15px;">
					$telefono - Correo: $correo
				</div>
				
			</td>
            <br>
            <br>
            
            <th style="background-color:white; width:745px">
                <div style="font-size:20px; color:red; text-align:center; ">
					$razonsocial
                </div>
            </th>
            <br>
            <th style="background-color:white; width:745px">
                <div style="font-size:10px; color:blue; text-align:right; line-height:25px;">
                 Fecha: $fechahoy
                </div>
            </th>


		</tr>
        
	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$pdf->Ln(0);

if($respuesta){    
// ---------------------------------------------------------
$bloque2 = <<<EOF

    <h3 style="text-align:center; width:800px">Reporte de Entrada del $fecha1 al $fecha2 </h3>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->Ln(2);
// ---------------------------------------------------------

    
// ---------------------------------------------------------
$bloque3 = <<<EOF
 	<table style="font-size:10px; padding:3px 3px;">
	  <tr bgcolor="#cccccc" class="text-center">
		<td style="border: 1px solid #666; width:70px; text-align:center">Familia</td>
		<td style="border: 1px solid #666; width:105px; text-align:center">Categoría</td>
		<td style="border: 1px solid #666; width:80px; text-align:center;">Código</td>
		<td style="border: 1px solid #666; width:170px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; width:70px; text-align:center">U.Med.</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">Cant</td>
		<td style="border: 1px solid #666; width:50px; text-align:center">P.Costo</td>
		<td style="border: 1px solid #666; width:60px; text-align:center">T.Compra</td>		
		<td style="border: 1px solid #666; width:50px; text-align:center">P.Vta.</td>
		<td style="border: 1px solid #666; width:60px; text-align:center">T.Venta</td>		
		<td style="border: 1px solid #666; width:45px; text-align:center">HL</td>		

     </tr>
	</table>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
$cantvta=$granTotalC=$granTotalV=$sumaimporte=$precioCosto=$precioVenta=$sumaCosto=$sumaVenta=$sumatotVta=$sumatotalV=$sumatotalC=0;
$tothl=$totalhl=$totalhectolitros=0;
$filas=count($respuesta);
foreach ($respuesta as $row) {

//$sumatotal=$row["venta"];
$precioCosto=number_format($row["precio_compra"],2,".",",");

$precioVenta=number_format($row["precio_venta"],2,".",",");

$sumatotalC=number_format($row["tot_compra"],2,".",",");
$sumatotalV=number_format($row["tot_venta"],2,".",",");
if($row['hectolitros']>0 && $row['unidadxcaja']>0){
	$tothl=$row['hectolitros']>0?$row['hectolitros']/$row['unidadxcaja']:0;
	$totalhl=$tothl*$row["tot_entro"];
	$tothl=number_format($totalhl,4,".",",");
}else{
	$tothl="";
}

$bloque4 = <<<EOF

 	<table style="font-size:9px; padding:3px 3px;">

	  <tr>
		<td style="border: 1px solid #666; width:70px; text-align:center">$row[familia]</td>
		<td style="border: 1px solid #666; width:105px; text-align:center">$row[categoria]</td>
		<td style="border: 1px solid #666; width:80px; text-align:left">$row[codigointerno]</td>
		<td style="border: 1px solid #666; width:170px; text-align:left">$row[descripcion]</td>
		<td style="border: 1px solid #666; width:70px; text-align:center">$row[medida]</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">$row[tot_entro]</td>
		<td style="border: 1px solid #666; width:50px; text-align:right">$$precioCosto</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">$$sumatotalC</td>		
		<td style="border: 1px solid #666; width:50px; text-align:right">$$precioVenta</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">$$sumatotalV</td>
		<td style="border: 1px solid #666; width:45px; text-align:right">$tothl</td>
      </tr>
     
 	</table>

EOF;
$cantvta+=$row['tot_entro'];
$sumaCosto+=$row['precio_compra'];
$sumaVenta+=$row['precio_venta'];
$granTotalC+=$row['tot_compra'];
$granTotalV+=$row['tot_venta'];
$totalhectolitros+=$totalhl;
    
$pdf->writeHTML($bloque4, false, false, false, false, '');
}
// ---------------------------------------------------------
$granTotalC=number_format($granTotalC,2,".",",");
$granTotalV=number_format($granTotalV,2,".",",");
$sumaCosto=number_format($sumaCosto,2,".",",");
$sumaVenta=number_format($sumaVenta,2,".",",");
$totalhectolitros=number_format($totalhectolitros,4,".",",");
$bloque6 = <<<EOF

	<table style="font-size:9px; padding:5px 3px;">

	<tr bgcolor="#cccccc">
		<td style="border: 1px solid #666; width:70px; text-align:right">Total Filas: $filas</td>
		<td style="border: 1px solid #666; width:425px; text-align:right">Totales:</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">$cantvta</td>
		<td style="border: 1px solid #666; width:50px; text-align:right">$$sumaCosto</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">$$granTotalC</td>
		<td style="border: 1px solid #666; width:50px; text-align:right">$$sumaVenta</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">$$granTotalV</td>
		<td style="border: 1px solid #666; width:45px; text-align:right">$totalhectolitros</td>
		<p></p>
    </tr>
    
 	</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');    
$pdf->Ln(6);
/*    
// ---------------------------------------------------------
$bloque7 = <<<EOF

	<table style="font-size:9px; padding:5px 5px;">

    <tr>
        <td style="border: 1px solid #666;width:260px; height:50px; text-align:center">Nombre y firma quien Recibe</td>
        <td style="width:20px;height:50px; text-align:center"></td>
        <td style="border: 1px solid #666;width:260px; height:50px; text-align:center">Nombre y firma quien Revisa</td>
    </tr>

 	</table>

EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');     */
// ---------------------------------------------------------    
//SALIDA DEL ARCHIVO 
 $nombre_archivo="entradas".$fecha_elabora.".pdf";   //genera el nombre del archivo para descargarlo
 ob_end_clean();
 $pdf->Output($nombre_archivo);
}else{
// ---------------------------------------------------------
$pdf->Ln(6);
$bloque7 = <<<EOF

	<table style="font-size:12px; padding:5px 5px;">

    <tr>
        <td style="border: 1px solid #666; width:780px; height:50px; text-align:center;">
        
        <h3> No existe información con los datos proporcionados. REVISE!!  </h3>
        $tabla, $claveAlm, $claveFam, $claveCat, $claveProd, $fechaVta1, $fechaVta2,
        </td>
    </tr>

 	</table>

EOF;

$pdf->writeHTML($bloque7, false, false, false, false, ''); 
// ---------------------------------------------------------        
  //$nombre_archivo="inventario";
ob_end_clean();
$pdf->Output("entradas.pdf", 'I');
}
}

}

$ReportEntrada = new imprimirRepEntrada();
//$inventario -> nameAlma = $_GET["idNomAlma"];
//$inventario -> nameFami = $_GET["idNumFam"];
$ReportEntrada -> traerImpresionEntrada();

//FUNCTION PARA MOSTRAR LA FECHA EN ESPAÑOL Y DE MEXICO
function fechaHoraMexico($timestamp) {
    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
    $hora = strftime("%I:%M:%S %p", strtotime($timestamp)); //Descomentar en caso de requerir hora
    setlocale(LC_TIME, 'spanish');
    $fecha = utf8_encode(strftime("%A %d de %B del %Y", strtotime($timestamp)));
    return ($fecha.' '.$hora);//$hora; concatenar con fecha para obtener fecha y hora
}
?>
