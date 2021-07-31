<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>DataTables | Gentallela</title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">

  <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />

  <script src="js/jquery.min.js"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
			          <!-- menu prile quick info -->
          <div class="profile">
            <div class="profile_info">
				<img src="images/icono.png" alt="...">
              <span>Bienvenido,</span>
              <h2><?php echo $_SESSION['usuario'];?></h2>
            </div>
          </div>
          <!-- /menu prile quick info -->
          <div class="clearfix"></div>

          <br />
          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <ul class="nav side-menu">
                <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="ingreso.php"><i class="fa fa-edit"></i>Ingreso</a></li>
				<?php
				  if($_SESSION['tipo']=="admin")
				  { ?>
				  	<li><a href="lista_casos.php"><i class="fa fa-camera"></i>Editar y/o agregar foto</a></li>
				<?php
				  }
				  ?>
				<li><a href="inventario.php"><i class="fa fa-table"></i>Salida o Eliminacion</a></li>
				<?php
				  if($_SESSION['tipo']=="admin")
				  { ?>
				  <li><a href="inventario_general.php"><i class="fa fa-filter"></i>Inventario General</a></li>
					<li><a href="consulta.php"><i class="fa fa-search"></i>Consulta</a></li>
				<?php
				  }
				  ?>
				 <?php
				  if($_SESSION['tipo']=="admin" or $_SESSION['tipo']=="jefe")
				  { ?>
					<li><a href="consulta_ingresos.php"><i class="fa fa-search"></i>Boletas de Ingreso</a></li>
					<li><a href="consulta_salidas.php"><i class="fa fa-search"></i>Boletas de Salida</a></li> 
				<?php
				  }
				  ?>
				<?php
				  if($_SESSION['tipo']=="admin")
				  { ?>
					<li><a href="evidencias.php"><i class="fa fa-archive"></i>Evidencias</a></li>
					<li><a href="personal.php"><i class="fa fa-users"></i>Personal</a></li>
					<li><a href="user_personal.php"><i class="fa fa-lock"></i> Seguridad </a></li>
				<?php
				  }
				  ?>
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a href="end.php" data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="images/img.jpg" alt="">John Doe
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                  <li><a href="javascript:;">  Profile</a>
                  </li>
                  <li>
                    <a href="javascript:;">
                      <span class="badge bg-red pull-right">50%</span>
                      <span>Settings</span>
                    </a>
                  </li>
                  <li>
                    <a href="javascript:;">Help</a>
                  </li>
                  <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </li>
                </ul>
              </li>

              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <span class="badge bg-green">6</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <div class="text-center">
                      <a>
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>

            </ul>
          </nav>
        </div>

      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">

          <div class="clearfix"></div>

          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Ingreso de nuevo registro</h2>

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <form class="form-horizontal form-label-left" action="a7_agregar.php" method="POST" enctype="multipart/form-data">
		  
<?php
include("conect.php");
$id=$_GET["id"];
$caso=$_GET["caso"];
$link=conect();
$sql=conect();
$lib = mysqli_query($sql,"select max(registro_entrega) as ultimo_id from detalle_1_a7 where id=$id");
$rs_lib = mysqli_fetch_assoc($lib);
$rn= $rs_lib['ultimo_id'] + 1;
					date_default_timezone_set("America/Lima");
					$fecha= date('Y-m-d');
					$an=date('Y');
					$hora = date('H:i:s')
					?>
					  <input type="hidden" name="id" value="<?php echo $id?>">
					  <input type="hidden" name="caso" value="<?php echo $caso?>">
					  <input type="hidden" name="registro" value="<?php echo $rn ?>">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha Entrega</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                      <input type="text" name="fecha" class="form-control" placeholder="Numero de Boleta de Ingreso" value="<?php echo $fecha; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Hora Entrega</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" name="hora" class="form-control" placeholder="Fecha de Internamiento" value="<?php echo $hora; ?>">
                      </div>
                    </div>
					<div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre (persona)<span class="required">*</span></label></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="nombre" class="form-control" placeholder="Nombre de quien deja los bienes">
                      </div>
                    </div>
					  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">DNI</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="DNI" name="dni">
                      </div>
                    </div>
					  <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Cargo</label>
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="Cargo / Institucion" name="cargo">
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
						<input type="reset" name="Borrar" value="Borrar" class="btn btn-primary">
						<input type="submit" name="Registrar" value="Registrar" class="btn btn-success">
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
			  
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">

                      <div class="x_title">
                        <center><h2>FORMATO A7 - CADENA DE CUSTODIA (*)</h2></center>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>FECHA</th>
                              <th>HORA</th>
                              <th>NOMBRE (QUIEN ENTREGA)</th>
                              <th>DNI</th>
                              <th>CARGO / INSTITUCIÓN</th>
							  <th>FIRMA</th>
                            </tr>
                          </thead>
							<tbody>
