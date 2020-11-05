var detalles=0;
let contar=1;
var qty=0;	
var preciocompra=0;
$(document).ready(function(){
    $("#btnGuardar").hide();
    $( "#sumasubtotal" ).prop( "disabled", true );
    $( "#iva" ).prop( "disabled", true );
    $( "#total" ).prop( "disabled", true );
})
    

//MUESTRA EL SELECT PARA AGREGAR PROD Y DESHABILITA LOS ALMACENES	
$("#nuevoAlmacen").change(function(){
	$("#agregaProdEntra").removeClass("d-none" )
    $('#nuevoAlmacen option:not(:selected)').attr('disabled',true);  //deshabilita select
});	
	

//AGREGA CANT EXISTENTE Y VALIDA LA CANT SALIENTE
$("#selecProducto").change(function(event){
event.preventDefault();
  let idProducto=$("#selecProducto").val();
  let quealmacen=$("#nuevoAlmacen").val().split('-');
  let nomBodega = quealmacen[1];    
    //console.log(nomBodega);
    //console.log("id PRODUCTO",idProducto)
  
  $.get('ajax/entradas.ajax.php', {idProducto:idProducto, nomAlmacen:nomBodega}, function(response,status) {
   //console.log(response, status);
    let contenido = JSON.parse(response);
    let cantexiste=parseFloat(contenido["cant"]);
    let precioVenta=parseFloat(contenido["precio_venta"]);
    let precioCompra=parseFloat(contenido["precio_compra"]);
     $("#cantExiste").val(cantexiste);
     $("#price_venta").val(precioVenta).number(true,2);
     $("#price_compra").val(precioCompra).number(true,2);
    });
});	

	
 //AGREGAR PRODUCTO SELECCIONADO                 
$("#agregarDetalle").click(function(event){
event.preventDefault();

var idProducto=$("#selecProducto").val();
var producto=$("#selecProducto option:selected" ).text();

idProducto=parseInt(idProducto);

//console.log(idProducto, producto, typeof idProducto);

//SE SEPARA EL CODIGO DEL PROD. SELECCIONADO    
var codigointerno= producto.substr(0, producto.indexOf('-'));
codigointerno.trim();

//SE SEPARA LA DESCRIPCION DEL PROD. SELECCIONADO        
var descripcion= producto.substr(producto.lastIndexOf("-") + 1);
descripcion.trim();

//Si no selecciona producto retorna
if(isNaN(idProducto)){
	return true;
} 


var cantEntra=$("#cantEntra").val();
cantEntra=parseFloat(cantEntra);

//Si no hay cantida de entrada, retorna
if(isNaN(cantEntra) || cantEntra<=0){
	return true;
} 

let preciocompra=$("#price_compra").val();
preciocompra=parseFloat(preciocompra);

let precioventa=$("#price_venta").val();
precioventa=parseFloat(precioventa);
    
    //DESPUES DE AÑADIR ELEMENTO SE INICIALIZA SELECT
    $("#selecProducto").val("");
    $("#selecProducto").change();

	//FUNCION PARA AGREGAR EL PRODUCTO CAPTURADO
	agregardet(idProducto,codigointerno,descripcion,cantEntra, preciocompra,precioventa);
	$("#cantEntra").val(0);
 
})

//FUNCION PARA AGREGAR ENTRADAS DE PRODUCTOS.
function agregardet(idProducto,codigointerno,descripcion,cantidad,precio_compra,precio_venta){  
	 let subtotal=0;
	 //costo=(cantidad*precio_compra);
	 //utilidad=(cantidad*precio_venta)-costo;
	var fila='<tr class="filas" id="fila'+contar+'">'+
        
    	'<th><button type="button" class="botonQuitar" onclick="eliminarDetalle('+contar+')" title="Quitar Concepto">X</button></th>'+
        
        '<th><input type="hidden" value="'+contar+'" style="width:3em">'+idProducto+'</th>'+
		
    	'<th><input type="hidden" name="codigointerno[]" id="codigointerno[]" value="'+codigointerno+'" style="width:13em;">'+codigointerno+'</th>'+
        
		'<th><input type="hidden" name="idProducto[]" value="'+idProducto+'" style="width:36em">'+descripcion+'</th>'+
		
		'<input type="hidden" name="precio_venta[]" id="precio_venta[]" value='+precio_venta+'>'+
        
    	'<th class="text-center"><input type="number" name="cantidad[]" id="cantidad[]" idFila=f'+contar+' class="cuantos text-center" value='+cantidad+' style="width:3.5em; text-align:center;" readonly></th>'+
        
    	'<th class="text-center"><input type="number" name="precio_compra[]" id="precio_compra[]" class="precio'+contar+'" value='+precio_compra+' step="any" style="width:5em; background-color:lightblue;" readonly dir="rtl"></th>'+
        
    	'<th class="text-center"><input type="text" name="subtotal" id="subtotal'+contar+'" class="importe_linea" value="'+subtotal+'" style="width:5em" step="any" readonly dir="rtl"></th>'+
		
    	'</tr>';
		
    	contar++;
    	detalles=detalles+1;    
		$('#detalles').prepend(fila);

	calcular()			//CALCULAR SUBTOTAL=CANT POR PRECIO
	calcularTotales();	//SUMA LOS SUBTOTALES PARA OBTENER EL TOTAL
	evaluar();			//SI NO HAY ELEMENTOS cont SE INICIALIZA
	
}
	
//CALCULAR SUBTOTAL DE CADA PRODUCTO
function calcular() {
	importe_subtotal = 0
	$(".importe_linea").each(
		function(index, value) {
			importe_subtotal = importe_subtotal + eval($(this).val());
			let qty=($(this).parent('th').prev().prev().children('input').val());
			let pre=($(this).parent('th').prev().children('input').val());
			let sub=$(this).attr("id")
			importe_subtotal = (parseFloat(qty)*parseFloat(pre));
			$("#"+sub).val(importe_subtotal).number(true,2);
			$(".importe_linea" ).prop( "disabled", true );
		}
	);
 }


