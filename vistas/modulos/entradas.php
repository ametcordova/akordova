<?php
    $fechainicio=date("d/m/Y");
?>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header p-1 m-0">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Compras:&nbsp; 
                <small><i class="fa fa-shopping-cart"></i></small>
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
        <button class="btn btn-danger btn-sm" id="btnregresar" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button>          


          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
              <i class="fa fa-minus"></i></button>
			<button type="button" class="btn btn-tool" onclick="regresar()" title="a Inicio">
              <i class="fa fa-times"></i></button>			  
          </div>
        </div>
	 <form role="form" method="POST" class="formularioEntrada" id="formulario">	
     
      <div class="card-body">
		
		
           <div class="form-row">
                <div class="form-group col-md-3">
                  <label><i class="fa fa-male"></i> Proveedor</label>
                  <select class="form-control form-control-sm" name="nuevoProveedor" id="nuevoProveedor" style="width: 100%;" tabindex="0" required title="Seleccione Proveedor">
                  <option value="">Selecione Proveedor</option>
                  <?php
                    $item="estatus";
                    $valor="1";
                    $prov=ControladorEntradas::ctrMostrarProv($item, $valor);
                    foreach($prov as $key=>$value){
                        //if($value["id"]=="1"){
                          //echo '<option selected value="'.$value["id"].'">'.$value["nombre"].'</option>';    
                        //}else{
                          echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                        //}
                    }
                  ?>				  
                  </select>
              </div>
           
                <!-- data-date-end-date=no puede seleccionar una fecha posterior a la actual -->
                  <div class="form-group col-md-1">
                    <label class="control-label" for="inputSuccess"><i class="fa fa-calendar"></i> F. Ped.</label>
                    <input type="text" class="form-control form-control-sm" name="fechaDocto" id="datepicker1" data-date-format="dd/mm/yyyy" data-date-end-date="0d" value="" tabindex="1" required title="Fecha de Pedido">
                    <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
                  </div>
				  
                  <div class="form-group col-md-1">
                    <label class="control-label" for="numeroDocto"><i class="fa fa-file-o"></i> # Doc</label>
                    <input type="text" class="form-control form-control-sm" name="numeroDocto" id="numeroDocto" value="" placeholder="" tabindex="2" required title="Núm de Documento">
                    <span id="msjDoctoRepetido"></span> 
                  </div>
				  
                  <div class="form-group col-md-1">
                    <label class="control-label" for="inputError"><i class="fa fa-calendar"></i> F. Entra</label>
                    <input type="text" class="form-control form-control-sm" name="fechaEntrada" id="datepicker2" data-date-format="dd/mm/yyyy" value="<?= $fechainicio?>" tabindex="3" tabindex="3" required title="Fecha de Entrada al Almacen">
                  </div>
                  <div class="form-group col-md-1.5">
                    <label class="control-label" for="inputError"><i class="fa fa-check"></i> Recibe:</label>
                    <input type="text" class="form-control form-control-sm" name="nombreRecibe" id="nombreRecibe" value="" placeholder="" tabindex="4" required title="Nombre Completo quien recibe el material">
                  </div>

                <div class="form-group col-md-1.5">
                 <label for="inputTipoMov"><i class="fa fa-bookmark-o"></i> Tipo de Entrada</label>
                  <select class="form-control form-control-sm" name="NuevoTipoEntrada" id="NuevoTipoEntrada" title="Tipo de Entrada" tabindex="5" required>
                  <?php
                    $item="clase";
                    $valor="E";
                    $tabla="tipomovimiento";
                    $tipomovSal=ControladorSalidas::ctrMostrarTipoMovs($tabla, $item, $valor);
                    foreach($tipomovSal as $key=>$value){
                        if($value["id"]=="1"){
                          echo '<option selected value="'.$value["id"].'">'.$value["nombre_tipo"].'</option>';    
                        }else{
                          echo '<option value="'.$value["id"].'">'.$value["nombre_tipo"].'</option>';
                        }
                    }
                  ?>				  
                  </select>			  
                </div>
			  
				   <div class="form-group col-md-1.5">
					  <label for="inputAlmacen"><i class="fa fa-hospital-o"></i> Almacen</label>
					  <select id="nuevoAlmacen" class="form-control form-control-sm" name="nuevoAlmacen" id="nuevoAlmacen" tabindex="6" required title="Seleccione Almacen de Entrada">
						<option value="" selected>Seleccione Almacen</option>
						 <?php
							$item=null;
							$valor=null;
							$almacenes=ControladorAlmacenes::ctrMostrarAlmacenes($item, $valor);
							foreach($almacenes as $key=>$value){
								echo '<option value="'.$value["id"].'-'.$value["nombre"].'">'.$value["nombre"].'</option>';
							}
						  ?>								
					  </select>			  
					</div>			
					
            </div>
					
			<div class="dropdown-divider m-1 p-0"></div>
           <div class="form-row d-none" id="agregaProdEntra">
            <div class="col-md-4">
                 <div class="form-group">
                  <select class="form-control select2" name="selecProducto" id="selecProducto" style="width: 100%;" tabindex="7">
				    <option selected value=""></option>
 					<?php
                        $item=null;
                        $valor=null;
                        $orden="id";
                        $estado=1;
                        $productos=ControladorProductos::ctrMostrarProductos($item, $valor,$orden, $estado);
                        foreach($productos as $key=>$value){
                          if(is_null($value["datos_promocion"])){	//VALIDA QUE PRODUCTO NO SEA PROMOCION
                                echo '<option value="'.$value["id"].'">'.$value["codigointerno"]." - ".$value['descripcion'].'</option>';
                          }
                        }
                      ?>		
                  </select>
                </div>
            </div>
			
            <div class="col-md-1">
      				<input type="number" class="form-control  text-center font-weight-bold mb-1" style="font-size:16px;" name="cantExiste" id="cantExiste" value="" readonly tabindex="8" title="Cantidad en Existencia">
            </div>
            
            <div class="col-md-1">
			      	<input type="number" class="form-control  text-center font-weight-bold mb-1" style="background-color:#F2F2F2; font-size:16px;" name="cantEntra" id="cantEntra" value="" step="any" min="0" tabindex="9" title="Capture cantidad de Entrada">
            </div>

            <div class="col-md-1 d-none">
				      <input type="number" class="form-control mb-1 text-danger font-weight-bold"  name="" id="" step="any" value=""  dir="rtl" title="Precio de Venta">
            </div>			

            
            <div class="col-md-1">
				      <input type="number" class="form-control mb-1 text-danger font-weight-bold" style="background-color:#F2F2F2; font-size:16px;"  name="price_compra" id="price_compra" value="" placeholder="" step="any" min="0" tabindex="10" dir="rtl" title="Precio de Entrada">
            </div>			
            
            <div class="col-md-1 d-none">
				      <input type="number" class="form-control mb-1 text-info" style="background-color:silver;"  name="price_venta" id="price_venta" value="" placeholder="" step="any" min="0" tabindex="7" dir="rtl" title="Precio de venta">
            </div>			

            <div class="col-md-4">
               <!--<button class="btn btn-primary btn-sm" data-toggle="modal" onclick="agregarDetalle();" id="agregarEntrada"><i class="fa fa-plus-circle"></i> Agregar</button> -->
               <button class="btn btn-primary" data-toggle="modal" id="agregarDetalle" tabindex="11"><i class="fa fa-plus-circle"></i> Agregar</button>
            </div>
			
            <div class="col-md-4 alert-danger d-none" style="height:30px;" id="msgerrorentrada">
						<!-- PARA MENSAJES DE ADVERTENCIA -->
            </div>

			
         </div>   
         
		<div class="dropdown-divider"></div>		
		
		<div class="wrapper">
		  <!-- Main content -->
			 <section class="invoice">
		 
				 <!-- Table row -->
				 <div class="row">
				  <div class="col-12 col-sm-12 table-responsive">
					<table class="table table-bordered table-condensed table-hover table-sm table-striped mb-0 p-0 dt-responsive" id="detalles" width="100%">

					  <thead class="bg-primary">
					  <tr class="text-center">
						<th style="width:6em">Acción</th>
						<th style="width:4em">#</th>
						<th style="width:13em">Código</th>
						<th style="width:36em">Producto</th>
						<th style="width:3em">Cant</th>
						<th style="width:5em">P.Compra</th>
						<th style="width:5em">Subtotal</th>
						<!-- <th style="width:4em">Utilidad</th>-->
					  </tr>
					  </thead>
					  <tbody>
									  
					  <div class="form-row">
						 <!--AQUI SE AÑADEN LAS ENTRADAS DE LOS PRODUCTOS  -->
					  </div>
					 
					  </tbody>
					  
					 </table>
					
				  </div>
				  <!-- /.col -->
				 </div>
				<!-- /.row -->

				<div class="row">
				  
				    <div class="col-lg-12 col-md-10 col-sm-6 text-right">
              <p class="lead p-0 m-0">Sumas Totales </p>
              <div class="table-responsive table-sm" style="background-color:#E0F8E0;">
                <table class="table text-right m-0">
                <tr>
                  <th style="width:40%">Subtotal:$</th>
                  <td><input type="text" id="sumasubtotal" readonly style="width:6rem" dir="rtl"></td>
                  <th>IVA $ (16%)</th>
                  <td><input type="text" id="iva" readonly style="width:6rem" dir="rtl"></td>
                  <th>Total: $</th>
                  <td><input type="text" id="total" class="font-weight-bold text-success" readonly style="width:6rem; font-size:1.2em" dir="rtl"></td>
                </tr>
                </table>
              </div>

  				  </div>  <!-- /.col -->

				</div>				<!-- /.row -->

		   </section>
		<!-- /.content -->
           <!-- BOTONES -->
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 text-center">
              <button class="btn btn-primary btn-lg" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
              <button id="btnCancelar" class="btn btn-danger btn-lg float-left" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
            </div>
		
		</div>
		
		<!-- ./wrapper -->

      </div>   <!-- /.card-body -->

	 </form>  <!-- TERMINA EL FORM  -->
  </div> <!-- /.card -->

 </section>   <!-- /.content -->
 
</div>
  <script defer src="vistas/js/entradas.js?v=010920"></script>
  <!-- /.content-wrapper -->
      <?php
        
        $crearEntrada=new ControladorEntradas();
        $crearEntrada->ctrCrearEntrada();
      ?>
