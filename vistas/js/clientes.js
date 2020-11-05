$("#modalAgregarCliente, #modalEditarCliente, #modalAbonoCliente, #modalEdoCtaCliente").draggable({
	 handle: ".modal-header"
});

function init(){
   
  $("#form_abono").on("submit",function(e){
    console.log("entra")
      agregarAbono(e);	
  })

}

/*=============================================
AGREGAR INGRESO
=============================================*/
function agregarAbono(e){
  e.preventDefault(); 
  
    const data = new FormData($("#form_abono")[0]);

     //for (var pair of data.entries()){console.log(pair[0]+ ', ' + pair[1]);}

     fetch('ajax/clientes.ajax.php?op=guardarAbono', {
        method: 'POST',
        body: data
     })
     .then(respuestafetch)
     .catch(showErrorFetch);   

}     

function respuestafetch(response) {
  //console.log('response.ok: ', response.ok);
   $('#modalAbonoCliente').modal('hide')

   let timerInterval
   Swal.fire({
     title: 'Aplicando Abono!',
     html: 'Espere por favor.. <b></b>',
     timer: 2000,
     timerProgressBar: true,
     onBeforeOpen: () => {
       Swal.showLoading()
       timerInterval = setInterval(() => {
         const content = Swal.getContent()
         if (content) {
           const b = content.querySelector('b')
           if (b) {
             b.textContent = Swal.getTimerLeft()
           }
         }
       }, 100)
     },
     onClose: () => {
       clearInterval(timerInterval)
     }
   }).then((result) => {
     /* Read more about handling dismissals below */
     if (result.dismiss === Swal.DismissReason.timer) {
      window.location = "clientes";
       console.log('I was closed by the timer')
     }
   })   
/*
    swal.fire({
      title: "Realizado!!",
      text: "Abono Guardado",
      icon: "success",
      })  //fin swal
      .then(function(result){
        if (result) {
          console.log(result);
          window.location = "clientes";
        }else{
          window.location = "clientes";
        }
    })  //fin .then
  */         
  if(response.ok) {
    response.text().then(showResultFetch);
  } else {
    showErrorFetch('status code: ' + response.status);
  }
}

function showResultFetch(txt) {
  console.log('muestro respuesta: ', txt);
}

function showErrorFetch(err) { 
  console.log('muestra error', err);
  swal.fire({
      title: "Error!!",
      text: err,
      icon: "error",
      })  //fin swal
    window.location = "inicio";
}

/* ============= ABONO A CLIENTE CON CREDITO ============ */
$(".activarDatatable").on("click", ".btnAbonoCliente", function(){
  let idClienteAbono = $(this).attr("idCliente");
  let saldocliente = $(this).attr("data-saldo");
  //console.log(idClienteAbono)
  $("[name='idClienteAbo']").val(idClienteAbono);
  $("[name='importeSaldo']").val(saldocliente);
})


/* ===TAMBIEN FUNCIONA ===
$('#modalAbonoCliente').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var saldo = button.data('saldo') 
  $('#importeSaldo').val(saldo)
})
*/

/*=============================================
EDITAR CLIENTE
=============================================*/
$(".activarDatatable").on("click", ".btnEditarCliente", function(){

	var idCliente = $(this).attr("idCliente");
	//console.log(idCliente);
	var datos = new FormData();
    datos.append("idCliente", idCliente);
    //console.log(datos);
    $.ajax({

      url:"ajax/clientes.ajax.php?op=mostrarClie",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta, status){
      console.log(respuesta, status);
        var dateString = respuesta["fecha_nacimiento"];
        console.log(moment(dateString).format('DD/MM/YYYY'));
      	 $("#idCliente").val(respuesta["id"]);
	       $("#EditarCliente").val(respuesta["nombre"]);
	       $("#EditarDocumento").val(respuesta["rfc"]);
	       $("#EditarEmail").val(respuesta["email"]);
	       $("#EditarTelefono").val(respuesta["telefono"]);
	       $("#EditarDireccion").val(respuesta["direccion"]);
         $("#EditarFechaNacimiento").val(respuesta["fecha_nacimiento"]);
         $("#EditarDescuento").val(respuesta["descuento"]);
         $("#saldoactual").val(respuesta["saldo"]);
         $("#EditarLimitecredito").val(respuesta["limitecredito"]);
         $("#EditarestadoCliente").val(respuesta["estado"]);
	  }

  	})

})

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".activarDatatable").on("click", ".btnEliminarCliente", function(){

	var idCliente = $(this).attr("idCliente");

  swal.fire({
    title: "¿Está seguro de desactivar el cliente?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "question",
    allowOutsideClick:false,
    allowEscapeKey:true,
    allowEnterKey: true,
    reverseButtons: true,			//invertir botones
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar',
    cancelButtonText: 'No, cancelar!',
  })
  .then((willDelete) => {
    if (willDelete.value) {
        window.location = "index.php?ruta=clientes&idCliente="+idCliente;
    }else{
        
    }
  });    
    
})

/*===================================================
DATOS AL ABRIR EL MODAL EDO CTA
===================================================*/
$('#modalEdoCtaCliente').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget) // Button that triggered the modal
  let nomclie = button.data('nomclie') 
  let idCliente = button.attr("idCliente");
  let modal=$(this);
  modal.find('#idCustomer').val(idCliente);
  modal.find('#nomcliente').text("CLIENTE: "+idCliente+' - '+nomclie);
})

/*===================================================
ENVIA EDO DE CUENTA DESDE EL DATATABLE
===================================================*/
$("#enviarEdoCta").on("click", function(){
	let idNomCustomer = $("#idCustomer").val();
	let FechIniEdoCta = $("#fechaIniEdocta").val();
	let FechFinEdoCta = $("#fechaFinEdocta").val();
	
   console.log(FechIniEdoCta,FechFinEdoCta,idNomCustomer);

    if(FechIniEdoCta.length > 0){
      $('#modalEdoCtaCliente').modal('hide')
      window.open("extensiones/tcpdf/pdf/reporte_edocta.php?codigo="+idNomCustomer+"&FechIniEdoCta="+FechIniEdoCta+"&FechFinEdoCta="+FechFinEdoCta,"_blank");
    }else{
      $('#modalEdoCtaCliente').modal('hide')
    }
})




init();