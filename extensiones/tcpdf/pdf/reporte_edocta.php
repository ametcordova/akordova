<?php
ob_clean();
set_time_limit(240);
require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

/*
include ('Numbers/Words.php');
*/

class impresionEdocta{

public $codigo;

public function traerImpresionEdocta(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA
$fechavtaIni = $_GET["FechIniEdoCta"];
$fechavtaFin = $_GET["FechFinEdoCta"];
$dateini = date("d-m-Y", strtotime($fechavtaIni));	
$datefin = date("d-m-Y", strtotime($fechavtaFin));
$item = "id";
$idNumCliente = $_GET["codigo"];

$respuestacliente = ControladorClientes::ctrMostrarClientes($item, $idNumCliente);
if($respuestacliente){

//PARAMETROS DE ENCABEZADO DEL REPORTE
$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
$direccion=defined('DIRECCION')?DIRECCION:'SIN DATO DE DIRECCION';
$colonia=defined('COLONIA')?COLONIA:'SIN DATO DE COLONIA';
$ciudad=defined('CIUDAD')?CIUDAD:'SIN DATO DE CIUDAD';
$telefono=defined('TELEFONO')?TELEFONO:'SIN DATO DE TELEFONO';
$correo=defined('CORREO')?CORREO:'SIN DATO DE CORREO';
$imagen=defined('IMAGEN')?'../../../'.IMAGEN:'../../../config/imagenes/logotipoempresa.png';

$fechaultcompra=date('d-m-Y', strtotime($respuestacliente['ultima_venta']));

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
		
<tr style="width:485px">

    <td style="width:65px"><img src="$imagen"></td>

    <td style="background-color:white; width:230px">
        
        <div style="font-size:8.5px; text-align:center; line-height:9px;">
            
            <br>
                $direccion, $colonia, $ciudad
        </div>

    </td>

    <td style="background-color:white; width:240px; padding-left:50px;">

        <div style="font-size:8.5px; text-align:center; line-height:9px;">
            
            <br>
            $telefono 
            
            <br>
            $correo

        </div>
        
    </td>

</tr>

</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

$pdf->Ln(1);
    
// ---------------------------------------------------------

// ------------------- ENTRADAS --------------------------------------
$bloque2 = <<<EOF

<h3 style="text-align:center; color:blue;">ESTADO DE CUENTA DEL $dateini AL $datefin</h3>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->Ln(2);
// ---------------------------------------------------------
//print_r($respuestacliente);
// ---------------------------------------------------------
$bloque3 = <<<EOF


<table style="font-size:9px; padding:5px 5px;">
    
<tr>		
    <td style="border: 1px solid #666; width:280px">Cliente: $respuestacliente[id] - $respuestacliente[nombre]</td>
    <td style="border: 1px solid #666; width:260px">Dir: $respuestacliente[direccion]</td>
</tr>

<tr>
   <td style="border: 1px solid #666; width:165px">Teléfono: $respuestacliente[telefono]</td>

   <td style="border: 1px solid #666; width:135px; text-align:left">RFC: $respuestacliente[rfc]</td>

    <td style="border: 1px solid #666; width:240px">email: $respuestacliente[email]</td>
</tr>

 <tr>
    <td style="border: 1px solid #666; width:115px;" >Saldo Actual.:<strong>$$respuestacliente[saldo]</strong></td>
    <td style="border: 1px solid #666; width:150px">Límite de Crédito: $respuestacliente[limitecredito]</td>
    <td style="border: 1px solid #666; width:150px">Total Compras: $respuestacliente[ventas]</td>
    
    <td style="border: 1px solid #666; width:125px">F.Ult. Compra: $fechaultcompra </td>
</tr>

</table>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');    
$pdf->Ln(4);
// ---------------------------------------------------------
$bloque4 = <<<EOF
    <h3 style="text-align:center;">DETALLE DE COMPRAS</h3>
 	<table style="font-size:10px; padding:3px 5px;">

	  <tr style="background-color:black; color:white;" class="text-center">
        <td style="border: 1px solid #666; width:38px; text-align:center">Ticket</td>
        <td style="border: 1px solid #666; width:63px; text-align:center">Fecha</td>
		<td style="border: 1px solid #666; width:90px; text-align:center;">Código</td>
		<td style="border: 1px solid #666; width:200px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; width:34px; text-align:center">Cant.</td>
		<td style="border: 1px solid #666; width:55px; text-align:center">P. Venta</td>
		<td style="border: 1px solid #666; width:60px; text-align:center">Total</td>
        
     </tr>
     
	</table>

EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');

// ---------------------------------------------------------
$respuestaventas = ControladorClientes::ctrReporteEdoCta($idNumCliente, $fechavtaIni, $fechavtaFin);
$totalxticket=$sumatotales=0;
//var_dump($respuestaventas);
$tickeanterior=$respuestaventas[0]['num_salida'];
foreach ($respuestaventas as $row) {

    if($row["es_promo"]==0){
        $sumtotal=($row["cant"]*$row["precio_venta"]); 
        $descripcion=trim(substr($row["descripcion"],0,36));
    }else{
        $sumtotal=$row["precio_venta"];
        $descripcion=trim(substr($row["descripcion"],0,36)."*");
    }    
    $FechTicket=date("d-m-Y", strtotime($row['fecha_salida']));
    $totalventa=number_format($sumtotal,2,".",",");
    
    if($row['num_salida']<>$tickeanterior){
        $totalxticket=number_format($totalxticket,2,".",",");
$bloque6 = <<<EOF
        
            <table bgcolor="#99ccff" style="font-size:10px; padding:3px 2px;">
        
             <tr class="text-center">
               <td style="border: 1px solid #666; width:480px; text-align:right">Total venta:</td>
               <td style="border: 1px solid #666; width:60px; text-align:right">$$totalxticket</td>
               
            </tr>
            
           </table>
        
EOF;
$pdf->writeHTML($bloque6, false, false, false, false, '');
$pdf->Ln(2);
$totalxticket=0;

$bloque5 = <<<EOF

        <table style="font-size:10px; padding:3px 2px;">
    
            <tr class="text-center">
            <td style="border: 1px solid #666; width:38px; text-align:center">$row[num_salida]</td>
            <td style="border: 1px solid #666; width:63px; text-align:center">$FechTicket</td>
            <td style="border: 1px solid #666; width:90px; text-align:left;">$row[codigointerno]</td>
            <td style="border: 1px solid #666; width:200px; text-align:left">$descripcion</td>
            <td style="border: 1px solid #666; width:34px; text-align:center">$row[cant]</td>
            <td style="border: 1px solid #666; width:55px; text-align:right">$row[precio_venta]</td>
            <td style="border: 1px solid #666; width:60px; text-align:right">$$totalventa</td>
            
            </tr>
            
        </table>
        
EOF;
$pdf->writeHTML($bloque5, false, false, false, false, '');  
$totalxticket+=$sumtotal;                     
$chk=true;
}else{

$bloque5 = <<<EOF

        <table style="font-size:10px; padding:3px 2px;">
    
            <tr class="text-center">
            <td style="border: 1px solid #666; width:38px; text-align:center">$row[num_salida]</td>
            <td style="border: 1px solid #666; width:63px; text-align:center">$FechTicket</td>
            <td style="border: 1px solid #666; width:90px; text-align:left;">$row[codigointerno]</td>
            <td style="border: 1px solid #666; width:200px; text-align:left">$row[descripcion]</td>
            <td style="border: 1px solid #666; width:34px; text-align:center">$row[cant]</td>
            <td style="border: 1px solid #666; width:55px; text-align:right">$row[precio_venta]</td>
            <td style="border: 1px solid #666; width:60px; text-align:right">$$totalventa</td>
            
            </tr>
            
        </table>
        
EOF;
$pdf->writeHTML($bloque5, false, false, false, false, '');    
$totalxticket+=$sumtotal;    
$chk=false;
    }
    
    $sumatotales+=$sumtotal;



if($chk){

}
    $tickeanterior=$row['num_salida'];
}
// FIN DE CICLO FOREACH
$totalxticket=number_format($totalxticket,2,".",",");
$sumatotales=number_format($sumatotales,2,".",",");
$bloque7 = <<<EOF

    <table style="font-size:10px; padding:3px 2px;">

    <tr bgcolor="#99ccff" class="text-center">
       <td style="border: 1px solid #666; width:480px; text-align:right">Total venta:</td>
       <td style="border: 1px solid #666; width:60px; text-align:right">$$totalxticket</td>
    </tr>

    <tr style="margin-top:0;">
       <td></td>
    </tr>
    
    <tr bgcolor="#99ffcc" class="text-center">
       <td style="border: 1px solid #666; width:480px; text-align:right">Suma Total:</td>
       <td style="border: 1px solid #666; width:60px; text-align:right">$$sumatotales</td>
    </tr>

   </table>

EOF;
$pdf->writeHTML($bloque7, false, false, false, false, '');
$pdf->Ln(4);
// ---------------------------------------------------------------------------------------------------------------------------
$respuestaabonos = ControladorClientes::ctrAbonosdeCliente($idNumCliente, $fechavtaIni, $fechavtaFin);

if($respuestaabonos){


$bloque8 = <<<EOF

    <h3 style="text-align:center;">ABONOS REALIZADOS</h3>

    <table style="font-size:10px; padding:3px 5px;">

    <tr style="background-color:black; color:white;" class="text-center">
       <td style="border: 1px solid #666; width:50px; text-align:center">#</td>
       <td style="border: 1px solid #666; width:75px; text-align:center">Fecha Abono</td>
       <td style="border: 1px solid #666; width:200px; text-align:center;">Concepto Abono</td>
       <td style="border: 1px solid #666; width:80px; text-align:center;">Importe Abono</td>
    </tr>
    
   </table>

EOF;
$pdf->writeHTML($bloque8, false, false, false, false, '');
$abono=$totabono=0;
foreach ($respuestaabonos as $row) {
    $FechAbono=date("d-m-Y", strtotime($row['fecha_abono']));
    $abono=number_format($row['abono'],2,".",",");
    $totabono+=$row['abono'];
$bloque9 = <<<EOF

    <table style="font-size:10px; padding:3px 2px;">

        <tr class="text-center">
        <td style="border: 1px solid #666; width:50px; text-align:center">$row[id]</td>
        <td style="border: 1px solid #666; width:75px; text-align:center">$FechAbono</td>
        <td style="border: 1px solid #666; width:200px; text-align:left">$row[concepto_abono]</td>
        <td style="border: 1px solid #666; width:80px; text-align:right">$$abono</td>
        
        </tr>
        
    </table>
    
EOF;
$pdf->writeHTML($bloque9, false, false, false, false, '');  
    
}
/*--------------------------------------------------------------------------------------------*/
$totabono=number_format($totabono,2,".",",");
$bloque10 = <<<EOF

    <table style="font-size:10px; padding:3px 2px;">

    <tr bgcolor="#99ffcc" class="text-center">
       <td style="border: 1px solid #666; width:325px; text-align:right">Total Abonos:</td>
       <td style="border: 1px solid #666; width:80px; text-align:right">$$totabono</td>
    </tr>

   </table>

EOF;
$pdf->writeHTML($bloque10, false, false, false, false, '');
$pdf->Ln(2);

}

// ---------------------------------------------------------    
//SALIDA DEL ARCHIVO 
 $nombre_archivo="edocta ".trim($respuestacliente['nombre']).".pdf";   //genera el nombre del archivo para descargarlo
 ob_end_clean();
 $pdf->Output($nombre_archivo);
}else{
  ob_end_clean();
  $pdf->Output("edocta.pdf");
}
}

}

$edocta = new impresionEdocta();
$edocta -> codigo = $_GET["codigo"];
$edocta -> traerImpresionEdocta();

?>