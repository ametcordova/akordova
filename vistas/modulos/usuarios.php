<?php
  $tabla="usuarios";
  $module="usuarios";
  $campo="configura";
  $acceso=accesomodulo($tabla, $_SESSION['id'], $module, $campo);
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header p-1 m-0">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Administrar Usuario:&nbsp; 
                <small><i class="fa fa-user"></i></small>
            </h3>
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
             <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAgregarusuario"><i class="fa fa-plus-circle"></i> Agregar usuario</button>
          <?php } ?>
        <button class="btn btn-danger btn-sm" id="btnregresar" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button>          

          <!--<h2 class="card-title">Control de Usuarios</h2> -->
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Ocultar">
              <i class="fa fa-minus"></i></button>
			<button type="button" class="btn btn-tool" onclick="regresar()" title="a Inicio">
              <i class="fa fa-times"></i></button>
			  
          </div>
         </div>
        
        <div class="card-body">
<div class="card">
            <div class="card-header">
              <!-- <h3 class="card-title">Tabla con todos los Usuarios</h3>-->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered compact table-hover table-striped dt-responsive activarDatatable" width="100%">
                <thead class="thead-dark">
                <tr>
                    <th style="width:10px;">#</th>
                    <th>Nombre</th>
                    <th>usuario</th>
                    <th>Foto</th>
                    <th>Perfil</th>
                    <th class="text-center">Estado</th>
                    <th>Fecha Login</th>
                    <th class="text-center">Acción</th>
                </tr>
                </thead>
                <tbody>
                
                <?php
                  
                  $campo=null;
                  $valor=null;
                  $usuarios=ControladorUsuarios::ctrMostrarUsuarios($campo, $valor);
                
                foreach($usuarios as $key => $value){
                      $fechalogin = date('d-m-Y H:i:s', strtotime($value["ultimo_login"]));
                      echo '
                  <tr>
                  <td>'.$value["id"].'</td>
                  <td>'.$value["nombre"].'</td>
                  <td>'.$value["usuario"].'</td>';
                  if($value["foto"]!=""){
                      echo '<td><img src="'.$value["foto"].'" class="img-thumbnail" width="30px" alt="Foto Usuario"></td>';
                  }else{
                      echo '<td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="30px" alt="Foto Usuario"></td>';
                  }
                  echo '<td>'.$value["perfil"].'</td>';
                  if(getAccess($acceso, ACCESS_ACTIVAR)){
                    if($value["estado"]!=0){
                      echo '<td class="text-center"><button class="btn btn-success btn-sm btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="0">Activado</button></td>';
                    }else{
                      echo '<td class="text-center"><button class="btn btn-danger btn-sm btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="1">Desactivado</button></td>';
                    }
                  }else{
                    if($value["estado"]!=0){
                      echo '<td class="text-center"><button class="btn btn-success btn-sm disabled">Activado</button></td>';
                    }else{
                      echo '<td class="text-center"><button class="btn btn-danger btn-sm disabled">Desactivado</button></td>';
                    }
                  }
                  echo '<td>'.$fechalogin.'</td>';
                  
                  echo '<td class="text-center">
                      <div class="btn-group">';
                      if(getAccess($acceso, ACCESS_EDIT)){
                        echo '<button class="btn btn-warning btn-sm btnEditarUsuario" idUsuario="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>&nbsp ';
                      }
                      if(getAccess($acceso, ACCESS_DELETE)){                      
                        echo '<button class="btn btn-danger btn-sm btnEliminarUsuario" idUsuario="'.$value["id"].'" fotoUsuario="'.$value["foto"].'" usuario="'.$value["usuario"].'"><i class="fa fa-times"></i></button>';
                      }
                      echo '</div>
                  </td>
                  </tr>';

                }   //fin del foreach
                    
                ?>
                
                </tbody>
                <tfoot class="thead-dark">
                <tr>
                    <th style="width:10px;">#</th>
                    <th>Nombre</th>
                    <th>usuario</th>
                    <th>Foto</th>
                    <th>Perfil</th>
                    <th>Estado</th>
                    <th>Fecha Login</th>
                    <th>Acción</th>
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
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <!-- === MODAL AGRAGAR USUARIO ==-->
 
  <div class="modal fade" id="modalAgregarusuario">
  <div class="modal-dialog">
   
    <div class="modal-content">
    <form role="form" method="POST" enctype="multipart/form-data">
      <!-- Modal Header -->
      <div class="modal-header" style="background:#F7FE2E;">
   
            <h4 class="modal-title">Agregar usuario</h4>
        
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
                      <span class="input-group-text"><i class="fa fa-user"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="Nombre" name="nuevoNombre" required>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-key"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="Usuario" name="nuevoUsuario" id="nuevoUsuario" required>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-lock"></i></span>
              </div>
              <input type="password" class="form-control input-lg" placeholder="Contraseña" name="nuevoPassword" required>
            </div>

            <div class="form-group mb-3">
              <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-users"></i></span>
                    <select class="form-control input-lg" name="nuevoPerfil">
                      <option value="">Seleccionar perfil</option>
                      <option value="Administrador">Administrador</option>
                      <option value="Especial">Especial</option>
                      <option value="Vendedor">Vendedor</option>
                    </select>
              </div>
            </div>

		    <div class="form-group">
            <label for="exampleInputFile">Subir Imagen</label>
            <div class="input-group">
                <div class="custom-file">
                        <input type="file" class="custom-file-input nuevaFoto" id="exampleInputFile" name="nuevaFoto">
                        <label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
                </div>
            </div>
			        <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="80px" alt="">
        </div>

