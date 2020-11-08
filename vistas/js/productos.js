let cont=1;
var detalles=0;
$("#modalEditarProducto, #modalAgregarProducto, #modal").draggable({
	 handle: ".modal-header"
});

let placeholder = "&#xf002 Busque y seleccione producto";
$('.select3').select2({
    placeholder: placeholder,
    escapeMarkup: function(m) { 
       return m; 
    }
});


//============AL ENTRAR AL MODAL DESACTIVA EL CHECKED DE LEYENDA =================
$("#modalEditarProducto, #modalAgregarProducto").on('show.bs.modal',function() {
	
    $(".tbodypromo").empty();	//VACIA LOS DATOS DE LA PROMOCION DEL TBODY
	
    $('.insertaLeyenda').iCheck('check', function(){
        $('.insertaLeyenda').iCheck('uncheck');    
	});


	// desactiva el check de envase
    $('.esenvase').iCheck('uncheck');

    // desactiva el check de servicio
    $('.esservicio').iCheck('uncheck');    

    // desactiva el check de servicio
    $('.esotros').iCheck('uncheck');    
	
    // desactiva el check de granel
    $('.esagranel').iCheck('uncheck');    


    //$('.edtpromocion').iCheck('uncheck');    

    //$('.promocion, .edtpromocion').iCheck('check', function(){
        //$('.promocion, .edtpromocion').iCheck('uncheck');    
	//});

    //$('.edtpromocion').iCheck('check', function(){
        //$('.edtpromocion').iCheck('check'); 
		//$(".edtoculto").removeClass("d-none");
	//});

});

/* == CHECAR QUE CUANDO CAMBIE MODIFIQUE EL OTRO CHECKBOX ==*/
	$('.esenvase').on('ifChecked', function(event){
	  //alert(event.type + ' callback');
	  $('.esservicio, .esotros').iCheck('uncheck');    
	});

	$('.esservicio').on('ifChecked', function(event){
	  $('.esenvase, .esotros').iCheck('uncheck');    
    });

	$('.esotros').on('ifChecked', function(event){
        $('.esenvase, .esservicio').iCheck('uncheck');    
    });
      
/* =========================================================*/

$('.insertaLeyenda').on('ifChanged', function(event) {
    if( $(this).is(':checked') ){      // Hacer algo si el checkbox ha sido seleccionado
        $(".inputLeyenda").removeClass("d-none");
    } else {        // Hacer algo si el checkbox ha sido deseleccionado
        $("#nuevaLeyenda").val("");
        $("#editarLeyenda").val("");
        $(".inputLeyenda").addClass("d-none");
    }
});


$('.promocion').on('ifChanged', function(event) {
    if( $(this).is(':checked') ){      // Hacer algo si el checkbox ha sido seleccionado
        $(".oculto").removeClass("d-none");
    } else {        // Hacer algo si el checkbox ha sido deseleccionado
        $(".oculto").addClass("d-none");
    }
});


$('.edtpromocion').on('ifChanged', function(event) {
    if( $(this).is(':checked') ){      // Hacer algo si el checkbox ha sido seleccionado
        $(".edtoculto").removeClass("d-none");
    } else {        // Hacer algo si el checkbox ha sido deseleccionado
        $(".edtoculto").addClass("d-none");
    }
});

// ============ AL SALIR DEL MODAL DE EDICION  ====================
$("#modalEditarProducto").on('hidden.bs.modal', function () {
 $(".tbodypromo").empty();	//VACIA LOS DATOS DE LA PROMOCION DEL TBODY
     // desactiva el check de promo
     $('.edtpromocion').iCheck('uncheck');    
     $('#formeditprod')[0].reset();
});

/*=============================================
CARGAR LA TABLA DINÁMICA DE PRODUCTOS
=============================================*/
var perfilOculto = $("#perfilOculto").val();
//var table=$('.tablaProductos').DataTable();
var printCounter = 0;

