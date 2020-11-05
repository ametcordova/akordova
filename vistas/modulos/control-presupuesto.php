<?php
  date_default_timezone_set('America/Mexico_City');
  $fechaToday=date("Y-m-d");
  //$fechaToday=date('2020-09-06');
  $tabla="usuarios";
  $module="controlefectivo";
  $campo="administracion";
  $acceso=accesomodulo($tabla, $_SESSION['id'], $module, $campo);    
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header m-1 p-1">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>
                <small><strong>Control de Efectivo
                <i class="fa fa-inbox" aria-hidden="true"></i>
                </strong>
                </small>
                
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Tablero</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <!-- <div class="card">-->
        <div class="card-header">
		
<!--
        <button class="btn btn-primary btn-sm" onclick="getData()"><i class="fa fa-plus-circle"></i> Agregar
          </button>
-->
        <div class="row m-0 p-0">
          <div class="form-group col-md-1 m-0 p-0">
        	 <button class="btn btn-danger btn-sm" id="btnregresar" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button>          
          </div>
          <?php 
            if(getAccess($acceso, ACCESS_VIEW)){?>
              <div class="form-group col-md-2 m-0 p-0">
              <input type="date" class="form-control input-sm text-primary" id="fechaListar" name="fechaListar" value="<?php echo $fechaToday;?>" title="Fecha a Listar Movimientos">
              </div>
          <?php } ?>

            <!-- ASIGNA VALOR PARA MOSTRAR EN JS  -->
            <div>
              <?php 
                $value_edit=getAccess($acceso, ACCESS_EDIT)?getAccess($acceso, ACCESS_EDIT):0;
              ?>
                <input type="hidden" id="ctrlefeview" value="<?= $value_edit?>" >

              <?php  
                $value_del=getAccess($acceso, ACCESS_DELETE)?getAccess($acceso, ACCESS_DELETE):0;
              ?>
                <input type="hidden" id="ctrlefedelete" value="<?= $value_del?>" >
            </div>
            
        </div>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>

        </div>

        <div class="card-body">
          
        <div class="row">
			<hr/>
                <!-- ==================  TABLA DE INGRESOS ===================== -->
                <div class="col-lg-6 col-md-6 col-sm-6">

                  <div class="alert alert-success p-0 m-1" role="alert">
                    <div class="row align-items-start">
                      <div class="col ml-2"><h4>Ingresos</h4></div>
                      <div class="col"></div>
                      <div class="col text-right px-2 mr-2"><h4 id="ingresototaldia">$</h4></div>
                    </div>                  
                  </div>
                  
                    <div class="table-responsive">
                        <table class="table table-striped table-sm compact table-hover dt-responsive" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:5%;" class='text-left'>Item</th>
									                  <th style="width:50%;" class='text-center'>Concepto Ing.</th>
									                  <th style="width:15%;" class='text-center'>Caja</th>
                                    <th style="width:20%;" class='text-right'>Importe</th>
                                    <th style="width:10%;" style="width:20px;" class='text-center'>Acción</th>
                                </tr>
                            </thead>
                            <tbody class='items_ingresos' id="items_ingresos">
                                
                            </tbody>
                        </table>
                        <hr/>
                            <tr>
                                <td colspan='6'>
                                <?php 
                                if(getAccess($acceso, ACCESS_ADD)){?>
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalIngresos"><span class="fa fa-plus-circle"></span> Agregar Ingresos</button>
                                <?php } ?>                                    
                                </td>
                            </tr>
                    </div>
                </div>

                <!-- ==================  TABLA DE EGRESOS ===================== -->

                <div class="col-lg-6 col-md-6 col-sm-6">
                
                  <div class="alert alert-danger p-0 m-1" role="alert">
                    <div class="row align-items-start">
                      <div class="col ml-2"><h4>Egresos</h4></div>
                      <div class="col"></div>
                      <div class="col text-right px-2 mr-2"><h4 id="egresototaldia"></h4></div>
                    </div>                  
                  </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm compact table-hover dt-responsive">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width:5%;" class='text-left'>Item</th>
									                  <th style="width:50%;" class='text-center'>Concepto Egr.</th>
                                    <th style="width:15%;" class='text-center'>Caja</th>
                                    <th style="width:20%;" class='text-right'>Importe</th>
                                    <th style="width:10%;" style="width:20px;" class='text-center'>Acción</th>
                                </tr>
                            </thead>
                            <tbody class='items_egresos' id="items_egresos">

                            </tbody>
                        </table>
                        <hr/>
                            <tr>
                                <td colspan='6'>
                                <?php 
                                if(getAccess($acceso, ACCESS_ADD)){?>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalEgresos"><span class="fa fa-minus-circle"></span> Agregar Egresos</button>
                                <?php } ?>                                                                        
                                </td>
                            </tr>
                    </div>
                </div>

            </div>  <!-- fin row -->


        </div>
        <!-- /.card-body -->
        
        <div class="card-footer">
          @Kórdova
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  