<?php $sSQL = "SELECT * FROM detalle_1_a7 where id=$id order by(registro_entrega)";
$result = mysqli_query($link,$sSQL);
while($row = mysqli_fetch_array($result)) { 
?>
                          
                            <tr>
                              <td><?php echo $row["fecha_entrega"];?></td>
                        	  <td><?php echo $row["hora_entrega"];?></td>
							  <td><?php echo $row["nombre_entrega"];?></td>
                        	  <td><?php echo $row["dni_entrega"];?></td>
                        	  <td><?php echo $row["cargo_entrega"];?></td>
                              <td></td>
                            </tr>
<?php
}
?>
                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div>
			  
                </div>
              </div>
              <!-- footer content -->
              <footer>
                <div class="copyright-info">
				  <p class="pull-left"><a href="a8-llenar.php?id=<?php echo $id?>&caso=<?php echo $caso?>"><button type="button" class="btn btn-success btn-lg"> Formulario A8 <i class="fa fa-arrow-circle-right"></i></button></a></p>
                  <p class="pull-right">Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a></p>
                </div>
                <div class="clearfix"></div>
              </footer>
              <!-- /footer content -->

            </div>
            <!-- /page content -->
          </div>

        </div>

        <div id="custom_notifications" class="custom-notifications dsp_none">
          <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
          </ul>
          <div class="clearfix"></div>
          <div id="notif-group" class="tabbed_notifications"></div>
        </div>

        <script src="js/bootstrap.min.js"></script>

        <!-- bootstrap progress js -->
        <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
        <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
        <!-- icheck -->
        <script src="js/icheck/icheck.min.js"></script>

        <script src="js/custom.js"></script>


        <!-- Datatables -->
        <!-- <script src="js/datatables/js/jquery.dataTables.js"></script>
  <script src="js/datatables/tools/js/dataTables.tableTools.js"></script> -->

        <!-- Datatables-->
        <script src="js/datatables/jquery.dataTables.min.js"></script>
        <script src="js/datatables/dataTables.bootstrap.js"></script>
        <script src="js/datatables/dataTables.buttons.min.js"></script>
        <script src="js/datatables/buttons.bootstrap.min.js"></script>
        <script src="js/datatables/jszip.min.js"></script>
        <script src="js/datatables/pdfmake.min.js"></script>
        <script src="js/datatables/vfs_fonts.js"></script>
        <script src="js/datatables/buttons.html5.min.js"></script>
        <script src="js/datatables/buttons.print.min.js"></script>
        <script src="js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="js/datatables/dataTables.keyTable.min.js"></script>
        <script src="js/datatables/dataTables.responsive.min.js"></script>
        <script src="js/datatables/responsive.bootstrap.min.js"></script>
        <script src="js/datatables/dataTables.scroller.min.js"></script>


        <!-- pace -->
        <script src="js/pace/pace.min.js"></script>
        <script>
          var handleDataTableButtons = function() {
              "use strict";
              0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                buttons: [{
                  extend: "copy",
                  className: "btn-sm"
                }, {
                  extend: "csv",
                  className: "btn-sm"
                }, {
                  extend: "excel",
                  className: "btn-sm"
                }, {
                  extend: "pdf",
                  className: "btn-sm"
                }, {
                  extend: "print",
                  className: "btn-sm"
                }],
                responsive: !0
              })
            },
            TableManageButtons = function() {
              "use strict";
              return {
                init: function() {
                  handleDataTableButtons()
                }
              }
            }();
        </script>
        <script type="text/javascript">
          $(document).ready(function() {
            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({
              keys: true
            });
            $('#datatable-responsive').DataTable();
            $('#datatable-scroller').DataTable({
              ajax: "js/datatables/json/scroller-demo.json",
              deferRender: true,
              scrollY: 380,
              scrollCollapse: true,
              scroller: true
            });
            var table = $('#datatable-fixed-header').DataTable({
              fixedHeader: true
            });
          });
          TableManageButtons.init();
        </script>
</body>

</html>
