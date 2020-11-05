<?php
  require_once './funciones/funciones.php';

  $tabla="usuarios";
  $moduloadmin="administracion";
  $modulocat="catalogo";
  $modulorep="reportes";
  $moduloconf="configura";

  $permisosadmin = ControladorPermisos::ctrGetPermisos($tabla, $_SESSION['id'], $moduloadmin);
  $permisoscat = ControladorPermisos::ctrGetPermisos($tabla, $_SESSION['id'], $modulocat);
  $permisosrep = ControladorPermisos::ctrGetPermisos($tabla, $_SESSION['id'], $modulorep);
  $permisosconf = ControladorPermisos::ctrGetPermisos($tabla, $_SESSION['id'], $moduloconf);
  
$administracion=$ventas=$compras=$adminventas=$controlefectivo=$ajusteinv=0;
$jsonpermisos=json_decode($permisosadmin->administracion, TRUE);   //convierte string a array
if(!$jsonpermisos==NULL){
  foreach ($jsonpermisos as $key => $value) {

    if($key=="ventas"){
      $ventas=$value;
    }
    if($key=="compras"){
      $compras=$value;
    }
    if($key=="adminventas"){
      $adminventas=$value;
    }
    if($key=="controlefectivo"){
      $controlefectivo=$value;
    }
    if($key=="ajusteinv"){
      $ajusteinv=$value;
    }
  }
 }

$productos=$categorias=$familias=$medidas=$proveedores=$clientes=$almacenes=$cajaventas=$tiposmov=0;
$jsonpermisos=json_decode($permisoscat->catalogo, TRUE);   //convierte string a array
if(!$jsonpermisos==NULL){
  foreach ($jsonpermisos as $key => $value) {

    if($key=="productos"){
      $productos=$value;
    }

    if($key=="categorias"){
      $categorias=$value;
    }

    if($key=="familias"){
      $familias=$value;
    }

    if($key=="medidas"){
      $medidas=$value;
    }

    if($key=="proveedores"){
      $proveedores=$value;
    }

    if($key=="clientes"){
      $clientes=$value;
    }

    if($key=="almacenes"){
      $almacenes=$value;
    }

    if($key=="cajaventas"){
      $cajaventas=$value;
    }

    if($key=="tiposmov"){
      $tiposmov=$value;
    }
  }
 }

$rvtas=$rcompras=$rinv=$rcortes=$rkardex=$rsugerido=$rcancela=0;
$jsonpermisos=json_decode($permisosrep->reportes, TRUE);   //convierte string a array
if(!$jsonpermisos==NULL){
 foreach ($jsonpermisos as $key => $value) {

   if($key=="rvtas"){
     $rvtas=$value;
   }
   if($key=="rcompras"){
     $rcompras=$value;
   }
   if($key=="rinv"){
     $rinv=$value;
   }
   if($key=="rcortes"){
     $rcortes=$value;
   }
   if($key=="rkardex"){
     $rkardex=$value;
   }
   if($key=="rsugerido"){
    $rsugerido=$value;
  }
  if($key=="rcancela"){
    $rcancela=$value;
  }

 }
}

$usuarios=$permisos=$empresa=0;
$jsonpermisos=json_decode($permisosconf->configura, TRUE);   //convierte string a array
if(!$jsonpermisos==NULL){
  foreach ($jsonpermisos as $key => $value) {

      if($key=="usuarios"){
        $usuarios=$value;
      }
      if($key=="permisos"){
        $permisos=$value;
      }
      if($key=="empresa"){
        $empresa=$value;
      }

  }
}

?>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!--
    <a href="inicio" class="brand-link">
      <img src="vistas/img/logotipoV1.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminInv3</span>
    </a>
