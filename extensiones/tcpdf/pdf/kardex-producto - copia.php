<?php
ob_clean();
set_time_limit(120);
date_default_timezone_set("America/Mexico_City");

require_once "../../../controladores/kardex-producto.controlador.php";
require_once "../../../modelos/kardex-producto.modelo.php";
//include "../../../config/parametros.php";

/*
include ('Numbers/Words.php');
*/

class imprimirKardex{

public $numKardex;

 public function traerImpresionKardex(){

	//TRAEMOS LA INFORMACIÓN DE LA VENTA
	$fechaHoy=date("d-m-Y");
	$campo="id_producto";
	$idalmacen = $_GET["almacensel"];
	$nomalmacen = $_GET["nomalmacen"];
	$idproducto = $_GET["productosel"];
	//$nomproducto = $_GET["nomproducto"];
	$fechainicial = $_GET["fechasel"];
	$datecurrent = date("d-m-Y", strtotime($fechainicial));	

	//PARAMETROS DE ENCABEZADO DEL REPORTE
	$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
	$direccion=defined('DIRECCION')?DIRECCION:'SIN DATO DE DIRECCION';
	$colonia=defined('COLONIA')?COLONIA:'SIN DATO DE COLONIA';
	$ciudad=defined('CIUDAD')?CIUDAD:'SIN DATO DE CIUDAD';
	$telefono=defined('TELEFONO')?TELEFONO:'SIN DATO DE TELEFONO';
	$correo=defined('CORREO')?CORREO:'SIN DATO DE CORREO';

	//REQUERIMOS LA CLASE TCPDF
	require_once('tcpdf_include.php');

	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	$pdf->startPageGroup();

	$pdf->AddPage();
		
	// ---------------------------------------------------------
	//$respuesta = ControladorKardex::ctrEntradaKardex($campo, $idproducto, $idalmacen, $fechainicial);
	//$respuestaAlmacen=true;
	$respuesta = ControladorKardex::ctrTraerProduct($idproducto);
	if($respuesta){
		$nomproducto=$respuesta['codigointerno'].' - '.$respuesta['descripcion'];

		$bloque1 = <<<EOF

			<table>
				
				<tr style="width:485px">

					<td style="width:65px"><img src="../../../config/logotipo.png"></td>

					<td style="background-color:white; width:230px">
						
						<div style="font-size:8.5px; text-align:center; line-height:10px;">
							
							<br>
								$direccion, $colonia, $ciudad
						</div>

					</td>

					<td style="background-color:white; width:240px; padding-left:50px;">

						<div style="font-size:8.5px; text-align:center; line-height:10px;">
							
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

		// ------------------- ENTRADAS --------------------------------------
		$bloque2 = <<<EOF

		<h3 style="text-align:center; color:blue;">KARDEX DE PRODUCTO DEL $datecurrent AL $fechaHoy</h3>
			Producto: $nomproducto 
		<h4 style="text-align:center;" class="m-0 p-0">ENTRADAS POR COMPRAS</h4>
		EOF;

		$pdf->writeHTML($bloque2, false, false, false, false, '');
		$pdf->Ln(2);
	}else{
		// ------------------- FIN ENTRADAS --------------------------------------
		$bloque2 = <<<EOF
		<h3 style="text-align:center;" class="m-0 p-0">NO EXISTE PRODUCTO</h3>
		EOF;

		$pdf->writeHTML($bloque2, false, false, false, false, '');
		$pdf->Ln(2);

	};
	// ----------------------ENTRADAS POR COMPRAS DE PRODUCTOS-----------------------------------
	$respuesta1 = ControladorKardex::ctrEntradaKardex($campo, $idproducto, $idalmacen, $fechainicial);
	if($respuesta1){
	$bloque3 = <<<EOF

		<table style="font-size:9px; padding:5px 5px;">

		<tr bgcolor="#cccccc" class="text-center">
			<td style="border: 1px solid #666; width:70px; text-align:center">Fecha Entrada</td>
			<td style="border: 1px solid #666; width:105px; text-align:center;">Docto No.</td>
			<td style="border: 1px solid #666; width:110px; text-align:center">Recibio</td>
			<td style="border: 1px solid #666; width:45px; text-align:center">Cant</td>
			<td style="border: 1px solid #666; width:75px; text-align:center">Precio Compra</td>
			<td style="border: 1px solid #666; width:130px; text-align:center">Tipo de Mov</td>
		</tr>
		</table>

	EOF;

	$pdf->writeHTML($bloque3, false, false, false, false, '');
	$pdf->Ln(1);
	// ---------------------------------------------------------
	$cantEntra=0;
	foreach ($respuesta1 as $row) {
		$originalDate = $row['fechaentrada'];
		$fechaentrada = date("d-m-Y", strtotime($originalDate));	
		$bloque4 = <<<EOF

		<table style="font-size:8px; padding:5px 3px;">

		<tr>
		<td style="border: 1px solid #666; width:70px; text-align:center">$fechaentrada</td>
		<td style="border: 1px solid #666; width:105px; text-align:center">$row[numerodocto]</td>
		<td style="border: 1px solid #666; width:110px; text-align:left">$row[recibio]</td>
		<td style="border: 1px solid #666; width:45px; text-align:center">$row[cantidad]</td>
		<td style="border: 1px solid #666; width:75px; text-align:right">$row[precio_compra]</td>
		<td style="border: 1px solid #666; width:130px; text-align:left">$row[nombre_tipo]</td>
		</tr>

		</table>

		EOF;
		$cantEntra+=$row['cantidad'];
		$pdf->writeHTML($bloque4, false, false, false, false, '');
	};	//fin del Foreach

	// ---------------------------------------------------------
	$bloque15 = <<<EOF

	<table style="font-size:9px; padding:5px 3px;">

	<tr bgcolor="#cccccc">
		<td style="border: 1px solid #666; width:285px; text-align:right">Total Entrada:</td>
		<td style="border: 1px solid #666; width:45px; text-align:center">$cantEntra</td>
	</tr>

	</table>

	EOF;

	$pdf->writeHTML($bloque15, false, false, false, false, '');    
	$pdf->Ln(6);

	}else{

		$bloque12 = <<<EOF

				<h5 style="text-align:center;" class="m-0 p-0">NO EXISTEN ENTRADAS POR COMPRAS DESDE ESA FECHA</h5>

		EOF;
			
		$pdf->writeHTML($bloque12, false, false, false, false, '');    
		$pdf->Ln(6);	
	};
	// ---------------------------------------------------------------------------
	// ----------------------ENTRADAS POR AJUSTE DE PRODUCTOS-----------------------------------
	$tipomov="E";
	$cantEntraAjuste=0;
	$respAjusteEntrada = ControladorKardex::ctrMovtoAjuste($tipomov, $idalmacen, $fechainicial);
	if($respAjusteEntrada){
		$bloque33 = <<<EOF
			<h4 style="text-align:center;" class="m-0 p-0">ENTRADAS POR AJUSTES DE INVENTARIO</h4>
			<table style="font-size:9px; padding:5px 5px;">

			<tr bgcolor="#cccccc" class="text-center">
				<td style="border: 1px solid #666; width:70px; text-align:center">Fecha Ajuste</td>
				<td style="border: 1px solid #666; width:105px; text-align:center;">Motivo Ajuste.</td>
				<td style="border: 1px solid #666; width:110px; text-align:center">Capturó</td>
				<td style="border: 1px solid #666; width:45px; text-align:center">Cant</td>
				<td style="border: 1px solid #666; width:75px; text-align:right"># de Ajuste</td>
				<td style="border: 1px solid #666; width:130px; text-align:center">Tipo de Mov</td>
			</tr>
			</table>

		EOF;

	$pdf->writeHTML($bloque33, false, false, false, false, '');
	$pdf->Ln(1);
	// ---------------------------------------------------------
	foreach ($respAjusteEntrada as $row) {
		$idProd = (int) $idproducto;
		$originalDate = $row['fecha_ajuste'];
		$fechaajuste = date("d-m-Y", strtotime($originalDate));	
		$cantProducto=0;

		$datos_json=json_decode($row['datos_ajuste'],TRUE);

		foreach($datos_json as $valor) {
			$valorProducto = (int) $valor['id_producto'];
			if($valorProducto===$idProd) {
				$Producto = $valor['id_producto'];
				$cantProducto = $valor['cantidad'];
			};	
		};
		if($cantProducto>0){
			$bloque44 = <<<EOF

			<table style="font-size:8px; padding:5px 3px;">
			
			<tr>
			<td style="border: 1px solid #666; width:70px; text-align:center">$fechaajuste</td>
			<td style="border: 1px solid #666; width:105px; text-align:center">$row[motivo_ajuste]</td>
			<td style="border: 1px solid #666; width:110px; text-align:left">$row[nombre]</td>
			<td style="border: 1px solid #666; width:45px; text-align:center">$cantProducto</td>
			<td style="border: 1px solid #666; width:75px; text-align:center">$row[id]</td>
			<td style="border: 1px solid #666; width:130px; text-align:left">$row[nombre_tipo]</td>
			</tr>
			
			</table>
			
			EOF;
			$cantEntraAjuste+=$cantProducto;
			$pdf->writeHTML($bloque44, false, false, false, false, '');
		};
	};		//fin del Foreach

	// ---------------------------------------------------------
	$bloque55 = <<<EOF

	<table style="font-size:9px; padding:5px 3px;">

	<tr bgcolor="#cccccc">
		<td style="border: 1px solid #666; width:285px; text-align:right">Total Entrada por Ajuste:</td>
		<td style="border: 1px solid #666; width:45px; text-align:center">$cantEntraAjuste</td>
	</tr>

	</table>

	EOF;

	$pdf->writeHTML($bloque55, false, false, false, false, '');    
	$pdf->Ln(6);

	}else{

	$bloque52 = <<<EOF

			<h5 style="text-align:center;" class="m-0 p-0">NO EXISTEN AJUSTES DE ENTRADA DESDE ESA FECHA</h5>

	EOF;
		
	$pdf->writeHTML($bloque52, false, false, false, false, '');    
	$pdf->Ln(6);	
	};
	// ---------------------------------------------------------------------------

	// ------------------SALIDAS DE PRODUCTOS---------------------------------------
	$bloque7 = <<<EOF
		<h4 style="text-align:center;" class="m-0 p-0">SALIDAS POR VENTAS</h4>
	EOF;

	$pdf->writeHTML($bloque7, false, false, false, false, '');     
	$pdf->Ln(1);
	// ---------------------------------------------------------    
	$bloque8 = <<<EOF
	<table style="font-size:9px; padding:5px 5px;">

	<tr class="text-center">
	<td style="width:190px;"> </td>
	<td style="border: 1px solid #666; width:80px; text-align:center; background-color:#cccccc;">Fecha Salida</td>
	<td style="border: 1px solid #666; width:70px; text-align:center; background-color:#cccccc;">Cant.</td>
	</tr>
	</table>

	EOF;

	$pdf->writeHTML($bloque8, false, false, false, false, '');     
	$pdf->Ln(1);
	// ---------------------- SALIDAS--------------------------------------    
	$respuesta2 = ControladorKardex::ctrSalidaKardex($campo, $idproducto, $idalmacen, $fechainicial);

	$cantSal=0;
	foreach ($respuesta2 as $row) {
		$originalDate = $row['fecha_salida'];
		$fechasalida = date("d-m-Y", strtotime($originalDate));	
	$bloque9 = <<<EOF

	<table style="font-size:8px; padding:5px 3px;">
	<tr class="text-center">
	<td style="width:190px;"> </td>
	<td style="border: 1px solid #666; width:80px; text-align:center">$fechasalida</td>
	<td style="border: 1px solid #666; width:70px; text-align:center">$row[cant]</td>
	</tr>  
	</table>

	EOF;
	$pdf->writeHTML($bloque9, false, false, false, false, '');    
	$cantSal+=$row['cant']; 
	};
	// ---------------------------------------------------------    
	$bloque10 = <<<EOF

	<table style="font-size:9px; padding:5px 3px;">

	<tr>
		<td style="width:190px;"> </td>
		<td style="border: 1px solid #666; width:80px; text-align:right; background-color:#cccccc;">Total Salida:</td>
		<td style="border: 1px solid #666; width:70px; text-align:center; background-color:#cccccc;">$cantSal</td>
	</tr>

	</table>

	EOF;

	$pdf->writeHTML($bloque10, false, false, false, false, '');    
	$pdf->Ln(6);

	// ----------------------SALIDAS POR AJUSTE DE PRODUCTOS-----------------------------------
	$tipomov="S";
	$cantSalidaAjuste=0;
	$respAjusteSalida = ControladorKardex::ctrMovtoAjuste($tipomov, $idalmacen, $fechainicial);
	if($respAjusteSalida){
	$bloque33 = <<<EOF
		<h4 style="text-align:center;" class="m-0 p-0">SALIDAS POR AJUSTES DE INVENTARIO</h4>
		<table style="font-size:9px; padding:5px 5px;">

		<tr bgcolor="#cccccc" class="text-center">
			<td style="border: 1px solid #666; width:70px; text-align:center">Fecha Ajuste</td>
			<td style="border: 1px solid #666; width:105px; text-align:center;">Motivo Ajuste.</td>
			<td style="border: 1px solid #666; width:110px; text-align:center">Capturó</td>
			<td style="border: 1px solid #666; width:45px; text-align:center">Cant</td>
			<td style="border: 1px solid #666; width:75px; text-align:right"># de Ajuste</td>
			<td style="border: 1px solid #666; width:130px; text-align:center">Tipo de Mov</td>
		</tr>
		</table>

	EOF;

	$pdf->writeHTML($bloque33, false, false, false, false, '');
	$pdf->Ln(1);
	// ---------------------------------------------------------

	foreach ($respAjusteSalida as $row) {
		$idProd = (int) $idproducto;
		$originalDate = $row['fecha_ajuste'];
		$fechaajuste = date("d-m-Y", strtotime($originalDate));	
		$cantProducto=0;

		$datos_json=json_decode($row['datos_ajuste'],TRUE);

		foreach($datos_json as $valor) {
			$valorProducto = (int) $valor['id_producto'];
			if($valorProducto===$idProd) {
				$Producto = $valor['id_producto'];
				$cantProducto = $valor['cantidad'];
			};	
		};
		if($cantProducto>0){
			$bloque44 = <<<EOF

			<table style="font-size:8px; padding:5px 3px;">
			
			<tr>
			<td style="border: 1px solid #666; width:70px; text-align:center">$fechaajuste</td>
			<td style="border: 1px solid #666; width:105px; text-align:center">$row[motivo_ajuste]</td>
			<td style="border: 1px solid #666; width:110px; text-align:left">$row[nombre]</td>
			<td style="border: 1px solid #666; width:45px; text-align:center">$cantProducto</td>
			<td style="border: 1px solid #666; width:75px; text-align:center">$row[id]</td>
			<td style="border: 1px solid #666; width:130px; text-align:left">$row[nombre_tipo]</td>
			</tr>
			
			</table>
			
			EOF;
			$cantSalidaAjuste+=$cantProducto;
			$pdf->writeHTML($bloque44, false, false, false, false, '');
		};
	};		//fin del Foreach

	// ---------------------------------------------------------
	$bloque55 = <<<EOF

	<table style="font-size:9px; padding:5px 3px;">

	<tr bgcolor="#cccccc">
		<td style="border: 1px solid #666; width:285px; text-align:right">Total Salida por Ajuste:</td>
		<td style="border: 1px solid #666; width:45px; text-align:center">$cantSalidaAjuste</td>
	</tr>

	</table>

	EOF;

	$pdf->writeHTML($bloque55, false, false, false, false, '');    
	$pdf->Ln(6);

	}else{

	$bloque52 = <<<EOF

			<h5 style="text-align:center;" class="m-0 p-0">NO EXISTEN AJUSTES DE SALIDA DESDE ESA FECHA</h5>

	EOF;
		
	$pdf->writeHTML($bloque52, false, false, false, false, '');    
	$pdf->Ln(6);	
	};

	// -----------------------------------------------------------------------
	$respuesta3 = ControladorKardex::ctrTraerExist($campo, $idproducto, $nomalmacen);
	$existencia=$respuesta3['cant'];
	$bloque13 = <<<EOF
	<table style="font-size:14px; padding:5px 5px;">

	<tr class="text-center">
	<td style="width:100px;"> </td>
	<td style="border: 1px solid #666; width:230px; text-align:center; background-color:#cccccc;">Existencia Actual:</td>
	<td style="border: 1px solid #666; width:80px; text-align:center; background-color:#cccccc;">$existencia</td>
	</tr>
	</table>

	EOF;

	$pdf->writeHTML($bloque13, false, false, false, false, '');     
	$pdf->Ln(1);
	//--------------------------------------------------------------------------
	//SALIDA DEL ARCHIVO 
	$nombre_archivo="kardex".trim($fechaHoy).".pdf";   //genera el nombre del archivo para descargarlo
	ob_end_clean();
	$pdf->Output($nombre_archivo);
	if($respuesta2){

	}else{
	$pdf->Ln(6);
	$bloque11 = <<<EOF
	<table style="font-size:12px; padding:5px 5px;">
		<tr>
			<td style="border: 1px solid #666; width:540px; height:50px; text-align:center;">
				<h3> No existe información con los datos proporcionados. REVISE!!  </h3>
			</td>
		</tr>
	</table>
		
	EOF;
	$pdf->writeHTML($bloque11, false, false, false, false, ''); 
	// --------------------------------------------------------  
	ob_end_clean();
	$pdf->Output("kardex.pdf");
	};

 }	//FIN DEL METODO
};   // FIN DE LA CLASE

$kardex = new imprimirKardex();
$kardex -> numKardex = $_GET["almacensel"];
$kardex -> traerImpresionKardex();

?>

