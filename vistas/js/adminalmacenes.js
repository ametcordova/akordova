

//Función que se ejecuta al inicio
function init(){

    /*=============================================
    VARIABLE LOCAL STORAGE
    =============================================*/
    if(localStorage.getItem("capturarRango") != null){
      $("#daterange-btn-compras span").html(localStorage.getItem("capturarRango"));
    }else{
      //$("#daterange-btn-Ajuste span").html('<i class="fa fa-calendar"></i> Rango de fecha!')
      fechadehoy();
    }

  }
 
function formatState (state) {
    if(!state.element) return;
    var os = $(state.element).attr('onlyslave');
    return $('<span onlyslave="' + os + '">' + state.text + '</span>');
 }
  
  $(document).ready(function() {
        $("#famDeVentas").select2({
        templateResult: formatState,
        placeholder: 'Selecciona Familia'
      });
  });

  
//$('#promocion').on('ifChanged', function(event) {
$("#SelectAll").on('ifToggled', function(event) {
    if( $(this).is(':checked') ){
        console.log("entra1")
        $("#famDeVentas > option").prop("selected","selected");// Select All Options
        $("#famDeVentas").trigger("change");// Trigger change to select 2
        $("#catDeVentas").prop('disabled', true);
    }else{
        console.log("entra2")
        //$("#famDeVentas > option").removeAttr("selected");
        //$("#famDeVentas").trigger("change");// Trigger change to select 2
        $("#famDeVentas").find('option').prop("selected",false);
        $("#famDeVentas").trigger('change');		
        $("#catDeVentas").prop('disabled', false);
     }
});


$('.btnImprimirRepo').on('click', function() {
    
let id_bodega=$("#almEntrada").val();
let id_nomalma=$("#almEntrada option:selected" ).text();    //Nombre del almacen Seleccionado
let id_familia=$("#famDeVentas").val();
let id_categoria=$("#catDeVentas").val();
let id_producto=$("#selectProductoRep").val();
let rangodeFecha = $("#daterange-btn-compras span").html();
let cuanto=rangodeFecha.length;
//let prods=$("[name='selectProductoRep[]']").val();

//console.log(prods);
//console.log(id_producto);
//console.log("rango de fecha:",rangodeFecha);

  
// SI NO TRAE FECHA, SE ASIGNA LA FECHA ACTUAL
if(parseInt(cuanto)>23){
    rangodeFecha=hoyFecha()+" - "+hoyFecha();
}
    let arrayFecha = rangodeFecha.split(" ", 3);
    let f1=arrayFecha[0].split("-");
    let f2=arrayFecha[2].split("-");
    let id_fechaentra1=f1[2].concat("-").concat(f1[1]).concat("-").concat(f1[0]); //armar la fecha año-mes-dia
    let id_fechaentra2=f2[2].concat("-").concat(f2[1]).concat("-").concat(f2[0]);
 
/*console.log("idalm:",id_bodega);
console.log("nomalm:",id_nomalma);
console.log("idfam:",id_familia);
console.log("idcat:",id_categoria);
console.log("idprod:",id_producto);
console.log("fechas:",rangodeFecha);
console.log("fecha1 ",id_fechaentra1);    
console.log("fecha2 ",id_fechaentra2); 
*/

if(parseInt(id_bodega)> 0){
     window.open("extensiones/tcpdf/pdf/reporte_entrada.php?idbodega="+id_bodega+"&idnomalma="+id_nomalma+"&idfamilia="+id_familia+"&idcategoria="+id_categoria+"&idproducto="+id_producto+"&idfechaentra1="+id_fechaentra1+"&idfechaentra2="+id_fechaentra2,"_blank");
}else{
    $('#messagerror').text('Seleccione Almacen!!');
    $("#messagerror").removeClass("d-none");
    setTimeout(function(){$("#messagerror").addClass("d-none")}, 3000);   //1000 ms= 1segundo
    return false;
}
    
});


$("#tablalistado tbody").on("click", "button.btnImprimir", function(){
	var idEntrada = $(this).attr("idNumDocto");
    if(idEntrada.length > 0){
     window.open("extensiones/tcpdf/pdf/imprimir_entrada.php?codigo="+idEntrada, "_blank");
    }
})