var table=$('.tablaProductos').dataTable( {
    "ajax": "ajax/datatable-productos.ajax.php?perfilOculto="+perfilOculto,
    "deferRender": true,
	"retrieve": true,
	"processing": true,
    "stateSave": true,
	"lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50, 100, "Todos"] ],
	"sPaginationType": "full_numbers",
    
	 "language": {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros  &nbsp",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrar registros del _START_ al _END_ de un total de _TOTAL_",
			"sautoWidth": 	   "true",
			"sInfoEmpty":      "Mostrar registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "(actualizados)",
			"sSearch":         "Buscar:",
			"searchPlaceholder":"Dato a buscar",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "<<",
			"sLast":     ">>",
			"sNext":     ">",
			"sPrevious": "<"}
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			},
			//dom: 'Bfrt<"col-md-6 inline"i> <"col-md-6 inline"p>',
			dom: '<clear>Bfrtip',
        buttons: [
            'copyHtml5',
            'csvHtml5',
            'pdfHtml5',
			{
			  extend: 'excel',
			  title:"CATALOGO DE PRODUCTOS.",
			  messageTop: 'The information in this table is copyright to @Kórdova Corp.',
			  messageBottom: '@Kórdova®',
 
			  text: 'E<u>X</u>port Excel',
			  className: 'exportExcel',
			  filename: 'CatProd',
			  exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]	//COLUMNAS A IMPRIMIR
              },			  
			  key: {
					key: 'x',
					altKey: true
				  }			  
			}, 			
		{
            extend: 'print',
            text: 'Imprimir',
            titleAttr: 'Imprimir',			
			className: 'imprimir',			
            autoPrint: false            //TRUE para abrir la impresora
        }],    
		initComplete: function () {			//botones pequeños y color verde
          var btns = $('.dt-button');
          btns.removeClass('dt-button');
          btns.addClass('btn btn-success btn-sm');
        },  
		"columnDefs": [
        {"className": "dt-center", "targets": [6]},	//la columna de Stock
			{"className": "dt-right", "targets": [7,8]},				
			{"className": "dt-right", "targets": [9]}				//Alinear columnas "_all" para todas las columnas
		],
} ).DataTable();

