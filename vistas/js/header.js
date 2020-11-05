/* ================================================
MODULO PARA MOSTRAR IMPORTES POR CONCEPTOS, EN LA 
VENTANA DE CAJA APERTURADA.
==================================================*/
$("#modalcajaventa").click(function(ev) {
    ev.preventDefault();
    var target = $(this).attr("href");
    console.log("entra:",target)
    //console.log(moment().format('YYYY-MM-DD')); 
    
    //window.location="modal-caja#cajaAbierta";

    //$('#cajaAbierta').on('show.bs.modal', function (e) {})

    let iddecaja = "id_caja";
    let numdecaja=$("#numcaja").val();
    let campofecha="fecha_salida";
    let cerrado=0;
    let datecurrent=moment().format('YYYY-MM-DD');
    
    generar(iddecaja,numdecaja,campofecha,cerrado,datecurrent);

});

/* ======= ENCADENAR SECUENCIALMENTE LLAMADAS A FUNCIONES ========*/
async function generar(iddecaja,numdecaja,campofecha,cerrado,datecurrent){
    try{    
        await traerventas(iddecaja,numdecaja,campofecha,cerrado,datecurrent);
        await traerenvases(iddecaja,numdecaja,campofecha,cerrado,datecurrent);
        await traerservicios(iddecaja,numdecaja,campofecha,cerrado,datecurrent);
        await traerotros(iddecaja,numdecaja,campofecha,cerrado,datecurrent);
        await traerventacredito(iddecaja,numdecaja,campofecha,cerrado,datecurrent);
        await traeringresosegresos(iddecaja,numdecaja,cerrado);
        await traerimportecajachica(iddecaja,numdecaja,cerrado,datecurrent);
        //setTimeout(sumartotalcaja,600);    
        await sumartotalcaja();
    } catch(err){
        console.log(err);
    }    
};


/*==== CONSULTA DE VENTAS ======== */
async function traerventas(iddecaja,numdecaja,campofecha,cerrado,datecurrent){
    let data = new FormData();
    data.append("fechasalida", campofecha);
    data.append("fechaactual", datecurrent);
    data.append("cerrado", cerrado);
    data.append("numcaja", numdecaja);
    try{
        await fetch('ajax/salidas.ajax.php?op=traertotalventas', {
            method: 'POST',
            body: data
        })
         .then(respuesta=>respuesta.json())
         .then(datos=>{
            //console.log(datos);
            totalsinpromo=datos.sinpromo==null?0:parseFloat(datos.sinpromo);
            totalconpromo=datos.promo==null?0:parseFloat(datos.promo);
            totaldeventas=new Intl.NumberFormat('en', {style: 'currency',currency: 'USD',currencySign: 'accounting',}).format((totalsinpromo+totalconpromo));
            $('#totaldeventas').html(totaldeventas);
            $('#totaldeventas').attr('data-ventas',(totalsinpromo+totalconpromo));
        }) 
   }catch(showErrorFetch){    

   }    
}

/*==== CONSULTA VENTAS DE ENVASES ======== */   
async function traerenvases(iddecaja,numdecaja,campofecha,cerrado,datecurrent){
let data = new FormData();
data.append("fechasalida", campofecha);
data.append("fechaactual", datecurrent);
data.append("cerrado", cerrado);
data.append("numcaja", numdecaja);

try{
    await fetch('ajax/salidas.ajax.php?op=traertotalenvases', {
      method: 'POST',
      body: data
    })
    .then(respuesta=>respuesta.json())
    .then(datos=>{
        //console.log(datos);
        totalenvases=datos.total==null?0:datos.total;
        totalenvases=new Intl.NumberFormat('en', {style: 'currency',currency: 'USD',currencySign: 'accounting',}).format((totalenvases));
        $('#totalenvases').html(totalenvases);
        $('#totalenvases').attr('data-envases',(datos.total));
        //console.log("entro2");
    }) 
    }catch(showErrorFetch){    
    }    
}

