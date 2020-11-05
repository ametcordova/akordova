<?php
ob_clean();
set_time_limit(120);
require_once "../../../controladores/reporteinventario.controlador.php";
require_once "../../../modelos/reporteinventario.modelo.php";
//include "../../../config/parametros.php";


// 540 max de la fila P y 800 L

class reporteInventario{

//public $nameAlma;
//public $nameFami;

public function traerReporteInventario(){

$fechahoy=fechaHoraMexico(date("d-m-Y G:i:s"));
//$fecharep=fechaHoraMexico(date("d-m-Y H:i:s"));

$hoy1 = date("Ymd");    
$hoy2 = date("His");
$fecha_elabora=$hoy1.$hoy2;
    
//TRAEMOS LA INFORMACIÓN 
$tabla=trim(strtolower($_GET["idNomAlma"]));
$campoFam = "id_familia";
$claveFam = $_GET["idNumFam"];

//PARAMETROS DE ENCABEZADO DEL REPORTE
$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
$direccion=defined('DIRECCION')?DIRECCION:'SIN DATO DE DIRECCION';
$colonia=defined('COLONIA')?COLONIA:'SIN DATO DE COLONIA';
$ciudad=defined('CIUDAD')?CIUDAD:'SIN DATO DE CIUDAD';
$telefono=defined('TELEFONO')?TELEFONO:'SIN DATO DE TELEFONO';
$correo=defined('CORREO')?CORREO:'SIN DATO DE CORREO';

//TRAER LOS DATOS DEL ALMACEN SELECCIONADO
$respuestaInventario = ControladorInventario::ctrReporteInventario($tabla, $campoFam, $claveFam);

if($respuestaInventario){

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
            <td style="background-color:white; width:800px">
                <div style="font-size:20px; color:red; text-align:center; line-height:25px;">
                $razonsocial
                </div>
            </td>


		</tr>
        
	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$pdf->Ln(0);
    
// ---------------------------------------------------------
$bloque2 = <<<EOF

    <h3 style="text-align:center; width:800px">Reporte de Inventario del Almacén $tabla al $fechahoy</h3>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->Ln(2);
// ---------------------------------------------------------

    
// ---------------------------------------------------------
$bloque3 = <<<EOF
 	<table style="font-size:10px; padding:5px 5px;">
	  <tr bgcolor="#cccccc" class="text-center">
		<td style="border: 1px solid #666; width:80px; text-align:center">Familia</td>
		<td style="border: 1px solid #666; width:95px; text-align:center">Categoría</td>
		<td style="border: 1px solid #666; width:75px; text-align:center;">Código</td>
		<td style="border: 1px solid #666; width:170px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; width:58px; text-align:center">U.Med.</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">Exist</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">stock</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">Dif.</td>
		<td style="border: 1px solid #666; width:46px; text-align:center">P.Unit</td>
		<td style="border: 1px solid #666; width:61px; text-align:center">Tot.Cto</td>
		<td style="border: 1px solid #666; width:46px; text-align:center">P.Vta</td>
		<td style="border: 1px solid #666; width:59px; text-align:center">Tot. Vta</td>
     </tr>
	</table>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
$cantEntra=$sumatotalvta=$sumatotalcto=$granTotal=$sumaimporte=$TotalCosto=0;
foreach ($respuestaInventario as $row) {

$sumaimporte=number_format($row["cant"]*$row["precio_venta"],2,".",",");
$sumacosto=number_format($row["cant"]*$row["precio_compra"],2,".",",");
$precioventa=number_format($row['precio_venta'],2,".",",");
$preciocosto=number_format($row['precio_compra'],2,".",",");
$sumatotalcto=$row["cant"]*$row["precio_compra"];
$sumatotalvta=$row["cant"]*$row["precio_venta"];
$descripcion=substr($row['descripcion'],0,34);

$bloque4 = <<<EOF

 	<table style="font-size:8px; padding:5px 3px;">

	  <tr>
		<td style="border: 1px solid #666; width:80px; text-align:center">$row[familia]</td>
		<td style="border: 1px solid #666; width:95px; text-align:center">$row[categoria]</td>
		<td style="border: 1px solid #666; width:75px; text-align:left">$row[codigointerno]</td>
		<td style="border: 1px solid #666; width:170px; text-align:left">$descripcion</td>
		<td style="border: 1px solid #666; width:58px; text-align:center">$row[medida]</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">$row[cant]</td>
		<td style="border: 1px solid #666; width:35px; text-align:right">$row[stock]</td>
		<td style="border: 1px solid #666; width:35px; text-align:right">$row[surtir]</td>
		<td style="border: 1px solid #666; width:46px; text-align:right">$$preciocosto</td>
		<td style="border: 1px solid #666; width:61px; text-align:right">$$sumacosto</td>
		<td style="border: 1px solid #666; width:46px; text-align:right">$$precioventa</td>
		<td style="border: 1px solid #666; width:59px; text-align:right">$$sumaimporte</td>
      </tr>
     
 	</table>

EOF;
$cantEntra+=$row['cant'];
$TotalCosto+=$sumatotalcto;
$granTotal+=$sumatotalvta;
$pdf->writeHTML($bloque4, false, false, false, false, '');
}
// ---------------------------------------------------------

$TotalCosto=number_format($TotalCosto,2,".",",");
$granTotal=number_format($granTotal,2,".",",");
$bloque6 = <<<EOF

	<table style="font-size:9px; padding:5px 3px;">

	<tr bgcolor="#cccccc">
		<td style="border: 1px solid #666; width:478px; text-align:right">Total Exist:</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">$cantEntra</td>
		<td style="border: 1px solid #666; width:116px; text-align:right">Total Costo:</td>
		<td style="border: 1px solid #666; width:61px; text-align:right">$$TotalCosto</td>
		<td style="border: 1px solid #666; width:46px; text-align:right">Total Vta:</td>
		<td style="border: 1px solid #666; width:59px; text-align:right">$$granTotal</td>
    </tr>
    
 	</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');    
$pdf->Ln(6);
// ---------------------------------------------------------
/*
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
*/
// ---------------------------------------------------------    
//SALIDA DEL ARCHIVO 
 $nombre_archivo="inventario_".$fecha_elabora.".pdf";   //genera el nombre del archivo para descargarlo
 ob_end_clean();
 //$pdf->Output($nombre_archivo, 'D');
 $pdf->Output($nombre_archivo, 'I');
}else{
  ob_end_clean();
  //$nombre_archivo="inventario";
  $pdf->Output("D","inventario.pdf");
}
}

}

$inventario = new reporteInventario();
$inventario -> nameAlma = $_GET["idNomAlma"];
$inventario -> nameFami = $_GET["idNumFam"];
$inventario -> traerReporteInventario();

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
