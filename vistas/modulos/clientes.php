
<?php
error_reporting(E_ALL^E_NOTICE);
//  require_once './funciones/funciones.php';
date_default_timezone_set("America/Mexico_City");
$fechaToday1=date("Y-m-d", strtotime("-30 day"));
$fechaToday2=date("Y-m-d");

$tabla="usuarios";
$module="clientes";
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
            <h3>Administrar Clientes:&nbsp; 
                <small><i class="fa fa-address-book"></i></small>
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
          <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAgregarCliente"><i class="fa fa-plus-circle"></i> Agregar Cliente
          </button>
        <?php } ?>
        <button class="btn btn-danger btn-sm" id="btnregresar" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button>          

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Ocultar">
              <i class="fa fa-minus"></i></button>
			<button type="button" class="btn btn-tool" onclick="regresar()" title="a Inicio">
              <i class="fa fa-times"></i></button>			  
          </div>
         </div>
        
        <div class="card-body">
        <div class="card">
          <!--
            <div class="card-header">
               <h3 class="card-title">Tabla con todas los Clientes</h3> 
            </div>
            -->
            
            <div class="card-body">
              <table class="table display compact cell-border striped hover dt-responsive activarDatatable" width="100%">
                <thead class="thead-dark">
                <tr>
                    <th style="width:9px;">#</th>
                    <th>Nombre</th>
                    <th>Rfc</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Ventas</th>
                    <th>Ult. Vta.</th>
                    <th>Saldo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                
  <?php

          $item = null;
          $valor = null;
          $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

          foreach ($clientes as $key => $value) {
            if($value["ultima_venta"]==null){
              $fechaUltCompra = "";
            }else{
              $fechaUltCompra = date('d-m-Y', strtotime($value["ultima_venta"]));
            }
            
            //$fechaAlta = date('d-m-Y', strtotime($value["fecha"]));
            $totcompras=number_format($value["ventas"],2,".",",");
            $totsaldo=number_format($value["saldo"],2,".",",");
              
            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["nombre"].'</td>

                    <td>'.$value["rfc"].'</td>

                    <td>'.$value["email"].'</td>

                    <td>'.$value["telefono"].'</td>

                    <td class="text-right">'."$".$totcompras.'</td>

                    <td class="text-center">'.$fechaUltCompra.'</td>

                    <td class="text-right">'.$totsaldo.'</td>';

                    echo '<td class="text-center">';
                    if($value["estado"]==1){
                      echo '<button class="btn btn-success btn-sm py-0 px-1 pt-1" idCliente="'.$value["id"].'" title="Activado"><i class="fa fa-unlock"></i></button>';
                    }else{
                      echo '<button class="btn btn-warning btn-sm  py-0 px-1 pt-1" idCliente="'.$value["id"].'" title="Desactivado"><i class="fa fa-lock"></i></button>';
                    };
                    echo '</td>';

                    echo '<td>
                      <div class="btn-group">';
                    if(getAccess($acceso, ACCESS_VIEW)){
                      echo '<button class="btn btn-primary btn-sm  py-0 px-1 pt-1 btnEditarCliente" data-toggle="modal" data-target="#modalEditarCliente" idCliente="'.$value["id"].'" title="Editar cliente"><i class="fa fa-pencil"></i></button> &nbsp';
                    }
                    if(getAccess($acceso, ACCESS_SELECT)){
                      echo '<button class="btn btn-info btn-sm py-0 px-1 pt-1 btnAbonoCliente" data-toggle="modal" data-target="#modalAbonoCliente" idCliente="'.$value["id"].'" data-saldo="'.$value["saldo"].'" title="Abono a cuenta"><i class="fa fa-money"></i></button> &nbsp';
                    }
                    if(getAccess($acceso, ACCESS_PRINTER)){
                      echo '<button class="btn btn-warning btn-sm py-0 px-1 pt-1 btnEdoCtaCliente" data-toggle="modal" data-target="#modalEdoCtaCliente" idCliente="'.$value["id"].'" data-nomclie="'.$value["nombre"].'" title="Estado de Cuenta"><i class="fa fa-newspaper-o"></i></button> &nbsp';
                    }

                    if(getAccess($acceso, ACCESS_DELETE)){
                          echo '<button class="btn btn-danger btn-sm py-0 px-1 pt-1 btnEliminarCliente" idCliente="'.$value["id"].'" title="Eliminar cliente"><i class="fa fa-lock"></i></button>';
                    }
                      echo '</div>  

                    </td>

                  </tr>';
          
            }

        ?>              
                
                </tbody>
                <tfoot class="thead-dark">
                <tr>
                    <th style="width:9px;">#</th>
                    <th>Nombre</th>
                    <th>Rfc</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Ventas</th>
                    <th>Últ. Venta</th>
                    <th>Saldo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
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
  
 <!-- === MODAL AGREGAR CLIENTES ==-->
 
  <div class="modal fade" id="modalAgregarCliente" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
   
    <div class="modal-content">
    <form role="form" method="POST">
      <!-- Modal Header -->
      <div class="modal-header colorbackModal p-2">
   
            <h4 class="modal-title">Agregar Cliente</h4>
        
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
                      <span class="input-group-text label-info"><i class="fa fa-user"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="Nombre *" name="nuevoCliente" title="Nombre completo del cliente" required>
              <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                      <span class="input-group-text label-info"><i class="fa fa-id-card"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="RFC" name="nuevoDocumento" title="Rfc del cliente" >
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text label-info"><i class="fa fa-map-marker"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="Dirección *" name="nuevaDireccion" title="Domicilio del cliente" required>
            </div>

          <div class="form-row">

            <div class="input-group mb-3 col-md-6">
              <div class="input-group-prepend">
                  <span class="input-group-text label-info"><i class="fa fa-phone"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="Teléfono *" name="nuevoTelefono" title="Tel. 10 Digitos" data-inputmask='"mask": "(999) 999-9999"' data-mask required>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <span class="input-group-text label-info"><i class="fa fa-percent"></i></span>
                </div>
                <input type="number" class="form-control input-lg" placeholder="Descuento" name="nuevoDescuento" title="Porciento de Descuento">
            </div>

           </div>

                                                                                                        
           <div class="form-row">
              <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <span class="input-group-text label-info"><i class="fa fa-envelope"></i></span>
                </div>
                <input type="email" class="form-control input-lg" placeholder="email *" name="nuevoEmail" title="email cliente" required>
              </div>

              <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <span class="input-group-text label-info"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control input-lg" placeholder="F. Nac. aaaa/mm/dd" name="nuevaFechaNacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask title="Fecha de Nacimiento">
              </div>

          </div>                                                                                                        
            <div class="form-row">  
                <div class="input-group mb-3 col-md-6">
                     <div class="input-group-prepend">
                        <span class="input-group-text label-info"><i class="fa fa-money"></i></span>
                      </div>
                        <input type="number" class="form-control input-lg" placeholder="Lim. de Crédito *" name="nvoLimitecredito" step="any" min=0 title="Limite de Crédito a Otorgar" required>
                </div>

                <div class="input-group mb-3 col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text label-info"><i class="fa fa-unlock-alt"></i></span>
                    </div>
                    <select class="form-control" name="nvoestadoCliente" id="nvoestadoCliente" required tabindex="" >
                    <option value="" selected>Seleccione *</option>
                    <option value="1">Activar</option>
                    <option value="0">Desactivar</option>
                    </select>	
                </div>
            </div>

        </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer colorbackModal p-2">
       
        <button type="button" class="btn btn-primary float-left" data-dismiss="modal"><i class="fa fa-reply"></i> Salir</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
      
      </div>
      
      <?php
        
        $crearCliente=new ControladorClientes();
        $crearCliente->ctrCrearCliente();
      ?>
     </form>
    </div> <!-- fin del modal-content -->
  </div>
