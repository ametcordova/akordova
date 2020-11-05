<?php

require_once "../../../controladores/entradas.controlador.php";
require_once "../../../modelos/entradas.modelo.php";

/*
include ('Numbers/Words.php');

// 540 max de la fila
*/
class imprimirEntrada{

public $codigo;

public function traerImpresionEntrada(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "numerodocto";
$numdeDocto = $_GET["codigo"];

//TRAER LOS DATOS DE hist_entrada
$respuestaAlmacen = ControladorEntradas::ctrEntradaAlm($itemVenta, $numdeDocto);

if($respuestaAlmacen){

//PARAMETROS DE ENCABEZADO DEL REPORTE
//$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
$direccion=defined('DIRECCION')?DIRECCION:'SIN DATO DE DIRECCION';
$colonia=defined('COLONIA')?COLONIA:'SIN DATO DE COLONIA';
$ciudad=defined('CIUDAD')?CIUDAD:'SIN DATO DE CIUDAD';
$telefono=defined('TELEFONO')?TELEFONO:'SIN DATO DE TELEFONO';
$correo=defined('CORREO')?CORREO:'SIN DATO DE CORREO';


/*
$fecha = substr($respuestaVenta["fecha"],0,-8);
$productos = json_decode($respuestaVenta["productos"], true);
$neto = number_format($respuestaVenta["neto"],2);
$impuesto = number_format($respuestaVenta["impuesto"],2);
$total = number_format($respuestaVenta["total"],2);
*/

//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->startPageGroup();

$pdf->AddPage();
    
// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>

			<td style="width:65px"><img src="../../../config/logotipo.png"></td>	

			<td style="background-color:white; width:187.5px">
				
				<div style="font-size:8.5px; text-align:center; line-height:15px;">
					
					<br>
					$direccion, $colonia, $ciudad
				</div>

			</td>

			<td style="background-color:white; width:187.5px">

				<div style="font-size:8.5px; text-align:center; line-height:15px;">
					
					<br>
					$telefono 
					
					<br>
					Correo: $correo

				</div>
				
			</td>

			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br>ENTRADA No.<br>$numdeDocto</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$pdf->Ln(2);
    
// ---------------------------------------------------------
$bloque2 = <<<EOF

<h2 style="text-align:center;">REPORTE DE ENTRADAS AL ALMACEN</h2>


EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->Ln(2);
// ---------------------------------------------------------

//var_dump($respuestaAlmacen);
$idProv=$respuestaAlmacen[0]["id_proveedor"];
$nomProv=$respuestaAlmacen[0]["nombreprov"];
$FechDocto=date("d/m/Y", strtotime($respuestaAlmacen[0]["fechadocto"]));
$idAlmacen=$respuestaAlmacen[0]["id_almacen"];
$nombreAlmacen=$respuestaAlmacen[0]["nombre"];
$fechEntrada=date("d/m/Y", strtotime($respuestaAlmacen[0]["fechaentrada"]));
$recibio=$respuestaAlmacen[0]["recibio"];

$bloque3 = <<<EOF

	<table style="font-size:9px; padding:5px 5px;">
    
    <tr>		
		<td style="border: 1px solid #666; width:540px">Proveedor: $idProv - $nomProv</td>
	</tr>
	
	<tr>
	   <td style="border: 1px solid #666; width:165px">Numero de Docto: $numdeDocto</td>

	   <td style="border: 1px solid #666; width:135px; text-align:left">Fecha Docto: $FechDocto
	   </td>

        <td style="border: 1px solid #666; width:240px">Almacen de Entrada: $idAlmacen - $nombreAlmacen</td>
	</tr>

 	<tr>
		<td style="border: 1px solid #666; width:300px">Recibio: $recibio</td>
        <td style="border: 1px solid #666; width:240px">Fecha recepción en Almacen: $fechEntrada</td>
	</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');
$pdf->Ln(4);
// ---------------------------------------------------------    
    
// ---------------------------------------------------------

$bloque4 = <<<EOF

 	<table style="font-size:10px; padding:2px 2px;">

	  <tr bgcolor="#cccccc" class="text-center">
		<td style="border: 1px solid #666; width:85px; text-align:center;">Código</td>
		<td style="border: 1px solid #666; width:196px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; width:65px; text-align:center">U.Med.</td>
		<td style="border: 1px solid #666; width:34px; text-align:center">Cant.</td>
		<td style="border: 1px solid #666; width:53px; text-align:center">P. Compra</td>
		<td style="border: 1px solid #666; width:60px; text-align:center">Total</td>
		<td style="border: 1px solid #666; width:48px; text-align:center">HL</td>
     </tr>
     
	</table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

// ---------------------------------------------------------
$cantEntra=$sumatotal=$granTotal=$sumaimporte=$tothl=$totalhl=$totalhectolitros=0;
foreach ($respuestaAlmacen as $row) {

$sumatotal=number_format($row["cantidad"]*$row["precio_compra"],2,".",",");

$sumaimporte=$row["cantidad"]*$row["precio_compra"];

if($row['hectolitros']>0 && $row['unidadxcaja']>0){
	$tothl=$row['hectolitros']>0?$row['hectolitros']/$row['unidadxcaja']:0;
	$totalhl=$tothl*$row["cantidad"];
	$tothl=number_format($totalhl,4,".",",");
}else{
	$tothl="";
}
$bloque5 = <<<EOF

 	<table style="font-size:9px; padding:3px 3px;">

	  <tr>
		<td style="border: 1px solid #666; width:85px; text-align:center">$row[codigointerno]</td>
		<td style="border: 1px solid #666; width:196px; text-align:left">$row[descripcion]</td>
		<td style="border: 1px solid #666; width:65px; text-align:center">$row[medida]</td>
		<td style="border: 1px solid #666; width:34px; text-align:center">$row[cantidad]</td>
		<td style="border: 1px solid #666; width:53px; text-align:right">$row[precio_compra]</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">$$sumatotal</td>
		<td style="border: 1px solid #666; width:48px; text-align:right">$tothl</td>
		
      </tr>
     
 	</table>

EOF;
$cantEntra+=$row['cantidad'];
$totalhectolitros+=$totalhl;
$granTotal+=$sumaimporte;
$pdf->writeHTML($bloque5, false, false, false, false, '');
}
// ---------------------------------------------------------

$granTotal=number_format($granTotal,2,".",",");
$totalhectolitros=number_format($totalhectolitros,4,".",",");
$bloque6 = <<<EOF

	<table style="font-size:9px; padding:4px 3px;">

	<tr bgcolor="#cccccc">
		<td style="border: 1px solid #666; width:346px; text-align:right">Total Entrada:</td>
		<td style="border: 1px solid #666; width:34px; text-align:center">$cantEntra</td>
		<td style="border: 1px solid #666; width:53px; text-align:right">Totales</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">$$granTotal</td>
		<td style="border: 1px solid #666; width:48px; text-align:right">$totalhectolitros</td>
    </tr>
    
 	</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');    
$pdf->Ln(6);
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

$pdf->writeHTML($bloque7, false, false, false, false, '');     
// ---------------------------------------------------------    
//SALIDA DEL ARCHIVO 
 $nombre_archivo="entrada".trim($numdeDocto).".pdf";   //genera el nombre del archivo para descargarlo
 $pdf->Output($nombre_archivo);
}else{
  //$nombre_archivo="entrada";
  $pdf->Output("entrada.pdf");
}
}

}

$entrada = new imprimirEntrada();
$entrada -> codigo = $_GET["codigo"];
$entrada -> traerImpresionEntrada();

?>