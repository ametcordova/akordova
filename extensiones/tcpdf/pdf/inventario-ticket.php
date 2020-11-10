<?php
//ob_clean();
require_once "../../../controladores/reporteinventario.controlador.php";
require_once "../../../modelos/reporteinventario.modelo.php";

$diadehoy=date("d-m-Y H:i:s");
$tabla=$_GET["idNomAlma"];
$campoFam = "id_familia";
$claveFam = $_GET["idNumFam"];

//TRAER LOS DATOS DEL ALMACEN SELECCIONADO
$respuestaInventario = ControladorInventario::ctrReporteInventario($tabla, $campoFam, $claveFam);

if($respuestaInventario){

//PARAMETROS DE ENCABEZADO DEL REPORTE
$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
$direccion=defined('DIRECCION')?DIRECCION:'SIN DATO DE DIRECCION';
$colonia=defined('COLONIA')?COLONIA:'SIN DATO DE COLONIA';
$ciudad=defined('CIUDAD')?CIUDAD:'SIN DATO DE CIUDAD';
$telefono=defined('TELEFONO')?TELEFONO:'SIN DATO DE TELEFONO';
$correo=defined('CORREO')?CORREO:'SIN DATO DE CORREO';

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../../tickets/inventario.css?v=16092020">
		
        <title>Impresión de Inventario</title>
    </head>
    <body>
        <div class="ticket">
		 <img src="../../tickets/logoticket.png" style="width:90%;" alt="Logo aKordova" />
            <p class="centered" style="font-family: Arial; font-size:12px;padding-top:-15px"><?php echo $razonsocial;?> 
                <br><?php echo DIRECCION;?> 
                <br><strong>RFC:</strong> <?php echo RFC;?> 
                <br><strong>TEL:</strong> <?php echo TELEFONO;?> 
				<br><strong>Fecha: </strong><?php echo $diadehoy."\n";?>
				</p>
			    <p style="font-family: Arial; font-size:11px;">
                    <strong>Existencia de Inventario valorizados:</strong>
                    <br><strong>Almacen: </strong> <?php echo $tabla."\n";?> 
                </p>	
                
                <table style="font-family: Arial; font-size:12px;">
                    <thead style="font-family: Arial; font-size:12px;">
                        <tr>
                            <th class="titledescription both_border">PROD.</th>
                            <th class="titlequantity both_border">CANT</th>
                            <th class="titleprice both_border">P.U.</th>
                            <th class="titleprice both_border">TOTAL</th>
                        </tr>
                    </thead>

                    <tbody>

                <?php               

                $cantExist=$totExiste=$granTotal=$sumtotal=$importeExist=0;
                foreach ($respuestaInventario as $row) {
                    $sumtotal=$row["precio_venta"]*$row["cant"];
                    $descripcion=trim(substr($row["descripcion"],0,26));
                    //$sumtotal=$row["precio_venta"];   
                    $cant=$row["cant"];

                    ?>
                    <tr style="font-family: Arial; font-size:11px;">
                        <td class="description" colspan=4><?php echo $descripcion."<br>";?></td>
                    </tr>
                    <tr style="font-family: Arial; font-size:11px;">
                        <td class="price" colspan=4> <?php echo $row["cant"]." x $".$row["precio_venta"]." = $".number_format($sumtotal,2)."<br>";?></td>
                    </tr>

                <?php
                    $granTotal+=$sumtotal;
                    $cantExist+=$row["cant"];
                }   //FIN DEL foreach
                ?>
                    <tr>
                    
                    </tr>
                        
                    <tr>
                        <td class="totales both_border" colspan=4> <?php echo "EXISTEN: ".number_format($cantExist)." - TOTAL: $".number_format($granTotal,2,'.',',')."<br>";?></td>
                    </tr>

                    <tr>
                    
                    </tr>

                    </tbody>
            </table>

            
        </div>
		<div class="text-center" style="margin: 0 auto; width: 150px;">
            <button id="btnPrint" class="btn-bootstrap1 hidden-print" onclick="window.print();window.close();">Imprimir</button>
            <button class="btn-bootstrap2 hidden-print" onclick="window.close();">Cerrar</button>
        </div>

        <!-- <script src="../../tickets/ticket.js?v=11012020"></script> -->
    </body>
</html>
<?php
}
?>
<!-- 
$iva=$suma * ($tax / 100);
$total_iva=number_format($iva,2,'.','');	
$total=$suma + $total_iva;
 -->
