function init(){

   abrirDatosEmpresa();

    
}

$("#formularioAgregarEmpresa").on("submit",function(e){
   //VERIFICA SI YA TIENE DATOS, UPDATE, SI NO, AGREGA
   var esnuevo =$("#esnuevo").val();
    if(esnuevo=="0"){
       console.log("Modificar empresa",esnuevo)
       updateEmpresa(e);
    }else{
      console.log("nueva Empresa", esnuevo)
       agregarEmpresa(e);
    }
       
 })


/*=====================================================================
UPDATE EMPRESA
======================================================================*/
function updateEmpresa(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioAgregarEmpresa")[0]);
     //for (var pair of formData.entries()){console.log(pair[0]+ ', ' + pair[1]);}
	 
	$.ajax({
		url: "ajax/empresa.ajax.php?op=updateEmpresa",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
	    success: function(datos){
         //console.log(datos);
            if(datos==""){
               Swal.fire({
                  title: "Realizado!!",
                  text: "Empresa se ha actualizado correctamente",
                  icon: "success",
                  timer: 2500
                  })  //fin swal
                  .then(function(result){
                    if (result) {
						   window.location = "inicio"; 
                    }
                  })  //fin .then
               
               }else{
                  swal.fire({
                  title: "Error!!",
                  text: datos,
                  icon: "error",
                  })  //fin swal

               }
            }
	    })
}
/* ======================================================================= */

//FUNCION PARA TRAER LOS DATOS DE LA EMPRESA
function abrirDatosEmpresa(){
try{
      fetch('ajax/empresa.ajax.php?op=traerDatosEmpresa', {
      })
       .then(respuesta=>respuesta.json())
       .then(datos=>{
          //console.log(datos, esnuevo);
          razonsocial=datos.razonsocial;
          rfc=datos.rfc;
          slogan=datos.slogan;
          $('#razonsocial').val(razonsocial);
          $('#rfc').val(rfc);
          $('#slogan').val(slogan);
          $('#direccion').val(datos.direccion);
          $('#colonia').val(datos.colonia);
          $('#codpostal').val(datos.codpostal);
          $('#ciudad').val(datos.ciudad);
          $('#estado').val(datos.estado);
          $('#telempresa').val(datos.telempresa);
          $('#mailempresa').val(datos.mailempresa); 
          $('#contacto').val(datos.contacto); 
          $('#telcontacto').val(datos.telcontacto);
          $('#mailcontacto').val(datos.mailcontacto);
          $('#msjpieticket').val(datos.msjpieticket);
          $('#mensajeticket').val(datos.mensajeticket);
          $('#ivaempresa').val(datos.iva);
          $('#impresora').val(datos.impresora);
          $('#rutarespaldo').val(datos.rutarespaldo);
          $('#namedatabase').val(datos.namedatabase);
          $('#idterminal').val(datos.idterminal);
          if(razonsocial===undefined){
            $('#esnuevo').val(1);
          }else{
            $('#esnuevo').val(0);
          }
         console.log("entro1",razonsocial, esnuevo);
      }) 
 }catch(showErrorFetch){    

}    

}

/*=====================================================================
AGREGAR EMPRESA
======================================================================*/
function agregarEmpresa(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioAgregarEmpresa")[0]);
     //for (var pair of formData.entries()){console.log(pair[0]+ ', ' + pair[1]);}
	 
	$.ajax({
		url: "ajax/empresa.ajax.php?op=guardar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
	    success: function(datos){
         //console.log(datos);
            if(datos==""){
               swal.fire({
                  title: "Realizado!!",
                  text: "Empresa se ha añadido correctamente",
                  icon: "success",
                  timer: 2500
                  })  //fin swal
                  .then(function(result){
                    if (result) {
						   window.location = "inicio"; 
                    }
                  })  //fin .then
               
               }else{
                  swal.fire({
                  title: "Error!!",
                  text: datos,
                  icon: "error",
                  })  //fin swal

               }
            }
	    })
}

/*==========================================================================*/
function showErrorFetch(err) { 
   console.log('muestra error', err);
   swal.fire({
       title: "Error!!",
       text: err,
       icon: "error",
       })  //fin swal
 }




init();