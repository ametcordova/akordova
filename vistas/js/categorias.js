$(document).ready(function(){
  //$(':input:visible:enabled:first').focus();
})

$("#modalAgregarCategoria, #modalEditarCategoria").draggable({

	 handle: ".modal-header"
});

//Función que se ejecuta al inicio
function init(){
  //categoria=1;
  //window.location = "index.php?ruta=categorias&categoria="+categoria;
	//listarCategorias();
    
}


$('#modalAgregarCategoria #modalEditarCategoria').on('show.bs.modal', function (e) {
  //$(':input:visible:enabled:first').focus();
  $(':input:text:visible:first').focus();
})


$('#btnVer').click(function(){
categoria=1;
var URLactual = $(location).attr('href');
console.log(URLactual);
 window.location = "index.php?ruta=categorias&categoria="+categoria;
})


$('.TablaCategorias').DataTable( {
        "stateSave": true,
	   "lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50, 100, "Todos"] ],
       "language": {
		"sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros &nbsp",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrar registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",           
        "sSearch":         "Buscar:",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"}
        },
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		},
        dom: '<clear>Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                title: "AdminLTE",
                customize: function ( doc ) {
                    pdfMake.createPdf(doc).open();
                },
            },
            
       {
            extend: 'print',
            text: 'Imprimir',
            autoPrint: false            //TRUE para abrir la impresora
        }
        ],
        initComplete: function () {
          var btns = $('.dt-button');
          btns.removeClass('dt-button');
          btns.addClass('btn btn-success btn-sm');
        }
		
    } );


$(document).ready(function (){ 
	$('.TablaCategorias tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
});
/*=============================================
EDITAR CATEGORIA
=============================================*/
$(".TablaCategorias").on("click", ".btnEditarCategoria", function(){

	var idCategoria = $(this).attr("idCategoria");

	var datos = new FormData();
	datos.append("idCategoria", idCategoria);
        // Display the key/value pairs
        for (var pair of datos.entries()){console.log(pair[0]+ ', ' + pair[1]);}
	$.ajax({
		url: "ajax/categorias.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
            //console.log(respuesta);
     		$("#editarCategoria").val(respuesta["categoria"]);
     		$("#idCategoria").val(respuesta["id"]);

          var datosFamilia = new FormData();
          datosFamilia.append("idFamilia",respuesta["id_familia"]);
          //console.log(respuesta["id_familia"]);
           $.ajax({
            
              url:"ajax/familias.ajax.php",
              method: "POST",
              data: datosFamilia,
              cache: false,
              contentType: false,
              processData: false,
              dataType:"json",
              success:function(respuesta){
                  //console.log("Familia",respuesta["familia"]);
                  if(typeof respuesta["familia"] === 'undefined'){
                      $("#editFamilia").val("");
                      $("#editFamilia").html("");
                  }else{
                      $("#editFamilia").val(respuesta["id"]);
                      $("#editFamilia").html(respuesta["familia"]);
                  }

              },
              error:function(response){
                   console.log(response);
               }

          })
            
     	}

	})


})

/*=============================================
ELIMINAR CATEGORIA
=============================================*/
$(".TablaCategorias").on("click", ".btnEliminarCategoria", function(){

	 var idCategoria = $(this).attr("idCategoria");

    swal.fire({
      title: "¿Está seguro de borrar la categoría?",
      text: "¡Si no lo está puede cancelar la acción!",
      icon: "warning",
      reverseButtons: true,			//invertir botones
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar!',
      cancelButtonText: 'No, cancelar!',
    })
    .then((willDelete) => {
      if (willDelete.value) {
        window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;
      } else {
        Swal.fire({
          title: 'Acción cancelada',
          icon: 'info',
          timer: 1500,
        })
      }
    });    
    
})

//init();