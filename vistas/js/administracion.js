$(document).ready(function(){
})

/* *************************************************************
 ******** funcion para guardar los accesos ************
 ****************************************************************/
$("#guardarPermisoAdmin").on("click",function(event){
    event.preventDefault();	
    
    let usuarioPermiso=$("#nvoUsuarioPermiso").val();
    var miArray = new Array()

    console.log("entra:",usuarioPermiso)
    $('#checkeadosadmin input[type=checkbox]').each(function(){
        if (this.checked) {
            miArray.push([$(this).attr('id'),$(this).val()]);
        }
            //miArray=[...nuevoarray];
    });     

let data = new FormData();
 data.append('miArray', JSON.stringify(miArray));
 data.append('idUsuario', usuarioPermiso);

    fetch('ajax/permiso.ajax.php?op=guardarPermisoAdmin', {
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

/***************************************************
*********  funcion para obtener los accesos *****
****************************************************/
 function obteneraccesos1(user){
    console.log(user);
    $('input').iCheck('uncheck');   //deschequea todos
    axios.get('ajax/permiso.ajax.php?op=getPermisos', {
        params: {
          user: user,
          modulo: 'administracion'
        }
    })
      .then((response) => {
    
        if(response.status==200) {
            //console.table(response.data)
            datas=response.data.administracion;
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


/*****************************************************
            HABILITAR CHECKBOX
*****************************************************/
$('.habilitaPermisoVentas').on('ifChecked', function (event) {
    console.log("Checkeado OK")
    $('input.rolventas').removeAttr("disabled");
    $('input.rolventas').iCheck('check');
});

$('.habilitaPermisoAdminVentas').on('ifChecked', function (event) {
    $('input.roladminventas').removeAttr("disabled");
    $('input.roladminventas').iCheck('check');
});

$('.habilitaPermisoControlEfe').on('ifChecked', function (event) {
    $('input.rolcontrolefe').removeAttr("disabled");
    $('input.rolcontrolefe').iCheck('check');
});

$('.habilitaPermisoAjusteInv').on('ifChecked', function (event) {
    $('input.rolajusteinv').removeAttr("disabled");
    $('input.rolajusteinv').iCheck('check');
});


/*****************************************************
            DESHABILITAR CHECKBOX
*****************************************************/
$('.habilitaPermisoVentas').on('ifUnchecked', function (event) {
    console.log("Deschekeado OK")
    $('input.rolventas').attr("disabled", "disabled");
    $('input.rolventas').iCheck('uncheck');
});

$('.habilitaPermisoAdminVentas').on('ifUnchecked', function (event) {
    $('input.roladminventas').attr("disabled", "disabled");
    $('input.roladminventas').iCheck('uncheck');
});

$('.habilitaPermisoControlEfe').on('ifUnchecked', function (event) {
    $('input.rolcontrolefe').attr("disabled", "disabled");
    $('input.rolcontrolefe').iCheck('uncheck');
});

$('.habilitaPermisoAjusteInv').on('ifUnchecked', function (event) {
    $('input.rolajusteinv').attr("disabled", "disabled");
    $('input.rolajusteinv').iCheck('uncheck');
});




