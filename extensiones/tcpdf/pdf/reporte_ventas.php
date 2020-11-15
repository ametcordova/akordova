<?php
ob_clean();
set_time_limit(60);
require_once "../../../controladores/reportedeventas.controlador.php";
require_once "../../../modelos/reportedeventas.modelo.php";

require_once "../../../controladores/tipomov.controlador.php";
require_once "../../../modelos/tipomov.modelo.php";

//include "../../../config/parametros.php";

// 540 max de la fila P y 745 L

class imprimirVentaxDia{

//public $nameAlma;
//public $nameFami;

public function traerImpresionVentaxdia(){

$directorio=getcwd();
$nombre_archivo="reporteventas.pdf";   //genera el nombre del archivo para descargarlo
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
$imagen=defined('IMAGEN')?'../../../'.IMAGEN:'../../../config/imagenes/logotipoempresa.png';

//TRAEMOS LA INFORMACIÓN 
$tabla=$_GET["idNumAlma"];
$almacen=$_GET["idNomAlma"];
$campoFam = "id_familia";
$claveFam = $_GET["idNumFam"];
$fechaVta1 = $_GET["idFechVta1"];
$fechaVta2 = $_GET["idFechVta2"];
$idNumCaja = $_GET["idNumCaja"];
$idNumCliente = $_GET["idNumCliente"];
$idNumProds = $_GET["idNumProds"];
$idTipoMovs = $_GET["idTipoMovs"];

//si es interno es true, se visualiza en pantalla
if(isset($_GET["interno"])){
	$interno=true;
}else{
	$interno=false;
}

//CAMBIAR EL FORMATO DE FECHA A yyyy-mm-dd Y SI ESTA VACIA TOMA FECHA ACTUAL
$fechavta1 = explode('-', $fechaVta1);
$fechavta2 = explode('-', $fechaVta2);
if(count($fechavta1) == 3){
  $fecha1 = $fechavta1[2].'-'.$fechavta1[1].'-'.$fechavta1[0];
  $fecha2 = $fechavta2[2].'-'.$fechavta2[1].'-'.$fechavta2[0];
}

//TRAER LOS DATOS DEL ALMACEN SELECCIONADO
$respuestaVentaxdia = ControladorVentas::ctrReporteVentas($tabla, $campoFam, $claveFam, $fechaVta1, $fechaVta2, $idNumCaja,$idNumCliente, $idNumProds, $idTipoMovs);

//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');

$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->startPageGroup();

$pdf->AddPage();
    
// ---------------------------------------------------------<td style="width:65px"><img src="../../../config/logotipo.png"></td>

$bloque1 = <<<EOF

	<table>
		
		<tr>
    
			<td style="width:65px"><img src="$imagen"></td>


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

if($respuestaVentaxdia){ 
	$idNumCliente = (int) $idNumCliente;
	if($idNumCliente>0){
		$nomclie=$respuestaVentaxdia[0]['cliente'];
	}else{
		$nomclie="TODOS";		
	}
	$idNumCaja=$idNumCaja>0?$idNumCaja:"TODOS";
	
// ---------------------------------------------------------
$bloque2 = <<<EOF
<table>
	<tr>
		<td style="background-color:white; width:250px">
			<h5>Reporte de Venta del $fecha1 al $fecha2 </h5>
		</td>
		<td style="background-color:white; width:180px">
			<h5>Almacen: $almacen </h5>
		</td>
		<td style="background-color:white; width:130px">
			<h5>Caja: $idNumCaja </h5>
		</td>
		<td style="background-color:white; width:150px">
			<h5>Cliente: $nomclie </h5>
		</td>

	</tr>

</table>		
    <!-- <h3 style="text-align:left; width:800px">Reporte de Venta del $fecha1 al $fecha2 </h3>-->

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->Ln(2);
// ---------------------------------------------------------
/*
$tabla="tipomovimiento";
$item="id";
$idtipomov=$respuestaVentaxdia[0]['id_tipomov'];

$respuesta = ControladorMovto::ctrMostrarTipoMov($tabla, $item, $idtipomov);
$nombretipomov=$respuesta[1];

// ---------------------------------------------------------
	$bloque3 = <<<EOF
	<h6>$nombretipomov</h6>	
	 <table style="font-size:10px; padding:3px 3px;">
	  <tr bgcolor="#cccccc" class="text-center">
		<td style="border: 1px solid #666; width:80px; text-align:center">Familia</td>
		<td style="border: 1px solid #666; width:90px; text-align:center">Categoría</td>
		<td style="border: 1px solid #666; width:80px; text-align:center;">Código</td>
		<td style="border: 1px solid #666; width:180px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; width:60px; text-align:center">U.Med.</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">Cant</td>
		<td style="border: 1px solid #666; width:45px; text-align:center">Costo</td>
		<td style="border: 1px solid #666; width:53px; text-align:center">Tot. Cto.</td>
		<td style="border: 1px solid #666; width:53px; text-align:center">Venta</td>
		<td style="border: 1px solid #666; width:53px; text-align:center">Promo</td>
		<td style="border: 1px solid #666; width:55px; text-align:center">Total Vta.</td>
     </tr>
	</table>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
*/
$cantvta=$granTotal=$totalsinpromo=$totalconpromo=$totcosto=$totalcosto=0;

$tabla="tipomovimiento";
$item="id";
$idtipomovIni=$i=$itera=0;
foreach ($respuestaVentaxdia as $row) {

// ---------------------------------------------------------
$idtipomov=$respuestaVentaxdia[$i]['id_tipomov'];

if($idtipomov<>$idtipomovIni){
if($itera>0){		//bandera para que no entre si es primera vez
// ---------------------------------------------------------
$dif=number_format($granTotal-$totalcosto,2,".",",");
$totalcosto=number_format($totalcosto,2,".",",");
$totalsinpromo=number_format($totalsinpromo,2,".",",");
$totalconpromo=number_format($totalconpromo,2,".",",");
$granTotal=number_format($granTotal,2,".",",");

$bloque6 = <<<EOF

	<table style="font-size:8.5px; padding:5px 3px;">

	<tr bgcolor="#cccccc">
		<td style="border: 1px solid #666; width:490px; text-align:right">Totales:</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">$cantvta</td>
		<td style="border: 1px solid #666; width:45px; text-align:right"></td>
		<td style="border: 1px solid #666; width:53px; text-align:right">$$totalcosto</td>
		<td style="border: 1px solid #666; width:53px; text-align:right">$$totalsinpromo</td>
		<td style="border: 1px solid #666; width:53px; text-align:right">$$totalconpromo</td>
		<td style="border: 1px solid #666; width:55px; text-align:right">$$granTotal</td>
    </tr>
	<tr>
		<td style="font-size:10px; border: 1px solid #666; background-color:#A9BCF5; width:490px; text-align:right">Diferencia:</td>
		<td style="font-size:10px; border: 1px solid #666; background-color:#81BEF7; width:294px; text-align:center">$$dif</td>
	</tr>
  
 	</table>

EOF;
$pdf->writeHTML($bloque6, false, false, false, false, '');    
$pdf->Ln(6);
$dif=0;
$totalcosto=0;
$totalsinpromo=0;
$totalconpromo=0;
$granTotal=0;
$cantvta=0;
/*====================================================================================================================== */	
}	
	$respuesta = ControladorMovto::ctrMostrarTipoMov($tabla, $item, $idtipomov);
	$nombretipomov=$respuesta[1];
	$idtipomovIni=$idtipomov;
// ---------------------------------------------------------
$bloque3 = <<<EOF
<h6>$nombretipomov</h6>	
 <table style="font-size:10px; padding:3px 3px;">
  <tr bgcolor="#cccccc" class="text-center">
	<td style="border: 1px solid #666; width:80px; text-align:center">Familia</td>
	<td style="border: 1px solid #666; width:90px; text-align:center">Categoría</td>
	<td style="border: 1px solid #666; width:80px; text-align:center;">Código</td>
	<td style="border: 1px solid #666; width:180px; text-align:center">Producto</td>
	<td style="border: 1px solid #666; width:60px; text-align:center">U.Med.</td>
	<td style="border: 1px solid #666; width:35px; text-align:center">Cant</td>
	<td style="border: 1px solid #666; width:45px; text-align:center">Costo</td>
	<td style="border: 1px solid #666; width:53px; text-align:center">Tot. Cto.</td>
	<td style="border: 1px solid #666; width:53px; text-align:center">Venta</td>
	<td style="border: 1px solid #666; width:53px; text-align:center">Promo</td>
	<td style="border: 1px solid #666; width:55px; text-align:center">Total Vta.</td>
 </tr>
</table>
EOF;
$itera=1;
$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------

}

$sumaconpromo="";
$totcosto=number_format($row['precio_compra']*$row['cant'],2,".",",");
$sumatotal=number_format($row['promo']+$row['sinpromo'],2,".",",");
$sumasinpromo=number_format($row["sinpromo"],2,".",",");
if($row["promo"]>0){
	$sumaconpromo="$".number_format($row["promo"],2,".",",");
}

/* ========================================================================*/
$bloque4 = <<<EOF
 	<table style="font-size:8px; padding:3px 3px;">

	  <tr>
		<td style="border: 1px solid #666; width:80px; text-align:center">$row[familia]</td>
		<td style="border: 1px solid #666; width:90px; text-align:center">$row[categoria]</td>
		<td style="border: 1px solid #666; width:80px; text-align:left">$row[codigointerno]</td>
		<td style="border: 1px solid #666; width:180px; text-align:left">$row[descripcion]</td>
		<td style="border: 1px solid #666; width:60px; text-align:center">$row[medida]</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">$row[cant]</td>
		<td style="border: 1px solid #666; width:45px; text-align:right">$$row[precio_compra]</td>
		<td style="border: 1px solid #666; background-color:#A9F5BC; width:53px; text-align:right">$$totcosto</td>
		<td style="border: 1px solid #666; width:53px; text-align:right">$$sumasinpromo</td>
		<td style="border: 1px solid #666; width:53px; text-align:right">$sumaconpromo</td>
		<td style="border: 1px solid #666; background-color:#81F7D8; width:55px; text-align:right">$$sumatotal</td>
	  </tr>
     
 	</table>

EOF;
$cantvta+=$row['cant'];
$totalsinpromo+=$row['sinpromo'];
$totalconpromo+=$row['promo'];
$granTotal+=$row['promo']+$row['sinpromo'];
$totalcosto+=$row['precio_compra']*$row['cant'];
$i++;
$pdf->writeHTML($bloque4, false, false, false, false, '');
}	// fin del foreach
/* ========================================================================*/

// ---------------------------------------------------------
$dif=number_format($granTotal-$totalcosto,2,".",",");
$totalcosto=number_format($totalcosto,2,".",",");
$totalsinpromo=number_format($totalsinpromo,2,".",",");
$totalconpromo=number_format($totalconpromo,2,".",",");
$granTotal=number_format($granTotal,2,".",",");

$bloque6 = <<<EOF

	<table style="font-size:8.5px; padding:5px 3px;">

	<tr bgcolor="#cccccc">
		<td style="border: 1px solid #666; width:490px; text-align:right">Totales:</td>
		<td style="border: 1px solid #666; width:35px; text-align:center">$cantvta</td>
		<td style="border: 1px solid #666; width:45px; text-align:right"></td>
		<td style="border: 1px solid #666; width:53px; text-align:right">$$totalcosto</td>
		<td style="border: 1px solid #666; width:53px; text-align:right">$$totalsinpromo</td>
		<td style="border: 1px solid #666; width:53px; text-align:right">$$totalconpromo</td>
		<td style="border: 1px solid #666; width:55px; text-align:right">$$granTotal</td>
    </tr>
	<tr>
		<td style="font-size:10px; border: 1px solid #666; background-color:#A9BCF5; width:490px; text-align:right">Diferencia:</td>
		<td style="font-size:10px; border: 1px solid #666; background-color:#81BEF7; width:294px; text-align:center">$$dif</td>
	</tr>
  
 	</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');    
$pdf->Ln(6);
/*====================================================================================================================== */
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
 
 //$nombre_archivo="ventadia".$fecha_elabora.".pdf";   //genera el nombre del archivo para descargarlo
 
	if($interno){
		ob_end_clean();
		$pdf->Output($directorio. '/' .$nombre_archivo,'F');
		//$pdf->Output('c:/xampp/htdocs/modelorama/extensiones/tcpdf/pdf/ventadia.pdf','F');
	}else{
		ob_end_clean();
		$pdf->Output($nombre_archivo);
	}
}else{
// ---------------------------------------------------------
$pdf->Ln(6);

$bloque7 = <<<EOF
     
	<table style="font-size:12px; padding:5px 5px;">

    <tr>
        <td style="border: 1px solid #666; width:780px; height:50px; text-align:center;">
			<h3> No existe información con los datos proporcionados. REVISE!! </h3>
        </td>
    </tr>

 	</table>

EOF;

$pdf->writeHTML($bloque7, false, false, false, false, ''); 
// ---------------------------------------------------------        
  
  	if($interno){
		ob_end_clean();
		$pdf->Output($directorio. '/' .$nombre_archivo,'F');
	}else{
ob_end_clean();
$pdf->Output($nombre_archivo, 'I');
	}

}
}

}

$ventaxdia = new imprimirVentaxDia();
//$inventario -> nameAlma = $_GET["idNomAlma"];
//$inventario -> nameFami = $_GET["idNumFam"];
$ventaxdia -> traerImpresionVentaxdia();

//FUNCTION PARA MOSTRAR LA FECHA EN ESPAÑOL Y DE MEXICO
function fechaHoraMexico($timestamp) {
    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");
    $hora = strftime("%I:%M:%S %p", strtotime($timestamp)); //Descomentar en caso de requerir hora
    setlocale(LC_TIME, 'spanish');
    $fecha = utf8_encode(strftime("%A %d de %B del %Y", strtotime($timestamp)));
    return ($fecha.' '.$hora);//$hora; concatenar con fecha para obtener fecha y hora
}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
?>

