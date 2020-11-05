<div id="fondo_login"></div>
<div class="login-box">
  <div class="login-logo">
    
	 <!-- <img src="config/logo_single.png" class="img-responsive" style="padding:20px 100px 0px 0px;" width="60%" alt="Logotipo Modelo">-->
    <h4 style="color:white;">Sistema Control de Inventario</h4>
  </div>
<?php
  $terminal =defined('TERMINAL')?TERMINAL:'SIN-ID';
  
  if(isset($_COOKIE['logusuario'])) { 
	  $user = $_COOKIE["logusuario"]; 
} else { 
  	$user="";
}
?>
  <!-- .login-logo -->
  <div class="card mt-4">
    <div class="card-body login-card-body">
    <div class="text-center"><a href="#" class="text-center" style="color:orange; font-weight: 400;"><b>@</b><img src="config/logo_single.ico" width="7%">Kórdova</a></div>
      <p class="login-box-msg m-0 p-1 h5">Tus credenciales para Iniciar sesión</p>
      <form method="post">

        <div class="form-group has-feedback">
    		  <span class="fa fa-bullseye form-control-feedback"></span>
          <input type="text" class="form-control" placeholder="ID" name="ingidentidad" value=<?= $terminal ?> readonly title="Número de PV">
        </div>

        <div class="form-group has-feedback">
    		  <span class="fa fa-user form-control-feedback"></span>
          <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" value="<?php echo $user?>" autofocus required title="Nombre de usuario registrado">
        </div>

        <div class="form-group has-feedback">
		      <span class="fa fa-key form-control-feedback"></span>
          <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" value="" title="Su contraseña" required>
        </div>
		<hr>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
                <input type="checkbox" name="recordarme" <?php if(isset($_COOKIE["logusuario"])) {?> checked <?php } ?> />
                <label> Recordarme  </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
        
        <?php
          $login=new controladorUsuarios();
          $login->ctrIngresoUsuario();
        ?>
        
      </form>

<!-- 
      <p class="mb-1">
        <a href="#">He olvidado mi password</a>
      </p>
      <p class="mb-0 text-center">
        <a href="#" class="text-center">Registrarse</a>
      </p>
-->      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

 

<!-- jQuery -->
<script src="extensiones/plugins/jquery/jquery.min.js"></script>
<script src="extensiones/jquery-ui-1.12.1/jquery-ui.js"></script>
<script defer src="vistas/js/usuario.js"></script>

<!-- iCheck -->
<script src="extensiones/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })
  });
</script>