-->
   
     <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-2 pb-2 mb-1 d-flex">
          <div class="image">
            <!-- <img src="vistas/modulos/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image"> -->
              <?php
                if($_SESSION["foto"]!=""){
                    echo '<img src="'.$_SESSION["foto"].'" alt="Usuario" class="img-circle elevation-2 user-image" width="25px">';
                }else{
                    echo '<img src="vistas/modulos/dist/img/anonymous.png" alt="Usuario" class="user-image" width="25px">';
                }
                
              ?>		  
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $_SESSION["perfil"] ?></a>
          </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-1">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               
               
          <li class="nav-item ">  <!-- menu-open si se quiere q este abierto esta opcion -->
            <a href="tablero" class="nav-link active">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
		  
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-th"></i>
              <p>Administración<i class="fa fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">

            <?php if(getAccess($ventas, ACCESS_ACC)){ ?>
              <li class="nav-item">
                <a href="salidas" class="nav-link">
				          <i class="fa fa-truck nav-icon"></i>
                  <p>Ventas</p>
                </a>
              </li>
             <?php } ?>                 

            <?php if(getAccess($compras, ACCESS_ACC)){ ?>             
              <li class="nav-item">
                <a href="entradas" class="nav-link">
                  <i class="fa fa-shopping-cart nav-icon"></i>
                  <p>Compras</p>
                </a>
              </li>
            <?php } ?>

            <?php if(getAccess($adminventas, ACCESS_ACC)){ ?>             
              <li class="nav-item">
                <a href="adminsalidas" class="nav-link">
                  <i class="fa fa-newspaper-o nav-icon"></i>
                  <p>Administrar Ventas</p>
                </a>
              </li>
             <?php } ?>

            <?php if(getAccess($controlefectivo, ACCESS_ACC)){ ?>             
              <li class="nav-item">
                <a href="control-presupuesto" class="nav-link">
                  <i class="fa fa-money nav-icon"></i>
                  <p>Control de Efectivo</p>
                </a>
              </li>
            <?php } ?>

            <?php if(getAccess($ajusteinv, ACCESS_ACC)){ ?>
              <li class="nav-item">
                <a href="ajusteinventario" class="nav-link">
                  <i class="fa fa-exchange nav-icon"></i>
                  <p>Ajuste de Inventario</p>
                </a>
              </li>
            <?php } ?>

            </ul>

		
          </li>
            
		<li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
                Catálogos
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            
            <ul class="nav nav-treeview">

			<?php if(getAccess($productos, ACCESS_ACC)){ ?>
              <li class="nav-item">
                <a href="productos" class="nav-link">
                  <i class="fa fa-tag nav-icon"></i>
                  <p>Productos</p>
                </a>
              </li>
			<?php } ?>

          <?php if(getAccess($categorias, ACCESS_ACC)){  ?>
              <li class="nav-item">
                <a href="categorias" class="nav-link">
                  <i class="fa fa-th nav-icon"></i>
                  <p>Categorias</p>
                </a>
              </li>
          <?php } ?>

          <?php if(getAccess($familias, ACCESS_ACC)){  ?>          
              <li class="nav-item">
                <a href="familias" class="nav-link">
                  <i class="fa fa-list-ul nav-icon"></i>
                  <p>Familias</p>
                </a>
              </li>
              <?php } ?>

            <?php if(getAccess($medidas, ACCESS_ACC)){  ?>
              <li class="nav-item">
                <a href="medidas" class="nav-link">
                  <i class="fa fa-tachometer nav-icon"></i>
                  <p>U.de Med.</p>
                </a>
              </li>
              <?php } ?>

            <?php if(getAccess($proveedores, ACCESS_ACC)){  ?>              
              <li class="nav-item">
                <a href="proveedores" class="nav-link">
                  <i class="fa fa-male nav-icon"></i>
                  <p>Proveedores</p>
                </a>
              </li>
            <?php } ?>

              <?php
              if(getAccess($clientes, ACCESS_ACC)){  ?>
              <li class="nav-item">
                <a href="clientes" class="nav-link">
                  <i class="fa fa-address-book nav-icon"></i>
                  <p>Clientes</p>
                </a>
              </li>
              <?php } ?>

            <?php if(getAccess($almacenes, ACCESS_ACC)){  ?>                            
              <li class="nav-item">
                <a href="crear-almacen" class="nav-link">
                  <i class="fa fa-building-o nav-icon"></i>
                  <p>Crear Almacen</p>
                </a>
              </li>
            <?php } ?>

            <?php if(getAccess($cajaventas, ACCESS_ACC)){  ?>
              <li class="nav-item">
                <a href="cajas" class="nav-link">
                  <i class="fa fa-inbox nav-icon"></i>
                  <p>Caja de Venta</p>
                </a>
              </li>
            <?php } ?>

            <?php if(getAccess($tiposmov, ACCESS_ACC)){  ?>
              <li class="nav-item">
                <a href="tipomov" class="nav-link">
                  <i class="fa fa-cc nav-icon"></i>
                  <p>Tipos de Mov.</p>
                </a>
              </li>
            <?php } ?>

			</ul>
			</li>

			<li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-file"></i>
              <p>
                Reportes
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            
            <ul class="nav nav-treeview">

            <?php if(getAccess($rvtas, ACCESS_ACC)){  ?>
            <li class="nav-item">
                <a href="reportedeventas" class="nav-link">
                  <i class="fa fa-money nav-icon"></i>
                  <p>Rep. de Ventas</p>
                </a>
              </li>
            <?php } ?>

              <?php if(getAccess($rcompras, ACCESS_ACC)){  ?>              
              <li class="nav-item">
                <a href="adminalmacenes" class="nav-link">
                  <i class="fa fa-sign-in nav-icon"></i>
                  <p>Rep. de Compras</p>
                </a>
              </li>
              <?php } ?>

              <?php if(getAccess($rinv, ACCESS_ACC)){  ?>              
              <li class="nav-item">
                <a href="reporteinventario" class="nav-link">
                  <i class="fa fa-book nav-icon"></i>
                  <p>Rep. de Inventario</p>
                </a>
              </li>
              <?php } ?>

              <?php if(getAccess($rcortes, ACCESS_ACC)){  ?>              
              <li class="nav-item">
                <a href="cortesdeventas" class="nav-link">
                  <i class="fa fa-folder nav-icon"></i>
                  <p>Cortes de Ventas</p>
                </a>
              </li>
              <?php } ?>              

              <?php if(getAccess($rkardex, ACCESS_ACC)){  ?>              
              <li class="nav-item">
                <a href="kardex-producto" class="nav-link">
                  <i class="fa fa-history nav-icon"></i>
                  <p>kardex de Producto</p>
                </a>
              </li>
              <?php } ?>

