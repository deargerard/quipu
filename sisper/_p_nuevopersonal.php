<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SISPER</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <link rel="stylesheet" href="plugins/jQueryUI/jquery-ui.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="dboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SIS</b>PER</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navegación</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
          
          <!-- Tasks: style can be found in dropdown.less -->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="m_fotos/<?php echo $_SESSION['docide'] ?>.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['nomusu'] ?> <i class="fa fa-angle-down"></i></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="m_fotos/<?php echo $_SESSION['docide'] ?>.jpg" class="img-circle" alt="User Image">
                <?php
                  $idusu=$_SESSION['identi'];
                  $ccar=mysqli_query($cone,"SELECT Denominacion FROM empleadocargo AS ec INNER JOIN cargo AS c ON ec.idEmpleado=c.idEmpleado WHERE idEmpleado=$idusu");
                  if($rcar=mysqli_fetch_assoc($ccar))
                    $car=$rcar["Denominacion"];
                  else
                    $car="Sin cargo";
                ?>
                <p>
                  <?php echo $_SESSION['nomusu'] ?>
                  <small><?php echo $car ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Contraseña</a>
                </div>
                <div class="pull-right">
                  <a href="salir.php" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="m_fotos/<?php echo $_SESSION['docide'] ?>.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p class="salto"><?php echo $_SESSION['nomusu'] ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form" id="fb_persona">
        <div class="input-group">
          <input type="text" name="ib_persona" class="form-control" id="i_bpersona" placeholder="Nombre">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat" data-toggle="modal" data-target="#mb_persona"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MENU</li>
        <li class="active">
          <a href="dboard.php">
            <i class="fa fa-home"></i><span>Inicio</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text"></i>
            <span>Mis Datos</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-file-text-o"></i> Datos Personales</a></li>
            <li><a href="#"><i class="fa fa-clock-o"></i> Asistencia</a></li>
            <li><a href="#"><i class="fa fa-check-square-o"></i> Permisos</a></li>
            <li><a href="#"><i class="fa fa-calendar"></i> Licencias</a></li>
            <li><a href="#"><i class="fa fa-plane"></i> Vacaciones</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Personal</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="p_personal"><a href="#"><i class="fa fa-user"></i> Personal</a></li>
            <li id="p_permisos"><a href="#"><i class="fa fa-check-square-o"></i> Permisos</a></li>
            <li id="p_licencias"><a href="#"><i class="fa fa-calendar"></i> Licencias</a></li>
            <li id="p_vacaciones"><a href="#"><i class="fa fa-plane"></i> Vacaciones</a></li>
            <li id="p_declaraciones"><a href="#"><i class="fa fa-pencil-square-o"></i> Declaración Jurada</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-newspaper-o"></i>
            <span>Reportes</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-user"></i>Personal</a></li>
            <li><a href="#"><i class="fa fa-clock-o"></i> Asistencia</a></li>
            <li><a href="#"><i class="fa fa-check-square-o"></i>Permisos</a></li>
            <li><a href="#"><i class="fa fa-calendar"></i>Licencias</a></li>
            <li><a href="#"><i class="fa fa-plane"></i>Vacaciones</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="ConPage">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Personal
        <small>Nuevo</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-users"></i> Nuevo</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">NUEVO</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <form action="" class="form-horizontal" id="f_npersonal">
                <div class="box-body">
                  <fieldset class="fieldset">
                    <legend class="text-primary"><i class="fa fa-angle-double-right"></i> Datos Personales</legend>
                  <div class="form-group">
                    <label for="apepat" class="col-sm-3 control-label">Apellido Paterno</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="apepat" name="apepat" class="form-control" placeholder="Apellido Paterno">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="apemat" class="col-sm-3 control-label">Apellido Materno</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="apemat" name="apemat" class="form-control" placeholder="Apellido Materno">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="nom" class="col-sm-3 control-label">Nombres</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="nom" name="nom" class="form-control" placeholder="Nombres">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Sexo</label>
                    <div class="col-sm-3 valida">
                      <div class="radio">
                        <label for="sexmas"><input type="radio" id="sexmas" name="sex" value="M" checked="checked">Masculino</label>
                      </div>
                    </div>
                    <div class="col-sm-3 valida">
                      <div class="radio">
                        <label for="sexfem"><input type="radio" id="sexfem" name="sex" value="F">Femenino</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecnac" class="col-sm-3 control-label">Fecha de Nacimiento</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecnac" name="fecnac" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="nac" class="col-sm-3 control-label">Nacionalidad</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="nac" name="nac" class="form-control" placeholder="Nacionalidad">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="depnac" class="col-sm-3 control-label">Lugar de Nacimiento</label>
                    <div class="col-sm-3 valida">
                      <select name="depnac" id="depnac" class="form-control" onChange="cprovincia(this.value)">
                        <option value="">DEPARTAMENTO</option>
                        <?php echo listadep($cone) ?>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="pronac" id="pronac" class="form-control" onChange="cdistrito(this.value)">
                        <option value="">PROVINCIA</option>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="disnac" id="disnac" class="form-control">
                        <option value="">DISTRITO</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="estciv" class="col-sm-3 control-label">Estado Civil</label>
                    <div class="col-sm-3 valida">
                      <select name="estciv" id="estciv" class="form-control">
                        <option value="">ESTADO CIVIL</option>
                        <?php
                            $q1=mysqli_query($cone,"select * from estadocivil");
                            while($fila=mysqli_fetch_assoc($q1)){
                                echo '<option value="'.$fila["idEstadoCivil"].'">'.$fila["EstadoCivil"].'</option>';
                            }
                            mysqli_free_result($q1);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="docide" class="col-sm-3 control-label">Documento Identidad</label>
                    <div class="col-sm-3 valida">
                      <select name="docide" id="docide" class="form-control">
                        <option value="">TIPO DOCUMENTO</option>
                        <option value="DNI">DNI</option>
                        <option value="CARNET EXTRANJERÍA">CARNET EXTRANJERÍA</option>
                        <option value="PASAPORTE">PASAPORTE</option>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <input type="text" id="numdoc" name="numdoc" class="form-control" placeholder="N° de Documento">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="libmil" class="col-sm-3 control-label">N° de Libreta Militar</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="libmil" name="libmil" class="form-control" placeholder="N° de Libreta Militar">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="aut" class="col-sm-3 control-label">ESSALUD (Autogenerado)</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="aut" name="aut" class="form-control" placeholder="Autogenerado">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ruc" class="col-sm-3 control-label">RUC</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="ruc" name="ruc" class="form-control" placeholder="RUC">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="corper" class="col-sm-3 control-label">Correo Personal</label>
                    <div class="col-sm-6 valida">
                      <input type="email" id="corper" name="corper" class="form-control" placeholder="Correo Personal">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numcue" class="col-sm-3 control-label">N° de cuenta BN</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numcue" name="numcue" class="form-control" placeholder="N° de cuenta BN">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="entcts" class="col-sm-3 control-label">Entidad CTS</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="entcts" name="entcts" class="form-control" placeholder="Entidad CTS">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="grusan" class="col-sm-3 control-label">Grupo Sanguíneo</label>
                    <div class="col-sm-3 valida">
                      <select name="grusan" id="grusan" class="form-control">
                        <option value="">GRUPO SANGUINEO</option>
                        <option value="O-">O-</option>
                        <option value="O+" selected>O+</option>
                        <option value="A-">A-</option>
                        <option value="A+">A+</option>
                        <option value="B-">B-</option>
                        <option value="B+">B+</option>
                        <option value="AB-">AB-</option>
                        <option value="AB+">AB+</option>
                      </select>
                    </div>
                  </div>
                  </fieldset>
                  <!--Grado Instrucción-->
                  <fieldset class="fieldset">
                    <legend class="text-primary"><i class="fa fa-angle-double-right"></i> Grado Instrucción</legend>
                  <div class="form-group">
                    <label for="grains" class="col-sm-3 control-label">Grado Instrucción</label>
                    <div class="col-sm-3 valida">
                      <select name="grains" id="grains" class="form-control" onChange="cnivel(this.value)">
                        <option value="">GRADO</option>
                        <?php echo listagra($cone) ?>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="nivins" id="nivins" class="form-control">
                        <option value="">NIVEL</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="esp" class="col-sm-3 control-label">Especialidad</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="esp" name="esp" class="form-control" placeholder="Especialidad">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="ins" name="ins" class="form-control" placeholder="Institución">
                    </div>
                  </div>
                  </fieldset>
                  <!--Sistema Pensión-->
                  <fieldset class="fieldset">
                    <legend class="text-primary"><i class="fa fa-angle-double-right"></i> Sistema Pensión</legend>
                  <div class="form-group">
                    <label for="penins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-3 valida">
                      <select name="penins" id="penins" class="form-control">
                        <option value="">INSTITUCIÓN</option>
                        <?php echo listapen($cone) ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="cuspp" class="col-sm-3 control-label">Código CUSPP</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="cuspp" name="cuspp" class="form-control" placeholder="CUSPP">
                    </div>
                  </div>
                  </fieldset>
                  <!--Domicilio-->
                  <fieldset class="fieldset">
                    <legend class="text-primary"><i class="fa fa-angle-double-right"></i> Domicilio</legend>
                  <div class="form-group">
                    <label for="conviv" class="col-sm-3 control-label">Condición Vivienda</label>
                    <div class="col-sm-3 valida">
                      <select name="conviv" id="conviv" class="form-control">
                        <option value="">CONDICIÓN</option>
                        <option value="PROPIA">PROPIA</option>
                        <option value="ALQUILER">ALQUILER</option>
                        <option value="FAMILIAR">FAMILIAR</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="dir" class="col-sm-3 control-label">Dirección</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="dir" name="dir" class="form-control" placeholder="Dirección">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="urb" class="col-sm-3 control-label">Urbanización</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="urb" name="urb" class="form-control" placeholder="Urbanización">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="depubi" class="col-sm-3 control-label">Ubicación</label>
                    <div class="col-sm-3 valida">
                      <select name="depubi" id="depubi" class="form-control" onChange="cprovinciad(this.value)">
                        <option value="">DEPARTAMENTO</option>
                        <?php echo listadep($cone) ?>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="proubi" id="proubi" class="form-control" onChange="cdistritod(this.value)">
                        <option value="">PROVINCIA</option>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="disubi" id="disubi" class="form-control">
                        <option value="">DISTRITO</option>
                      </select>
                    </div>
                  </div>
                  </fieldset>
                  <!--Teléfono-->
                  <fieldset class="fieldset">
                    <legend class="text-primary"><i class="fa fa-angle-double-right"></i> Teléfono</legend>
                  <div class="form-group">
                    <label for="tiptel" class="col-sm-3 control-label">Teléfono</label>
                    <div class="col-sm-3 valida">
                      <select name="tiptel" id="tiptel" class="form-control">
                        <option value="">TIPO TELÉFONO</option>
                        <?php echo listattel($cone) ?>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <input type="text" id="numtel" name="numtel" class="form-control" placeholder="Número">
                    </div>
                  </div>
                  </fieldset>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="reset" class="btn btn-default">Restablecer</button>
                  <button type="submit" class="btn btn-info pull-right">Guardar</button>
                </div>
                <!-- /.box-footer-->
              </form>
              <script>
                function cprovincia(val){
                  $('#pronac').html('<option value="">Cargando...</option>');
                  $.ajax({
                    url: 'm_inclusiones/ajax/a_scarga.php',
                    data: 'iddep='+val,
                    success: function(resp){ 
                      $('#pronac').html(resp) 
                    }
                   });
                   $('#disnac').html('<option value="">DISTRITO</option>')
                }
                function cdistrito(val){
                  $('#disnac').html('<option value="">Cargando...</option>');
                  $.ajax({
                    url: 'm_inclusiones/ajax/a_scarga.php',
                    data: 'idpro='+val,
                    success: function(resp){ 
                      $('#disnac').html(resp) 
                    }
                   }); 
                }
                function cnivel(val){
                  $('#nivins').html('<option value="">Cargando...</option>');
                  $.ajax({
                    url: 'm_inclusiones/ajax/a_scarga.php',
                    data: 'gi='+val,
                    success: function(resp){ 
                      $('#nivins').html(resp)
                    }
                   }); 
                }
                function cprovinciad(val){
                  $('#proubi').html('<option value="">Cargando...</option>');
                  $.ajax({
                    url: 'm_inclusiones/ajax/a_scarga.php',
                    data: 'iddep='+val,
                    success: function(resp){ 
                      $('#proubi').html(resp)
                    }
                   });
                   $('#disubi').html('<option value="">DISTRITO</option>')
                }
                function cdistritod(val){
                  $('#disubi').html('<option value="">Cargando...</option>');
                  $.ajax({
                    url: 'm_inclusiones/ajax/a_scarga.php',
                    data: 'idpro='+val,
                    success: function(resp){ 
                      $('#disubi').html(resp) 
                    }
                   }); 
                }

                </script>
            </div>
            <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Ministerio Público</b> Distrito Fiscal de Cajamarca
    </div>
    <strong>Copyright &copy; 2016 Oficina de Sistemas e Informática.</strong> Todos los derechos reservados.
  </footer>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->

