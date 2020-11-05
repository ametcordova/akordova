<?php
$tabla="usuarios";
$module="ventas";
$campo="administracion";
$acceso=accesomodulo($tabla, $_SESSION['id'], $module, $campo);
$fechaHoy=date("d/m/Y");
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
  
</body>
</html> -->
<!-- <style>
.select2 {
  font-family: 'FontAwesome';
}
</style> -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header p-1 m-0">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-4">
            <h1><small><i class="fa fa-money" aria-hidden="true"></i> Modulo de Ventas</small></h1>
          </div>
          <div class="col-sm-4 text-primary">
          <label>F2 = Buscar  &nbsp - &nbsp F9 = Ticket  &nbsp - &nbsp  F10 = Guardar</label>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="tablero">Tablero</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header m-0 p-1">

          <div class="col-md-8" >
            <button class="btn btn-danger btn-sm" id="btnregresar" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button>          
          </div>


          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-tool" onclick="regresar()" data-widget="remove" data-toggle="tooltip" title="Inicio"><i class="fa fa-times"></i></button>
          </div>

          
        </div>
        
        <form role="form" method="POST" class="formularioSalida" id="formularioSalida" >
        
        <div class="card-body py-1 pt-1">

           <div class="form-row m-0">
                <div class="form-group col-md-2">
                 <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
                  <label><i class="fa fa-user"></i> Cliente</label>
                  <select class="form-control form-control-sm" name="nuevoCliente" id="nuevoCliente" style="width: 100%;" required title="Cliente a Vender">
                  <option value="">Selecione Cliente</option>
                  <?php
                    $item=null;
                    $valor=null;
                    $clientes=ControladorClientes::ctrMostrarClientes($item, $valor);
                    foreach($clientes as $key=>$value){
                      if($value["estado"]=="1"){
                        if($value["id"]=="1"){
                          echo '<option selected value="'.$value["id"].'">'.$value["nombre"].'</option>';    
                        }else{
                          echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                        }
                      }
                    }
                  ?>				  
                  </select>
              </div>
           
                <!-- data-date-end-date=no puede seleccionar una fecha posterior a la actual -->
                  <div class="form-group col-md-1">

                    <label class="control-label" for="numeroDocto"><i class="fa fa-file-o"></i> No.</label>
                    <input type="text" class="form-control form-control-sm text-center bg-secondary font-weight-bolder" name="numeroSalidaAlm" id="numeroSalidaAlm" value=""  readonly title="Número de Venta">
                    <span  id="msjNumeroRepetido"></span> 
                  </div>
                  
                      <div class="form-group col-md-1">
                        <label class="control-label" for="inputError"><i class="fa fa-calendar"></i> Fecha</label>
                        <input type="text" class="form-control form-control-sm" name="fechaSalida" value="<?= $fechaHoy ?>" tabindex="2" readonly title="Fecha Venta">
                      </div>

                  <div class="form-group col-md-1.5">
                    <label class="control-label" for="inputError"><i class="fa fa-check"></i> Usuario:</label>
                    <input type="text" class="form-control form-control-sm" name="nombreSalida" id="nombreSalida" value="<?php echo $_SESSION['nombre'];?>" placeholder=""  readonly title="Usuario que realiza la venta">
                    <input type="hidden" name="idcaja" id="idcaja" value="<?= $_SESSION['idcaja'];?>" >
                  </div>
				  
                <div class="form-group col-md-2">
                 <label for="inputTipoMov"><i class="fa fa-bookmark-o"></i> Tipo de Mov.</label>
                  <select class="form-control form-control-sm" name="nuevoTipoSalida" id="nuevoTipoSalida" tabindex="4" required title="Tipo de Venta">
                    <option >Seleccione Tipo</option>
                  <?php
                    $item="clase";
                    $valor="S";
                    $tabla="tipomovimiento";
                    $tipomov=ControladorSalidas::ctrMostrarTipoMovs($tabla, $item, $valor);
                    foreach($tipomov as $key=>$value){
                        if($value["id"]=="1"){
                          echo '<option selected value="'.$value["id"].'">'.$value["nombre_tipo"].'</option>';    
                        }else{
                          echo '<option value="'.$value["id"].'">'.$value["nombre_tipo"].'</option>';
                        }
                    }
                  ?>				  
                  </select>			  
                  <input type="hidden" name="tipodeventa" id="tipodeventa" >
                </div>

              <div class="form-group col-md-1">
                  <label for="inputAlmacen"><i class="fa fa-hospital-o"></i> Almacen</label>
                  <select class="form-control form-control-sm" name="nuevaSalidaAlmacen" id="nuevaSalidaAlmacen" tabindex="0" required title="Almacen de Salida Producto">
                  <option value="" selected>Seleccione Almacen</option>
                          <?php
                              $item=null;
                              $valor=null;
                              $almacenes=ControladorAlmacenes::ctrMostrarAlmacenes($item, $valor);
                              foreach($almacenes as $key=>$value){
                  if($value["id"]=="1"){
                      echo '<option selected value="'.$value["id"].'-'.$value["nombre"].'">'.$value["nombre"].'</option>';
                  }else{
                                    echo '<option value="'.$value["id"].'-'.$value["nombre"].'">'.$value["nombre"].'</option>';
                              }							  
                      
                              }
                            ?>								
                  </select>			  
              </div>

              <div class="form-group col-md-1">
                  <label for="inputAlmacen"><i class="fa fa-dot-circle-o"></i> Tipo Vta</label>
                  <select class="form-control form-control-sm" name="nuevotipovta" id="nuevotipovta" tabindex="0" required title="Tipo de venta realizada.">
                  <option value="0" selected>Mostrador</option>
                  <option value="1" >Domicilio</option>
                  </select>			  
              </div>

              <!-- PANTALLA DEL TOTAL DE VENTA -->
              <div class="form-group col-md-2 text-center text-justify border border-success rounded d-none " id="priceventa" style="background-color:#D5F5E3; color:green;" >
                <!-- <h1 class="priceventa" style="font-family:Arial; font-size:3em;"></h1>-->
                <h1 class="priceventa" style="font-family: 'Play', sans-serif; font-size:2.8em; font-weight:bold;"></h1>
              </div>

            </div>
                    
			        <div class="dropdown-divider m-0 p-1"></div> 
            
           <div class="form-row " id="agregarProd">        <!--tmb invisible -->
            <div class="col-md-4">
                 <div class="form-group">
                <select class="form-control select3" name="selecProductoSal" id="selecProductoSal" style="width: 100%;" autofocus tabindex="5">
				            <option selected value=""></option>
 				  	          <?php
                        $item=null;
                        $valor=null;
                        $orden="id";
                        $estado=1;  
                        $productos=ControladorProductos::ctrListaProductos($item, $valor,$orden, $estado);
                        foreach($productos as $key=>$value){
                            echo '<option value="'.$value["id"].'">'.$value["codigointerno"]." - ".$value["descripcion"].'</option>';
                        }
                      ?>		
                  </select>
                </div>
            </div>

            <div class="col- ">
              <input type="number" class="form-control form-control-sm text-center  font-weight-bold inputVta" name="cantExiste" id="cantExiste" value="" step="any" readonly title="Cantidad Existente">
              <input type="hidden" name="umedida" id="umedida" value="" >
            </div>

            <div class="col- m-0" >
				      <input type="number" class="form-control form-control-sm font-weight-bold inputprecio text-center" name="precioValor" id="precioValor" value="" placeholder="" step="any" min="0" tabindex="" title="Precio Venta">
            </div>
            
            <div class="col- m-0 cajaprecio">
				      <input type="number" class="form-control form-control-sm font-weight-bold text-center inputVta" name="cantSalida" id="cantSalida" value="" placeholder="" step="any" min="1" tabindex="6" title="Cantidad Salida">
            </div>
			
            <div class="col- mr-0">
               <button class="btn btn-primary btn-sm " id="agregarProductos" tabindex="7"><i class="fa fa-plus-circle"></i> Agregar</button>
            </div>

			  <?php
           if(getAccess($acceso, ACCESS_ACTIVAR)){?>
            <div class="col- ml-1 form-check">
              <input class="form-check-input checkbox-inline" type="checkbox" value="1" name="promo" id="promocion">
              <label class="form-check-label" for="promo">
               Ajuste
              </label>
            </div>	
			  <?php } ?>
              
            <div class="js-event-log"></div> 

            <div class="col- ml-2 alert-danger rounded d-none" id="mensajerror">
						<!-- PARA MENSAJES DE ADVERTENCIA -->
            </div>
			
         </div>   

        <div class="wrapper">
          <!-- Main content Producto no existe o no tiene existencia que solicita!!-->
          <section class="invoice">
        
            <!-- Table row -->
            <div class="row">
              <div class="col-12 col-sm-12 table-responsive" style="height: 20em !important; overflow: scroll;">
                
              <table class="table table-bordered table-condensed table-sm table-striped mb-0 p-0 table-hover " id="detalleSalida" width="100%" >

                <thead class="thead-dark">
                <tr class="text-center">
                <th style="width:3rem">Acción</th>
                <th>#</th>
                <th>Código</th>
                <th>Producto</th>
                <th>U. Med</th>
                <th>Cant</th>
                <th>P.venta</th>
                <th>Subtotal</th>
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

            <div class="dropdown-divider"></div> 
            
            <div class="row ">
            
              <!-- /.col -->
              <div class="col-lg-12 col-md-12 col-sm-12 ">

                <div class="table-responsive table-sm ">
                  <table class="table m-0 table-primary">
                    <tr class="font-weight-bold ">
                       <th style="width:35%" id="ubicacion"></th>
                      <!--<th style="width:10%">Descuento:$</th>
                      <td><input type="text" id="sumadescuento" readonly style="width:6rem" dir="rtl"></td> -->
                      <th style="width:10%">Subtotal:$</th>
                      <td><input type="text" id="sumasubtotal" readonly style="width:6rem" dir="rtl"></td>
                      <th style="width:10%">IVA $ (16%)</th>
                      <td><input type="text" id="iva" readonly style="width:6rem" dir="rtl"></td>
                      <th style="width:10%">Total: $</th>
                      <td style="font-size:1.3em"><input type="text" id="total" readonly style="width:6.6rem" class="font-weight-bold text-success text-center"></td>
                    </tr>
                  </table>
                </div>

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </section>	<!-- /.content -->
              <!-- BOTONES -->
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-2 text-center mt-3">
                  <input type="text" name="saveregtick" id="saveRegTick" value="Guardar y Ticket" class="boton_personalizado float-right" title="Guarda y Ticket" readonly>
                  <button class="btn btn-success btn-lg" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                  <button id="btnCancelar" class="btn btn-danger btn-lg float-left" onclick="regresar()" type="button"><i class="fa fa-times"></i> Cancelar</button>
                  <input type="hidden" name="pagocliente" id="pagocliente" value="0" >
                  <input type="hidden" name="printicket" id="printicket" value="0" >
                </div>
        
        </div>
        <!-- ./wrapper -->        

        </div><!-- /FIN de .card-body -->
        
         <div class="card-footer text-right m-0">
<!--		 
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button class="btn btn-primary btn-sm" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
              <button id="btnCancelar" class="btn btn-danger btn-sm" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
            </div>
-->			
        </div> <!-- /.card-footer-->    
	    </form>  <!-- TERMINA EL FORM  -->
	</div>  <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- <script defer src="vistas/js/salidas.js?v=020920"></script> -->
  
  <!-- /.content-wrapper -->
   <?php
    $crearSalida=new ControladorSalidas();
    $crearSalida->ctrCrearSalida();
    
  ?>
