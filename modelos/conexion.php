<?php
date_default_timezone_set('America/Mexico_City');

class Conexion{

static public function conectar(){
    $end = '2019-12-31';
    $fecha_actual = strtotime(date("Y-m-d H:i:s"));
    $fecha_check = strtotime($end);

        //if($fecha_actual <= $fecha_check){
				
		try {
			$link = new PDO("mysql:host=localhost;dbname=cvc",
								"root",
								"");

			$link->exec("set names utf8");
			
			$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $link;
			
		} catch (PDOException $e){
			print "Error!: " . $e->getMessage() . "<br/>";
			die();        
		}
		
	//}else{
	//	print "Error!: Sin Licencia";
	//}


}


}  //fin de la clase
