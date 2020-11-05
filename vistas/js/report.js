$(document).ready(function(){
    //$('input.rolcliente').attr("disabled", "disabled");    
    //$('input.rolproducto').attr("disabled", "disabled");  
})


$("#guardarPermisoRep").on("click",function(event){
    event.preventDefault();	
    
    let usuarioPermiso=$("#nvoUsuarioPermiso").val();
    var miArray = new Array()

    console.log("entra:",usuarioPermiso)
    $('#checkeadosreportes input[type=checkbox]').each(function(){
        if (this.checked) {
            //console.log($(this).attr('name')+', ',$(this).val()+' ');
            //console.log($(this).attr('id')+', ',$(this).val()+' ');
            miArray.push([$(this).attr('id'),$(this).val()]);
        }
            //miArray=[...nuevoarray];
    });     
    //console.table(miArray);

 //HACER UN FETCH AL CAT DE PROD
 let data = new FormData();
 data.append('miArray', JSON.stringify(miArray));
 data.append('idUsuario', usuarioPermiso);

    fetch('ajax/permiso.ajax.php?op=guardarPermisoRep', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
    console.log(data)
    if(data===false){
        console.log(data);
    }else{
        Swal.fire({
            title: 'Los cambios han sido guardados!',
            confirmButtonText: `Enterado`,
          }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }else{
                $("#accordion").hide();
                window.location.reload();
            }
          })
                    
    }
    })
    .catch(error => console.error(error))

 });        //fin del funcion


function obteneraccesos3(user){
console.log(user);
$('input').iCheck('uncheck');   //deschequea todos
axios.get('ajax/permiso.ajax.php?op=getPermisos', {
    params: {
      user: user,
      modulo: 'reportes'
    }
})
  .then((response) => {

    if(response.status==200) {
        //console.table(response.data)
        datas=response.data.reportes;
        //console.log(datas);
        bigdata=JSON.parse(datas);

        activarcheckbox(bigdata)

    }else{
        console.log(response);    
    }
    
  })
  .catch((error) => {
    console.log(error);
  });
}

// ES6  FUNCIONA IGUAL QUE $.each
//Object.keys(nvo).forEach(llave => console.log(llave, nvo[llave]));


/*****************************************************
            HABILITAR CHECKBOX
*****************************************************/
$('.habilitaPermisoRepVentas').on('ifChecked', function (event) {
    console.log("Checkeado OK")
    $('input.rolrepvtas').removeAttr("disabled");
    $('input.rolrepvtas').iCheck('check');
});

$('.habilitaPermisoRepCompras').on('ifChecked', function (event) {
    $('input.rolrepcompras').removeAttr("disabled");
    $('input.rolrepcompras').iCheck('check');
});

$('.habilitaPermisoRepInv').on('ifChecked', function (event) {
    $('input.rolrepinv').removeAttr("disabled");
    $('input.rolrepinv').iCheck('check');
});

$('.habilitaPermisoRepCV').on('ifChecked', function (event) {
    $('input.rolrepcv').removeAttr("disabled");
    $('input.rolrepcv').iCheck('check');
});

$('.habilitaPermisoRepKardex').on('ifChecked', function (event) {
    $('input.rolrepkardex').removeAttr("disabled");
    $('input.rolrepkardex').iCheck('check');
});

$('.habilitaPermisoRepSug').on('ifChecked', function (event) {
    $('input.rolrepsugerido').removeAttr("disabled");
    $('input.rolrepsugerido').iCheck('check');
});

$('.habilitaPermisoRepCanc').on('ifChecked', function (event) {
    $('input.rolrepcancela').removeAttr("disabled");
    $('input.rolrepcancela').iCheck('check');
});

/*****************************************************
            DESHABILITAR CHECKBOX
*****************************************************/
$('.habilitaPermisoRepVentas').on('ifUnchecked', function (event) {
    console.log("Deschekeado OK")
    $('input.rolrepvtas').attr("disabled", "disabled");
    $('input.rolrepvtas').iCheck('uncheck');
});

$('.habilitaPermisoRepCompras').on('ifUnchecked', function (event) {
    $('input.rolrepcompras').attr("disabled", "disabled");
    $('input.rolrepcompras').iCheck('uncheck');
});

$('.habilitaPermisoRepInv').on('ifUnchecked', function (event) {
    $('input.rolrepinv').attr("disabled", "disabled");
    $('input.rolrepinv').iCheck('uncheck');
});

$('.habilitaPermisoRepCV').on('ifUnchecked', function (event) {
    $('input.rolrepcv').attr("disabled", "disabled");
    $('input.rolrepcv').iCheck('uncheck');
});

$('.habilitaPermisoRepKardex').on('ifUnchecked', function (event) {
    $('input.rolrepkardex').attr("disabled", "disabled");
    $('input.rolrepkardex').iCheck('uncheck');
});

$('.habilitaPermisoRepSug').on('ifUnchecked', function (event) {
    $('input.rolrepsugerido').attr("disabled", "disabled");
    $('input.rolrepsugerido').iCheck('uncheck');
});

$('.habilitaPermisoRepCanc').on('ifUnchecked', function (event) {
    $('input.rolrepcancela').attr("disabled", "disabled");
    $('input.rolrepcancela').iCheck('uncheck');
});

/*
    GUARDAR:
    UPDATE `usuarios` SET `permisos`='{"administracion":{"ventas": 63, "compras": 19, "Adminventas":19, "controlefectivo":19, "ajusteinv": 19}, "catalogos":{"productos": 15, "clientes": 159} }' WHERE `id`=1
    UPDATE `usuarios` SET `permisos`='{"ventas": 63, "compras": 19, "Adminventas":19, "controlefectivo":19, "ajusteinv": 19,"productos": 15, "clientes": 159}' WHERE `id`=1
    UPDATE `usuarios` SET `permisos`='{"productos": 14, "categorias": 15, "clientes":127}' WHERE `id`=2

    CONSULTAR
    SELECT permisos->'$.administracion.ventas' AS acceso FROM usuarios WHERE `id`=1
    SELECT JSON_EXTRACT(permisos, '$.administracion.ventas') AS acceso FROM usuarios WHERE `id`=1
    SELECT JSON_EXTRACT(permisos, '$.productos') AS acceso FROM usuarios WHERE `id`=2
    
SELECT `permisos` FROM `usuarios` WHERE permisos->'$.catalogos.clientes'>0
SELECT `permisos` FROM `usuarios` WHERE permisos->'$.administracion.ventas'>0
'{"catalogos" : {"clientes": "159", "productos": "15"}, "Administracion" : {"ventas": "98", "compras": "15"}}');

 ;    
*/