/*==== CONSULTA VENTAS DE SERVICIOS ======== */   
async function traerservicios(iddecaja,numdecaja,campofecha,cerrado,datecurrent){
let data = new FormData();
data.append("fechasalida", campofecha);
data.append("fechaactual", datecurrent);
data.append("cerrado", cerrado);
data.append("numcaja", numdecaja);
    try{
        await fetch('ajax/salidas.ajax.php?op=traertotalservicios', {
            method: 'POST',
            body: data
        })
         .then(respuesta=>respuesta.json())
         .then(datos=>{
            //console.log(datos);
            totalservicios=datos.total==null?0:datos.total;
            totalservicios=new Intl.NumberFormat('en', {style: 'currency',currency: 'USD',currencySign: 'accounting',}).format((totalservicios));
            $('#totalservicios').html(totalservicios);
            $('#totalservicios').attr('data-servicios',(datos.total));
            //console.log("entro3");
          }) 
    }catch(showErrorFetch){    
    }    
}        

/*==== CONSULTA VENTAS DE ABARROTES ======== */   
async function traerotros(iddecaja,numdecaja,campofecha,cerrado,datecurrent){
    let data = new FormData();
    data.append("fechasalida", campofecha);
    data.append("fechaactual", datecurrent);
    data.append("cerrado", cerrado);
    data.append("numcaja", numdecaja);
        try{
            await fetch('ajax/salidas.ajax.php?op=traertotalotros', {
                method: 'POST',
                body: data
            })
             .then(respuesta=>respuesta.json())
             .then(datos=>{
                //console.log(datos);
                totalabasinpromo=datos.sinpromo==null?0:parseFloat(datos.sinpromo);
                totalabaconpromo=datos.promo==null?0:parseFloat(datos.promo);
                totalotros=new Intl.NumberFormat('en', {style: 'currency',currency: 'USD',currencySign: 'accounting',}).format((totalabasinpromo+totalabaconpromo));
                $('#totalotros').html(totalotros);
                $('#totalotros').attr('data-otros',(totalabasinpromo+totalabaconpromo));
                //console.log("entro3");
              }) 
        }catch(showErrorFetch){    
        }    
}        
    
/*==== CONSULTA VENTAS A CREDITO ======== */   
async function traerventacredito(iddecaja,numdecaja,campofecha,cerrado,datecurrent){
let data = new FormData();
data.append("fechasalida", campofecha);
data.append("fechaactual", datecurrent);
data.append("cerrado", cerrado);
data.append("numcaja", numdecaja);
    try{
       await fetch('ajax/salidas.ajax.php?op=traertotalacredito', {
            method: 'POST',
            body: data
        })
         .then(respuesta=>respuesta.json())
         .then(datos=>{
            //console.log(datos);
            totcredsinpromo=datos.sinpromo==null?0:parseFloat(datos.sinpromo);
            totcredconpromo=datos.promo==null?0:parseFloat(datos.promo);
            totalacredito=new Intl.NumberFormat('en', {style: 'currency',currency: 'USD',currencySign: 'accounting',}).format((totcredsinpromo+totcredconpromo));
            $('#totalacredito').html(totalacredito);
            $('#totalacredito').attr('data-creditos',(totcredsinpromo+totcredconpromo));
            //console.log("entro4");
          }) 
    }catch(showErrorFetch){    
    }    
}