$(document).ready(function (){ 

	$('.tablaProductos tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

//Disable full page
$('.content-wrapper').on('cut copy paste', function (e) {
    alert("No se puede copiar");
    e.preventDefault();
});

});


/*=============================================
VERIFICAR QUE NO SE REPITA EL CODIGO
=============================================*/
$("#nuevoCodInterno").blur(function(){
    console.log("entra:",$("#nuevoCodInterno").val())
    let idCodInterno =$("#nuevoCodInterno").val();
    idCodInterno = idCodInterno.trim();
	var datos = new FormData();
    datos.append("idcodinterno", idCodInterno);    

        (async () => {
            try {
                var init = {
                    method: "POST",
                    body: datos
                };
                var response = await fetch('ajax/productos.ajax.php', init);
                if (response.ok) {
                    var respuesta = await response.json();
                    //console.log(respuesta);
                    //console.log("respuesta es: " + respuesta.descripcion);
                    if(!respuesta==false){
                        
                        $('span.msjCodigoRepetido').html(`<p class="ml-2" style='color:red'>AVISO!! ${'Código Repetido'} </p>`);
                        $("span.msjCodigoRepetido").css("display", "inline").fadeOut(4000);
                        $("input#nuevoCodInterno").val('');
                        $("input#nuevoCodInterno").focus();
                        //return false;
                    }
                } else {
                   throw new Error(response.statusText);
                }
            } catch (err) {
                console.log("Error al realizar la petición AJAX: " + err.message);
            }
        })();        
})

/*=============================================
VERIFICAR QUE NO SE REPITA EL CODIGO AL EDITAR PROD
=============================================*/
$("#editarCodInterno").change(function(){
    console.log("entra:",$("#editarCodInterno").val())
    let idCodInterno =$("#editarCodInterno").val();
    idCodInterno = idCodInterno.trim();
	var datos = new FormData();
    datos.append("idcodinterno", idCodInterno);    

        (async () => {
            try {
                var init = {
                    method: "POST",
                    body: datos
                };
                var response = await fetch('ajax/productos.ajax.php', init);
                if (response.ok) {
                    var respuesta = await response.json();
                    //console.log(respuesta);
                    //console.log("respuesta es: " + respuesta.descripcion);
                    if(!respuesta==false){
                        
                        $('span.msjCodigoRepetido').html(`<p class="ml-2" style='color:red'>AVISO!! ${'Código Repetido'} </p>`);
                        $("span.msjCodigoRepetido").css("display", "inline").fadeOut(4000);
                        $("input#editarCodInterno").val('');
                        $("input#editarCodInterno").focus();
                        //return false;
                    }
                } else {
                   throw new Error(response.statusText);
                }
            } catch (err) {
                console.log("Error al realizar la petición AJAX: " + err.message);
            }
        })();        
})

/*=============================================
CAPTURANDO LA FAMILIA PARA MOSTRAR LAS CATEGORIAS
=============================================*/
$("#nuevaFamilia").on('change',function () {
    //$("#catDeVentas").val(0);
        //id_familia = $(this).val();
        let id_familia=$("#nuevaFamilia").val();
		console.log("dato", id_familia);
		$.post("ajax/adminalmacenes.ajax.php", { id_familia: id_familia }, function(datafamilia){
            //console.log(data);
			$("#nuevaCategoria").html(datafamilia);
		});            
})

/*=============================================
MOSTRAR CATEGORIA SEGUN FAMILIA PARA EDITAR
=============================================*/
$(".editfam").on('change',function () {
        //console.log($(this).val());
        let id_familia=$(this).val();
		console.log("dato", id_familia);
		$.post("ajax/adminalmacenes.ajax.php", { id_familia: id_familia }, function(datafamilia){
            //console.log(data);
			$(".editarCategoria").html(datafamilia);
		});            
})

/*=============================================
CAPTURANDO LA CATEGORIA PARA ASIGNAR CÓDIGO
=============================================*/
$("#nuevaCategoria").change(function(){

	var idCategoria = $(this).val();

	var datos = new FormData();
  	datos.append("idCategoria", idCategoria);

  	$.ajax({

      url:"ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){

      	if(!respuesta){

      		var nuevoCodigo = idCategoria+"00";
      		$("#nuevoCodigo").val(nuevoCodigo);

      	}else{

      		var nuevoCodigo = Number(respuesta["codigo"]) + 1;
          	$("#nuevoCodigo").val(nuevoCodigo);

      	}
                
      }

  	})

})

/*=============================================
AGREGANDO PRECIO DE VENTA
=============================================*/
$("#nuevoPrecioCompra, #editarPrecioCompra").change(function(){

	if($(".porcentaje").prop("checked")){

		var valorPorcentaje = $(".nuevoPorcentaje").val();
		
		var porcentaje = Number(($("#nuevoPrecioCompra").val()*valorPorcentaje/100))+Number($("#nuevoPrecioCompra").val());

		var editarPorcentaje = Number(($("#editarPrecioCompra").val()*valorPorcentaje/100))+Number($("#editarPrecioCompra").val());

		$("#nuevoPrecioVenta").val(porcentaje);
		$("#nuevoPrecioVenta").prop("readonly",true);

		$("#editarPrecioVenta").val(editarPorcentaje);
		$("#editarPrecioVenta").prop("readonly",true);

	}else{
        console.log("no entra a cambiar porcentaje2")
    }
        var datos = new FormData();
        //datos.append("idProducto", idProducto);
        for (var pair of datos.entries()){console.log(pair[0]+ ', ' + pair[1]);}

})


/*=============================================
CAMBIO DE PORCENTAJE
=============================================*/
$('.porcentaje').on('ifChanged', function(event) {
    //alert('checked = ' + event.target.checked);
    //alert('value = ' + event.target.value);
});