<!-- ================================ MODAL INGRESOS ======================== -->
<div class="modal fade" id="modalIngresos" data-backdrop="static" data-keyboard="false" tabindex="-1">

<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header bg-success py-1 m-0">
      <h3>Ingreso</h3>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body py-1 m-0">
		  <form id="form_ingreso" class="py-0 m-0">
		
      <div class="row">
						<div class="col-md-5">
                <label>Fecha: <strong class="text-danger">*</strong></label>
                  <input type="date" class="form-control" id="fechaIngreso" name="fechaIngreso" value="<?php echo date("Y-m-d");?>" required>
                  <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
                  <input type="hidden" name="idcaja" id="idcajaing" value="<?= $_SESSION['idcaja'];?>" >
						</div>

						<div class="col-md-7">
                <label>Concepto: <strong class="text-danger">*</strong></label>
                  <input type="text" class="form-control" id="conceptoIngreso" name="conceptoIngreso" placeholder="Max. 25 letras" required>
						</div>
						
			</div>

          <div class="col-md-12">
             <label for="importeIngreso" class="col-form-label">Importe: <strong class="text-danger">*</strong></label>
                <input type="number" class="form-control" name="importeIngreso" id="importeIngreso" value="" placeholder="Capture Ingreso" title="Ingreso a caja" min="0" step="any" required>
          </div>

          <div class="col-md-12">
            <label for="motivoInlngreso" class="col-form-label">Descripcion:</label>
                <textarea class="form-control" type="text" id="descripcionIngreso" name="descripcionIngreso" title="Breve descripcion del Ingreso" rows="1" placeholder="Descripción detallada"></textarea>
          </div> 

          <div class="modal-footer bg-success p-2 m-2">
            <button type="button" data-dismiss="modal" class="btn btn-sm">Cerrar</button>
            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
          </div>
        </form>

      </div>
  </div>
 </div>
</div>  
  <!-- ================================ FIN MODAL INGRESOS ======================== -->

<!-- ================================ MODAL EGRESOS ======================== -->
<div class="modal fade" id="modalEgresos" data-backdrop="static" data-keyboard="false" tabindex="-1">

<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header bg-danger py-1 m-0">
      <h3>Egreso</h3>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body py-1 m-0">
		  <form id="form_egreso" class="py-0 m-0">
		
      <div class="row">
						<div class="col-md-5">
                <label>Fecha: <strong class="text-danger">*</strong></label>
                  <input type="date" class="form-control" id="fechaEgreso" name="fechaEgreso" value="<?php echo date("Y-m-d");?>" required>
                  <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
                  <input type="hidden" name="idcaja" id="idcajaegr" value="<?= $_SESSION['idcaja'];?>" >
						</div>

						<div class="col-md-7">
                <label>Concepto: <strong class="text-danger">*</strong></label>
                  <input type="text" class="form-control" id="conceptoEgreso" name="conceptoEgreso" placeholder="Max. 25 letras" required>
						</div>
						
			</div>

          <div class="col-md-12">
             <label for="importeIngreso" class="col-form-label">Importe: <strong class="text-danger">*</strong></label>
                <input type="number" class="form-control" name="importeEgreso" id="importeEgreso" value="" placeholder="Capture Egreso" title="Egreso a caja" min="0" step="any" required>
          </div>

          <div class="col-md-12">
            <label for="motivoInEgreso" class="col-form-label">Descripcion:</label>
                <textarea class="form-control" type="text" id="descripcionEgreso" name="descripcionEgreso" title="Breve descripcion del Egreso" rows="1" placeholder="Descripción detallada"></textarea>
          </div> 

          <div class="modal-footer bg-danger py-2 m-2">
            <button type="button" data-dismiss="modal" class="btn btn-sm">Cerrar</button>
            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
          </div>
        </form>

      </div>
  </div>
 </div>
