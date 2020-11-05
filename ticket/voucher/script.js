//Función que se ejecuta al inicio
function init(){

  imprimir_ticket();

}


function imprimir_ticket(){

  let cantidad=1;
  let producto="CHEETOS VERDES 80 G";
  let preciounitario="$8.50";
  let totalunitario="$8.50";
  var contenido=document.getElementById('datosdeventa');
  contenido.innerHTML+=`
  <tr>
  <td class='producto'>${producto}</td>
  <td class='cantidad text-right'>${cantidad}</td>
  <td class='precio'>${preciounitario}</td>
  </td>
  </tr>
`

}


function imprimir() {
  window.print();
  window.close();
}

function cerrar() {
    window.close();
}


init();