$(".nuevoPorcentaje").change(function(){

    // $('porcentaje').iCheck('check', function(){
    //     //alert('Well done, Sir');
    //     console.log("aqui si entra a cambiar porcentaje")    
    // });    
    //$('porcentaje').on('ifChecked', function(event){
        //$(".hide").toggle();
    //});
	//if($(".porcentaje").prop("checked")){
        
        //console.log("aqui tmb entra a cambiar porcentaje")
		var valorPorcentaje = $(this).val();      //con this obtenemos lo que trae .nuevoPorcentaje
		
		var porcentaje = Number(($("#nuevoPrecioCompra").val()*valorPorcentaje/100))+Number($("#nuevoPrecioCompra").val());

		var editarPorcentaje = Number(($("#editarPrecioCompra").val()*valorPorcentaje/100))+Number($("#editarPrecioCompra").val());

		$("#nuevoPrecioVenta").val(porcentaje);
		$("#nuevoPrecioVenta").prop("readonly",true);

		$("#editarPrecioVenta").val(editarPorcentaje);
		$("#editarPrecioVenta").prop("readonly",true);
        
        //console.log("entra cambio de porcentaje");

        //var datos = new FormData();
        var datos = new FormData($("form")[0]);
        //datos.append("idProducto", idProducto);
        for (var pair of datos.entries()){console.log(pair[0]+ ', ' + pair[1]);}

    //});


})

$(".porcentaje").on("ifUnchecked",function(){

	$("#nuevoPrecioVenta").prop("readonly",false);
	$("#editarPrecioVenta").prop("readonly",false);

})

$(".porcentaje").on("ifChecked",function(){

	$("#nuevoPrecioVenta").prop("readonly",true);
	$("#editarPrecioVenta").prop("readonly",true);

})


/*=============================================
SUBIENDO LA FOTO DEL PRODUCTO
=============================================*/

$(".nuevaImagen").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

  		$(".nuevaImagen").val("");

  		 swal.fire({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe estar en formato JPG o PNG!",
              icon: "error",
              cancelButtonText: 'Cerrar!',
		    });

  	}else if(imagen["size"] > 2000000){

  		$(".nuevaImagen").val("");

  		 swal.fire({
		      title: "Error al subir la imagen",
		      text: "¡La imagen no debe pesar más de 2MB!",
		      icon: "error",
		      cancelButtonText: "¡Cerrar!"
		    });

  	}else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}
})


