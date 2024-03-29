<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quipu - <?php echo $tit ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bootstrap/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="dist/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/select2.min.css">
  <!-- Select Multiple -->
  <link rel="stylesheet" href="plugins/bootstrap-select/dist/css/bootstrap-select.min.css">
    <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <link rel="stylesheet" href="plugins/jQueryUI/jquery-ui.css">
    <!-- datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="plugins/datatables.net/js/buttons.dataTables.min.css">
  <link rel="stylesheet" href="plugins/datatables.net/js/jquery.dataTables_themeroller.css">
    <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Favicon -->
  <link rel='shortcut icon' type='image/x-icon' href='m_images/favicon.png' />
<?php
if(!empty($css)){
  echo $css;
}
?>
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
  .datepicker{
    z-index:1200 !important;
  }
  @media print
  {
    .no-print, .no-print * {
      display: none !important;
    }
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
      <span class="logo-mini"><b>Q</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Qui</b>pu</span>
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
                  <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#m_camconpersonal">Contraseña</a>
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
      <?php
      if(accesocon($cone,$_SESSION['identi'],10)){
      ?>
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
      <?php
      }
      ?>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MENU</li>
        <li class="active">
          <a href="dboard.php">
            <i class="fa fa-home"></i><span>Inicio</span>
          </a>
        </li>
        <li class="treeview" id="miperfil">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>Mi Perfil</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="fichapersonal"><a href="perpersonal.php"><i class="fa fa-circle-o"></i> Ficha Personal</a></li>
            <li id="fichalaboral"><a href="ficlaboral.php"><i class="fa fa-circle-o"></i> Ficha Laboral</a></li>
          </ul>
        </li>
        <?php
        if(accesocon($cone,$_SESSION['identi'],1)){
        ?>
        <li class="treeview" id="personal">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Personal</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="pagpersonal"><a href="pagpersonal.php"><i class="fa fa-circle-o"></i> Personal</a></li>
            <?php if(accesoadm($cone,$_SESSION['identi'],1)){ ?>
            <li id="nuepersonal"><a href="nuepersonal.php"><i class="fa fa-circle-o"></i> Nuevo</a></li>
            <?php } ?>
            <li id="reppersonal"><a href="reppersonal.php"><i class="fa fa-circle-o"></i> Reportes</a></li>
          </ul>
        </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],5)){
        ?>
        <li class="treeview" id="permisos">
          <a href="#">
            <i class="fa fa-clock-o"></i>
            <span>Permisos</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="pagpermisos"><a href="pagpermisos.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
            <li id="reppermisos"><a href="repermisos.php"><i class="fa fa-circle-o"></i> Reporte</a></li>
          </ul>
        </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],4)){
        ?>
        <li class="treeview" id="licencias">
          <a href="#">
            <i class="fa fa-calendar-o"></i>
            <span>Licencias</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if(accesoadm($cone,$_SESSION['identi'],4)){ ?>
            <li id="paglicencias"><a href="paglicencias.php"><i class="fa fa-circle-o"></i> Registro</a></li>
            <?php } ?>
            <li id="replicencias"><a href="replicencias.php"><i class="fa fa-circle-o"></i> Reportes</a></li>
          </ul>
        </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],3) || esResDespacho($cone,$_SESSION['identi'])){
        ?>
        <li class="treeview" id="vacaciones">
          <a href="#">
            <i class="fa fa-plane"></i>
            <span>Vacaciones</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if(esResDespacho($cone,$_SESSION['identi'])){ ?>
            <li id="provacaciones"><a href="provacaciones.php"><i class="fa fa-circle-o"></i> Programación</a></li>
            <?php } if(accesoadm($cone,$_SESSION['identi'],3)){ ?>
            <li id="pagvacaciones"><a href="pagvacaciones.php"><i class="fa fa-circle-o"></i> Reprogramación</a></li>
            <?php } if(accesoadm($cone,$_SESSION['identi'],14)){ ?>
            <li id="aprvacaciones"><a href="aprvacaciones.php"><i class="fa fa-circle-o"></i> Aprobación</a></li>
            <li id="ejevacaciones"><a href="ejevacaciones.php"><i class="fa fa-circle-o"></i> Ejecución</a></li>
            <?php } if(accesocon($cone,$_SESSION['identi'],3)){ ?>
            <li id="repvacaciones"><a href="repvacaciones.php"><i class="fa fa-circle-o"></i> Reportes</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],8)){
        ?>
        <li class="treeview" id="decjuradas">
          <a href="#">
            <i class="fa fa-file-text-o"></i>
            <span>Dec. Juradas</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="pagdecjuradas"><a href="pagdecjuradas.php"><i class="fa fa-circle-o"></i> Dec. Juradas</a></li>
            <li id="repdecjuradas"><a href="repdecjuradas.php"><i class="fa fa-circle-o"></i> Reporte</a></li>
          </ul>
        </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],6)){
        ?>
        <li class="treeview" id="organizacional">
          <a href="#">
            <i class="fa fa-sitemap"></i>
            <span>Organizacional</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="depmante"><a href="depmante.php"><i class="fa fa-circle-o"></i> Dependencia</a></li>
            <li id="coomante"><a href="coomante.php"><i class="fa fa-circle-o"></i> Coordinación</a></li>
            <li id="dearmante"><a href="dearmante.php"><i class="fa fa-circle-o"></i> Despacho/Área</a></li>
            <li id="locmante"><a href="locmante.php"><i class="fa fa-circle-o"></i> Local</a></li>
            <li id="ambmante"><a href="ambmante.php"><i class="fa fa-circle-o"></i> Ambiente</a></li>
          </ul>
        </li>
        <?php
        }
         if(accesocon($cone,$_SESSION['identi'],12)){
        ?>
        <li class="treeview" id="directorio">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Directorio</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="dirper"><a href="dirper.php"><i class="fa fa-circle-o"></i> Personal</a></li>
            <li id="dirdep"><a href="dirdep.php"><i class="fa fa-circle-o"></i> Dependencia</a></li>
          </ul>
        </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],7)){
        ?>
        <li id="accesos">
          <a href="accesos.php">
            <i class="fa fa-key"></i><span>Accesos</span>
          </a>
        </li>
        <?php
        }
        ?>
        <?php
        if(accesoadm($cone,$_SESSION['identi'],11)){
        ?>
        <li id="intranet">
          <a href="intranet.php">
            <i class="fa fa-globe"></i><span>Intranet</span>
          </a>
        </li>
        <?php
        }
        ?>
        <?php
        if(accesocon($cone,$_SESSION['identi'],2)){
        ?>
        <li id="asistencia">
          <a href="asistencia.php">
            <i class="fa fa-calendar"></i><span>Asistencia</span>
          </a>
        </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],13)){
        ?>
        <li class="treeview" id="documentario">
          <a href="#">
            <i class="fa fa-file-text-o"></i>
            <span>Documentario</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="regdocumentario"><a href="regdocumentario.php"><i class="fa fa-circle-o"></i> Registro/Busqueda</a></li>
            <!--<li id="repdocumentario"><a href="repdocumentario.php"><i class="fa fa-circle-o"></i> Reportes</a></li>-->
          </ul>
        </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],15)){
        ?>
        <li class="treeview" id="comservicios">
          <a href="#">
            <i class="fa fa-automobile"></i>
            <span>Comisión de Servicios</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if(accesoadm($cone,$_SESSION['identi'],15)){ ?>
            <li id="pagcomservicios"><a href="pagcomservicios.php"><i class="fa fa-circle-o"></i> Registro</a></li>
            <?php } ?>
            <li id="repcomservicios"><a href="repcomservicios.php"><i class="fa fa-circle-o"></i> Reportes</a></li>
          </ul>
        </li>
        <?php
        }
        if(solucionador($cone, $_SESSION['identi'])){
        ?>
        <li class="treeview" id="mesaayuda">
          <a href="#">
            <i class="fa fa-user-md"></i>
            <span>Mesa de Ayuda</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="maatenciones"><a href="maatenciones.php"><i class="fa fa-circle-o"></i> Atenciones</a></li>
            <li id="mareportes"><a href="mareportes.php"><i class="fa fa-circle-o"></i> Reportes</a></li>
          </ul>
        </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],16)){
        ?>
        <li class="treeview" id="tesoreria">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Tesorería</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li id="teasignaciones"><a href="teasignaciones.php"><i class="fa fa-circle-o"></i> Asignaciones</a></li>
            <li id="terendiciones"><a href="terendiciones.php"><i class="fa fa-circle-o"></i> Rendiciones</a></li>
            <li id="teadelantos"><a href="teadelantos.php"><i class="fa fa-circle-o"></i> Pagos</a></li>
            <li id="teviaticos"><a href="teviaticos.php"><i class="fa fa-circle-o"></i> Viáticos</a></li>
            <li id="tereportes"><a href="tereportes.php"><i class="fa fa-circle-o"></i> Reportes</a></li>
          </ul>
        </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],17)){
        ?>
          <li class="treeview" id="tramitedoc">
            <a href="#">
              <i class="fa fa-folder-open"></i>
              <span>Trámite Doc.</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(accesoadm($cone,$_SESSION['identi'],17)){ ?>
              <li id="tdmesapartes"><a href="tdmesapartes.php"><i class="fa fa-circle-o"></i> Mesa Partes</a></li>
              <?php } ?>
              <li id="tdbandeja"><a href="tdbandeja.php"><i class="fa fa-circle-o"></i> Bandeja</a></li>
              <li id="tdconsultas"><a href="tdconsultas.php"><i class="fa fa-circle-o"></i> Consultas</a></li>
            </ul>
          </li>
        <?php
        }
        if(accesocon($cone,$_SESSION['identi'],18)){
        ?>
          <li class="treeview" id="elecciones">
            <a href="#">
              <i class="fa fa-hand-o-up"></i>
              <span>Elecciones</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(accesoadm($cone,$_SESSION['identi'],18)){ ?>
              <li id="elregistro"><a href="elregistro.php"><i class="fa fa-circle-o"></i> Registro</a></li>
              <?php } ?>
              <li id="elconsulta"><a href="elconsulta.php"><i class="fa fa-circle-o"></i> Consultas</a></li>
            </ul>
          </li>
        <?php
        }
        ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="ConPage">
    <!-- Content Header (Page header) -->
