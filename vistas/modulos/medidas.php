<?php
  $tabla="usuarios";
  $module="medidas";
  $campo="catalogo";
  $acceso=accesomodulo($tabla, $_SESSION['id'], $module, $campo);
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header p-1 m-0">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h4>Administrar U. de Medidas:&nbsp; 
                <small><i class="fa fa-tachometer"></i></small>
            </h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Tablero</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        
         <div class="card-header">
         <?php if(getAccess($acceso, ACCESS_ADD)){?>
           <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAgregarMedidas"><i class="fa fa-plus-circle"></i> Agregar U. de Medidas
          </button>
         <?php } ?> 
        <button class="btn btn-danger btn-sm" id="btnregresar" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button>          

          <!--<h2 class="card-title">Control de Usuarios</h2> -->
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Ocultar">
              <i class="fa fa-minus"></i></button>
          </div>
         </div>
        
        <div class="card-body">
        <div class="card">
            <div class="card-body">
              <table class="table table-bordered compact striped hover dt-responsive activarDatatable" width="100%">
                <thead class="thead-dark">
                <tr>
                    <th style="width:12px;">#</th>
                    <th>U. de Medida</th>
                    <th style="width:16px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                
                <?php
                  
                  $campo=null;
                  $valor=null;
                  $medidas=ControladorMedidas::ctrMostrarMedidas($campo, $valor);
                
              foreach($medidas as $key => $value){

                echo '
                <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["medida"].'</td>
                  <td>';
                  if(getAccess($acceso, ACCESS_EDIT)){
                  echo '<button class="btn btn-warning btn-sm btnEditarMedida " idMedida="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarMedida"><i class="fa fa-pencil"></i></button>';
                  }        
                  if(getAccess($acceso, ACCESS_DELETE)){
                  echo ' <button class="btn btn-danger btn-sm btnEliminarMedida"  idMedida="'.$value["id"].'"><i class="fa fa-times"></i></button>';
                  }
                  echo '</td>
                </tr>';
              }
                ?>
                
                </tbody>
                <tfoot class="thead-dark">
                <tr>
                    <th style="width:12px;">#</th>
                    <th>U. de Medida</th>
                    <th style="width:16px;">Acciones</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->            
        </div>
        <!-- /.card-body -->
        
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <!-- === MODAL AGREGAR CATEGORÍA ==-->
 
  <div class="modal fade" id="modalAgregarMedidas" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
   
    <div class="modal-content">
    <form role="form" method="POST">
      <!-- Modal Header -->
      <div class="modal-header colorbackModal">
   
            <h4 class="modal-title">Agregar U. de Medida</h4>
        
            <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      

      <!-- Modal body -->
      <div class="modal-body">
           
        <div class="box-body">
        </div>   

        <div class="card card-info">
         <div class="card-body">
           
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-th"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="Captura Unidad de Medida" name="nuevaMedida" onkeyUp="mayuscula(this);" required>
            </div>
                                
         </div>
        </div>
      
      </div>

      <!-- Modal footer -->
      <div class="modal-footer colorbackModal">
       
        <button type="button" class="btn btn-primary float-left" data-dismiss="modal"><i class="fa fa-reply"></i> Salir</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
      
      </div>
      
      <?php
        
        $crearMedida=new ControladorMedidas();
        $crearMedida->ctrCrearMedida();
      ?>
     </form>
    </div> <!-- fin del modal-content -->
  </div>
</div>  


<!-- === MODAL EDITAR CATEGORIA ==-->
  <div class="modal fade" id="modalEditarMedida" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
   
    <div class="modal-content">
    <form role="form" method="POST">
      <!-- Modal Header -->
      <div class="modal-header colorbackModal">
   
            <h4 class="modal-title">Editar U. de Medida</h4>
        
            <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      

      <!-- Modal body -->
      <div class="modal-body">
           
        <div class="box-body">
        </div>   

        <div class="card card-info">
         <div class="card-body">
           
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-th"></i></span>
              </div>
              <input type="text" class="form-control input-lg" value="" id="editarMedida" name="editarMedida" onkeyUp="mayuscula(this);" required>
              <input type="hidden" name="idMedida" id="idMedida">
            </div>
            
         </div>
        </div>
      
      </div>

      <!-- Modal footer -->
      <div class="modal-footer colorbackModal">
       
        <button type="button" class="btn btn-primary float-left" data-dismiss="modal"><i class="fa fa-reply"></i> Salir</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar Cambios</button>
      
      </div>
      
      <?php
        
        $editarMedida=new ControladorMedidas();
        $editarMedida->ctrEditarMedida();
      ?>
     </form>
    </div> <!-- fin del modal-content -->
  </div>
</div>  
<script defer src="vistas/js/medidas.js"></script>

<?php

  $borrarMedida = new ControladorMedidas();
  $borrarMedida -> ctrBorrarMedida();

?> 