/*=============================================
MOSTRAR PARA EDITAR PRODUCTO
=============================================*/
$(".tablaProductos tbody").on("click", "button.btnEditarProducto", function(){
    //var pagina_actual = table.page();
    //localStorage.setItem("pagina_actual", pagina_actual);

	var idProducto = $(this).attr("idProducto");
	
	var datos = new FormData();
        datos.append("idProducto", idProducto);
        //for (var pair of datos.entries()){console.log(pair[0]+ ', ' + pair[1]);}
    $.ajax({
      url:"ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
          //console.log(respuesta);
          
          var datosFamilia = new FormData();
          datosFamilia.append("idFamilia",respuesta["id_familia"]);
          //console.log(respuesta["id_categoria"]);
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
                      $("#editarFamilia").val("");
                      $("#editarFamilia").html("");
                  }else{
                      $("#editarFamilia").val(respuesta["id"]);
                      $("#editarFamilia").html(respuesta["familia"]);
                  }

              },
              error:function(response){
                   console.log(response);
               }

          })

          /* ============= TRAER CATEGORIA ================*/
          let idfamilia=respuesta["id_familia"];
          let idcategoria=respuesta["id_categoria"];

            $.get("ajax/adminalmacenes.ajax.php?op=ObtenerCategoria", 
            {idfamilia: idfamilia, idcategoria: idcategoria }, 
            function(datacategoria){
                //console.log(datacategoria);
                $(".editarCategoria").html(datacategoria);
            });            


          /* ============= TRAER MEDIDA ================*/
          var datosMedida = new FormData();
          datosMedida.append("idMedida",respuesta["id_medida"]);
          //console.log(respuesta["id_medida"]);
           $.ajax({

              url:"ajax/medidas.ajax.php",
              method: "POST",
              data: datosMedida,
              cache: false,
              contentType: false,
              processData: false,
              dataType:"json",
              success:function(respuesta){
                  
                  $("#editarMedida").val(respuesta["id"]);
                  $("#editarMedida").html(respuesta["medida"]);

              },
               error:function(response, status){
                   console.log(response, status);
               }

          })
          
           $("#id_de_Producto").val(idProducto);
		   
           $("#editarCodigo").val(respuesta["codigo"]);
		   
           $("#editarCodInterno").val(respuesta["codigointerno"]);

           $("#editarDescripcion").val(respuesta["descripcion"]);

           $("#editarStock").val(respuesta["stock"]);
		   
           $("#editarMinimo").val(respuesta["minimo"]);

           $("#editarUnidadxCaja").val(respuesta["unidadxcaja"]);
           
           $("#editarHectolitros").val(respuesta["hectolitros"]);

           $("#editarPrecioCompra").val(respuesta["precio_compra"]);
          
           $("#editarNuevoMargen").val(respuesta["margen"]);

           $("#editarPrecioVenta").val(respuesta["precio_venta"]);
          
           $("#editarLeyenda").val(respuesta["leyenda"]);

           let cadena=respuesta["ubicacion"];
           if(cadena===null || cadena==="null"){
            console.log("ubicacion vacia:",cadena);
           }else{
            let pasillo = cadena.substring(0, 3);
            let anaquel = cadena.substring(6, 3);
            let gaveta = cadena.substring(6, 9);   
            //console.log('cadena:',cadena, 'pasillo:',pasillo, 'anaquel:',anaquel, 'gaveta:',gaveta);
            $("#editarPasillo").val(pasillo);
            $("#editarAnaquel").val(anaquel);
            $("#editarGaveta").val(gaveta);
           }
           //console.log(cadena);     //003015008
        //    for (var i = 0 ; i < cadena.length ; i++){
        //     console.log( cadena.substring(i, (cadena.length)),"valor de 1:",i, "valor de lenght:", cadena.length);
        //     }
		   
           $("#editarEstatus").val(respuesta["estado"]);

           // SI TIENE LEYENDA, LO CHECKEA
		   if(respuesta['leyenda']!=""){
			$('.insertaLeyenda').iCheck('check');       
		   }

		   // SI ES ENVASE, LO CHECKEA
		   if(respuesta['totaliza']==0){
			$('.esenvase').iCheck('check');       
		   }

		   // SI ES SERVICIO, LO CHECKEA
		   if(respuesta['totaliza']==2){
			$('.esservicio').iCheck('check');       
		   }
           
		   // SI ES OTROS, LO CHECKEA
		   if(respuesta['totaliza']==3){
			$('.esotros').iCheck('check');       
           }
           
		   // SI ES A GRANEL, LO CHECKEA
		   if(respuesta['granel']==1){
			$('.esagranel').iCheck('check');       
           }

           let datosdepromo=(respuesta["datos_promocion"]);

           jsondeProm = JSON.parse(datosdepromo);
            
           //MUESTRA PRODUCTOS CON PROMOCION
		   if(datosdepromo!=null){
            $('.edtpromocion').iCheck('check');
               alladeProdProm(jsondeProm);
		   }

        //    if(respuesta["imagen"] != ""){
        //    	$("#imagenActual").val(respuesta["imagen"]);
        //    	$(".previsualizar").attr("src",  respuesta["imagen"]);
        //    }
    },
   error:function(response, status){
   console.log(response, status);
   }

  })

})

