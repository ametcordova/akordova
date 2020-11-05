	$("#datos_factura").submit(function(){
		  var cliente = $("#cliente").val();
		  
		  if (cliente>0){
			//window.open('ticket.php?cliente='+cliente);
			window.open('ticket.php?cliente='+cliente, '_blank','top=200,left=500,width=450,height=400');
		 } else {
			 alert("Selecciona el cliente");
			 return false;
		 }
		 
	 });
		
	