</div>
<!-- ./wrapper -->
<!--Modal busqueda-->
<div class="modal fade" id="mb_persona" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Personal</h4>
      </div>
      <div class="modal-body" id="dmb_persona">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Busqueda-->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Jquery-iu -->
<script src="plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="m_inclusiones/js/funcionesin.js"></script>
<script src="m_inclusiones/js/funcionesme.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Jquery Validation -->
<script src="m_inclusiones/js/jquery.validate.js"></script>
<script src="m_inclusiones/js/messages_es_PE.js"></script>
<script>
$(function() {
    $('input[name="fecnac"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        format: 'DD/MM/YYYY',
        "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    }
    });
});

$( "#f_npersonal" ).validate( {
  rules: {
    apepat: "required",
    apemat: "required",
    nom: "required",
    fecnac:{required:true, datePE:true},
    nac: "required",
    depnac: "required",
    pronac: "required",
    disnac: "required",
    estciv: "required",
    docide: "required",
    numdoc: {required:true,minlength:8,remote:{url:"m_inclusiones/ajax/a_vdocumento.php",type:"get"}},
    libmil:{required:false, minlength:8},
    aut:{required:false,minlength:15},
    ruc:{required:false,minlength:11},
    corper:{required:true,email:true},
    numcue:{required:false,minlength:10},
    entcts:{required:false,minlength:3},
    grusan:"required",
    grains:"required",
    nivins:"required",
    esp:"required",
    ins:"required",
    penins:"required",
    cuspp:{required:true,minlength:12},
    conviv:"required",
    dir:"required",
    urb:{required:false,minlength:6},
    depubi:"required",
    proubi:"required",
    disubi:"required",
    tiptel:"required",
    numtel:{required:true,minlength:9}
  },
  messages: {
    apepat: "Ingrese apellido paterno.",
    apemat: "Ingrese apellido materno.",
    nom: "Ingrese nombres.",
    fecnac: {required:"Ingrese fecha de nacimiento.",datePE:"Ingrese una fecha valida."},
    nac: "Ingrese nacionalidad.",
    depnac:"Elija departamento.",
    pronac:"Elija provincia.",
    disnac:"Elija distrito.",
    estciv:"Elija estado civil.",
    docide:"Elija tipo de documento de identidad",
    numdoc:{required:"Ingrese el número del documento elegido.",minlength:"Mínimo 8 caracteres",remote:"En número del documento ingresado ya existe."},
    libmil:{minlength:"Mínimo 8 caracteres."},
    aut:{minlength:"El autogenerado contiene 15 caracteres."},
    ruc:{minlength:"El RUC contiene 11 caracteres."},
    numcue:{minlength:"Mínimo 10 caracteres."},
    entcts:{minlength:"Mínimo 3 caracteres."},
    grusan:"Elija grupo sanguineo.",
    grains:"Elija grado de instrucción.",
    nivins:"Elija nivel.",
    esp:"Ingrese especialidad o NINGUNA  en caso no tenga.",
    ins:"Ingrese institución.",
    penins:"Elija la institución a la que está afiliado.",
    cuspp:{required:"Ingrese el código CUSPP",minlength:"Mínimo 12 caracteres."},
    conviv:"Elija la condición de la vivienda.",
    dir:"Ingrese la dirección.",
    urb:{minlength:"Mínimo 6 caracteres."},
    depubi:"Elija departamento.",
    proubi:"Elija provincia.",
    disubi:"Elija distrito.",
    tiptel:"Elija tipo de teléfono.",
    numtel:{required:"Ingrese el número de teléfono.",minlength:"Mínimo 9 caracteres."}
  },
  errorElement: "em",
  errorPlacement: function ( error, element ) {
    // Add the `help-block` class to the error element
    error.addClass( "help-block" );

    if ( element.prop( "type" ) === "checkbox" ) {
      error.insertAfter( element.parent( "label" ) );
    } else if ( element.prop( "type" ) === "radio" ){
      error.insertAfter( element.parent( "label" ) );
    }
    else {
      error.insertAfter( element );
    }
  },
  highlight: function ( element, errorClass, validClass ) {
    $( element ).parents( ".valida" ).addClass( "has-error" ).removeClass( "has-success" );
  },
  unhighlight: function (element, errorClass, validClass) {
    $( element ).parents( ".valida" ).addClass( "has-success" ).removeClass( "has-error" );
  }
} );
</script>
</body>
</html>
<?php
}else{
  header('Location: index.php');
}
?>