function alladeProdProm(proddePromocion){
let data = new FormData();
  for (let index = 0; index <= proddePromocion.length-1; index++) {
        let idProducto=proddePromocion[index]["id_producto"];
        let cantidad=proddePromocion[index]["cantidad"];
        let preciopromo=proddePromocion[index]["precio"];
		idProducto=parseInt(idProducto);

		 //HACER UN FETCH AL CAT DE PROD
		 data.append('idProducto', idProducto);

			(async () => {
			let rawResponse = await fetch('ajax/productos.ajax.php', {
			  method: 'POST',
			  body: data
			});
	
		result = await rawResponse.json();
		let codigointerno=result.codigointerno;
		let descripcion=result.descripcion;
	
		//console.log(result.codigointerno, result.descripcion);
	
        var fila='<tr class="filas" id="fila'+cont+'">'+
                
        '<td><button type="button" class="botonQuitar" onclick="eliminarDetallePromo('+cont+')" title="Quitar Concepto">X</button></td>'+
        
        '<td><input type="hidden" value="'+cont+'">'+idProducto+'</td>'+
        
        '<td><input type="hidden" name="codigointerno[]" id="codigointerno[]" value="'+codigointerno+'">'+codigointerno+'</td>'+
        
        '<td><input type="hidden" class="prodactivo" style="width:15rem" name="idProducto[]" value="'+idProducto+'">'+descripcion+'</td>'+
    
        '<td class="text-center"><input type="hidden" name="cantidad[]" id="cantidad[]" idFila=f'+cont+' class="cuantos" value='+cantidad+' style="width:3rem" required readonly dir="rtl">'+cantidad+'</td>'+
    
        '<td class="text-center"><input type="hidden" name="precio_promo[]" id="precio_promo[]" class="preciovta" value='+preciopromo+' step="any" style="width:5rem" readonly dir="rtl">'+preciopromo+'</td>'+
        
        '</tr>';
        cont++;
        detalles=detalles+1;    
        $('#editdetSalidaProm').append(fila);           
	
	})();	
		
  }
  
}

/*=============================================
ELIMINAR PRODUCTO
=============================================*/
$(".tablaProductos tbody").on("click", "button.btnEliminarProducto", function(){

	var idProducto = $(this).attr("idProducto");
	var codigo = $(this).attr("codigo");
	//var imagen = $(this).attr("imagen");

    swal.fire({
      title: "¿Está seguro de borrar este Producto?",
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
      cancelButtonText: 'No, cancelar!',
    })

    .then((willDelete) => {
      if (willDelete.value) {
        window.location = "index.php?ruta=productos&idProducto="+idProducto+"&codigo="+codigo;
      }
    });       
    
})

// MODAL PARA VISUALIZAR IMAGEN DEL PRODUCTO -->
// $(".tablaProductos tbody").on("click", ".idImagen", function(){
//     let descripcionProd=($(this).attr("descripcionProd"));
//     let codeProd=($(this).attr("codigointerno"));
// 	let muestra_imagen = ($(this).attr("src"));
// 	console.log(codeProd);
//     $('#ModalCenterTitle').html("");
//     $('#ModalCenterTitle').html('Imagen de: '+descripcionProd+' Cod: '+codeProd);
// 	$('#imagen-modal').attr('src', muestra_imagen);
	
// })


// $("#agregarProd").click(function(){
//     $("#imagenActual").val("");
//     $(".previsualizar").attr("src","vistas/img/productos/default/anonymous.png");
// })

/*================== AGREGAR PRODUCTOS DE PROMOCION ============================= */
$("#agregaProductoProm").click(function(event){
    event.preventDefault();
    //console.log($("#qty").val());
    var idProducto=$("#selecProductoProm").val();
    var producto=$("#selecProductoProm option:selected" ).text();       //obtener el texto del valor seleccionado
    var cantidad=$("#qty").val();
    var preciopromo=$("#price").val();
    cantidad=parseInt(cantidad);
    preciopromo=parseFloat(preciopromo).toFixed(2);


	if(isNaN(preciopromo) || preciopromo<0){
	  return true;
	}
	
    if(cantidad==0 || isNaN(cantidad)){
        return true;
    }else if(cantidad<0){
        return true;    
    }  

	//SE SEPARA EL CODIGO DEL PROD. SELECCIONADO    
	var codigointerno= producto.substr(0, producto.indexOf('-'));
	codigointerno.trim();
	//SE SEPERA LA DESCRIPCION DEL PROD. SELECCIONADO        
	var descripcion= producto.substr(producto.lastIndexOf("-") + 1);
	descripcion.trim();

    var fila='<tr class="filas" id="fila'+cont+'">'+
			
    '<td><button type="button" class="botonQuitar" onclick="eliminarDetallePromo('+cont+')" title="Quitar Concepto">X</button></td>'+
    
    '<td><input type="hidden" value="'+cont+'">'+idProducto+'</td>'+
    
    '<td><input type="hidden" name="codigointerno[]" id="codigointerno[]" value="'+codigointerno+'">'+codigointerno+'</td>'+
    
    '<td><input type="hidden" class="prodactivo" style="width:15rem" name="idProducto[]" value="'+idProducto+'">'+descripcion+'</td>'+

    '<td class="text-center"><input type="hidden" name="cantidad[]" id="cantidad[]" idFila=f'+cont+' class="cuantos" value='+cantidad+' style="width:3rem" required readonly dir="rtl">'+cantidad+'</td>'+

    '<td class="text-center"><input type="hidden" name="precio_promo[]" id="precio_promo[]" class="preciovta" value='+preciopromo+' step="any" style="width:5rem" readonly dir="rtl">'+preciopromo+'</td>'+
    
    '</tr>';
    cont++;
    detalles=detalles+1;    
    $('#detalleSalidaProm').append(fila);    
    $('#selecProductoProm').val(null).trigger('change');	
    $("#qty").val(0);
    $("#price").val(0);

})    


