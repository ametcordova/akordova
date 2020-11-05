<?php
//Activamos el almacenamiento en el buffer
ob_start();
$tabla="usuarios";
$module="rcompras";
$campo="reportes";
$acceso=accesomodulo($tabla, $_SESSION['id'], $module, $campo);

?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header pt-2 pb-0 m-1">
      <div class="container-fluid">
	  
        <div class="row">
          <div class="col-sm-3">
            <h4><small><i class="fa fa-money" aria-hidden="true"></i> Reporte de Compras</small></h4>
          </div>

          <div class="col-sm-4">

          <button class="btn btn-danger btn-sm" id="btnregresar" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button>

          <button class="btn btn-primary btn-sm" id="" onclick="location.reload()" type="button" title="Recargar página"><i class="fa fa-refresh"></i></button>

          </div>

          <div class="col-sm-5">
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
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
              <i class="fa fa-minus"></i></button>
			<button type="button" class="btn btn-tool" onclick="regresar()" title="a Inicio">
              <i class="fa fa-times"></i></button>			  
          </div>
           
          <div class="row">
           
            <div class="form-group col-md-1.8 mr-1">
                <select id="almEntrada" class="form-control form-control-sm" name="almEntrada" tabindex="1" required>
				<option value="0" selected>Almacen</option>
                 <?php
                   $item=null;
                    $valor=null;
                    $almacenes=ControladorAlmacenes::ctrMostrarAlmacenes($item, $valor);
                    foreach($almacenes as $key=>$value){
                      if($value["id"]=="1"){
                        echo '<option selected value="'.$value["id"].'">'.$value["nombre"].'</option>';
                      }else{
                        echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                      }

                    }                    
                  ?>								
				 </select>
            </div>
<!--
    <select multiple id="e1" style="width:300px">
        <option value="AL">Alabama</option>
        <option value="Am">Amalapuram</option>
        <option value="An">Anakapalli</option>
        <option value="Ak">Akkayapalem</option>
        <option value="WY">Wyoming</option>
    </select>

    <input type="checkbox" id="checkbox23" >Select All
-->    

            <div class="form-group col-md-2">
                <select multiple="multiple[]" class="form-control form-control-sm" id="famDeVentas" name="famDeVentas" tabindex="2">

                 <?php
                   $item=null;
                    $valor=null;
                    $familiaInv=ControladorFamilias::ctrMostrarFamilias($item, $valor);
                    foreach($familiaInv as $key=>$value){
                        echo '<option onlyslave="True" value="'.$value["id"].'">'.$value["familia"].'</option>';
                    }                    
                  ?>								
				 </select>
            </div>
			
            <div class="col- mr-2 form-check">
              <input class="form-check-input checkbox-inline" type="checkbox" value="1" name="SelectAll" id="SelectAll">
              <label class="form-check-label" for="all">
               Todos
              </label>
            </div>	



            <div class="form-group col-md-1.5">
                <select class="form-control form-control-sm" id="catDeVentas" name="catDeVentas" tabindex="3">
				<option value=0 selected>Categoría</option>
                 <?php
                   $item=null;
                    $valor=null;
                    $categoriaInv=ControladorCategorias::ctrMostrarCategorias($item, $valor);
                    foreach($categoriaInv as $key=>$value){
                        echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';
                    }                    
                  ?>								
				 </select>
            </div>
                        
            <div class="form-group col-md-3 " id="agregarProd">        <!--tmb invisible -->
                  <select class="form-control form-control-sm select4" name="selectProductoRep[]" multiple="multiple[]" id="selectProductoRep" style="width: 100%;" tabindex="5">
          					<?php
                        $item=null;
                        $valor=null;
                        $orden="id";
                        $estado=1;
                        $productos=ControladorProductos::ctrMostrarProductos($item, $valor,$orden, $estado);
                        foreach($productos as $key=>$value){
                          if(is_null($value["datos_promocion"])){	//VALIDA QUE PRODUCTO NO SEA PROMOCION
                            echo '<option value="'.$value["id"].'">'.$value["codigointerno"]." - ".$value["descripcion"].'</option>';
                          }
                        }
                      ?>		
                  </select>
            </div>            

                <!-- Date range -->
            <div class="form-group col-md-2">
              <div class="input-group input-group-sm">
                <button type="button" class="btn btn-default btn-sm float-right" id="daterange-btn-compras">
                 <span><i class="fa fa-calendar"></i> Rango de fecha</span><i class="fa fa-caret-down"></i> 
                </button>
              </div>
            </div>
                <!-- /.form group -->
            
          <?php if(getAccess($acceso, ACCESS_VIEW)){?>
	        <div class="form-group col-md-.5 ml-1">
              <button class="btn btn-success btn-sm" onclick="listarEntrada()" >
               <i class="fa fa-eye"></i> Ver
               </button>
            </div>
          <?php } ?> 

          <?php if(getAccess($acceso, ACCESS_PRINTER)){?>                                    
          <div class="form-group col-md-1 m-0">
            <button class="btn btn-primary btn-sm btnImprimirRepo" title="Reporte en PDF"><i class="fa fa-print"></i> Reporte</button>
          </div>  
          <?php } ?>
          <span class="clearfix"></span>
            <div class="col-md-3 alert-danger rounded d-none h-25 text-center"  id="messagerror">
						<!-- PARA MENSAJES DE ADVERTENCIA -->
            </div>            
            
               
        </div>
        <div class="card-body">

	<table id="tablalistado" class="table table-bordered compact striped hover dt-responsive" width="100%">
               <thead class="thead-dark">
			   
                 <th style="width:10px;">#</th>
                 <th style="width:10px;">id_prov</th>
                 <th style="width:390px;">Proveedor</th>
                 <th style="width:110px;"># Docto</th>
                 <th style="width:130px;">F. Entrada</th>
                 <th style="width:70px;">Cant.</th>
                 <th style="width:130px;">Almacen</th>
                 <th style="width:80px;">Acción</th>

            </thead>
            <tbody>                            
            </tbody>
					  <tfoot class="thead-dark">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                      </tfoot>
            
        </table>    
		
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
  
  <!-- /.content-wrapper 
SELECT  hist.id_proveedor, prov.nombre, hist.numerodocto, hist.fechaentrada,sum(cantidad) as entro, alm.nombre as almacen FROM hist_entrada hist inner join proveedores prov ON hist.id_proveedor=prov.id inner join almacenes alm ON hist.id_almacen=alm.id GROUP by hist.numerodocto

SELECT `numerodocto`,`fechaentrada`, sum(`cantidad`),`id_proveedor`,prov.nombre,`id_almacen`,alm.nombre as almacen FROM hist_entrada 
INNER JOIN proveedores prov ON id_proveedor=prov.id
INNER JOIN almacenes alm ON id_almacen=alm.id
GROUP by `numerodocto`,`fechaentrada`,`id_almacen`,`id_proveedor`
  -->
<?php 
ob_end_flush();
?>
<script defer src="vistas/js/adminalmacenes.js"></script>  