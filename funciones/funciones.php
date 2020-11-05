<?php
/******************************************************
     * Función para verificar si tiene los permisos
******************************************************/
 function getAccess($bit1, $bit2){
  return (((int)$bit1 & (int)$bit2) == 0) ? false : true;     //hay que notar que estamos usando el símbolo & (ampersand). Este es el operador AND a nivel de bit en PHP; el operador AND booleano se representa con dos símbolos ampersand &&
}

/********************************************************
* Función para traer los permisos segun usuario y modulo
********************************************************/
function accesomodulo($tabla, $usuario, $module, $campo){
  $acceso=0;
  $permiso = ControladorPermisos::ctrGetAccesos($tabla, $usuario, $module, $campo);
  $acceso=$permiso[0];
    
  return $acceso;

}