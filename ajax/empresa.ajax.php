<?php
session_start();
require_once "../controladores/empresa.controlador.php";
require_once "../modelos/empresa.modelo.php";

switch ($_GET["op"]){
        
	case 'guardar':
		if($_SERVER["REQUEST_METHOD"]=="POST" AND isset($_POST["razonsocial"])){
            
				$tabla = "empresa";

				$datos = array("razonsocial"		=> $_POST["razonsocial"],
                        "rfc"				    => strtoupper($_POST["rfc"]),
                        "slogan"     		=> $_POST["slogan"],
                        "direccion"     => $_POST["direccion"],
                        "colonia"     	=> $_POST["colonia"],
                        "codpostal"   	=> $_POST["codpostal"],
                        "ciudad"     		=> $_POST["ciudad"],
                        "estado"     		=> $_POST["estado"],
                        "telempresa"    => $_POST["telempresa"],
                        "mailempresa"   => $_POST["mailempresa"],
                        "contacto"     	=> strtoupper($_POST["contacto"]),
                        "telcontacto"   => $_POST["telcontacto"],
                        "mailcontacto"  => $_POST["mailcontacto"],
                        "iva"     			=> $_POST["ivaempresa"],
                        "impresora"     => $_POST["impresora"],
                        "msjpieticket"  => $_POST["msjpieticket"],
                        "mensajeticket" => $_POST["mensajeticket"],
                        "rutarespaldo"  => $_POST["rutarespaldo"],
                        "namedatabase"  => trim($_POST["namedatabase"]),
						            "ultusuario" 		=> $_POST["idDeUsuario"]
							   );
                
                $rspta = ControladorEmpresa::ctrCrearEmpresa($tabla, $datos);
                creaArchivo();
                echo $rspta;
            }
    break;

    case 'traerDatosEmpresa':
        $respuesta = ControladorEmpresa::ctrTraerDatosEmpresa();
        echo json_encode($respuesta);        
	  break;
        
    case 'updateEmpresa':
      if($_SERVER["REQUEST_METHOD"]=="POST" AND isset($_POST["razonsocial"])){
              
          $tabla = "empresa";
  
          $datos = array("razonsocial"        => trim($_POST["razonsocial"]),
                         "rfc"				        => trim(strtoupper($_POST["rfc"])),
                         "slogan"     	      => trim($_POST["slogan"]),
                         "direccion"          => trim($_POST["direccion"]),
                         "colonia"     		    => trim($_POST["colonia"]),
                         "codpostal"   		    => $_POST["codpostal"],
                         "ciudad"     		    => trim($_POST["ciudad"]),
                         "estado"     		    => trim($_POST["estado"]),
                         "telempresa"     	  => trim($_POST["telempresa"]),
                         "mailempresa"     	  => trim($_POST["mailempresa"]),
                         "contacto"     		  => strtoupper($_POST["contacto"]),
                         "telcontacto"     	  => trim($_POST["telcontacto"]),
                         "mailcontacto"       => trim($_POST["mailcontacto"]),
                         "iva"     			      => $_POST["ivaempresa"],
                         "impresora"          => trim($_POST["impresora"]),
                         "msjpieticket"     	=> trim($_POST["msjpieticket"]),
                         "mensajeticket"     	=> trim($_POST["mensajeticket"]),
                         "rutarespaldo"     	=> trim($_POST["rutarespaldo"]),
                         "namedatabase"     	=> trim($_POST["namedatabase"]),
                         "ultusuario" 		    => $_POST["idDeUsuario"]
                   );
                  
                  $rspta = ControladorEmpresa::ctrUpdateEmpresa($tabla, $datos);
                  creaArchivo();
                  echo $rspta;
              }
      break;   
       
        
}  //FIN DE SWITCH

/* CREA ARCHIVO PARAMETROS.PHP */
function creaArchivo(){
  $miArchivo = fopen("../config/parametros.php", "w") or die("No se puede abrir/crear el archivo!");
  //Creamos una variable personalizada
 $citystate = trim($_POST["ciudad"]).', '.trim($_POST["estado"]);
                    
 $datosphp = "<?php             
   define ('RAZON_SOCIAL', '".$_POST['razonsocial']."');
   define ('DIRECCION', '".trim($_POST["direccion"])."');
   define ('COLONIA','".trim($_POST["colonia"])."');
   define ('CIUDAD','".$citystate."');
   define ('RFC','".strtoupper($_POST["rfc"])."');
   define ('TELEFONO', '".trim($_POST["telempresa"])."');
   define ('CORREO','".trim($_POST["mailempresa"])."');
   define ('IMPRESORA','".trim($_POST["impresora"])."');
   define ('DRIVEBACKUP','".trim($_POST["rutarespaldo"])."');
   define ('DATABASE','".trim($_POST["namedatabase"])."');
   define ('SLOGAN','".trim($_POST["slogan"])."');
   define ('FOOTER','".trim($_POST["msjpieticket"])."');
   define ('LEYENDA','".trim($_POST["mensajeticket"])."');
   define ('TERMINAL','".trim($_POST["idterminal"])."');
 ?>";
                    
   fwrite($miArchivo, $datosphp);
   fclose($miArchivo);
 
}

/*

<?php
$miArchivo = fopen("holaMundo.php", "w") or die("No se puede abrir/crear el archivo!");
 
//Creamos una variable personalizada
$var = 'testDatosPersonalizados';
 
$php = "<?php 
echo 'hola mundo';
 
// Esto sería un comentario
 
// Un bucle para probar que funciona.
for (\$i=0; \$i < 10; \$i++) { 
	echo \$i;
}
 
// Creamos una variable y probamos que funciona con la variable creada anteriormente
\$variable = '".$var."';
 
// Damos un salto de linea para que sea más legible
echo '<br>';
 
// Mostramos la variable que acabamos de crear.
echo \$variable;
 
 
?>";
 
fwrite($miArchivo, $php);
fclose($miArchivo);
?>

*/