<!-- Navbar -->
<?php
require "controladores/reporteinventario.controlador.php";
require "modelos/reporteinventario.modelo.php";

$fechadeHoy = date("d/m/Y");
$item = null;
$valor = null;
$tabla = "principal";
$bajostock = ControladorInventario::ctrProductosBajoStock($tabla, $item, $valor);
$totBajoStock = count($bajostock);
?>
<!-- <nav class="main-header navbar navbar-expand border-bottom navbar-dark bg-success"> PARA CUSTOMIZAR-->
<nav class="main-header navbar navbar-expand border-bottom navbar-light bg-white">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="inicio" class="nav-link font-weight-bold">
        <button type="button" class="btn btn-sm btn-primary">Inicio</button>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="salidas" class="nav-link font-weight-bold text-success" id="botonVta">
        <button type="button" class="btn btn-sm btn-success">Ventas <span class="badge badge-light">Ctrl+F6</span></button>
      </a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="control-presupuesto" class="nav-link font-weight-bold" id="">
        <button type="button" class="btn btn-sm btn-info">Ctrl de efectivo</button>
      </a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <?php
      if (isset($_SESSION['caja'])) { ?>
        <a href="#cajaAbierta" data-toggle="modal" id="modalcajaventa" class="nav-link font-weight-bold">
          <button type="button" class="btn btn-sm btn-warning"><?= $_SESSION['caja']; ?></button>
        </a>
        <input type="hidden" id="numcaja" value="<?= $_SESSION['idcaja']; ?>">
      <?php } else { ?>
        <a href="#" class="nav-link font-weight-bold text-danger" title="Sin caja aperturada"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
        </a>
      <?php } ?>
    </li>

  </ul>

  <!-- SEARCH FORM -->
  <!--    
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
-->
  <!-- HORA Y FECHA -->
  <div class="ml-5 mr-5 d-none d-sm-inline-block d-md-inline-block text-center" style="width:30rem;">
    <p class="h6" id="liveclock" style="margin-top:5px;color:violet;"></p>
  </div>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    <!-- User Account: style can be found in dropdown.less -->
    <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="<?php echo $_SESSION['foto'] ?>" class="user-image rounded-circle efecto" alt="Image" width="25px">
        <span class="hidden-xs" id="usuar"><?php echo $_SESSION['usuario']; ?></span>
      </a>

      <ul class="dropdown-menu" style="background-color:orange;">
        <!-- User image -->
        <li class="user-header text-center">
          <img src="<?php echo $_SESSION['foto'] ?>" class="user-image img-size-50 img-circle rounded" alt="User Image">
        </li>
        <li class="user-body text-center">
          <span class="hidden-xs" id="usuar"><?php echo $_SESSION['nombre']; ?></span>
          <div class="dropdown-divider"></div>
          Software de Inventario
          <small>amet.cordova@gmail.com</small>
        </li>
        <div class="dropdown-divider"></div>
        <!-- Menu Footer-->
        <li class="user-footer">
          <div class="text-center">
            <a href="salir" class="btn btn-success btn-flat" id="outsystem">Salir &nbsp&nbsp<i class="fa fa-sign-out"></i></a> <!--	cerrar la aplicacion  -->
          </div>
          <!-- <br>
                    <div class="text-center">
                      <a href="closebackup" class="btn btn-info btn-flat">Salir y Resp.&nbsp&nbsp<i class="fa fa-sign-out"></i></a>		
                    </div> -->
        </li>

      </ul>

    </li>

    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">

      <a class="nav-link" href="reporteinventario" title="Prod. bajo stock">
        <i class="fa fa-level-down"></i>&nbsp&nbsp
        <span class="badge badge-danger navbar-badge"><?php echo $totBajoStock ?></span>
      </a>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" title="SideBar"><i class="fa fa-th-large"></i></a>
    </li>

  </ul>
