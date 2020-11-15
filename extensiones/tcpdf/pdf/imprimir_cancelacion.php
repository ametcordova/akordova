<?php
ob_clean();
require_once "../../../controladores/salidas.controlador.php";
require_once "../../../modelos/salidas.modelo.php";
//include "../../../config/parametros.php";

/*
include ('Numbers/Words.php');
*/

class imprimirCancelacion{

public $codigo;

public function traerImpresionSalida(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$campo = "num_cancelacion";
//$numdeSalida = $_GET["codigo"];
$valor = $_GET["numcancelacion"];

$respuesta = ControladorSalidas::ctrImprimirCancelacion($campo, $valor);

if($respuesta){
$num_salida=$respuesta[0]["num_salida"];
//PARAMETROS DE ENCABEZADO DEL REPORTE
$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
$direccion=defined('DIRECCION')?DIRECCION:'SIN DATO DE DIRECCION';
$colonia=defined('COLONIA')?COLONIA:'SIN DATO DE COLONIA';
$ciudad=defined('CIUDAD')?CIUDAD:'SIN DATO DE CIUDAD';
$telefono=defined('TELEFONO')?TELEFONO:'SIN DATO DE TELEFONO';
$correo=defined('CORREO')?CORREO:'SIN DATO DE CORREO';
$imagen=defined('IMAGEN')?'../../../'.IMAGEN:'../../../config/imagenes/logotipoempresa.png';

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

			<td style="width:65px"><img src="$imagen"></td>

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
					$correo

				</div>
				
			</td>

			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br>Cancelación No.<br>$valor</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$pdf->Ln(2);
    
// ---------------------------------------------------------
$bloque2 = <<<EOF

<h2 style="text-align:center;">REPORTE CANCELACIÓN DE VENTA</h2>


EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->Ln(2);
// ---------------------------------------------------------

//var_dump($respuestaAlmacen);
$idCliente=$respuesta[0]["id_cliente"];
$nomCliente=$respuesta[0]["nombrecliente"];
//$FechDocto=date("d/m/Y", strtotime($respuestaAlmacen[0]["fechadocto"]));
$idAlmacen=$respuesta[0]["id_almacen"];
$nombreAlmacen=$respuesta[0]["nombrealma"];
$fechaSalida=date("d/m/Y", strtotime($respuesta[0]["fecha_salida"]));
$fechaCancelacion=date("d/m/Y h:i:s A", strtotime($respuesta[0]["ultmodificacion"]));
$usuario=$respuesta[0]["nombreusuario"];

$bloque3 = <<<EOF

	<table style="font-size:9px; padding:5px 5px;">
    
    <tr>		
		<td style="border: 1px solid #666; width:300px">Cliente: $idCliente - $nomCliente</td>
		<td style="border: 1px solid #666; width:240px">Canceló: $usuario</td>
	</tr>
	
	<tr>
	   <td style="border: 1px solid #666; width:165px">Num. de Venta: $num_salida</td>

	   <td style="border: 1px solid #666; width:135px; text-align:left"> 
	   </td>

        <td style="border: 1px solid #666; width:240px">Almacen de Entrada: $idAlmacen - $nombreAlmacen</td>
	</tr>

 	<tr>
		<td style="border: 1px solid #666; width:300px">Fecha venta.: $fechaSalida</td>
        <td style="border: 1px solid #666; width:240px">Fecha y hora de cancelación: $fechaCancelacion</td>
	</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');
$pdf->Ln(4);
// ---------------------------------------------------------    
    
// ---------------------------------------------------------

$bloque4 = <<<EOF

 	<table style="font-size:10px; padding:5px 5px;">

	  <tr bgcolor="#cccccc" class="text-center">
		<td style="border: 1px solid #666; width:32px; text-align:center">id</td>
		<td style="border: 1px solid #666; width:85px; text-align:center;">Código</td>
		<td style="border: 1px solid #666; width:200px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; width:65px; text-align:center">U.Med.</td>
		<td style="border: 1px solid #666; width:38px; text-align:center">Cant.</td>
		<td style="border: 1px solid #666; width:60px; text-align:center">P. Venta</td>
		<td style="border: 1px solid #666; width:60px; text-align:center">Total</td>
        
     </tr>
     
	</table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

// ---------------------------------------------------------
$cantSalida=$granTotal=$sumtotal=0;
foreach ($respuesta as $row) {
if ($row["es_promo"]==0) {
	$sumatotal=number_format($row["cantidad"]*$row["precio_venta"],2);
	$sumtotal=($row["cantidad"]*$row["precio_venta"]);
	$descripcion=trim($row["descripcion"]);
} else {
	$sumatotal=number_format($row["precio_venta"],2);
	$sumtotal=$row["precio_venta"];
	$descripcion=trim($row["descripcion"]."*");	
}


$bloque5 = <<<EOF

 	<table style="font-size:9px; padding:3px 3px;">

	  <tr>
		<td style="border: 1px solid #666; width:32px; text-align:center">$row[id_producto]</td>
		<td style="border: 1px solid #666; width:85px; text-align:center">$row[codigointerno]</td>
		<td style="border: 1px solid #666; width:200px; text-align:left">$descripcion</td>
		<td style="border: 1px solid #666; width:65px; text-align:center">$row[medida]</td>
		<td style="border: 1px solid #666; width:38px; text-align:center">$row[cantidad]</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">$row[precio_venta]</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">$$sumatotal</td>
      </tr>
     
 	</table>

EOF;
$cantSalida+=$row['cantidad'];
$granTotal+=$sumtotal;
$pdf->writeHTML($bloque5, false, false, false, false, '');
}
// ---------------------------------------------------------
   
$granTotal = number_format($granTotal, 2);

$bloque6 = <<<EOF

	<table style="font-size:9px; padding:3px 3px;">

	<tr bgcolor="#cccccc">
		<td style="border: 1px solid #666; width:382px; text-align:right">Cant. Salida:</td>
		<td style="border: 1px solid #666; width:38px; text-align:center">$cantSalida</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">Venta Total</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">$$granTotal</td>
    </tr>
    
 	</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');    
$pdf->Ln(6);
// ---------------------------------------------------------
$bloque7 = <<<EOF

	<table style="font-size:9px; padding:5px 5px;">

    <tr>
        <td style="border: 1px solid #666;width:260px; height:50px; text-align:center">Nombre y firma quien Canceló</td>
        <td style="width:20px;height:50px; text-align:center"></td>
        <td style="border: 1px solid #666;width:260px; height:50px; text-align:center">Nombre y firma quien Autorizó</td>
    </tr>

 	</table>

EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');     
// ---------------------------------------------------------    
//SALIDA DEL ARCHIVO 
 $nombre_archivo="cancelacion".trim($numdeSalida).".pdf";   //genera el nombre del archivo para descargarlo
 ob_end_clean();
 $pdf->Output($nombre_archivo);
}else{
  //$nombre_archivo="entrada";
  ob_end_clean();
  $pdf->Output("salida.pdf");
}
}

}

$cancelacion = new imprimirCancelacion();
$cancelacion -> codigo = $_GET["numcancelacion"];
$cancelacion -> traerImpresionSalida();

?>