function listarEntrada(){
   let almacenSel = $("#almEntrada").val();
   let id_familia=$("#famDeVentas").val();
   let id_categoria=$("#catDeVentas").val();
   let id_producto=$("#selectProductoRep").val();
   idNumAlma=parseInt(almacenSel);
       if(idNumAlma==0){
		$('#messagerror').text('Seleccione Almacen!!');
		$("#messagerror").removeClass("d-none");
		setTimeout(function(){$("#messagerror").addClass("d-none")}, 3000);   //1000 ms= 1segundo
        return false;
        }   
   let rangodeFecha = $("#daterange-btn-compras span").html();
   let cuanto=rangodeFecha.length;
   
   //console.log("rango de fecha:",rangodeFecha);
   //console.log("Alm:",almacenSel,"id_fam:",id_familia, "id_cat:",id_categoria, "id_prod:",id_producto);
     
   // SI NO TRAE FECHA, SE ASIGNA LA FECHA ACTUAL
   if(parseInt(cuanto)>23){
       rangodeFecha=hoyFecha()+" - "+hoyFecha();
   }
       let arrayFecha = rangodeFecha.split(" ", 3);
       let f1=arrayFecha[0].split("-");
       let f2=arrayFecha[2].split("-");
       let id_fechaentra1=f1[2].concat("-").concat(f1[1]).concat("-").concat(f1[0]); //armar la fecha año-mes-dia
       let id_fechaentra2=f2[2].concat("-").concat(f2[1]).concat("-").concat(f2[0]);   
    
$(document).ready(function() {

$('#tablalistado').dataTable({
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
                title: "Reporte de Compras",
                filename: 'reportecompras',
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
		"ajax":
				{
					url: 'ajax/adminalmacenes.ajax.php', data:{almacenSel: almacenSel, fechainientra: id_fechaentra1, fechafinentra: id_fechaentra2, id_familia: id_familia, id_categoria: id_categoria, id_producto: id_producto},
					type : "get",
					dataType : "json",	
					error: function(e){
						console.log(e.responseText);
                    }
                },
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 4, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();

});         
}

$('.select4').select2({
  placeholder: 'Busca y selecciona hasta 5 productos',
  maximumSelectionLength: 5,            //maximo de items para seleccionar
 });
/*
var data = []; // Programatically-generated options array with > 5 options
$(".mySelect").select2({
    data: data,
    placeholder: placeholder,
    allowClear: false,
    minimumResultsForSearch: 5});
*/

$("#famDeVentas").on('change',function () {
    $("#catDeVentas").val(0);
    $("#selectProductoRep").select2("val", "");
	$("#famDeVentas option:selected").each(function () {       //?? 
        //id_familia = $(this).val();
        let id_familia=$("#famDeVentas").val();
		//console.log("dato", id_familia);
		$.post("ajax/adminalmacenes.ajax.php", { id_familia: id_familia }, function(datafamilia){
            //console.log(data);
			$("#catDeVentas").html(datafamilia);
		});            
	});
})


$(" #famDeVentas, #catDeVentas").on('change',function () {
    $("#selectProductoRep").select2("val", "");
    let id_familia=$("#famDeVentas").val();
	$("#catDeVentas option:selected").each(function () {       //?? 
		let id_categoria = $(this).val();
		console.log("Fam:",id_familia, "cat:",id_categoria);
		$.post("ajax/adminalmacenes.ajax.php", { idfamilia : id_familia , id_categoria: id_categoria }, function(data){
            //console.log(data);
			$("#selectProductoRep").html(data);
		});            
	});
})

//Date range as a button
    //$('#daterange-btn').daterangepicker({ startDate: '04/01/2019', endDate: '04/03/2019' },
    $('#daterange-btn-compras').daterangepicker(
        
        {
          ranges   : {
            'Hoy'       : [moment(), moment()],
            'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 Días' : [moment().subtract(6, 'days'), moment()],
            'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
            'Este Mes'  : [moment().startOf('month'), moment().endOf('month')],
            'Último Mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
  
          "locale": {
              "format": "YYYY-MM-DD",
              "separator": " - ",
              "daysOfWeek": [
                  "Do",
                  "Lu",
                  "Ma",
                  "Mi",
                  "Ju",
                  "Vi",
                  "Sa"
              ],
              "monthNames": [
                  "Enero",
                  "Febrero",
                  "Marzo",
                  "Abril",
                  "Mayo",
                  "Junio",
                  "Julio",
                  "Agosto",
                  "Setiembre",
                  "Octubre",
                  "Noviembre",
                  "Diciembre"
              ],
              "firstDay": 1
          },          
          startDate: moment(),
          endDate  : moment()
        },
        function (start, end) {
          $('#daterange-btn-compras span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
            
          var fechaInicial=start.format('YYYY-M-D');
          var fechaFinal=end.format('YYYY-M-D');
          //console.log(fechaInicial, fechaFinal);
          var capturarRango = $("#daterange-btn-compras span").html();
          //console.log("rango de fecha:",capturarRango);
          
            localStorage.setItem("capturarRango", capturarRango);
            
            //window.location = "index.php?ruta=reportes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
        }
      )
  
/*=============================================
ASIGNA FECHA ACTUAL EN DATERANGEPICKER 
=============================================*/    
function fechadehoy(){
   
    var d = new Date();
    //console.log("Fecha de Hoy:",d);
    var dia = d.getDate();
    var mes = d.getMonth()+1;
    var año = d.getFullYear();

    if(mes < 10){

      var fechaInicial = dia+"-0"+mes+"-"+año;
      var fechaFinal = dia+"-0"+mes+"-"+año;

    }else if(dia < 10){

      var fechaInicial = "0"+dia+"-"+mes+"-"+año;
      var fechaFinal =   "0"+dia+"-"+mes+"-"+año;

    }else if(mes < 10 && dia < 10){

      var fechaInicial = "0"+dia+"-0"+mes+"-"+año;
      var fechaFinal =   "0"+dia+"-0"+mes+"-"+año;

    }else{

      var fechaInicial = dia+"-"+mes+"-"+año;
      var fechaFinal =   dia+"-"+mes+"-"+año;

    } 
        $("#daterange-btn-compras span").html(fechaInicial+' - '+fechaFinal);
        //console.log(fechaInicial+' - '+fechaFinal);
    	  localStorage.setItem("capturarRango", fechaInicial+' - '+fechaFinal);
    	
} 

function hoyFecha(){
    var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1;
        var yyyy = hoy.getFullYear();
        
        dd = addZero(dd);
        mm = addZero(mm);

        return yyyy+'-'+mm+'-'+dd;
 }

function addZero(i) {
    if (i < 10) {
        i = '0' + i;
    }
    return i;
}

init();