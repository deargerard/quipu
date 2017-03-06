<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SISPER - <?php echo $tit ?></title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <link rel="stylesheet" href="plugins/jQueryUI/jquery-ui.css">
    <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  
  <style>
  .ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 200px;
  }
  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue-light fixed sidebar-mini">
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
              <img src="<?php echo mfotop($_SESSION['docide']) ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['nomusu'] ?> <i class="fa fa-angle-down"></i></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo mfotop($_SESSION['docide']) ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['nomusu'] ?>
                  <small><?php echo cargoe($cone,$_SESSION['identi']) ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#m_camconpersonal">Cambiar Contraseña</a>
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
          <img src="<?php echo mfotop($_SESSION['docide']) ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p class="salto"><?php echo $_SESSION['nomusu'] ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form" id="fb_persona">
        <div class="input-group">
          <input type="text" name="ib_persona" data-provide="typeahead" class="form-control" id="i_acpersona" placeholder="Buscar persona">
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
        <li class="treeview" id="personal">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Personal</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="pagpersonal"><a href="pagpersonal.php"><i class="fa fa-circle-o"></i> Personal</a></li>
            <li id="nuepersonal"><a href="nuepersonal.php"><i class="fa fa-circle-o"></i> Nuevo</a></li>
            <li id="perpersonal"><a href="perpersonal.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
            <li id="licpersonal"><a href="licpersonal.php"><i class="fa fa-circle-o"></i> Licencias</a></li>
            <li id="vacpersonal"><a href="vacpersonal.php"><i class="fa fa-circle-o"></i> Vacaciones</a></li>
            <li id="decjurpersonal"><a href="decjurpersonal.php"><i class="fa fa-circle-o"></i> Declaración Jurada</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file"></i>
            <span>Reportes</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Personal</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Asistencia</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Permisos</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Licencias</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Vacaciones</a></li>
          </ul>
        </li>
        <?php if(accesocon($cone,$_SESSION['identi'],6)){ ?>
        <li class="treeview" id="mantenimiento">
          <a href="#">
            <i class="fa fa-wrench"></i>
            <span>Mantenimiento</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="depmante"><a href="depmante.php"><i class="fa fa-circle-o"></i> Dependencia</a></li>
            <li id="locmante"><a href="locmante.php"><i class="fa fa-circle-o"></i> Local</a></li>
            <li id="benmante"><a href="benmante.php"><i class="fa fa-circle-o"></i> Beneficio</a></li>
            <li id="sispenmante"><a href="sispenmante.php"><i class="fa fa-circle-o"></i> Sistema Pensión</a></li>
            <li id="tiptelmante"><a href="tiptelmante.php"><i class="fa fa-circle-o"></i> Tipo Teléfono</a></li>
          </ul>
        </li>
        <?php } ?>
        <li id="accesos">
          <a href="accesos.php">
            <i class="fa fa-key"></i><span>Accesos</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="ConPage">
    <!-- Content Header (Page header) -->