//QUITA ELEMENTO 
function eliminarDetallePromo(indice){
    $("#fila" + indice).remove();
    //calculaTotalesSalida();
    detalles=detalles-1;
    if (!detalles>0){
        cont=0;
      }
}
/*================================================================================ */

/*================== EDITAR PRODUCTOS DE PROMOCION ============================= */
$("#editarProductoProm").click(function(event){
    event.preventDefault();
    //console.log($("#qty").val());
    var idProducto=$("#editSelProdProm").val();
    var producto=$("#editSelProdProm option:selected" ).text();       //obtener el texto del valor seleccionado
    var cantidad=$("#editqty").val();
    var preciopromo=$("#editprice").val();
    cantidad=parseInt(cantidad);
    preciopromo=parseFloat(preciopromo).toFixed(2);

	
	if(isNaN(preciopromo) || preciopromo<0){
	  return true;
	}
	
    if(cantidad==0 || isNaN(cantidad)){
        return true;
    }else if(cantidad<0){
        return true;    
    }  
	
	//SE SEPARA EL CODIGO DEL PROD. SELECCIONADO    
	var codigointerno= producto.substr(0, producto.indexOf('-'));
	codigointerno.trim();
	//SE SEPERA LA DESCRIPCION DEL PROD. SELECCIONADO        
	var descripcion= producto.substr(producto.lastIndexOf("-") + 1);
	descripcion.trim();

    var fila='<tr class="filas" id="fila'+cont+'">'+
			
    '<td><button type="button" class="botonQuitar" onclick="eliminarDetallePromo('+cont+')" title="Quitar Concepto">X</button></td>'+
    
    '<td><input type="hidden" value="'+cont+'">'+idProducto+'</td>'+
    
    '<td><input type="hidden" name="codigointerno[]" id="codigointerno[]" value="'+codigointerno+'">'+codigointerno+'</td>'+
    
    '<td><input type="hidden" class="prodactivo" style="width:15rem" name="idProducto[]" value="'+idProducto+'">'+descripcion+'</td>'+

    '<td class="text-center"><input type="hidden" name="cantidad[]" id="cantidad[]" idFila=f'+cont+' class="cuantos" value='+cantidad+' style="width:3rem" required readonly dir="rtl">'+cantidad+'</td>'+

    '<td class="text-center"><input type="hidden" name="precio_promo[]" id="precio_promo[]" class="preciovta" value='+preciopromo+' step="any" style="width:5rem" readonly dir="rtl">'+preciopromo+'</td>'+
    
    '</tr>';
    cont++;
    detalles=detalles+1;    
    $('#editdetSalidaProm').append(fila);    

    $('#selecProductoProm').val(null).trigger('change');	
    $("#editqty").val(0);
    $("#editprice").val(0);

})    




/*
//PARA CHECAR SI COMO VAN LOS DATOS
$("#checar").click(function(){
var datos = new FormData($("#formulario")[0]);
 //datos.append("idProducto", idProducto);
  for (var pair of datos.entries()){
    console.log(pair[0]+ ', ' + pair[1]);
  }
window.setTimeout(function(){
}, 10600);    
});
*/

