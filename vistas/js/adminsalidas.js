
/*===================================================
ENVIA REPORTE DE SALIDA DE ALMACEN DESDE EL DATATABLE
===================================================*/
$("#tablalistaSalida tbody").on("click", "a.btnImprimirNotSal", function(){
	let idNotaSalida = $(this).attr("idNumSalida");
   //console.log(idNotaSalida);
    if(idNotaSalida.length > 0){
     window.open("extensiones/tcpdf/pdf/imprimir_salida.php?codigo="+idNotaSalida, "_blank");
    }
})

/*===================================================
ENVIA TICKET DE SALIDA DE ALMACEN DESDE EL DATATABLE
===================================================*/
$("#tablalistaSalida tbody").on("click", "a.btnPrintTicket", function(){
	let idNotaSalida = $(this).attr("idNumSalida");
   //console.log(idNotaSalida);
    if(idNotaSalida.length > 0){
      window.open("extensiones/tcpdf/pdf/impticket.php?codigo="+idNotaSalida,"_blank","top=100,left=500,width=350,height=500");
    }
})

/*===================================================
ENVIA TICKET DE SALIDA DE ALMACEN DESDE EL DATATABLE
===================================================*/
$("#tablalistaSalida tbody").on("click", "a.btnImprimirTicket", function(){
	let idNotaSalida = $(this).attr("idNumSalida");
   //console.log(idNotaSalida);
    if(idNotaSalida.length > 0){
      window.open("extensiones/tcpdf/pdf/imprimir_ticket.php?codigo="+idNotaSalida,"_blank","top=200,left=500,width=400,height=400");
    }
})

/*===================================================
VISUALIZA TICKET DE SALIDA DE ALMACEN DESDE EL DATATABLE
===================================================*/
$("#tablalistaSalida tbody").on("click", "a.btnVerTicket", function(){
	let idNotaSalida = $(this).attr("idNumSalida");
   //console.log(idNotaSalida);
    if(idNotaSalida.length > 0){

	  window.open("ticket/voucher/ver_ticket.html?codigo="+idNotaSalida, "_blank","top=180,left=560,width=250,height=400");
	
    }
})

/*===================================================
ELIMINA VENTA DESDE EL DATATABLE
===================================================*/
$("#tablalistaSalida tbody").on("click", "a.btnEliminarVenta", function(){
	let idNotaSalida = $(this).attr("idNumSalida");
	let idusuario=$("#idDeUsuario").val();
    //console.log("Eliminar:",idNotaSalida);
	//console.log("usuario:",idusuario);
	Swal.fire({
		title: '¿Está seguro de Eliminar Venta #'+idNotaSalida,
		text: "¡Si no lo está puede cancelar la acción!",
		icon: 'warning',
		reverseButtons: true,			//invertir botones
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar!',
		cancelButtonText: 'No, cancelar',
	  })
	
    .then((aceptado) => {
      if (aceptado.value) {
		const data = new FormData();
		data.append('idNotaSalida', idNotaSalida);
		data.append('idUsuario', idusuario);
		fetch('ajax/adminsalidas.ajax.php', {
		   method: 'POST',
		   body: data
		})
		.then(function(response) {
		   if(response.ok) {
			  console.log(response);
			   return response.text()
		   } else {
			   throw "Error en la llamada Ajax";
		   }

		})
		.then(function(texto) {
		console.log(texto);
         $('#tablalistaSalida').DataTable().ajax.reload(null, false);
		})
		.catch(function(err) {
		   console.log(err);
		});		
   		 swal({
		      title: "Realizado!!",
		      text: `La Venta No. ${idNotaSalida} ha sido Eliminado`,				//backtick ` para crear cadenas interpoladas
		      icon: "success",
		      button: "¡Cerrar!"
		    })
			.then((aceptado) => {
			  if (aceptado) {
				//window.location = "adminsalidas";
			  }else{
				  return false;
			  }
			}); 
				
			  }else{
				  return false;
			  }
	}); 
    
})

/*=========================================================
MUESTRA SALIDAS DE ALMACEN EN EL DATATABLE SEGUN CONDICIONES
==========================================================*/
function listarSalida(){
   let almacenSel = $("#almSalida").val();
   let clienteSel = $("#clienteSel").val();
   let fechaSel = $("#datepicker4").val();
    console.log(almacenSel, clienteSel, fechaSel);

$(document).ready(function() {

$('#tablalistaSalida').dataTable(
	{
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
		"sNext":     ">",
		"sPrevious": "<"}
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
                title: "@Kórdova",
                customize: function ( doc ) {
                    pdfMake.createPdf(doc).open();
                },
            },
            
       {
            extend: 'print',
            text: 'Imprimir',
            autoPrint: false            //TRUE para abrir la impresora
        }],    
		initComplete: function () {			//botones pequeños y color verde
          var btns = $('.dt-button');
          btns.removeClass('dt-button');
          btns.addClass('btn btn-success btn-sm');
        },  
		"columnDefs": [
        {"className": "dt-center", "targets": [4]},
        {"className": "dt-center", "targets": [5]},
        {"className": "dt-center", "targets": [7]},
        {"className": "dt-center", "targets": [8]},
		{"className": "dt-right", "targets": [6]}				//Alinear columnas "_all" para todas las columnas
		],
	"footerCallback": function ( row, data, start, end, display ) {
	   var api = this.api();
	 //console.log(api,data);

	   // cant Total over all pages
	   var totalcant = api.column(5).data().sum();
	   totalcant=new Intl.NumberFormat('en', {notation: 'standard',}).format(totalcant);
	   //console.log(totalcant);

	   // Total over this page
	   var pageTotal = api.column(6, {page:'current'}).data().sum();
	   pageTotal=new Intl.NumberFormat('en', {style: 'currency',currency: 'USD',currencySign: 'accounting',}).format(pageTotal);
	   //console.log(pageTotal);
	
	   // Total over all pages
	   var total = api.column(6).data().sum();
	   total=new Intl.NumberFormat('en', {style: 'currency',currency: 'USD',currencySign: 'accounting',}).format(total);
	   //console.log(total);

	   $(api.column(4).footer()).html('Totales:');
	   $(api.column(5).footer()).html(totalcant);
	   $(api.column(6).footer()).html(pageTotal);
	   $(api.column(7).footer()).html(total);
	},
		"processing": true,
		"ajax":
				{
					url: 'ajax/adminsalidas.ajax.php',
					data:{almacenSel: almacenSel, clienteSel: clienteSel, fechaSel: fechaSel},
					type : "get",
					dataType : "json",	
					error: function(e){
						console.log(e.responseText);
                    }
                },
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 3, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();

});         
}
//=========================================================
//FIN DEL DATATABLE
//==========================================================


$('#datepicker4').datepicker({
    autoclose:true,
    todayHighlight:true,
    calendarWeeks:true,
    clearBtn:true,
    language:"es"
});   
    
jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        if ( typeof a === 'string' ) {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if ( typeof b === 'string' ) {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }
        return a + b;
    }, 0 );
} );	

$(document).ready(function (){ 
	$('#tablalistaSalida tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
});
