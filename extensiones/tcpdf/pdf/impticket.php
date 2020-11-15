<?php
//ob_clean();
require_once "../../../controladores/salidas.controlador.php";
require_once "../../../modelos/salidas.modelo.php";
	
//TRAEMOS LA INFORMACIÓN DE LA VENTA
$itemSalida = "num_salida";
$numdeSalida = intval($_GET["codigo"]);
	
//$session_id= session_id();

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
        //exit;
    }
};

//PARAMETROS DE ENCABEZADO DEL REPORTE
$razonsocial=defined('RAZON_SOCIAL')?RAZON_SOCIAL:'SIN DATO DE RAZON SOCIAL';
$direccion=defined('DIRECCION')?DIRECCION:'SIN DATO DE DIRECCION';
$colonia=defined('COLONIA')?COLONIA:'SIN DATO DE COLONIA';
$ciudad=defined('CIUDAD')?CIUDAD:'SIN DATO DE CIUDAD';
$telefono=defined('TELEFONO')?TELEFONO:'SIN DATO DE TELEFONO';
$correo=defined('CORREO')?CORREO:'SIN DATO DE CORREO';
$imagen=defined('IMAGEN')?'../../../'.IMAGEN:'../../../config/imagenes/logotipoempresa.png';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../../tickets/ticket.css?v=14092020">
		
        <title>Impresión de ticket</title>
    </head>
    <body>
        <div class="ticket centered">
		 <img src=<?php echo $imagen;?> style="width:100px; height:50px" alt="Logotipo" />
            <p class="centered" style="font-family: Arial; font-size:12px;padding-top:-15px; margin-top:0"><?php echo $razonsocial;?> 
                <br><?php echo DIRECCION;?> 
                <br><strong>RFC:</strong> <?php echo RFC;?> 
                <br><strong>TEL:</strong> <?php echo TELEFONO;?> 
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
                        <tr>
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
                        $descripcion=trim(substr($row["descripcion"],0,36));
                    }else{
                        $sumtotal=$row["precio_venta"];   
                        $descripcion=trim(substr($row["descripcion"],0,36)."*");
                    }
                    ?>
                    <tr style="font-family: Arial; font-size:11px;">
                        <td class="description" colspan=3><?php echo $descripcion."<br>";?></td>
                    </tr>
                    <tr style="font-family: Arial; font-size:11px;">
                        <td class="price" colspan=3> <?php echo $row["cantidad"]." x $".$row["precio_venta"]." = $".number_format($sumtotal,2)."<br>";?></td>
                    <?php

                        if(strlen($row["leyenda"])>0){ ?>
                        <tr>
                            <td class="description" colspan=3><?php echo $row["leyenda"];?></td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tr>

                <?php
                    $granTotal+=$sumtotal;
                }   //FIN DEL foreach
                ?>
                    <?php
                    $cambiode=$pagocon<>0?($pagocon-$granTotal):0;
                    ?>
                       
                        <tr>
                        </tr>
                        
                        <tr>
                            <th class="price totales both_border" colspan=3> TOTAL A PAGAR $ <?php echo number_format($granTotal,2);?></th>
                        </tr>
                        <tr>
                        <td class="price" colspan=3> <?php echo "PAGO: $".number_format($pagocon,2)." / CAMBIO: $".number_format($cambiode,2)."<br>";?></td>
                        </tr>

                    </tbody>
            </table>

            <p class="centered"><?php echo FOOTER;?>
				<br><?php echo LEYENDA."</br>";?>
            </p>
            <p class="centered"><?php echo $nombre_tipo;?>
				<br><?php echo $entregaen;?>
            </p>
            
            
        </div>
        <div style="display: block; content:''; clear: both;"></div>

        <div class="text-center" style="margin: 0 auto; width: 150px;">
        <br>
            <button id="btnPrint" class="btn-bootstrap1 hidden-print" onclick="window.print();window.close();">Imprimir</button>
            <button class="btn-bootstrap2 hidden-print" onclick="window.close();">Cerrar</button>
        </div>

        <!-- <script src="../../tickets/ticket.js?v=11012020"></script> -->
    </body>
</html>

<!-- 
$iva=$suma * ($tax / 100);
$total_iva=number_format($iva,2,'.','');	
$total=$suma + $total_iva;
 -->
