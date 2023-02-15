<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SISPER | Login</title>
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
    <div class="login-logo">
      <a href="index.php"> <img src="m_images/img_login.png" class="img-responsive center-block" alt="Logo"></a>
    </div>
    <p class="login-box-msg">Inicia sesión para acceder.</p>
    <form id="f_login" name="f_login" action="" method="post">
      <div class="form-group has-feedback valida">
        <span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
        <input name="doc" type="text" class="form-control" placeholder="Documento de identidad">
      </div>
      <div class="form-group has-feedback valida">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <input name="pas" type="password" class="form-control" placeholder="Contraseña">
      </div>
      <div class="row">
        <!--<div class="col-xs-6">
          <a href="#">Olvide mi contraseña</a>
        </div>-->
        <!-- /.col -->
        <div class="col-xs-12">
          <button id="flogin" type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-sign-in"></i> Ingresar</button><br>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <div id="a_login" role="alert"></div>
    <div class="row">
      <div class="col-xs-12">
        <button type="button" class="btn btn-default btn-block btn-flat" data-toggle="modal" data-target="#m_ocon"><i class="fa fa-frown-o"></i> He olvidado mi contraseña</button><br>
      </div>
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<div class="modal fade" id="m_ocon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-muted" id="myModalLabel"><i class="glyphicon glyphicon-info-sign text-yellow"></i> Recuperar contraseña</h4>
      </div>
      <form id="f_ocon">
      <div class="modal-body text-center" id="r_ocon">
          <p class="text-md"> Si desea recuperar su contraseña, solicite el cambio mediante un correo a: <b class="text-orange">informatica.cajamarcadj@mpfn.gob.pe</b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <!-- <button type="submit" id="b_gocon" class="btn btn-primary">Recuperar</button> -->
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