<!--			
            <div class="input-group mb-3">
              <div class="panel">Subir Foto</div>
            </div>
              <input type="file" class="nuevaFoto" placeholder="foto" name="nuevaFoto">
              <p class="help-block">peso Maximo de la foto 2mb.</p>
              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="80px" alt="">
			  -->    
         </div>
        </div>
  
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="background:#F7FE2E;">
       
        <button type="button" class="btn btn-primary float-left" data-dismiss="modal"><i class="fa fa-reply"></i> Salir</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
      
      </div>
      
      <?php
        
        $crearUsuario=new ControladorUsuarios();
        $crearUsuario->ctrCrearusuario();
      ?>
     </form>
    </div> <!-- fin del modal-content -->
  </div>
</div>  


<!-- === MODAL EDITAR USUARIO ==-->
 
  <div class="modal fade" id="modalEditarUsuario">
  <div class="modal-dialog">
   
    <div class="modal-content">
    <form role="form" method="POST" enctype="multipart/form-data" id="frmEditarusuario">
      <!-- Modal Header -->
      <div class="modal-header" style="background:#F7FE2E;">
   
            <h4 class="modal-title">Editar usuario</h4>
        
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
                      <span class="input-group-text"><i class="fa fa-user"></i></span>
              </div>
              <input type="text" class="form-control input-lg" value="" id="editarNombre" name="editarNombre" required>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-key"></i></span>
              </div>
              <input type="text" class="form-control input-lg" value="" id="editarUsuario" name="editarUsuario" readonly>
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-lock"></i></span>
              </div>
              <input type="password" class="form-control input-lg" placeholder="Escriba nueva contraseña" name="editarPassword">
              <input type="hidden" id="passwordActual" name="passwordActual">
            </div>

            <div class="form-group mb-3">
              <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-users"></i></span>
                    <select class="form-control" name="editarPerfil">
                      <option value="" id="editarPerfil"></option>
                      <option value="Administrador">Administrador</option>
                      <option value="Especial">Especial</option>
                      <option value="Vendedor">Vendedor</option>
                    </select>
              </div>
            </div>
                                
            <div class="input-group mb-3">
              <div class="panel">Subir Foto</div>
            </div>
              <input type="file" class="nuevaFoto" placeholder="foto" name="editarFoto">
              <p class="help-block">peso Maximo de la foto 2mb.</p>
              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizarEditar" width="80px" alt="">
              <input type="hidden" id="fotoActual" name="fotoActual">
         </div>
        </div>
      
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="background:#F7FE2E;">
       
        <button type="button" class="btn btn-primary float-left" data-dismiss="modal"><i class="fa fa-reply"></i> Salir</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar Cambios</button>
      
      </div>
      
      <?php
        
        $editarUsuario=new ControladorUsuarios();
        $editarUsuario->ctrEditarUsuario();
      ?>
     </form>
    </div> <!-- fin del modal-content -->
  </div>
</div>  
<script defer src="vistas/js/usuario.js"></script>
<?php

  $borrarUsuario = new ControladorUsuarios();
  $borrarUsuario -> ctrBorrarUsuario();

?> 