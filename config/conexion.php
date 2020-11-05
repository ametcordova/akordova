<?php
date_default_timezone_set('America/Mexico_City');
require_once dirname( __DIR__ ).'/config/parametros.php';
require_once dirname( __DIR__ ).'/config/accesos.php';
class Conexion{

static public function conectar(){
	$mysqlDatabaseName =defined('DATABASE')?DATABASE:null;
	//$vigencia=defined('DATABASE')?VIGENCIA:null;
    //$end = '2020-08-15';
    $fecha_actual = strtotime(date("Y-m-d H:i:s"));
    //$fecha_check = strtotime($vigencia);

    //if($fecha_actual <= $fecha_check){
				
		try {
			$link = new PDO("mysql:host=localhost;dbname=dbmodelo","root","");
			//$link = new PDO("mysql:host=localhost;dbname=akordova_dbmodelo1","akordova_root","Super6908");
			//$link = new PDO("mysql:host=localhost;dbname=$mysqlDatabaseName","akordova_root","Super6908");

			$link->exec("set names utf8");
			
			$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $link;
			
		} catch (PDOException $e){
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		
	//}else{
		//print "Error!: Sin Licencia";
	//	header('location:vistas/modulos/404b.php');

	//}


}


}  //fin de la clase


