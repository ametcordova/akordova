<?php
if(!session_id()){
session_start();
}
require_once 'controladores/plantilla.controlador.php';
require_once 'controladores/categorias.controlador.php';
require_once 'controladores/clientes.controlador.php';
require_once 'controladores/proveedores.controlador.php';
require_once 'controladores/salidas.controlador.php';
require_once 'controladores/entradas.controlador.php';
require_once 'controladores/usuarios.controlador.php';
require_once 'controladores/medidas.controlador.php';
require_once 'controladores/productos.controlador.php';
require_once 'controladores/familias.controlador.php';
require_once 'controladores/cajas.controlador.php';
require_once 'controladores/empresa.controlador.php';
require_once 'controladores/crear-almacen.controlador.php';
require_once 'controladores/entradas.controlador.php';
require_once 'controladores/respaldo.controlador.php';
require_once 'controladores/reportedeventas.controlador.php';
require_once 'controladores/permisos.controlador.php';

require_once 'modelos/permisos.modelo.php';
require_once 'modelos/usuarios.modelo.php';
require_once 'modelos/salidas.modelo.php';
require_once 'modelos/categorias.modelo.php';
require_once 'modelos/medidas.modelo.php';
require_once 'modelos/clientes.modelo.php';
require_once 'modelos/proveedores.modelo.php';
require_once 'modelos/productos.modelo.php';
require_once 'modelos/familias.modelo.php';
require_once 'modelos/cajas.modelo.php';
require_once 'modelos/empresa.modelo.php';
require_once 'modelos/crear-almacen.modelo.php';
require_once 'modelos/entradas.modelo.php';
require_once 'modelos/reportedeventas.modelo.php';
require_once 'extensiones/vendor/autoload.php';

$plantilla=new ControladorPlantilla();

$plantilla->ctrPlantilla();