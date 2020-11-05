<?php
date_default_timezone_set('America/Mexico_City');
$fecha_actual = date("Y-m-d");
echo $fecha_actual;
echo "</br>";
echo date("Y-m-d",strtotime($fecha_actual."- 61 days")); 
echo "</br>";
echo date("Y-m-d",strtotime($fecha_actual."- 33 days")); 
echo "</br>";

$totalVentas=array_sum(array_column($totalVentasxFamilia, 'venta'));  //saca la suma en una columna de una array aunque sea string