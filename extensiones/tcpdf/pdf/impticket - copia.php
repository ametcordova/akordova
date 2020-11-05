<?php
ob_clean();
require_once "../../../controladores/salidas.controlador.php";
require_once "../../../modelos/salidas.modelo.php";
	
//TRAEMOS LA INFORMACIÓN DE LA VENTA
$itemSalida = "num_salida";
$numdeSalida = intval($_GET["codigo"]);
	
$session_id= session_id();

//salidas.controlador.php
$respuestaAlmacen = ControladorSalidas::ctrSalidaAlm($itemSalida, $numdeSalida);

$nomCliente=$respuestaAlmacen[0]["nombrecliente"];
$usuario=$respuestaAlmacen[0]["nombreusuario"];
$entregaen=$respuestaAlmacen[0]["id_tipovta"]==0?"Entrega en: Mostrador":"Entrega a: Domicilio";
$fechaSalida=date("d-m-Y H:i:s", strtotime($respuestaAlmacen[0]["ultmodificacion"]));

if($respuestaAlmacen){
    $respuestacobro = ControladorSalidas::ctrCobroVenta($numdeSalida);
     if($respuestacobro){
        $pagocon=$respuestacobro['pago'];
     }else{
        $pagocon=0;
        exit;
    }
};
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../../tickets/ticket.css?v=05092020">
		
        <title>Impresión de ticket</title>
    </head>
    <body>
        <div class="ticket">
		 <img src="../../tickets/logo.png" alt="Logo aKordova" />
            <p class="centered" style="font-family: Arial; font-size:12px;"><?php echo RAZON_SOCIAL."\n";?> 
                <br><?php echo DIRECCION."\n";?> 
                <br><strong>RFC:</strong> <?php echo RFC."\n";?> 
                <br><strong>TEL:</strong> <?php echo TELEFONO."\n";?> 
                <?php
                    if(SLOGAN!=""){
                        echo "<br>".SLOGAN;
                    }
                ?>
				<br><strong>F.Venta: </strong><?php echo $fechaSalida."\n";?>
				<br><strong>Ticket #:</strong> <?php echo $numdeSalida."\n";?> 
				</p>
			    <p style="font-family: Arial; font-size:11px;">
                    <strong>Cliente :</strong> <?php echo $nomCliente."\n";?> 
                    <br><strong>Atendió: </strong> <?php echo $usuario."\n";?> 
                </p>	
                
                <table style="font-family: Arial; font-size:12px;">
                    <thead style="font-family: Arial; font-size:12px;">
                        <tr >
                            <th class="titlequantity both_border">Cant.</th>
                            <th class="titledescription both_border">Descripción</th>
                            <th class="titleprice both_border">Total</th>
                        </tr>
                    </thead>

                    <tbody>

                <?php               
                $cantSalida=$granTotal=$sumtotal=0;
                $nombre_tipo=$respuestaAlmacen[0]["nombre_tipo"];
                foreach ($respuestaAlmacen as $row) {
                    if($row["es_promo"]==0){
                        $sumtotal=($row["cantidad"]*$row["precio_venta"]); 
                        $descripcion=trim(substr($row["descripcion"],0,26));
                    }else{
                        $sumtotal=$row["precio_venta"];   
                        $descripcion=trim(substr($row["descripcion"],0,36)."*");
                    }
                    ?>
                    <tr style="font-family: Arial; font-size:11px;">
                        <td class="description" colspan=3><?php echo $descripcion;?></td>
                        <td class="price"> <?php echo "<br>".$row["cantidad"]." x $".$row["precio_venta"]." = $".number_format($sumtotal,2);?></td>
                    <?php
                        if(strlen($row["leyenda"])>0){ ?>
                            <td class="description"><?php echo $row["leyenda"];?></td>
                    <?php
                        }
                    ?>

                <?php
                    $granTotal+=$sumtotal;
                }   //FIN DEL foreach
                ?>
                    <?php
                    $cambiode=$pagocon<>0?($pagocon-$granTotal):0;
                    ?>
                        <tr>
                            <td class="quantity"></td>
                            <td class="description"> NETO</td>
                            <td class="price"> <?php echo number_format($granTotal,2);?></td>
                        </tr>
                        
                        <tr>
                            <td class="quantity"></td>
                            <td class="description"> IVA  (<?php echo 16?>%)</td>
                            <td class="price"> <?php echo number_format($granTotal,2);?></td>
                        </tr>
                        
                        <tr>
                        
                            <th class="price totales both_border" colspan=3> TOTAL IMPORTE  $ <?php echo number_format($granTotal,2);?></th>
                        </tr>
                    </tbody>
                </table>

            <p class="centered">Gracias por su compra!
				<br>RECARGAS Y MÁS SERVICIOS
			</p>
        </div>
		
        <button id="btnPrint" class="hidden-print" onclick="window.print();">Imprimir</button>
		<button  class="hidden-print" onclick="window.close();">Cerrar</button>

        <script src="../../tickets/ticket.js?v=11012020"></script>
    </body>
</html>

<!-- 
$iva=$suma * ($tax / 100);
$total_iva=number_format($iva,2,'.','');	
$total=$suma + $total_iva;
 -->