/*==== CONSULTA DE INGRESOS E EGRESOS ======== */
async function traeringresosegresos(iddecaja,numdecaja,cerrado){
    let datos = new FormData();
	datos.append("item", iddecaja);
    datos.append("iddeCaja", numdecaja);
    datos.append("cerrado", cerrado);
    try{
        await fetch('ajax/control-presupuesto.ajax.php?op=ingresoegreso', {
            method: 'POST',
            body: datos
        })
        .then(respuesta=>respuesta.json())
        .then(datos=>{
            //console.log(datos.monto_ingreso);
            totalingreso=datos.monto_ingreso==null?0:datos.monto_ingreso;
            totalegreso=datos.monto_egreso==null?0:datos.monto_egreso;
            $('#totalingreso').attr('data-ingreso',totalingreso);
            $('#totalegreso').attr('data-egreso',totalegreso);
            totalingreso=new Intl.NumberFormat('en',{style:'currency',currency:'USD',currencySign: 'accounting',}).format(totalingreso);
            totalegreso=new Intl.NumberFormat('en',{style: 'currency',currency: 'USD',currencySign: 'accounting',}).format(totalegreso);
            $('#totalingreso').html(totalingreso);
            $('#totalegreso').html(totalegreso);
            //console.log("ingreso:", $('#totalingreso' ).data( 'ingreso' ) );
            //console.log("egreso:", $('#totalegreso' ).data( 'egreso' ) );
            //console.log("entro5");
        })
    }catch(showErrorFetch){    
    }    
}            

/*==== CONSULTA DE INGRESOS E EGRESOS ======== */
async function traerimportecajachica(iddecaja,numdecaja,cerrado,datecurrent){
    //console.log("entra cajachica:",iddecaja,numdecaja,cerrado,datecurrent);
    let datos = new FormData();
	datos.append("item", iddecaja);
    datos.append("iddeCaja", numdecaja);
    datos.append("cerrado", cerrado);
    datos.append("fechaactual", datecurrent);
    try{
        await fetch('ajax/control-presupuesto.ajax.php?op=importecajachica', {
            method: 'POST',
            body: datos
        })
        .then(respuesta=>respuesta.json())
        .then(datos=>{
            //console.log(datos.cajachica);
            totalcajachica=datos.cajachica==null?0:datos.cajachica;
            //$('#totalcajachica').attr('data-ingreso',totalcajachica);
            totalcajachica=new Intl.NumberFormat('en',{style:'currency',currency:'USD',currencySign: 'accounting',}).format(totalcajachica);
            $('#totalcajachica').html(totalcajachica);

            //console.log("ingreso:", $('#totalingreso' ).data( 'ingreso' ) );
            //console.log("entro5");
        })
    }catch(showErrorFetch){    
    }    
}            


function sumartotalcaja(){
    totalefectivo = 0
    var data="";
    //console.log("ingreso:", $('#totalingreso' ).data( 'ingreso' ) );
    //console.log("egreso:", $('#totalegreso' ).data( 'egreso' ) );

	$(".idforsuma").each(function(index, value) {
        //console.log(index, value);
       // console.log("evalua: ",$(this).data());
        data = $(this).data();
        for(var i in data){
          //console.log("itera:",i);
            if(i==="egreso"){
               totalefectivo-=parseFloat(data[i]);    
            }else{
               totalefectivo+=parseFloat(data[i]) || 0;
            }
                //console.log(data[i])
        }            
    });

    totalefectivo=new Intl.NumberFormat('en', {style: 'currency',currency: 'USD',currencySign: 'accounting',}).format(totalefectivo);
    $('#totalefectivo').html(totalefectivo);
    //console.log("entro final",totalefectivo);
}

function showErrorFetch(err) { 
    console.log('muestra error', err);
    swal.fire({
        title: "Error!!",
        text: err,
        icon: "error",
        })  //fin swal
  }
  

$("#cajaAbierta").on('hidden.bs.modal', ()=> {
    //console.log("removedata");
    $( "#databox" ).removeData();
    $( "#databox" ).removeAttr();
    //console.log("ingreso:", $('#totalingreso' ).data( 'ingreso' ) );
});

/*

$('#cajaactiva').on('click', function(ev) {
    //window.location = "inicio";
    
     window.setTimeout(function(){ 
        console.log("entra")
        location.reload();
        abrirmodal();
     } ,2000);
});

$('#cajaAbierta').on('show.bs.modal', function (e) {
})

*/