<?php

require_once "../../../controladores/reporteinventario.controlador.php";
require_once "../../../modelos/reporteinventario.modelo.php";


// 540 max de la fila P y 800 L

class imprimirInventario{

//public $nameAlma;
//public $nameFami;

public function traerImpresionInventario(){

$fechahoy=fechaHoraMexico(date("d-m-Y G:i:s"));
    
$horahoy=time();    
    
//TRAEMOS LA INFORMACIÓN 
$tabla=$_GET["idNomAlma"];
$campoFam = "id_familia";
$claveFam = $_GET["idNumFam"];

//TRAER LOS DATOS DEL ALMACEN SELECCIONADO
$respuestaInventario = ControladorInventario::ctrReporteInventario($tabla, $campoFam, $claveFam);

if($respuestaInventario){

//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');

$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
$pdf->SetMargins(1,1,1, true);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->startPageGroup();

$pdf->AddPage('P', 'A7');
$pdf->SetFont('times', 'BI', 8);
// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
    
			<td style="width:25px"><img src="images/logo_corona.png"></td>


            <td style="background-color:white;">
				<div style="text-align:center;">
                    Av. Perícles y Catazajá No. 401, Fracc. Centenario, Tuxtla Gutiérrez, Chiapas.
				</div>
			</td>

		</tr>
        
	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$pdf->Ln(0);
    
// ---------------------------------------------------------
$bloque2 = <<<EOF

    <h3 style="text-align:center;">Reporte de Inventario del Almacén $tabla al $fechahoy</h3>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->Ln(2);
// ---------------------------------------------------------

    
// ---------------------------------------------------------
$bloque3 = <<<EOF
 	<table style="font-size:8px; padding:5px 5px;">
	  <tr bgcolor="#cccccc" class="text-center">
		<td style="border: 1px solid #666; text-align:center;">Código</td>
		<td style="border: 1px solid #666;  text-align:center">Producto</td>
		<td style="border: 1px solid #666; text-align:center">Exist</td>
     </tr>
	</table>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
$cantEntra=$sumatotal=$granTotal=$sumaimporte=0;
foreach ($respuestaInventario as $row) {

//$sumatotal=number_format($row["cantidad"]*$row["precio_compra"],2,".",",");

//$sumaimporte=$row["cantidad"]*$row["precio_compra"];

$bloque4 = <<<EOF

 	<table style="font-size:6px; padding:5px 5px;">

	  <tr>
		<td style="border: 1px solid #666;text-align:left">$row[codigointerno]</td>
		<td style="border: 1px solid #666; text-align:center">$row[descripcion]</td>
		<td style="border: 1px solid #666; text-align:center">$row[cant]</td>
      </tr>
     
 	</table>

EOF;
//$cantEntra+=$row['cantidad'];
//$granTotal+=$sumaimporte;
$pdf->writeHTML($bloque4, false, false, false, false, '');
}
// ---------------------------------------------------------
/*
$granTotal=number_format($granTotal,2,".",",");
$bloque6 = <<<EOF

	<table style="font-size:9px; padding:5px 3px;">

	<tr bgcolor="#cccccc">
		<td style="border: 1px solid #666; width:382px; text-align:right">Total Entrada:</td>
		<td style="border: 1px solid #666; width:38px; text-align:center">$cantEntra</td>
		<td style="border: 1px solid #666; width:60px; text-align:right">Totales</td>
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
        <td style="border: 1px solid #666;width:260px; height:50px; text-align:center">Nombre y firma quien Recibe</td>
        <td style="width:20px;height:50px; text-align:center"></td>
        <td style="border: 1px solid #666;width:260px; height:50px; text-align:center">Nombre y firma quien Revisa</td>
    </tr>

 	</table>

EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');     */
// ---------------------------------------------------------    
//SALIDA DEL ARCHIVO 
 $nombre_archivo="inventario1".$horahoy.".pdf";   //genera el nombre del archivo para descargarlo
 $pdf->Output($nombre_archivo);
}else{
  //$nombre_archivo="inventario";
  $pdf->Output("inventario.pdf");
}
}

}

$inventario = new imprimirInventario();
$inventario -> nameAlma = $_GET["idNomAlma"];
$inventario -> nameFami = $_GET["idNumFam"];
$inventario -> traerImpresionInventario();

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