<!--
              <li class="nav-item">
                <a href="historia-producto" class="nav-link">
                  <i class="fa fa-list-ol nav-icon"></i>
                  <p>Historial de Prod.</p>
                </a>
              </li>
-->
              <?php if(getAccess($rsugerido, ACCESS_ACC)){  ?> 
              <li class="nav-item">
                <a href="sugerido-compra" class="nav-link">
                  <i class="fa fa fa-bars nav-icon"></i>
                  <p>Sugerido de Compra</p>
                </a>
              </li>
              <?php } ?>              

              <?php if(getAccess($rcancela, ACCESS_ACC)){  ?>              
              <li class="nav-item">
                <a href="reportecancelados" class="nav-link">
                  <i class="fa fa-eraser nav-icon"></i>
                  <p>Rep. de Cancelaciones</p>
                </a>
              </li>
              <?php } ?>              

			</ul>
			</li>

			<li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                Configuración
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            
        <ul class="nav nav-treeview">
			  
          <?php if(getAccess($usuarios, ACCESS_ACC)){?> 
            <li class="nav-item">
              <a href="usuarios" class="nav-link">
                <i class="nav-icon fa fa-users"></i>
                <p>
                  Usuarios
                </p>
              </a>
            </li>
      		<?php } ?>

          <?php if(getAccess($permisos, ACCESS_ACC)){?> 
            <li class="nav-item">
              <a href="permisos" class="nav-link">
                <i class="nav-icon fa fa-id-card-o"></i>
                <p>
                  Permisos
                </p>
              </a>
            </li>
      		<?php } ?>

          <?php if(getAccess($empresa, ACCESS_ACC)){?>           
            <li class="nav-item">
              <a href="empresa" class="nav-link">
                <i class="nav-icon fa fa-building"></i>
                <p>
                  Empresa
                </p>
              </a>
            </li>
         <?php } ?>
          
			  </ul>
			</li>      
         
<!--
      <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-database"></i>
              <p>
                Respaldos
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            
        <ul class="nav nav-treeview">
     
          <li class="nav-item">
            <a href="respaldo" class="nav-link">
              <i class="nav-icon fa fa-hdd-o"></i>
              <p>Crear Respaldo</p>
            </a>
          </li>

          <li class="nav-item">
                <a href="gestionrespaldos" class="nav-link">
                  <i class="nav-icon fa fa-server"></i>
                  <p>Gestión Respaldos</p>
                </a>
              </li>

          </ul>
			</li>      
-->
    </ul>
      </nav>
      <!-- /.sidebar-menu -->
      
    </div>
    <!-- /.sidebar -->
  </aside>