</div>    <!-- fin del modal -->


<!-- === MODAL EDITAR CLIENTES ==-->
 
  <div class="modal fade" id="modalEditarCliente" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
   
    <div class="modal-content">
    <form role="form" method="POST">
      <!-- Modal Header -->
      <div class="modal-header colorbackModal p-2">
   
            <h4 class="modal-title">Editar Cliente</h4>
        
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
              <input type="text" class="form-control input-lg" placeholder="Nombre completo *" name="EditarCliente" id="EditarCliente" title="Nombre del cliente"required>
              <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
              <input type="hidden" id="idCliente" name="idCliente">
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="Rfc" name="EditarDocumento" id="EditarDocumento" title="Rfc Cliente">
            </div>

           <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="Dirección *" name="EditarDireccion" id="EditarDireccion" title="Domicilio del cliente" required>
           </div>

           <div class="input-group mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-envelope"></i></span>
              </div>
              <input type="email" class="form-control input-lg" placeholder="email *" name="EditarEmail" id="EditarEmail" title="email cliente" required>
            </div>

            <div class="row">

            <div class="input-group mb-3 col-md-6">
              <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-phone"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="Teléfono *" name="EditarTelefono" id="EditarTelefono"data-inputmask='"mask": "(999) 999-9999"' data-mask title="Télefono cliente" required>
            </div>

            <div class="input-group mb-3 col-md-6">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-percent"></i></span>
                </div>
                <input type="number" class="form-control input-lg" placeholder="Descuento" step="any" min="0" name="EditarDescuento" id="EditarDescuento" title="Porciento de Descuento">
            </div>

            </div>
            
            <div class="row">

              <div class="input-group mb-3 col-md-6">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                  <input type="text" class="form-control input-lg" placeholder="Fecha Nac. aaaa/mm/dd" name="EditarFechaNacimiento" id="EditarFechaNacimiento" title="Fecha de Nacimiento"  data-inputmask="'alias': 'yyyy/mm/dd'" data-mask >
              </div>

              <div class="input-group mb-3 col-md-6">
              <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-money"></i></span>
                  </div>
                 <input type="number" class="form-control" name="saldoactual" id="saldoactual" title="Saldo Actual" readonly>
              </div>

           </div>

           <div class="form-row">  
                <div class="input-group mb-3 col-md-6">
                     <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                      </div>
                        <input type="number" class="form-control input-lg" placeholder="Lim. de Crédito *" title="Limite de Crédito" name="EditarLimitecredito" id="EditarLimitecredito" step="any" min=0 title="Limite de crédito a asignar" required>
                </div>

                <div class="input-group mb-3 col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-unlock-alt"></i></span>
                    </div>
                    <select class="form-control" name="EditarestadoCliente" id="EditarestadoCliente" required tabindex="" >
                    <option value="" selected>Seleccione *</option>
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                    </select>	
                </div>
            </div>

         </div>
        </div>
      
      </div>

      <!-- Modal footer -->
      <div class="modal-footer colorbackModal p-2">
       
        <button type="button" class="btn btn-primary float-left" data-dismiss="modal"><i class="fa fa-reply"></i> Salir</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar Cambios</button>
      
      </div>
      
      <?php
        
        $editarCliente = new ControladorClientes();
        $editarCliente -> ctrEditarCliente();      
      ?>
     </form>
    </div> <!-- fin del modal-content -->
  </div>
