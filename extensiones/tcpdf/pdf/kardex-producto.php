<?php
ob_clean();
set_time_limit(120);
date_default_timezone_set("America/Mexico_City");

require_once "../../../controladores/kardex-producto.controlador.php";
require_once "../../../modelos/kardex-producto.modelo.php";

//include "../../../config/parametros.php";

class imprimirKardex{

public $numKardex;

 public function traerImpresionKardex(){
	
	$pdo=getPDO();
	//TRAEMOS LA INFORMACIÓN DE LA VENTA
	$fechaHoy=date("d-m-Y");
	$campo="id_producto";
	$idalmacen = $_GET["almacensel"];
	$almacen = trim($_GET["nomalmacen"]);
	$nomalmacen = trim(strtolower($_GET["nomalmacen"]));
	$idproducto = intval($_GET["productosel"]);
	//$nomproducto = $_GET["nomproducto"];
	$fechainicial = $_GET["fechaselIni"];
	$fechafinal = $_GET["fechaselFin"];
	$dateini = date("d-m-Y", strtotime($fechainicial));	
	$datefin = date("d-m-Y", strtotime($fechafinal));	

	//PARAMETROS DE ENCABEZADO DEL REPORTE
	$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
	$direccion=defined('DIRECCION')?DIRECCION:'SIN DATO DE DIRECCION';
	$colonia=defined('COLONIA')?COLONIA:'SIN DATO DE COLONIA';
	$ciudad=defined('CIUDAD')?CIUDAD:'SIN DATO DE CIUDAD';
	$telefono=defined('TELEFONO')?TELEFONO:'SIN DATO DE TELEFONO';
	$correo=defined('CORREO')?CORREO:'SIN DATO DE CORREO';
// Page footer

	//REQUERIMOS LA CLASE TCPDF
	require_once('tcpdf_include.php');


	$pdf = new TCPDF('L', PDF_UNIT, 'LETTER', true, 'UTF-8', false);

	// set auto page breaks
	//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->SetAutoPageBreak(TRUE, 15);
	$pdf->SetFooterMargin(8);		//para que salga el numero de paginas
	$pdf->startPageGroup();
	$pdf->AddPage();
		
/*---------------------------------------------------------*/
	$respuesta = ControladorKardex::ctrTraerProduct($idproducto);
	if($respuesta){
		$nomproducto=substr($respuesta['id'].'-'.$respuesta['codigointerno'].' - '.$respuesta['descripcion'],0,45);

$bloque1 = <<<EOF

	<table>
				
				<tr style="width:800px">

					<td style="width:60px"><img src="../../../config/logotipo.png"></td>

					<td style="background-color:white; width:350px">
						
						<div style="font-size:8.5px; text-align:center; line-height:10px;">
							
								$direccion, $colonia, $ciudad
						</div>

					</td>

					<td style="background-color:white; width:350px; padding-left:50px;">

						<div style="font-size:8.5px; text-align:center; line-height:10px;">
							
							Teléfono: $telefono   email: $correo
							<br>
						</div>
						
					</td>
					<br>

					<td style="background-color:white; width:800px">
						<div style="font-size:20px; color:red; text-align:center; line-height:55px;">
						$razonsocial
						</div>
					</td>
					
				</tr>

	</table>

EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');
$pdf->Ln(-16);
//-------------------------------------------------------------------------------------
$existanterior=0;
//$nombremes_anterior =strtolower(date('F', strtotime($fechainicial.'-1 month')));
// $sql="SELECT $nombremes_anterior FROM kardex WHERE id_producto='".$idproducto."'";
// $query = $pdo->prepare($sql);
// $query->execute();
// $rsp = $query->fetch(PDO::FETCH_ASSOC);
// $existanterior=$rsp[$nombremes_anterior];
$existanterior=saberExistencia($fechainicial, $idalmacen, $idproducto);
//--------------------------------------------------------------------------------------
//-------------------ENTRADAS--------------------------------------
$bloque2 = <<<EOF
	<div style="text-align:left;">
		<h4 style="text-align:center; color:blue;">Kardex del $dateini al $datefin del Almacen  $almacen</h4>
	</div>	
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->Ln(-4);
}else{
//------------------- FIN ENTRADAS --------------------------------------
$bloque2 = <<<EOF
	<h3 style="text-align:center;" class="m-0 p-0">NO EXISTE PRODUCTO</h3>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
$pdf->Ln();
};
//------------------ENTRADAS POR COMPRAS DE PRODUCTOS--------------------------------
$bloque3 = <<<EOF
	<table style="font-size:9.5px; padding:3px 2px;">
		<tr bgcolor="#cccccc" class="text-center">
			<td style="border: 1px solid #666; width:295px; height:15px; text-align:left; color:#034E74">PRODUCTO: $nomproducto</td>
			<td style="border: 1px solid #666; width:110px; height:15px; text-align:center; color:#02630B;">EXIST. ANT. $existanterior</td>
			<td style="border: 1px solid #666; width:110px; height:15px; text-align:center">ENTRADAS</td>
			<td style="border: 1px solid #666; width:110px; height:15px; text-align:center">SALIDAS</td>
			<td style="border: 1px solid #666; width:115px; height:15px; text-align:center">SALDOS</td>
		</tr>
	</table>

	<table style="font-size:9px; padding:3px 2px;">
		<tr bgcolor="#cccccc" class="text-center">
			<td style="border: 1px solid #666; width:65px; height:10px; text-align:center;">Fecha Movto.</td>
			<td style="border: 1px solid #666; width:100px; height:10px; text-align:center;">Docto No.</td>
			<td style="border: 1px solid #666; width:130px; height:10px; text-align:center">Tipo de Mov</td>
			<td style="border: 1px solid #666; width:110px; height:10px; text-align:center">Usuario</td>
			<td style="border: 1px solid #666; width:40px; height:10px; text-align:center">Cant</td>
			<td style="border: 1px solid #666; width:70.5px; height:10px; text-align:center">Precio Compra</td>
			<td style="border: 1px solid #666; width:40px; height:10px; text-align:center">Cant</td>
			<td style="border: 1px solid #666; width:70px; height:10px; text-align:center">Precio Venta</td>
			<td style="border: 1px solid #666; width:45px; height:10px; text-align:center">Exist.</td>
			<td style="border: 1px solid #666; width:69.5px; height:10px; text-align:center">Total</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque3, false, false, false, false, '');
$pdf->Ln(1);
//--------------------------------------------------------------------------------------
$nuevaexistencia=0;
for($i=$fechainicial;$i<=$fechafinal;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
$datemov=date("d-m-Y", strtotime($i));
//------------------ SUMAR ENTRADAS POR COMPRAS ---------------------------------------
$sql="SELECT *, tm.nombre_tipo FROM hist_entrada he
INNER JOIN tipomovimiento tm ON he.id_tipomov=tm.id
WHERE id_producto='".$idproducto."' and id_almacen='".$idalmacen."'  and fechaentrada='".$i."' ORDER BY fechaentrada ASC";
$query = $pdo->prepare($sql);
$query->execute();
$rsp = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($rsp as $row) {
$cant=$row["cantidad"];
$nuevaexistencia=$existanterior+$cant;
$totcompra=$totventa=number_format($row["cantidad"]*$row['precio_compra'],2,'.',',');
$bloque4 = <<<EOF

 	<table style="font-size:8px; padding:3px 2px;">
	  <tr >
		<td style="border: 1px solid #666; width:65px; text-align:center">$datemov</td>
		<td style="border: 1px solid #666; width:100px; text-align:center">$row[numerodocto]</td>
		<td style="border: 1px solid #666; width:130px; text-align:center">$row[nombre_tipo]</td>
		<td style="border: 1px solid #666; width:110px; text-align:center">$row[recibio]</td>
		<td style="border: 1px solid #666; width:40px; text-align:center">$cant</td>
		<td style="border: 1px solid #666; width:70px; text-align:right">$$row[precio_compra]</td>
		<td style="border: 1px solid #666; width:40px; text-align:center"></td>
		<td style="border: 1px solid #666; width:70px; text-align:center"></td>
		<td style="border: 1px solid #666; width:45px; text-align:center">$nuevaexistencia</td>
		<td style="border: 1px solid #666; width:70px; text-align:right">$$totcompra</td>
      </tr>
 	</table>
EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');
$pdf->Ln(.7);
$existanterior=$nuevaexistencia;
}	//fin del FOREACH DE ENTRADAS
/*----------------------------------- CALCULAR ENTRADAS POR AJUSTE DE INV -----------------------------------------------*/
$sql = "SELECT ai.id, ai.fecha_ajuste, ai.tipomov, tm.nombre_tipo, ai.id_almacen, ai.datos_ajuste, ai.id_usuario,us.nombre 
FROM ajusteinventario ai
INNER JOIN tipomovimiento tm ON ai.tipomov=tm.id 
INNER JOIN usuarios us ON ai.id_usuario=us.id
WHERE ai.fecha_ajuste='".$i."'  AND ai.id_almacen='".$idalmacen."' AND ai.tipomov IN (2,7,8)";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($arr as $datos) {
$id=$datos['id'];
$datos_json=json_decode($datos['datos_ajuste'],TRUE);		//decodifica los datos JSON 
foreach($datos_json as $valor) {
	
$idprod=intval($valor['id_producto']);
if($idprod==$idproducto){
	$cant=$valor['cantidad'];
	$nuevaexistencia=$existanterior+$cant;

$bloque4 = <<<EOF
	<table style="font-size:8px; padding:3px 2px;">
   
		 <tr >
		   <td style="border: 1px solid #666; width:65px; text-align:center">$datemov</td>
		   <td style="border: 1px solid #666; width:100px; text-align:center">$id</td>
		   <td style="border: 1px solid #666; width:130px; text-align:center">$datos[nombre_tipo]</td>
		   <td style="border: 1px solid #666; width:110px; text-align:center">$datos[nombre]</td>
		   <td style="border: 1px solid #666; width:40px; text-align:center">$cant</td>
		   <td style="border: 1px solid #666; width:70px; text-align:right"></td>
		   <td style="border: 1px solid #666; width:40px; text-align:center"></td>
		   <td style="border: 1px solid #666; width:70px; text-align:center"></td>
		   <td style="border: 1px solid #666; width:45px; text-align:center">$nuevaexistencia</td>
		   <td style="border: 1px solid #666; width:70px; text-align:right"></td>
		 </tr>
		
	</table>
EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');
$pdf->Ln(.7);		
$existanterior=$nuevaexistencia;
}
}
}
/*----------------------------------- FIN DE CALCULAR ENTRADAS POR AJUSTE DE INV -------------------------------------------*/

//-------------------------------- CANCELACIONES DE VENTA -----------------------------------------------------------
$sql="SELECT cv.*,us.nombre FROM cancela_venta cv 
INNER JOIN usuarios us ON cv.ultusuario=us.id
WHERE cv.id_producto='".$idproducto."' AND cv.id_almacen='".$idalmacen."' AND 
DATE_FORMAT(cv.ultmodificacion,'%Y-%m-%d')='".$i."' ORDER BY cv.ultmodificacion ASC";
$querysal = $pdo->prepare($sql);
$querysal->execute();
$rsp2 = $querysal->fetchAll(PDO::FETCH_ASSOC);
foreach ($rsp2 as $row) {
$cant=$row["cantidad"];
$nuevaexistencia=$existanterior+$row["cantidad"];
$totcancela=number_format($row["cantidad"]*$row['precio_venta'],2,'.',',');
$datemov=date("d-m-Y", strtotime($i));
$datecan=date("d-m-Y", strtotime($row['fecha_salida']));
$bloque4 = <<<EOF

 	<table style="font-size:8px; padding:3px 2px;">

	  <tr >
		<td style="border: 1px solid #666; width:65px; text-align:center">$datemov</td>
		<td style="border: 1px solid #666; width:100px; text-align:center">$row[num_salida] / $row[num_cancelacion]</td>
		<td style="border: 1px solid #666; width:130px; text-align:center">CANCELACION - FV.$datecan</td>
		<td style="border: 1px solid #666; width:110px; text-align:center">$row[nombre]</td>
		<td style="border: 1px solid #666; width:40px; text-align:center">$cant</td>
		<td style="border: 1px solid #666; width:70px; text-align:right">$$row[precio_venta]</td>
		<td style="border: 1px solid #666; width:40px; text-align:center"></td>
		<td style="border: 1px solid #666; width:70px; text-align:center"></td>
		<td style="border: 1px solid #666; width:45px; text-align:center">$nuevaexistencia</td>
		<td style="border: 1px solid #666; width:70px; text-align:right">$$totcancela</td>
      </tr>
     
 	</table>

EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');
$pdf->Ln(.7);
$existanterior=$nuevaexistencia;
}	//fin del FOREACH DE CANCELACIONES
/*---------------------------------------------------------------------------------------*/
//--------------------------------TICKETS DE VENTA -----------------------------------------------------------
$sql="SELECT hs.fecha_salida, hs.id_producto, hs.num_salida, hs.id_tipomov, tm.nombre_tipo, hs.ultusuario, us.nombre, hs.cantidad, hs.precio_venta, hs.id_almacen FROM hist_salidas hs 
INNER JOIN tipomovimiento tm ON hs.id_tipomov=tm.id 
INNER JOIN usuarios us ON hs.ultusuario=us.id
WHERE hs.id_producto='".$idproducto."' AND hs.id_almacen='".$idalmacen."' AND hs.fecha_salida='".$i."' ORDER BY hs.fecha_salida ASC";
$querysal = $pdo->prepare($sql);
$querysal->execute();
$rsp2 = $querysal->fetchAll(PDO::FETCH_ASSOC);
foreach ($rsp2 as $row) {
$cant=$row["cantidad"];
$nuevaexistencia=$existanterior-$row["cantidad"];
$totventa=number_format($row["cantidad"]*$row['precio_venta'],2,'.',',');
$bloque4 = <<<EOF

 	<table style="font-size:8px; padding:3px 2px;">

	  <tr >
		<td style="border: 1px solid #666; width:65px; text-align:center">$datemov</td>
		<td style="border: 1px solid #666; width:100px; text-align:center">$row[num_salida]</td>
		<td style="border: 1px solid #666; width:130px; text-align:center">$row[nombre_tipo]</td>
		<td style="border: 1px solid #666; width:110px; text-align:center">$row[nombre]</td>
		<td style="border: 1px solid #666; width:40px; text-align:center"></td>
		<td style="border: 1px solid #666; width:70px; text-align:center"></td>
		<td style="border: 1px solid #666; width:40px; text-align:center">$cant</td>
		<td style="border: 1px solid #666; width:70px; text-align:right">$$row[precio_venta]</td>
		<td style="border: 1px solid #666; width:45px; text-align:center">$nuevaexistencia</td>
		<td style="border: 1px solid #666; width:70px; text-align:right">$$totventa</td>
      </tr>
     
 	</table>

EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');
$pdf->Ln(.7);
$existanterior=$nuevaexistencia;
}	//fin del FOREACH DE TICKETS DE VENTA
/*---------------------------------------------------------------------------------------*/
/*CALCULAR SALIDAS POR AJUSTE DE INV  */
$sql = "SELECT ai.id, ai.fecha_ajuste, ai.tipomov, tm.nombre_tipo, ai.id_almacen, ai.datos_ajuste, ai.id_usuario,us.nombre 
FROM ajusteinventario ai
INNER JOIN tipomovimiento tm ON ai.tipomov=tm.id 
INNER JOIN usuarios us ON ai.id_usuario=us.id
WHERE ai.fecha_ajuste='".$i."'  AND ai.id_almacen='".$idalmacen."' AND ai.tipomov IN (1,3,4,5,6)";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($arr as $datos) {
$id=$datos['id'];
$datos_json=json_decode($datos['datos_ajuste'],TRUE);		//decodifica los datos JSON 
foreach($datos_json as $valor) {
	
$idprod=intval($valor['id_producto']);
if($idprod==$idproducto){
	$cant=$valor['cantidad'];
	$nuevaexistencia=$existanterior-$cant;

$bloque4 = <<<EOF
	<table style="font-size:8px; padding:3px 2px;">
   	 <tr >
	   <td style="border: 1px solid #666; width:65px; text-align:center">$datemov</td>
	   <td style="border: 1px solid #666; width:100px; text-align:center">$id</td>
	   <td style="border: 1px solid #666; width:130px; text-align:center">$datos[nombre_tipo]</td>
	   <td style="border: 1px solid #666; width:110px; text-align:center">$datos[nombre]</td>
	   <td style="border: 1px solid #666; width:40px; text-align:center"></td>
	   <td style="border: 1px solid #666; width:70px; text-align:right"></td>
	   <td style="border: 1px solid #666; width:40px; text-align:center">$cant</td>
	   <td style="border: 1px solid #666; width:70px; text-align:center"></td>
	   <td style="border: 1px solid #666; width:45px; text-align:center">$nuevaexistencia</td>
	   <td style="border: 1px solid #666; width:70px; text-align:right"></td>
	 </tr>
	</table>
EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');
$pdf->Ln(.7);		
$existanterior=$nuevaexistencia;
}
}
}
/*--------------------------------------------------------------------------------------*/


}   //fin del FOR de FECHAS
//--------------------------------------------------------------------------
//SALIDA DEL ARCHIVO 
$nombre_archivo="kardex".trim($fechaHoy).".pdf";   //genera el nombre del archivo para descargarlo
ob_end_clean();
$pdf->Output($nombre_archivo);
$pdf->Ln(6);
//--------------------------------------------------------  
ob_end_clean();
$pdf->Output("kardex.pdf");

}	//FIN DEL METODO
};   // FIN DE LA CLASE

