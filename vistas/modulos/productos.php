<?php
  $tabla="usuarios";
  $module="productos";
  $campo="catalogo";
  $acceso=accesomodulo($tabla, $_SESSION['id'], $module, $campo);
?>
<style>
	.select2-results__options{
        font-size:13px !important;
	}	
</style>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header py-1 m-0">
      <div class="container-fluid m-0 py-1">
        <div class="row">
          <div class="col-sm-6">
            <h4>Administrar Productos:&nbsp; 
               <small><i class="fa fa-tag"></i></small>

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
           <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAgregarProducto" id="agregarProd">
             <i class="fa fa-plus-circle"></i> Agregar Productos
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
               <h3 class="card-title">Tabla con todos los Productos</h3>
            </div> -->
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered compact table-hover dt-responsive tablaProductos" width="100%">
                <thead class="thead-dark">
                  <tr style="font-size:13px;">
                   <th style="width:3.5%">#</th>
                   <th>Cód. Int.</th>
                   <th>Descripción</th>
                   <th style="width:11%">Familia</th>
                   <th style="width:13%">Categoría</th>
        				   <th>U. Med</th>
                   <th>Stock</th>
                   <th style="width:7%">P. Compra</th>
                   <th style="width:7%">P. Venta</th>
                   <th>Accion</th>
                 </tr> 
                </thead>
                
                <tbody>
                
                </tbody>
 
                <tfoot>
                  <tr style="font-size:13px;" class="thead-dark">
                   <th style="width:3.5%">#</th>
                   <th>Cód. Int.</th>
                   <th>Descripción</th>
                   <th style="width:11%">Familiar</th>
                   <th style="width:13%">Categoría</th>
				           <th>U. Med</th>
                   <th>Stock</th>
                   <th>P. Compra</th>
                   <th>P. Venta</th>
                   <th>Accion</th>
                 </tr> 
               </tfoot>

              </table>
              <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->            
        </div>
        <!-- /.card-body -->
        
        <!--
        <div class="card-footer">
          Footer
        </div>
         /.card-footer-->
        
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <!-- ============================================================================
 ========================== MODAL AGREGAR PRODUCTOS ============================
