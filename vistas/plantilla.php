<?php
//session_start();
// ob_start();
// if(!session_id()){

// }
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Admin | @K</title>
  
  <!-- <link rel="shortcut icon" type="image/x-icon" href="vistas/modulos/dist/img/favicon.ico"/>  -->
  <link rel="icon" type="image/x-icon" href="config/favicon.ico"/>
  <link rel="shortcut icon" type="image/x-icon" href="config/favicon.ico"/>

   <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="extensiones/font-awesome/css/font-awesome.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="extensiones/dist/css/adminlte.css">

  <!-- style propios-->
  <link rel="stylesheet" href="extensiones/estilos/estilos.css?v=010920">
  
  <!-- iCheck -->
  <link rel="stylesheet" href="extensiones/iCheck/square/blue.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="extensiones/DataTables/datatables.min.css">  

  <link rel="stylesheet" href="extensiones/jquery-ui-1.12.1/jquery-ui.css">  
  
    <!-- Google Font: Source Sans Pro 
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
  <link href="extensiones/dist/css/css.css" rel="stylesheet">

 <!-- datepicker -->
  <link rel="stylesheet" href="extensiones/datepicker/datepicker3.css">
  
<!-- daterangepicker -->
  <link rel="stylesheet" href="extensiones/daterangepicker/daterangepicker-bs3.css">

<!-- Select2 -->
  <link rel="stylesheet" href="extensiones/select2/select2.css">  

  <!-- IonIcons  -->
  <link rel="stylesheet" href="extensiones/ionicons/css/ionicons.min.css">
  
 <!--sweetalert2.min.js>-->  
<script src="extensiones/sweetalert2/sweetalert2.all.min.js"></script> 

<link rel="stylesheet" href="extensiones/animate/animate.min.css">

<!-- axios 0.20.0 -->  
<script src="extensiones/axios/axios.min.js"></script>

  <!-- <link href="https://fonts.googleapis.com/css?family=Orbitron&display=swap" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css?family=Play&display=swap" rel="stylesheet">

  

<style>
    .pointer {cursor: pointer;};
	.select2 {font-family: 'FontAwesome'};
</style>
</head>

	<!--==== CUERPO DEL DOCUMENTO IMAGEN adminlte.css===-->
	<body class="hold-transition sidebar-collapse sidebar-mini login-page" onLoad="show5();">

	<?php

if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"]=="ok"){
		
	echo '<div class="wrapper">';
	  
	  // ======== cabecera ========
	  include "modulos/header.php";
	  
	// ======== menu ========
	  include "modulos/menu.php";

	  //include 'config/parametros.php';
	  
	   if(isset($_GET["ruta"])){
		if($_GET["ruta"]=="inicio" ||
		   $_GET["ruta"]=="usuarios" ||
		   $_GET["ruta"]=="salidas" ||
		   $_GET["ruta"]=="entradas" ||
		   $_GET["ruta"]=="ventas" ||
		   $_GET["ruta"]=="cortesdeventas" ||
		   $_GET["ruta"]=="clientes" ||
		   $_GET["ruta"]=="proveedores" ||
		   $_GET["ruta"]=="categorias" ||
		   $_GET["ruta"]=="medidas" ||
		   $_GET["ruta"]=="productos" ||
		   $_GET["ruta"]=="familias" ||
		   $_GET["ruta"]=="cajas" ||
		   $_GET["ruta"]=="empresa" ||
		   $_GET["ruta"]=="control-presupuesto" ||
		   $_GET["ruta"]=="crear-almacen" ||
		   $_GET["ruta"]=="almacen" ||
		   $_GET["ruta"]=="adminalmacenes" ||
		   $_GET["ruta"]=="adminsalidas" ||
		   $_GET["ruta"]=="reporteinventario" ||
		   $_GET["ruta"]=="reportedeventas" ||
		   $_GET["ruta"]=="reportecancelados" ||
		   $_GET["ruta"]=="respaldo" ||
		   $_GET["ruta"]=="tablero" ||
		   $_GET["ruta"]=="tipomov" ||
		   $_GET["ruta"]=="ajusteinventario" ||
		   $_GET["ruta"]=="gestionrespaldos" ||
		   $_GET["ruta"]=="closebackup" ||
		   $_GET["ruta"]=="kardex-producto" ||
		   $_GET["ruta"]=="historia-producto" ||
		   $_GET["ruta"]=="sugerido-compra" ||
		   $_GET["ruta"]=="catfamilias" ||
		   $_GET["ruta"]=="permisos" ||
		   $_GET["ruta"]=="salir"){
			include "modulos/".$_GET["ruta"].".php";
		}else{
			include "modulos/404.php";
		}
	   }else{
		   include "modulos/inicio.php";
	   }
		
		/* Main Footer */
		include 'modulos/footer.php';
	
	echo '</div>';
	/*-- fin de wrapper --*/
}else{
	//include 'config/conexion.php';
	include 'modulos/login.php';
}	
?>
<!-- AQUI SE VINCULAN LOS ARCHIVOS JS -->
<script src="vistas/js/plantilla.js"></script> 
<script src="vistas/js/tablero.js"></script>
<script defer src="vistas/js/cajas.js?v=05092020"></script>
<script defer src="vistas/js/header.js?v=05092020"></script>
<script defer src="vistas/js/salidas.js?v=05092020"></script>
<script defer src="vistas/js/funciones.js?v=05092020"></script>

<!--<script src="vistas/js/scriptxvox.js"></script> -->
<!--<script src="vistas/js/app.js"></script> -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>-->