$("#modalAgregarAlmacen, #modalEditarAlmacen").draggable({
	 handle: ".modal-header"
});

/*=============================================
EDITAR CLIENTE
=============================================*/
$(".activarDatatable").on("click", ".btnEditarAlmacen", function(){

	var idAlmacen = $(this).attr("idAlmacen");

	var datos = new FormData();
    datos.append("idAlmacen", idAlmacen);
    console.log(datos);
    $.ajax({

      url:"ajax/crear-almacen.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta, status){
      console.log(respuesta, status);
          //var dateString = respuesta["fecha_nacimiento"];
          //console.log(moment(dateString).format('DD/MM/YYYY'));
      	   $("#idAlmacen").val(respuesta["id"]);
	       $("#editarAlmacen").val(respuesta["nombre"]);
	       $("#editarUbicacion").val(respuesta["ubicacion"]);
		   $("#editarResponsable").val(respuesta["responsable"]);
	       $("#editarEmail").val(respuesta["email"]);
	       $("#editarTelefono").val(respuesta["telefono"]);
	  }

  	})

})

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".activarDatatable").on("click", ".btnEliminarAlmacen", function(){

	var idAlmacen = $(this).attr("idAlmacen");

  Swal.fire({
    title: 'AVISO!',
    text: 'Estamos trabajando en esta opción.',
    imageUrl: 'config/rockefellercenter.jpg',
    imageWidth: 600,
    imageHeight: 300,
    imageAlt: 'Custom image',
    confirmButtonText: 'Lo entiendo'
  })

  /*
  swal.fire({
    title: "¿Está seguro de borrar este Almacen?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    allowOutsideClick:false,
    allowEscapeKey:true,
    allowEnterKey: true,
    reverseButtons: true,			//invertir botones
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar!',
    cancelButtonText: 'No, cancelar',
  })

  .then((willDelete) => {
    if (willDelete.value) {
        //window.location = "index.php?ruta=crear-almacen&idAlmacen="+idAlmacen;
    };
  });    
  */
})