</nav> <!-- /.navbar -->
<!-- ========================================================================================== -->
<!--         MODAL PARA VER IMPORTES DE CAJA DE VENTA                                           -->
<!-- ========================================================================================== -->
<div class="modal fade" id="cajaAbierta" role="dialog">

  <!-- <div class="modal-dialog modal-lg"> -->
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header colorbackModal py-2 m-0">
        <h4><?= $fechadeHoy ?></h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">

        <div class="col-md-12 mr-2">
          <!-- Widget: user widget style 2 -->
          <div class="card card-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-warning mb-2 p-2">
              <div class="widget-user-image">
                <img class="img-circle elevation-4" src="<?php echo $_SESSION['foto'] ?>" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <div class="row">
                <div class="col-md-9">
                  <h3 class="widget-user-username m-0"><?php echo $_SESSION['nombre']; ?></h3>
                  <h5 class="widget-user-desc m-0 "><?php echo $_SESSION['perfil']; ?></h5>
                </div>
                <div class="col-md-3">
                  <h5 class="text-center">Caja No. <?= $_SESSION['caja']; ?></h5>
                </div>
              </div>
            </div>

            <div class="card-footer p-0" id="databox">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a href="salidas" class="nav-link py-0 px-3 pt-1">
                    <h5>+ Ventas <span class="float-right badge bg-primary idforsuma" data-ventas="" id="totaldeventas"></span></h5>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="reportedeventas" class="nav-link text-info  py-0 px-3 pt-1">
                    <h5>+ Envases <span class="float-right badge bg-info idforsuma" data-envases="" id="totalenvases"></span></h5>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="reportedeventas" class="nav-link text-warning  py-0 px-3 pt-1">
                    <h5>+ Servicios <span class="float-right badge bg-warning idforsuma" data-servicios="" id="totalservicios"></span></h5>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="reportedeventas" class="nav-link py-0 px-3 pt-1" style="color:coral;">
                    <h5>+ Otros <span class="float-right badge text-white idforsuma" style="background-color:coral;" data-otros="" id="totalotros"></span></h5>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="reportedeventas" class="nav-link text-body  py-0 px-3 pt-1">
                    <h5>* Ventas a Crédito <span class="float-right badge bg-secondary text-white" data-creditos="" id="totalacredito"></span></h5>
                  </a>
                </li>

                <?php
                if (isset($_SESSION["abierta"])) { ?>
                  <li class="nav-item ">
                    <a href="control-presupuesto" class="nav-link text-success  py-0 px-3 pt-1">
                      <h5>+ Ingreso <span class="float-right badge bg-success idforsuma" data-ingreso="" id="totalingreso"></span></h5>
                    </a>
                  </li>
                  <li class="nav-item ">
                    <a href="control-presupuesto" class="nav-link text-danger  py-0 px-3 pt-1">
                      <h5>- Egreso <span class="float-right badge bg-danger idforsuma" data-egreso="" id="totalegreso"></span></h5>
                    </a>
                  </li>
                <?php } ?>

                <li class="nav-item text-dark">
                  <a href="#" class="nav-link text-dark  py-0 px-3 pt-1">
                    <h4>Total Efectivo: <span class="float-right badge bg-dark" id="totalefectivo"></span></h4>
                  </a>
                </li>

                <?php
                if (isset($_SESSION["abierta"])) { ?>
                  <li class="nav-item">
                    <a href="#" class="nav-link py-0 px-3 pt-1">
                      <h5 style="color:#DF01A5;"><i class="fa fa-cube" aria-hidden="true"></i> Caja Chica:<span class="float-right badge" style="color: white; background-color:#DF01A5;" id="totalcajachica"></span></h5>
                    </a>
                  </li>
                <?php } ?>

              </ul>
            </div> <!-- //fin del card-footer -->
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->

      </div>

      <div class="modal-footer py-2 m-0">
        <?php
        if (isset($_SESSION["abierta"])) { ?>
          <button type="button" class="btn btn-dark mr-auto" id="cerrarcaja">Cerrar Caja</button> <!-- en cajas.js-->

          <a href="control-presupuesto">
            <button type="button" class="btn btn-success mr-auto" id="ingreso">Ingreso</button>
          </a>
          <a href="control-presupuesto">
            <button type="button" class="btn btn-danger mr-auto" id="egreso">Egreso</button>
          </a>

          <button type="button" class="btn btn-primary mr-auto" id="imprimirCorteX" title="Imprimir en Ticket">Imprimir</button>

        <?php } else { ?>
          <button type="button" class="btn btn-dark mr-auto" id="abrircaja">Abrir Caja</button>
        <?php } ?>

        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-reply"></i>Salir</button>
      </div>
    </div>
  </div>
</div>
<!---**************** FIN MODAL DE CAJA **********  Corte de Caja X y Z sist de Punto de venta -->

<!-- /* ======================= AVISO ANTES DE LAS 12:00 ========================== */ -->
<div id="aviso24" class="modal fade" tabindex="-1" data-focus-on="input:first" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning py-1 m-0">
        <h3>AVISO!!</h3>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body text-center">
        <p>POR FAVOR ANTES DE LAS 12:00 am</p>
        <p>REALICE CIERRE DE CAJA.</p>
        <p>De lo contrario sus ventas entraran para</p>
        <p>el siguiente día y no podrá hacer cierre de caja.</p>
      </div>

      <div class="modal-footer py-2 m-0">
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-warning">Entendido</button>
      </div>

    </div>
  </div>
</div>
<!-- ===============================  =========================================================== -->
<!--<script defer src="extensiones/js-cookie-master/js.cookie.min.js?v=250520"></script>
 <script defer src="vistas/js/cajas.js?v=250520"></script>
<script defer src="vistas/js/header.js?v=250520"></script> -->