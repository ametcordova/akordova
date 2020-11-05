new Vue({
    el: '#app',
    data:{
      id:'',
      familia:'',
      ultusuario:'',
      ultmodificacion:'',
      dataTable:null,
    },
    methods:{
      
      addUser(){
          this.dataTable.row.add([
            this.id,
            '<a href="#">'+this.name+'</a>',
            this.email,
            '<a href="#" class="btn btn-info" >editar</a></td> <a href="#" class="btn btn-danger" >Borrar</a></td>'
          ]).draw(false)
          this.id='';
            this.name='';
            this.email='';
      }
    },
    created(){
        console.log("entra aqui VUE1")
    },
    mounted(){
    console.log("entra aqui VUE")
      let familias = [];
        this.dataTable = $('#user-table').dataTable({
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
             ],initComplete: function () {			//botones pequeños y color verde
               var btns = $('.dt-button');
               btns.removeClass('dt-button');
               btns.addClass('btn btn-success btn-sm');
             },            
        }).DataTable();
      const url = 'ajax/family.ajax.php?op=listarFamilias';
      fetch(url)
      .then(res => res.json())
      .then(data => {
          data.forEach(item => {
            familias.push(item);
        });
      
          familias.forEach(items=>{
          this.dataTable.row.add([
            items.id,
            '<a href="#">'+items.familia+'</a>',
            items.ultmodificacion,
            '<a href="#" class="btn btn-info btn-sm" ><i class="fa fa-pencil"></i></a></td> <a href="#" class="btn btn-danger btn-sm" ><i class="fa fa-times"></i></a></td>'
          ]).draw(false) 
          })
      })
    }
  })