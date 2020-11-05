<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header p-1 m-0">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1><small>Modulo de Respaldo de Base de Datos</small></h1>
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
      <div class="card">
        <div class="card-header">

	 <button class="btn btn-danger btn-sm" id="btnregresar" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button>          

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" onclick="regresar()" title="Inicio">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="card-body text-center">
          <form role="form" method="POST" action="">
			<div class="alert alert-success" role="alert">
			  <h4 class="alert-heading">RESPALDO!</h4>
			  <p>Para realizar el respaldo de la Base de Datos del sistema, pulse la imagen que aparece abajo de la flecha</p>
			  <hr>
			  <p class="mb-0"><i class="fa fa-arrow-circle-down fa-4x" aria-hidden="true"></i></p>
			</div>
		  <button type="submit" name="submit" class=" btn rounded img-fluid"><img src="vistas/img/img-backup.png" style="width:50%" alt="respaldo" title="Click para generar Respaldo"/></button>
          </form>
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
  <!-- /.content-wrapper  -->
       <?php
        $crearRespaldo=new ControladorRespaldo();
        $crearRespaldo->ctrCrearRespaldo();
      ?>               