</div>  
  <!-- ================================ FIN MODAL EGRESOS ======================== -->

<!-- ================================ MODAL UPDATE INGRESOS ======================== -->
<div class="modal fade" id="update_ingresos" data-backdrop="static" data-keyboard="false" tabindex="-1">

<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header bg-success py-1 m-0">
      <h3 id="title_ingreso"></h3>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body py-1 m-0">
		  <form id="form_update_ingreso" class="py-0 m-0">
		
      <div class="row">
						<div class="col-md-5">
                <label>Fecha: <strong class="text-danger">*</strong></label>
                  <input type="date" class="form-control" id="editfechaIngreso" name="editfechaIngreso" value="" readonly>
                  <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
                  <input type="hidden" name="idcaja" id="idcajauping" value="<?= $_SESSION['idcaja'];?>" >
                  <input type="hidden"  name="edit_id" id="edit_id" value="">
						</div>

						<div class="col-md-7">
                <label>Concepto: <strong class="text-danger">*</strong></label>
                  <input type="text" class="form-control" id="editconceptoIngreso" name="editconceptoIngreso" placeholder="Max. 25 letras" required>
						</div>
						
			</div>

          <div class="col-md-12">
             <label for="importeIngreso" class="col-form-label">Importe: <strong class="text-danger">*</strong></label>
                <input type="number" class="form-control" name="editimporteIngreso" id="editimporteIngreso" value="" placeholder="Capture Ingreso" title="Ingreso a caja" min="0" step="any" required>
          </div>

          <div class="col-md-12">
            <label for="motivoInlngreso" class="col-form-label">Descripcion:</label>
                <textarea class="form-control" type="text" id="editdescripcionIngreso" name="editdescripcionIngreso" title="Descripcion del Ingreso" rows="1" placeholder="Descripción detallada"></textarea>
          </div> 

          <div class="modal-footer bg-success p-2 m-2">
            <button type="button" data-dismiss="modal" class="btn btn-sm">Cerrar</button>
            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
          </div>
        </form>

      </div>
  </div>
 </div>
</div>  
<!-- ================================ FIN MODAL UPDATE INGRESOS ======================== -->

<!-- ================================ MODAL UPDATE EGRESOS ======================== -->
<div class="modal fade" id="update_egresos" data-backdrop="static" data-keyboard="false" tabindex="-1">

<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header bg-danger py-1 m-0">
      <h3 id="title_egreso"></h3>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body py-1 m-0">
		  <form id="form_update_egreso" class="py-0 m-0">
		
      <div class="row">
						<div class="col-md-5">
                <label>Fecha: <strong class="text-danger">*</strong></label>
                  <input type="date" class="form-control" id="editfechaEgreso" name="editfechaEgreso" value="" readonly>
                  <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
                  <input type="hidden" name="idcaja" id="idcajaupegr" value="<?= $_SESSION['idcaja'];?>" >
                  <input type="hidden"  name="editid" id="editid" value="">
						</div>

						<div class="col-md-7">
                <label>Concepto: <strong class="text-danger">*</strong></label>
                  <input type="text" class="form-control" id="editconceptoEgreso" name="editconceptoEgreso" placeholder="Max. 25 letras" required>
						</div>
						
			</div>

          <div class="col-md-12">
             <label for="importeIngreso" class="col-form-label">Importe: <strong class="text-danger">*</strong></label>
                <input type="number" class="form-control" name="editimporteEgreso" id="editimporteEgreso" value="" placeholder="Capture Egreso" title="Egreso de caja" min="0" step="any" required>
          </div>

          <div class="col-md-12">
            <label for="motivoInEgreso" class="col-form-label">Descripcion:</label>
                <textarea class="form-control" type="text" id="editdescripcionEgreso" name="editdescripcionEgreso" title="Descripcion del Egreso" rows="1" placeholder="Descripción detallada"></textarea>
          </div> 

          <div class="modal-footer bg-danger py-2 m-2">
            <button type="button" data-dismiss="modal" class="btn btn-sm">Cerrar</button>
            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
          </div>
        </form>

      </div>
  </div>
 </div>
</div>  
  <!-- ================================ FIN MODAL UPDATE EGRESOS ======================== -->
  <script defer src="vistas/js/control-presupuesto.js?v=02092020"></script>

