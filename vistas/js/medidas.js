var tabla;


$("#modalAgregarMedidas, #modalEditarMedida").draggable({
	 handle: ".modal-header"
});


/*=============================================
EDITAR UNIDAD DE MEDIDA
=============================================*/
$(".activarDatatable").on("click", ".btnEditarMedida", function(){

	var idMedida = $(this).attr("idMedida");

	var datos = new FormData();
	datos.append("idMedida", idMedida);
        // Display the key/value pairs
        //for (var pair of datos.entries()){console.log(pair[0]+ ', ' + pair[1]);}
	$.ajax({
		url: "ajax/medidas.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
            console.log(respuesta);
     		$("#editarMedida").val(respuesta["medida"]);
     		$("#idMedida").val(respuesta["id"]);

     	}

	})


})

/*=============================================
ELIMINAR CATEGORIA
=============================================*/
tabla=$(".activarDatatable").on("click", ".btnEliminarMedida", function(){

	 var idMedida = $(this).attr("idMedida");

    swal.fire({
      title: "¿Está seguro de borrar la Unidad de Medida?",
      text: "¡Si no lo está puede cancelar la acción!",
      icon: "question",
      reverseButtons: true,			//invertir botones
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar!',
      cancelButtonText: 'No, cancelar!',
    })
    .then((willDelete) => {
      if (willDelete.value) {
        window.location = "index.php?ruta=medidas&idMedida="+idMedida;
	    }
    });    
    
})

$(document).ready(function (){ 
	$('.activarDatatable tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
});
