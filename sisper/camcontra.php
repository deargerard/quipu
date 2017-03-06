<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SISPER | Ingresando...</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bootstrap/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="dist/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- Favicon -->
  <link rel='shortcut icon' type='image/x-icon' href='m_images/favicon.png' />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="login-box-body">
    <h4 class="login-box-msg">CAMBIAR CONTRASEÑA</h4>
    <p class="text-justify">Por motivos de seguridad, se recomienda cambiar la contraseña inicial y luego cada 3 meses.</p>
    <p class="text-justify">Dicha contraseña debe contener como mínimo 6 caracteres, pudiendo ser estos, alfanuméricos y especiales.</p>
    <form id="f_camcontra" name="f_camcontra" action="" method="post">
      <div class="form-group has-feedback valida">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <input name="pas1" id="pas1" type="password" class="form-control" placeholder="Nueva Contraseña">
      </div>
      <div class="form-group has-feedback valida">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <input name="pas2" id="pas2" type="password" class="form-control" placeholder="Repetir Nueva Contraseña">
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button id="b_camcontra" type="submit" class="btn btn-danger btn-block btn-flat">Cambiar contraseña</button><br>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- Jquery Validation -->
<script src="m_inclusiones/js/jquery.validate.js"></script>
<script src="m_inclusiones/js/messages_es_PE.js"></script>
<script src="m_inclusiones/js/funciones.js"></script>
<script>
$(document).ready(function(){
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
});
</script>
</body>
</html>
<?php
}else{
  header('Location: index.php');
}
?>
