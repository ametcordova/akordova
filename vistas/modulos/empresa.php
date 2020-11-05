<?php
if($_SESSION["perfil"] == "Administrador" ){
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header m-1 p-1">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6 ">
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
		 
          <h3 class="card-title">Datos de la Empresa:&nbsp;
		   <button class="btn btn-danger btn-sm" id="btnregresar" onclick="regresar()" type="button"><i class="fa fa-arrow-circle-left"></i> Regresar</button> 
		  </h3>

          <div class="card-tools">
		  
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-tool" onclick="regresar()" title="a Inicio">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
		<form role="form" id="formularioAgregarEmpresa">

		  <div class="form-row">
		   <div class="form-group col-md-6">
			<label for="inputAddress">Razón Social de la Empresa <span class="text-danger">*</span> </label>
			<input type="text" class="form-control" name="razonsocial" id="razonsocial" placeholder="" value="" title="Nombre de su empresa" autofocus required>
			<input type="hidden"  name="idDeUsuario" value="<?php echo $_SESSION['id'];?>">
			<input type="hidden"  name="esnuevo" id="esnuevo" value="0">
		   </div>				
			<div class="form-group col-md-2">
			  <label for="inputZip">Rfc <span class="text-danger">*</span></label>
			  <input type="text" class="form-control" name="rfc" id="rfc" value="" required>
			</div>			
			<div class="form-group col-md-4">
			  <label for="inputZip">Slogan</label>
			  <input type="text" class="form-control" name="slogan" id="slogan" value="">
			</div>			
		  </div>

		  <div class="form-row">
			<div class="form-group col-md-5">
			  <label for="inputCity">Dirección <span class="text-danger">*</span></label>
			  <input type="text" class="form-control" name="direccion" id="direccion" value="" required>
			</div>
			<div class="form-group col-md-2">
			  <label for="inputCity">Colonia <span class="text-danger">*</span></label>
			  <input type="text" class="form-control" name="colonia" id="colonia" value="" required>
			</div>

			<div class="form-group col-md-1">
			  <label for="inputZip">C.P.</label>
			  <input type="number" class="form-control" name="codpostal" id="codpostal" value="">
			</div>
			<div class="form-group col-md-2">
			  <label for="inputState">Ciudad <span class="text-danger">*</span></label>
			   <input type="text" class="form-control" name="ciudad" id="ciudad" value="" required>
			</div>
			<div class="form-group col-md-2">
			  <label for="inputCity">Estado <span class="text-danger">*</span></label>
			  <input type="text" class="form-control" name="estado" id="estado" value="" required>
			</div>
		  </div>

		 <div class="form-row">
			<div class="form-group col-md-2">
			  <label for="inputZip">Teléfono Empresa <span class="text-danger">*</span></label>
			  <input type="text" class="form-control" name="telempresa" id="telempresa" value="" required>
			</div>
			<div class="form-group col-md-3">
			  <label for="inputZip">Email Empresa</label>
			  <input type="email" class="form-control" name="mailempresa"  id="mailempresa" value="">
			</div>
			<div class="form-group col-md-3">
			  <label for="inputCity">Contacto</label>
			  <input type="text" class="form-control" name="contacto"  id="contacto" value="">
			</div>
			<div class="form-group col-md-2">
			  <label for="inputZip">Teléfono Contacto</label>
			  <input type="text" class="form-control" name="telcontacto"  id="telcontacto" value="">
			</div>
			<div class="form-group col-md-2">
			  <label for="inputZip">Email Contacto</label>
			  <input type="email" class="form-control" name="mailcontacto"  id="mailcontacto" value="">
			</div>
		  </div>

		  <div class="form-row">
			<div class="form-group col-md-6">
			  <label for="inputZip">Leyenda Ticket</label>
			  <input type="text" class="form-control" name="msjpieticket" id="msjpieticket" value="">
			</div>
			<div class="form-group col-md-6">
			  <label for="printer">Mensaje pie de Ticket:</label>
			  <input type="text" class="form-control" name="mensajeticket"  id="mensajeticket" value="">
			</div>
		  </div>

		  <div class="dropdown-divider"></div> 
		  <p class="text-center bg-warning">Datos modificables solo por soporte técnico.</p>

		 <div class="form-row"> 
			<div class="form-group col-md">
				<label for="exampleInputFile">Subir Imagen</label>
				<div class="input-group">
					<div class="custom-file">
							<input type="file" class="custom-file-input" id="exampleInputFile">
							<label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
					</div>
					<div class="input-group-append">
							<span class="input-group-text" id="">Subir</span>
					</div>
				</div>
			</div>	

			<div class="form-group col-md-1">
			  <label for="inputZip">% de IVA <span class="text-danger">*</span></label>
			  <input type="number" class="form-control" name="ivaempresa"  id="ivaempresa" value="" required>
			</div>

			<div class="form-group col-md-2">
			  <label for="printer">Mod. Impresora <span class="text-danger">*</span></label>
			  <input type="text" class="form-control" name="impresora"  id="impresora" value="" required title="Como aparece en su configuración de impresora" readonly>
			</div>

			<div class="form-group col-md-2">
			  <label for="printer">Ruta para Respaldo: <span class="text-danger">*</span></label>
			  <input type="text" class="form-control" name="rutarespaldo"  id="rutarespaldo" value="" title="Ejem. D:/respaldo" readonly>
			</div>

			<div class="form-group col-md-2">
			  <label for="database">Base de datos: <span class="text-danger"></span></label>
			  <input type="text" class="form-control" name="namedatabase"  id="namedatabase" value="" title="Max. 12 letras" readonly>
			</div>

			<div class="form-group col-md-1">
			  <label for="database">Terminal: <span class="text-danger"></span></label>
			  <input type="text" class="form-control" name="idterminal"  id="idterminal" value="" title="ID Terminal" readonly>
			</div>

		 </div>

		  <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Guardar</button>

		</form>
		<?php
			//$datosEmpresa=new ControladorEmpresa();
			//$datosEmpresa->ctrCrearEmpresa();
	    ?>

		  
        </div>

        <!-- /.card-body 
        <div class="card-footer">
          Footer	
        </div>
        <!-- fin de .card-footer -->
      </div>
	  
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <script defer src="vistas/js/empresa.js"></script>
  <!-- /.content-wrapper -->
<?php
}else{
	include "inicio.php";
}	