================================================================================= -->
<div class="modal fade" id="modalAgregarProducto" data-backdrop="static" data-keyboard="false" tabindex="">
  <div class="modal-dialog modal-lg p-0 my-0">
   
   <div class="modal-content">
    <form role="form" method="POST" id="formularioproducto">
      <!-- Modal Header -->
      <div class="modal-header m-0 py-2 colorbackModal">
         <h5 class="modal-title">Agregar Producto
			    <small><i class="fa fa-tag"></i></small>
		    </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      

      <!-- Modal body -->
    <div class="modal-body">
           
        <div class="box-body">
        </div>   

     <div class="card card-info">
         <div class="card-body">

            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA Y UNIDA DE MEDIDA-->
            <div class="form-row">

                <div class="form-group col-sm-4 mb-2">
                   <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-list-ol"></i></span> 
                    <select class="form-control input-lg"  name="nuevaFamilia" id="nuevaFamilia" required title="Familia"autofocus>
                     <option value="">Seleccionar Familia</option>
                      <?php
                        $item=null;
                        $valor=null;
                        $familias=ControladorFamilias::ctrMostrarFamilias($item, $valor);
                        foreach($familias as $key=>$value){
                            echo '<option value="'.$value["id"].'">'.$value["familia"].'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group col-sm-5 mb-2">
                   <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-th"></i></span> 
                    <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" tabindex="1" required title="Categoría">
                      <option value="0" selected>Seleccionar categoría</option>

                      <?php
                        // $item=null;
                        // $valor=null;
                        // $categorias=ControladorCategorias::ctrMostrarCategorias($item, $valor);
                        // foreach($categorias as $key=>$value){
                        //     echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';
                        // }
                      ?>

                    </select>
                  </div>
                </div>     

                <div class="form-group col-sm-3 mb-2">
                   <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-tachometer"></i></span> 
                    <select class="form-control input-lg" id="nuevaMedida" name="nuevaMedida" tabindex="2" required title="U. de Medida">
                      <option value="">U. de Medida</option>
                      <?php
                        $item=null;
                        $valor=null;
                        $medidas=ControladorMedidas::ctrMostrarMedidas($item, $valor);
                        foreach($medidas as $key=>$value){
                            echo '<option value="'.$value["id"].'">'.$value["medida"].'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>    

               <div class="form-group col-sm-3 mb-2 d-none">
                <div class="input-group">
                  <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-code"></i></span>
                  </div>
                  <input type="text" class="form-control input-lg" placeholder="" name="nuevoCodigo" id="nuevoCodigo" readonly required>
                  <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
                </div>
                </div>
            </div>     <!-- fin de CATEGORIA Y UNIDAD DE MEDIDA -->

                 <div class="form-row">  

                <div class="form-group col-sm-4 mb-2">
                <div class="input-group">
                  <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                  </div>
                  <input type="text" class="form-control input-lg" placeholder="Ingresar Código *" name="nuevoCodInterno" id="nuevoCodInterno" tabindex="3" required title="Código del Producto">
                </div>
                <span class="msjCodigoRepetido"></span> 
                </div>

                <div class="form-group col-sm-8 mb-2">
                <div class="input-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fa fa-tag"></i></span>
                  </div>
                  <input type="text" class="form-control input-lg" placeholder="Descripción del prod. sin guiones *" name="nuevaDescripcion" id="nuevaDescripcion" tabindex="4" onkeyUp="mayuscula(this);" title="Capture descripción del producto sin guiones" required>
                </div>
                </div>
            </div>


                <div class="form-row">    
                <div class="form-group col-sm-3 mb-2">
                    <div class="input-group">
                      <div class="input-group-prepend">
                         <span class="input-group-text"><i class="fa fa-plus-square"></i></span>
                      </div>
                      <input type="number" class="form-control input-lg" placeholder="Maximo" name="nuevoStock" id="nuevoStock" min="0" step="any" tabindex="5" title="Máximo">
                    </div>
                </div>

                <div class="form-group col-sm-3 mb-2">
                    <div class="input-group">
                      <div class="input-group-prepend">
                         <span class="input-group-text"><i class="fa fa-minus-square"></i></span>
                      </div>
                      <input type="number" class="form-control input-lg" placeholder="Mínimo *" name="nuevoMinimo" id="nuevoMinimo" min="0" step="any" title="Mínimo" required tabindex="6">
                    </div>
                </div>

                <div class="form-group col-sm-3 col-xs-12 mb-2">
                    <div class="input-group">
                      <div class="input-group-prepend">
                         <span class="input-group-text"><i class="fa fa-archive"></i></span>
                      </div>
                      <input type="number" class="form-control input-lg" placeholder="Unidad x Caja" name="nuevoUnidadxCaja" id="nuevoUnidadxCaja" min="0" step="any" tabindex="7" title="Unidad por Caja/Paquete/Bolsa/Bulto">
                    </div>
                </div>

                <div class="form-group col-sm-3 col-xs-12 mb-2">
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-flask"></i></span>
                      </div>
                      <input type="number" class="form-control input-lg" placeholder="Hectolitros" name="nuevoHectolitros" id="nuevoHectolitros" min="0" step="any" tabindex="8" title="Hectolitros">
                  </div>
                </div>
                

            </div>

                <!--Porcentaje no se guarda en la BD -->
                 <div class="form-row">
                     <div class="col-sm-2 col-xs-3 pt-2">
                         <div class="form-group">
                            <div class="checkbox icheck">
                             <label>
                                 <input type="checkbox" class="minimal flat-red porcentaje">
                                 Usar %
                             </label>
                             </div>
                         </div>
                     </div>

                     <div class="col-sm-2 col-xs-3 " style="padding-left:4px">
                         <div class="input-group">
                             <input type="number" class="form-control nuevoPorcentaje" name="nuevoMargen" id="nuevoMargen" min="0" value="0" step="any" tabindex="8">
                             <span class="input-group-text"><i class="fa fa-percent"></i></span>
                         </div>
                     </div>

                     <div class="form-group col-sm-4 col-xs-12 ">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-arrow-up"></i></span>
                        </div>
                        <input type="number" class="form-control input-lg" placeholder="Precio de Compra *" name="nuevoPrecioCompra" id="nuevoPrecioCompra" min="0" step="any" required tabindex="9" title="Precio de Compra">
                      </div>
                    </div>

                    <div class="form-group col-sm-4 col-xs-12">
                         <div class="input-group">
                           <div class="input-group-prepend">
                             <span class="input-group-text"><i class="fa fa-arrow-down"></i></span>
                           </div>
                          <input type="number" class="form-control input-lg" placeholder="Precio de Venta" name="nuevoPrecioVenta" id="nuevoPrecioVenta" min="0" step="any" tabindex="10" title="Precio de Venta">
                         </div>
                     </div>

                </div>  <!--fin del form-row  -->

                <div class="form-row">

                <div class="col-sm-2.5 col-xs-2">
                    <div class="input-group">
                      <span class="input-group-text"> <i class="fa fa-map-marker"></i>&nbsp UBICACIÓN</span>
                    </div>
                </div>

                  <div class="col-sm-3 col-xs-3">
                    <div class="input-group">
                    <span class="input-group-text">Pasillo</span>
                      <input type="text" class="form-control" name="nuevoPasillo" id="nuevoPasillo" pattern=".{3,}" title="Máximo 3 caracteres" maxlength="3" onkeyUp="mayuscula(this);" tabindex="">
                    </div>
                  </div>

                  <div class="col-sm-3 col-xs-3">
                    <div class="input-group">
                    <span class="input-group-text">Anaquel</span>
                      <input type="text" class="form-control" name="nuevoAnaquel" id="nuevoAnaquel" pattern=".{3,}" title="Máximo 3 caracteres" maxlength="3" onkeyUp="mayuscula(this);" tabindex="">
                    </div>
                  </div>

                  <div class="col-sm-3 col-xs-3">
                    <div class="input-group">
                    <span class="input-group-text">Gaveta</span>
                      <input type="text" class="form-control" name="nuevaGaveta" id="nuevaGaveta" pattern=".{3,}" title="Máximo 3 caracteres" maxlength="3" onkeyUp="mayuscula(this);" tabindex="">
                    </div>
                  </div>

                </div>  <!--fin del form-row  -->

                <!-- INSERTAR LEYENDA -->
                 <div class="form-row mb-1 mt-1 pt-2">
                     <div class="col-sm-3 col-xs-3">
                         <div class="form-group">
                            <div class="checkbox icheck">
                             <label>
                                 <input type="checkbox" class="minimal flat-red insertaLeyenda" tabindex="11">
                                 Leyenda en ticket
                             </label>
                             </div>
                         </div>
                     </div>

                     <div class="col-sm-9 col-xs-9 inputLeyenda d-none" style="padding-left:4px">
                        <div class="input-group">
                          <input type="text" class="form-control" name="nuevaLeyenda" id="nuevaLeyenda" value="" placeholder="Max. 50 Letras" maxlength="50" onkeyUp="mayuscula(this);" tabindex="12">
                        </div>
                     </div>
                 </div>

                <!-- INSERTAR CHECK PROMO -->
              <div class="form-row mb-1">
                    <div class="col-sm-2 ">
                        <div class="form-group">
                            <div class="checkbox icheck">
                             <label>
                                 <input type="checkbox" class="minimal flat-red promocion" tabindex="13">
                                 Promoción
                             </label>
                             </div>
                        </div>
                    </div>


                <div class="col-sm-6 mb-2 oculto d-none" style="padding-left:4px">
                  <select class="form-control select3" name="selecProductoProm" id="selecProductoProm" style="width: 100%;">
                      <option selected value=""></option>
                        <?php
                    $item=null;
                    $valor=null;
                    $orden="id";
                    $estado=1;
                    $productos=ControladorProductos::ctrMostrarProductos($item, $valor,$orden, $estado);
                    foreach($productos as $key=>$value){
                      if($value["datos_promocion"]==null){	//VALIDA QUE PRODUCTO NO SEA PROMOCION
                        echo '<option value="'.$value["id"].'">'.$value["codigointerno"]." - ".$value["descripcion"].'</option>';
                      }
                    }
                    ?>		
                  </select>
                </div>

                  <div class="col-md-1 mr-1 oculto d-none">
                      <input type="number" class="form-control form-control-sm mb-1 font-weight-bold inputVta" name="qty" id="qty" value="" placeholder="" step="any" min="0" tabindex="" title="cantidad">
                  </div>

                  <div class="col-md-1 mr-1 oculto d-none">
                      <input type="number" class="form-control form-control-sm mb-1 font-weight-bold inputVta" name="price" id="price" value="" placeholder="$" step="any" min="0" title="Precio venta">
                  </div>

                  <div class="col-md-1 mr-1 oculto d-none">
                  <button class="btn btn-primary btn-sm mb-1 " id="agregaProductoProm"><i class="fa fa-plus-circle"></i> Agregar</button>
                </div>

              </div>	<!-- FIN DEL FORM-ROW DE CHECK PROMO -->
                

			<div class="row oculto d-none">
				  <div class="col-12 col-sm-12 table-responsive">
				    
					<table class="table table-bordered table-sm mb-0 p-0 table-hover dt-responsive" id="detalleSalidaProm" width="100%" height="8px">

					  <thead class="thead-dark">
              <tr class="text-center">
                <th style="width:3rem">Acción</th>
                <th style="width:3.1rem">#</th>
                <th style="width:8.5rem">Código</th>
                <th>Producto</th>
                <th style="width:3rem">Cant</th>
                <th style="width:3rem">Precio</th>
  					  </tr>
					  </thead>

					  <tbody class="tbodypromo bg-primary">
              <div class="form-row">
              <!--AQUI SE AÑADEN LOS PRODUCTOS DE LAS PROMOCIONES  -->
              </div>
					  </tbody>

					 </table>
					
				  </div>
				  <!-- /.col -->
			</div>  <!-- / fin del .row -->

        <div class="dropdown-divider"></div> 

                <!-- <div class="form-group col-12">
                  <label for="exampleInputFile">Subir Imagen. - Peso Máximo de la foto 2mb. </label>
                  <div class="input-group">
                    <div class="custom-file">
                     <input type="file" class="custom-file-input form-control-sm nuevaImagen" id="exampleInputFile" name="nuevaImagen" tabindex="14">
                     <label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
                    </div>
                  </div>
					        <img src="vistas/img/productos/default/default.jpg" class="img-thumbnail previsualizar" width="85px" alt=""> -->
                    <!--<img src="" class="img-thumbnail previsualizar" width="90px" alt=""> -->
                <!-- </div> -->

            <div class="form-row mb-0">

              <label for="inputEstatus">Estatus:</label>
                <div class="col-md-2 ml-0">
                  <select class="form-control form-control-sm" name="NuevoEstatus" id="NuevoEstatus" required>
                  <option selected value="1">Activado</option>
                  <option value="0">Desactivado</option>
                  </select>			  
                </div>

               <div class="col-sm-2 col-xs-2 ml-2">
                  <div class="form-group">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox" name="nuevoEnvase" value="1" class="minimal flat-red esenvase" tabindex="15">
                               Es Envase
                         </label>
                      </div>
                  </div>
                </div>

                <div class="col-sm-2 col-xs-2">
                  <div class="form-group">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox" name="nuevoServicio" value="1" class="minimal flat-red esservicio" tabindex="16">
                               Es Servicio
                         </label>
                      </div>
                  </div>
                </div>

                <div class="col-sm-2 col-xs-2 mr-0">
                  <div class="form-group mr-0">
                      <div class="checkbox icheck mr-0">
                        <label>
                          <input type="checkbox" name="nuevoOtros" value="1" class="minimal flat-red esotros mr-0" tabindex="17">
                              Otros
                         </label>
                      </div>
                  </div>
                </div>

                <div class="col-sm-2 col-xs-2 ml-0 p-0">
                  <div class="form-group">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox" name="nuevoGranel" value="1" class="minimal flat-red esagranel" tabindex="18">
                               Vta a Granel
                         </label>
                      </div>
                  </div>
                </div>
            </div>

            </div>   <!-- fin de CARD BODY --> 
  
      </div>

      <!-- Modal footer -->
      <div class="modal-footer mt-1 p-0 mr-3">
        <button type="button" class="btn btn-sm btn-primary float-left" data-dismiss="modal"><i class="fa fa-reply"></i> Salir</button>
        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Guardar Producto</button>
      </div>
      
      <?php
        $crearProducto=new ControladorProductos();
        $crearProducto->ctrCrearProducto();
      ?>
    </div>  
   </form>
  </div> <!-- fin del modal-content -->
 </div>
</div>    <!-- fin del modal -->


<!-- ===========================================================================================
  ===================================== MODAL EDITAR PRODUCTOS ================================
=============================================================================================== -->
 
  <div class="modal fade" id="modalEditarProducto" data-backdrop="static" data-keyboard="false" tabindex="">
  <div class="modal-dialog modal-lg">
   
   <div class="modal-content">
    <form role="form" method="POST" enctype="multipart/form-data" id="formeditprod">
      <!-- Modal Header -->
      <div class="modal-header m-0 py-2 colorbackModal">
   
        <h4 class="modal-title">Editar Producto
  			  <small><i class="fa fa-tag"></i></small>
	  		</h4>
        
            <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      

      <!-- Modal body -->
      <div class="modal-body p-1">
<!--           
        <div class="box-body">
        </div>   
-->
        <div class="card card-info">
         <div class="card-body">

        <!-- ENTRADA PARA SELECCIONAR CATEGORÍA Y UNIDAD DE MEDIDA-->
		<div class="form-row">
		 <input type="hidden" name="id_de_Producto" id="id_de_Producto" value="">
           
			<div class="form-group col-sm-4 mb-2 mt-0">
               <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-list-ol"></i></span> 
                <select class="form-control input-lg editfam"  name="editarFamilia" required title="Familia">
                  <option id="editarFamilia"></option>
                  <?php
                    $item=null;
                    $valor=null;
                    $familias=ControladorFamilias::ctrMostrarFamilias($item, $valor);
                    foreach($familias as $key=>$value){
                        echo '<option value="'.$value["id"].'">'.$value["familia"].'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>


            <div class="form-group col-sm-5 mb-2">
                   <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-th"></i></span> 
                    <select class="form-control input-lg editarCategoria" name="editarCategoria"  required title="Categoría">
                      <option id="editarCategoria"></option>
                      <?php
                        // $item=null;
                        // $valor=null;
                        // $categorias=ControladorCategorias::ctrMostrarCategorias($item, $valor);
                        // foreach($categorias as $key=>$value){
                        //     echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';
                        // }
                      ?>
                    </select>
                  </div>
                </div>     
<!--           
            <div class="form-group col-sm-5 mb-2 mt-0">
               <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-th"></i></span> 
                <select class="form-control input-lg"  name="editarCategoria">
                  <option id="editarCategoria"></option>
                </select>
              </div>
            </div>     
-->
            <div class="form-group col-sm-3 mb-2 mt-0">
               <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-tachometer"></i></span> 
                <select class="form-control input-lg"  name="editarMedida" required title="U. de Medida">
                  <option id="editarMedida"></option>
                  <?php
                    $item=null;
                    $valor=null;
                    $medidas=ControladorMedidas::ctrMostrarMedidas($item, $valor);
                    foreach($medidas as $key=>$value){
                        echo '<option value="'.$value["id"].'">'.$value["medida"].'</option>';
                    }
                  ?>
                </select>
              </div>
            </div> 
            <!-- ESTA OCULTO. -->
			<div class="form-group col-sm-3 mb-2 d-none">
            <div class="input-group">
              <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-code"></i></span>
              </div>
              <input type="text" class="form-control input-lg" title="Código Categoría" name="editarCodigo" id="editarCodigo" readonly>
			  <input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
            </div>
            </div>
            
        </div>     <!-- fin de CATEGORIA Y UNIDAD DE MEDIDA -->
                          
		 <div class="form-row"> 

			<div class="form-group col-sm-4 mb-2">
            <div class="input-group">
              <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-barcode"></i></span>
              </div>
              <input type="text" class="form-control input-lg" placeholder="Ingresar Código" name="editarCodInterno" id="editarCodInterno" required title="Código del Producto">
            </div>
              <span class="msjCodigoRepetido"></span> 
            </div>
		 
            <div class="form-group col-sm-8 mb-2">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-tag"></i></span>
                </div>
                <input type="text" class="form-control input-lg" name="editarDescripcion" id="editarDescripcion" onkeyUp="mayuscula(this);" title="Capture descripción del producto sin guiones" required>
              </div>
            </div>
        </div>
            
			
        <div class="form-row">    
            <div class="form-group col-sm-3 mb-2">
            <div class="input-group">
              <div class="input-group-prepend">
                 <span class="input-group-text"><i class="fa fa-plus-square"></i></span>
              </div>
              <input type="number" class="form-control input-lg" placeholder="Máximo" name="editarStock" id="editarStock" min="0" step="any" title="Máximo" >
            </div>
            </div>

            <div class="form-group col-sm-3 mb-2">
            <div class="input-group">
              <div class="input-group-prepend">
                 <span class="input-group-text"><i class="fa fa-minus-square"></i></span>
              </div>
              <input type="number" class="form-control input-lg" placeholder="Mínimo" name="editarMinimo" id="editarMinimo" min="0" step="any" title="Mínimo" required>
            </div>
            </div>

            <div class="form-group col-sm-3 col-xs-12 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                         <span class="input-group-text"><i class="fa fa-archive"></i></span>
                    </div>
                    <input type="number" class="form-control input-lg" placeholder="Unidad x Caja" name="editarUnidadxCaja" id="editarUnidadxCaja" min="0" step="any" tabindex="7" title="Unidad por Caja/Paquete/Bolsa/Bulto">
                </div>
            </div>

            <div class="form-group col-sm-3 col-xs-12 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                         <span class="input-group-text"><i class="fa fa-flask"></i></span>
                    </div>
                    <input type="number" class="form-control input-lg" placeholder="hectolitros" name="editarHectolitros" id="editarHectolitros" min="0" step="any" tabindex="8" title="Hectolitros">
                </div>
            </div>

        </div>

                <!--Porcentaje no se guarda en la BD -->
                <div class="form-row">
                     <div class="col-sm-2.5 col-xs-3">
                         <div class="form-group">
                            <div class="checkbox icheck">
                             <label style="font-size:.72em;">
                                 <input type="checkbox" class="minimal flat-red porcentaje">
                                 Usar porcentaje
                             </label>
                             </div>
                         </div>
                     </div>

                     <div class="col-sm-2 col-xs-3 mb-2">
                         <div class="input-group">
                            <input type="number" class="form-control nuevoPorcentaje" name="editarNuevoMargen" id="editarNuevoMargen" min="0" step="any" value="" required> <span class="input-group-text p-1"><i class="fa fa-percent"></i></span>
                         </div>
                     </div>

                     <div class="form-group col-sm-4 col-xs-12 mb-2">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text p-1"><i class="fa fa-arrow-up"></i></span>
                            </div>
                            <input type="number" class="form-control input-lg" name="editarPrecioCompra" id="editarPrecioCompra" min="0" step="any" required title="Precio de Compra">
                          </div>
                    </div>

                    <div class="form-group col-sm-4 col-xs-12">
                         <div class="input-group">
                           <div class="input-group-prepend">
                             <span class="input-group-text p-1"><i class="fa fa-arrow-down"></i></span>
                           </div>
                           <input type="number" class="form-control input-lg" name="editarPrecioVenta" id="editarPrecioVenta" min="0" step="any" required title="Precio de Venta">
                         </div>
                     </div>

		            </div>    <!-- fin del form-row-->        

                <div class="form-row">

                <div class="col-sm-2.5 col-xs-2">
                    <div class="input-group">
                      <span class="input-group-text"> <i class="fa fa-map-marker"></i>&nbsp UBICACIÓN</span>
                    </div>
                </div>

                  <div class="col-sm-3 col-xs-3">
                    <div class="input-group">
                    <span class="input-group-text">Pasillo</span>
                      <input type="text" class="form-control" name="editarPasillo" id="editarPasillo" pattern=".{3,}" title="Máximo 3 caracteres" maxlength="3" onkeyUp="mayuscula(this);" tabindex="">
                    </div>
                  </div>

                  <div class="col-sm-3 col-xs-3">
                    <div class="input-group">
                    <span class="input-group-text">Anaquel</span>
                      <input type="text" class="form-control" name="editarAnaquel" id="editarAnaquel" pattern=".{3,}" title="Máximo 3 caracteres" maxlength="3" onkeyUp="mayuscula(this);" tabindex="">
                    </div>
                  </div>

                  <div class="col-sm-3 col-xs-3 pb-2">
                    <div class="input-group">
                    <span class="input-group-text">Gaveta</span>
                      <input type="text" class="form-control" name="editarGaveta" id="editarGaveta" pattern=".{3,}" title="Máximo 3 caracteres" maxlength="3" onkeyUp="mayuscula(this);" tabindex="">
                    </div>
                  </div>

                </div>  <!--fin del form-row  -->                

                <!-- INSERTAR LEYENDA -->
                 <div class="form-row mb-1">
                     <div class="col-sm-3 col-xs-3">
                         <div class="form-group">
                            <div class="checkbox icheck">
                             <label>
                                 <input type="checkbox" class="minimal flat-red insertaLeyenda" tabindex="10">
                                 Leyenda en ticket
                             </label>
                             </div>
                         </div>
                     </div>

                     <div class="col-sm-9 col-xs-9 inputLeyenda d-none" style="padding-left:4px">
                        <div class="input-group">
                          <input type="text" class="form-control" name="editarLeyenda" id="editarLeyenda" value="" placeholder="Max. 50 Letras" maxlength="51" onkeyUp="mayuscula(this);" tabindex="11">
                        </div>
                     </div>
                 </div>

                <!-- INSERTAR CHECK PROMO -->
                <div class="form-row mb-1">
                    <div class="col-sm-2 ">
                        <div class="form-group">
                            <div class="checkbox icheck">
                             <label>
                                 <input type="checkbox" class="minimal flat-red edtpromocion" tabindex="12">
                                 Promoción
                             </label>
                             </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-2 edtoculto d-none" style="padding-left:4px">
                      <select class="form-control select3" name="editSelProdProm" id="editSelProdProm" style="width: 100%;">
                          <option selected value=""></option>
                            <?php
                        $item=null;
                        $valor=null;
                        $orden="id";
                        $estado=1;
                        $productos=ControladorProductos::ctrMostrarProductos($item, $valor,$orden, $estado);
                        foreach($productos as $key=>$value){
                          if($value["datos_promocion"]==null){	//VALIDA QUE PRODUCTO NO SEA PROMOCION
                            echo '<option value="'.$value["id"].'">'.$value["codigointerno"]." - ".$value["descripcion"].'</option>';
                          }
                        }
                        ?>		
                      </select>
                    </div>

                  <div class="col-md-1 mr-1 edtoculto d-none">
                      <input type="number" class="form-control form-control-sm mb-1 font-weight-bold inputVta" name="editqty" id="editqty" value="" placeholder="" step="any" min="0" tabindex="8" title="cantidad">
                  </div>

                  <div class="col-md-1 mr-1 edtoculto d-none">
                      <input type="number" class="form-control form-control-sm mb-1 font-weight-bold inputVta" name="editprice" id="editprice" value="" placeholder="$" step="any" min="0" title="Precio venta">
                  </div>

                <div class="col-md-1 mr-1 edtoculto d-none">
                    <button class="btn btn-primary btn-sm mb-1 " id="editarProductoProm"><i class="fa fa-plus-circle"></i> Agregar</button>
                </div>

              </div>	<!-- FIN DEL FORM-ROW DE CHECK PROMO -->

            <div class="row edtoculto d-none">
              <div class="col-12 col-sm-12 table-responsive">
              <table class="table table-bordered compact table-dark table-sm mb-0 p-0 table-hover dt-responsive" id="editdetSalidaProm" width="100%" height="8px">

                <thead class="thead-dark">
                <tr class="text-center">
                <th style="width:3rem">Acción</th>
                <th style="width:3.1rem">#</th>
                <th style="width:8.5rem">Código</th>
                <th>Producto</th>
                <th style="width:3rem">Cant</th>
                <th style="width:3rem">Precio</th>
                </tr>
                </thead>
                <tbody class="tbodypromo bg-primary">

                <div class="form-row">
                <!--AQUI SE AÑADEN LAS ENTRADAS DE LOS PRODUCTOS  -->
                </div>
              
                </tbody>
              </table>
              
              </div>  <!-- /.col -->
			      </div>  <!-- / fin del .row -->

        <div class="dropdown-divider"></div> 

            <!-- <div class="form-group">
                <label for="exampleInputFile">Subir Imagen. - Peso Máximo de la foto 2mb. </label>
                <p class="help-block">Peso máximo de la foto 2mb. - </p>
                 <div class="input-group">
                    <div class="custom-file">
                            <input type="file" class="custom-file-input nuevaImagen" id="exampleInputFile" name="editarImagen">
                            <label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
                    </div>
                </div>
                <img src="vistas/img/productos/default/default.jpg" class="img-thumbnail previsualizar" width="85px" alt="">
                <input type="hidden" name="imagenActual" id="imagenActual"> 
            </div> -->

         <div class="form-row m-0">
              <label for="inputEstatus">Estatus:</label>
              <div class="col-md-2 ml-0">
                <select class="form-control form-control-sm" name="editarEstatus" id="editarEstatus" required>
                <option value="1">Activado</option>
                <option value="0">Desactivado</option>
                </select>			  
              </div>

              <div class="col-sm-2 col-xs-2 ml-2">
                  <div class="form-group">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox" name="editarEnvase" value="1" class="minimal flat-red esenvase" tabindex="10">
                               Es Envase
                         </label>
                      </div>
                  </div>
                </div>

                <div class="col-sm-2 col-xs-2">
                  <div class="form-group">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox" name="editarServicio" value="1" class="minimal flat-red esservicio" tabindex="11">
                               Es Servicio
                         </label>
                      </div>
                  </div>
                </div>

                <div class="col-sm-2 col-xs-2">
                  <div class="form-group">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox" name="editarOtros" value="1" class="minimal flat-red esotros" tabindex="12">
                               Otros
                         </label>
                      </div>
                  </div>
                </div>

                <div class="col-sm-2 col-xs-2 ml-0 p-0">
                  <div class="form-group">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox" name="editarGranel" value="1" class="minimal flat-red esagranel" tabindex="18">
                               Vta a Granel
                         </label>
                      </div>
                  </div>
                </div>


              </div>
    
         </div>   <!--fin  -->
		 

        </div>    <!--fin de -->
	
      </div>

      <!-- Modal footer -->
      <div class="modal-footer m-0 p-0 mr-3">
        <button type="button" class="btn btn-primary btn-sm float-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-sm btn-success">Guardar Cambios</button>
      </div>
      
      <?php
        $editarProducto=new ControladorProductos();
        $editarProducto->ctrEditarProducto();
      ?>
     </form>
    </div> <!-- fin del modal-content -->
  </div>
</div> 

<?php

  $EliminarProducto = new ControladorProductos();
  $EliminarProducto -> ctrEliminarProducto();

?> 

<!-- Modal para visualizar imagen del producto -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="ModalCenterTitle"></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
		<img src="" id="imagen-modal" class="img-fluid imagen" alt="">
        <!--<img src="vistas/img/productos/default/anonymous.png" id="imagen-modal">-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script defer src="vistas/js/productos.js?v=01092020"></script>