//FUNCION QUE SUMA LOS SUBTOTALES
function calcularTotales() {
	importe_subtotal = 0
	$(".importe_linea").each(
		function(index, value) {
			importe_subtotal = importe_subtotal + eval($(this).val());
            console.log("eval: ",eval($(this).val()));
		}
	);
    var impuesto =16;
    var antesdeiva=(impuesto/100)+1;        //1.16
        
    var importe_antes_iva=Number(importe_subtotal / antesdeiva);
        
    var sacar_iva=(Number(importe_subtotal)-importe_antes_iva);
        
    var importe_total=importe_antes_iva+sacar_iva;
    
    $("#sumasubtotal").val(importe_antes_iva).number(true,2);
    $("#iva").val(sacar_iva).number(true,2);
    $("#total").val(importe_total).number(true,2);
    
    /*
    var importe_iva=Number(importe_subtotal * impuesto/100);
    var importe_total=Number(importe_iva) + Number(importe_subtotal);    
    
	$("#sumasubtotal").val(importe_subtotal).number(true,2);
	$("#iva").val(importe_iva).number(true,2);
	$("#total").val(importe_total).number(true,2);
    */
    
	if(importe_total>0){
	  $("#btnGuardar").show();
    }else{
		$("#btnGuardar").hide();
	}
}


//QUITA ELEMENTO 
 function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar();
  }

 
//SI NO HAY ELEMENTOS cont SE INICIALIZA
function evaluar(){
  if (!detalles>0){
      contar=0;
	  $("#btnGuardar").hide();
    }
}


//ENVIAR FORMULARIO PARA GUARDAR DATOS DE ENTRADA
$("body").on("submit", "#formulario", function( event ) {	
event.preventDefault();
event.stopPropagation();	
console.log("enviar form");

	Swal.fire({
		title: '¿Está seguro de Guardar Entrada?',
		text: "¡Si no lo está puede cancelar la acción!",
		icon: 'warning',
		reverseButtons: true,			//invertir botones
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Guardar!',
		cancelButtonText: 'No, cancelar!',
	  })

    .then((aceptado) => {
      if (aceptado.value) {
		  event.currentTarget.submit();		//CONTINUE EL ENVIO DEL FORMULARIO
      }else{
		  return false;
	  }
    }); 

 });


 /*
$('.btnImprimirEntrada').on('click', function() {
  var idNumEntrada = $("#numeroDocto").val();
    window.open("extensiones/tcpdf/pdf/imprimir_entrada.php?codigo="+idNumEntrada, "_blank");
});
*/


//VALIDAR QUE NUM DE DOCTO NO SE REPITA POR AJAX.GET
$('#numeroDocto').on('blur', function() {
    $('span#msjDoctoRepetido').html("");
    var numDocto = $("#numeroDocto").val();
   if(numDocto.length !=0){
     //if($("#numeroDocto").val().length !=0){

        $.get("ajax/entradas.ajax.php", {numDocto : numDocto}, function(resp, estado,jqXHR){
         console.log("Respuesta: " + resp + "\nEstado: " + estado +"\njqHXR: " + jqXHR);   
	   
		 if(estado="success"){	
			if(!(parseInt(resp)===0)){
			  //$('span#msjDoctoRepetido').html("<label class='alert alert-info'>Número ya existe!!</label>");
			  $('span#msjDoctoRepetido').html(`<label style='color:red'>AVISO!! ${resp} </label>`);
			  $("input#numeroDocto").focus(function(){
			  $("span#msjDoctoRepetido").css("display", "inline").fadeOut(4000);
			});
				 $("#numeroDocto").val('');
				 $("#numeroDocto").focus();
			}  
		}else{
			$('span#msjDoctoRepetido').html(`<label style='color:red'>ERROR!! ${estado} </label>`);
		}
		
      })   
   }	

});

$('.select2').select2({
  placeholder: 'Busca y selecciona un producto',
});



/* ======================================== CODIGO RECICLABLE  ======================================*/
//CHECA QUE NO HAYA SUBTOTALES SIN IMPORTE
/*
$("body").on("click", "#btnGuardar", function( event ) {    
let check;
   $(".importe_linea").each(function(index, value) {
	  chek=eval($(this).val());
        if(chek==0){
          event.preventDefault();
          return false;
        }
	})
});
*/


/*
	//TRAER EL PRECIO DE COMPRA Y PRECIO DE VENTA
	$.getJSON( "ajax/productos.ajax.php", { "idProducto" : idProducto} )
		.done(function( data, textStatus, jqXHR ) {
			var preciocompra=data.precio_compra;
			
			$(".precio"+(cont-1)).val(preciocompra);
			
			var pcompra=$(".precio"+(cont-1)).val();
			
			$("#subtotal").val(pcompra);
			
			console.log($("idFila"+cont-1).val());
			
			console.log("precio Compra",data.precio_compra);
			if ( console && console.log ) {
				console.log( "La solicitud se ha completado correctamente.",textStatus, jqXHR );
				//console.log(data);
				if (textStatus === "success") {
					//datos=JSON.stringify(data);

					console.log("precio Compra",data.precio_compra);
					console.log("precio Venta",data.precio_venta);
					var preciocompra=data.precio_compra;
				}
			}
			
		})
		
		.fail(function( jqXHR, textStatus, errorThrown ) {
			if ( console && console.log ) {
				console.log( "Algo ha fallado: " + textStatus); 
			}
		});
	//FINALIZA .getjson   
*/