$kardex = new imprimirKardex();
$kardex -> numKardex = $_GET['almacensel'];
$kardex -> traerImpresionKardex();

/*------------------------------------------------------------------------------ */
// FUNCION PARA SACAR LA EXISTENCIA HASTA LA FECHA INICIAL
/*------------------------------------------------------------------------------ */
function saberExistencia($fechInicial, $idbodega, $idprod){
$pdo=getPDO();
$existenceprevious=0;

$nombremes_anterior =strtolower(date('F', strtotime($fechInicial.'-1 month')));
$primer_dia_mes=date("Y-m-d",strtotime($fechInicial.'first day of this month'));
$dia_anterior=date('Y-m-d', strtotime($fechInicial.'-1 day'));

$es_enero=date('m-d', strtotime($fechInicial));
$es_el_primer_dia=date('d', strtotime($fechInicial));

//si la fecha es el 01/01 entonces tome saldo de invinicial
if($nombremes_anterior=='december'){
	$nombremes_anterior='invinicial';
}

//si es primer dia de enero o el primer dia del mes, la fecha inicial será el primer día
if($es_enero=='01-01' OR $es_el_primer_dia=='01'){
	$dia_anterior=$primer_dia_mes;
}


$sql="SELECT $nombremes_anterior FROM kardex WHERE id_producto='".$idprod."'";
$query = $pdo->prepare($sql);
$query->execute();
$rsp = $query->fetch(PDO::FETCH_ASSOC);
if($rsp){
	$existenceprevious=$rsp[$nombremes_anterior];
}
if($existenceprevious>0){
	/*----------------------------------- SUMAR ENTRADAS POR COMPRAS -----------------------------------------------*/		
	$sql="SELECT SUM(cantidad) AS cantidad FROM hist_entrada WHERE id_producto='".$idprod."' and id_almacen='".$idbodega."' AND fechaentrada>='".$primer_dia_mes."' AND fechaentrada<='".$dia_anterior."' ";
	$query = $pdo->prepare($sql);
	$query->execute();
	$rsp = $query->fetch(PDO::FETCH_ASSOC);
	if($rsp){
		$cant=$rsp["cantidad"];
		$existenceprevious=$existenceprevious+$cant;
	}
	/*----------------------------------- FIN DE SUMAR ENTRADAS POR COMPRAS -----------------------------------------------*/		

	/* -------------------------------- CANCELACIONES DE VENTA -----------------------------------------------------------*/
	$sql="SELECT SUM(cantidad) AS cantidad FROM cancela_venta  
	WHERE id_producto='".$idprod."' AND id_almacen='".$idbodega."' AND 
	DATE_FORMAT(ultmodificacion,'%Y-%m-%d')>='".$primer_dia_mes."' AND DATE_FORMAT(ultmodificacion,'%Y-%m-%d')<='".$dia_anterior."' ORDER BY ultmodificacion ASC";
	$querysal = $pdo->prepare($sql);
	$querysal->execute();
	$rsp2 = $querysal->fetch(PDO::FETCH_ASSOC);
	if($rsp2){
		$existenceprevious=$existenceprevious+$rsp2["cantidad"];
	}

	/*-----------------------------  FIN DE CANCELACIONES DE VENTA-----------------------------------------------------------*/

	/*----------------------------------- CALCULAR ENTRADAS POR AJUSTE DE INV -----------------------------------------------*/
	$sql = "SELECT datos_ajuste FROM ajusteinventario WHERE fecha_ajuste>='".$primer_dia_mes."' AND fecha_ajuste<='".$dia_anterior."' AND  id_almacen='".$idbodega."' AND tipomov IN (2,7,8)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($arr as $datos) {
		$datos_json=json_decode($datos['datos_ajuste'],TRUE);		//decodifica los datos JSON 
		foreach($datos_json as $valor) {
			$idproduct=intval($valor['id_producto']);
			if($idproduct==intval($idprod)){
				$cant=$valor['cantidad'];
				$existenceprevious=$existenceprevious+$cant;
			}
		}
	}
	/*----------------------------------- FIN DE CALCULAR ENTRADAS POR AJUSTE DE INV -------------------------------------------*/

	//--------------------------------TICKETS DE VENTA -----------------------------------------------------------
	$sql="SELECT SUM(cantidad) AS cantidad FROM hist_salidas 
	WHERE id_producto='".$idprod."' AND id_almacen='".$idbodega."' AND fecha_salida>='".$primer_dia_mes."' AND fecha_salida<='".$dia_anterior."' ";
	$querysal = $pdo->prepare($sql);
	$querysal->execute();
	$rsp2 = $querysal->fetch(PDO::FETCH_ASSOC);
	if($rsp2){
		$existenceprevious=$existenceprevious-$rsp2["cantidad"];	
	}

	/*---------------------------------------------------------------------------------------*/

	/*----------------------------------- CALCULAR ENTRADAS POR AJUSTE DE INV -----------------------------------------------*/
	$sql = "SELECT datos_ajuste FROM ajusteinventario WHERE fecha_ajuste>='".$primer_dia_mes."' AND fecha_ajuste<='".$dia_anterior."' AND  id_almacen='".$idbodega."' AND tipomov IN (1,3,4,5,6)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if($arr){
		foreach ($arr as $datos) {
			$datos_json=json_decode($datos['datos_ajuste'],TRUE);		//decodifica los datos JSON 
			foreach($datos_json as $valor) {
				$idproduct=intval($valor['id_producto']);
				if($idproduct==intval($idprod)){
					$cant=$valor['cantidad'];
					$existenceprevious=$existenceprevious-$cant;
				}
			}
		}
	}
	/*----------------------------------- FIN DE CALCULAR ENTRADAS POR AJUSTE DE INV -------------------------------------------*/
} //fin del if	
	return $existenceprevious;
}	//fin de la funcion

/*================ ABRE LA BASE DE DATOS =============== */
function getPDO(){
	//$mysqlDatabaseName =defined('DATABASE')?DATABASE:null;
    try{
		$pdo = new PDO('mysql:host=localhost;dbname=dbmodelo', 'root', '');
		//$pdo = new PDO("mysql:host=localhost;dbname=$mysqlDatabaseName","akordova_root","Super6908");
		$pdo->exec("set names utf8");
        return $pdo;
    }catch (PDOException $e) {
		print "¡Error!: <br/>";
		//die();
        return null;
    }
}
/*========================================================= */
?>