</div>    <!-- fin del modal -->

<!-- ================================ MODAL INGRESOS ======================== -->
<div class="modal fade" id="modalAbonoCliente" data-backdrop="static" data-keyboard="false" tabindex="-1">

<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header bg-success py-1 m-0">
      <h3>Abono a Cuenta</h3>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body py-1 m-0">
		  <form id="form_abono" class="py-0 m-0">
		
      <div class="row">
						<div class="col-md-5">
                <label>Fecha: <strong class="text-danger">*</strong></label>
                  <input type="date" class="form-control" id="fechaAbono" name="fechaAbono" value="<?php echo date("Y-m-d");?>" required>
                  <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
                  <input type="hidden" name="idcajaAbono" id="idcajaAbono" value="<?= $_SESSION['idcaja'];?>" >
                  <input type="hidden" id="idClienteAbo" name="idClienteAbo">
						</div>

						<div class="col-md-7">
                <label>Concepto: <strong class="text-danger">*</strong></label>
                  <input type="text" class="form-control" id="conceptoAbono" name="conceptoAbono" placeholder="Max. 25 letras" tabindex="1" required>
						</div>
						
			</div>

        <div class="row">            
          <div class="col-md-5">
             <label for="importesaldo" class="col-form-label">Saldo:</label>
                <input type="number" class="form-control" name="importeSaldo" id="importeSaldo" value="" placeholder="Saldo" title="Saldo de cliente" readonly>
          </div>

          <div class="col-md-7">
             <label for="importeAbono" class="col-form-label">Importe: <strong class="text-danger">*</strong></label>
                <input type="number" class="form-control" name="importeAbono" id="importeAbono" value="" placeholder="Capture Abono" title="Abono a cliente" min="0" step="any" tabindex="2" required>
          </div>
        </div>

          <div class="col-md-12">
            <label for="motivoInAbono" class="col-form-label">Descripcion:</label>
                <textarea class="form-control" type="text" id="descripcionAbono" name="descripcionAbono" title="Breve descripcion del Abono" rows="1" tabindex="3" placeholder="Descripción detallada"></textarea>
          </div> 

          <div class="modal-footer bg-success p-2 m-2">
            <button type="button" data-dismiss="modal" class="btn btn-sm">Cerrar</button>
            <button type="submit" class="btn btn-sm btn-primary" tabindex="4">Guardar</button>
          </div>
        </form>

      </div>
  </div>  <!-- fin modal content -->
 </div>
</div>  
 <!-- ================================ FIN MODAL INGRESOS ======================== -->
<!-- Modal -->
<div class="modal fade" id="modalEdoCtaCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header py-1 m-0">
        <h5 class="modal-title" id="exampleModalLabel">Estado de Cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <div class="row m-0 p-0">
        <label for="nombreclie" id="nomcliente"></label>
      </div>

      <div class="row m-0 p-0">
          <div class="form-group col-md-6 m-0 p-1">
              <label>Fecha Inicial:</label>
              <input type="date" class="form-control input-sm text-primary" id="fechaIniEdocta" name="fechaIniEdocta" value="<?php echo $fechaToday1;?>" title="Fecha Inicial">
              <input type="hidden" name="idCustomer" id="idCustomer" value="">
          </div>

          <div class="form-group col-md-6 m-0 p-1">
              <label>Fecha Final:</label>
              <input type="date" class="form-control input-sm text-primary" id="fechaFinEdocta" name="fechaFinEdocta" value="<?php echo $fechaToday2;?>" title="Fecha Final">
          </div>
        </div>
      </div>
      <div class="modal-footer py-1 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="enviarEdoCta">Generar</button>
      </div>
    </div>
  </div>
</div>

</div>
<!-- ================================ FIN MODAL EDO CTA ======================== -->

<script defer src="vistas/js/clientes.js"></script>

<?php

  $eliminarCliente = new ControladorClientes();
  $eliminarCliente -> ctrEliminarCliente();

?>