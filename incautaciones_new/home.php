<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>MP | Incautaciones</title>
	<link rel="icon" type="image/png" href="images/icono.png" />
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


        <script src="../assets/js/ie8-responsive-file-warning.js"></script>


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


</head>


<body class="nav-md">
<?php include("conect.php");
$link=conect();
						date_default_timezone_set("America/Lima");
					$fecha= date('Y-m-d');?>

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
				  	<li><a href="consulta_formatos.php"><i class="fa fa-file-text"></i>Formato A7 y A8</a></li>
				  	<li><a href="casos_docs.php"><i class="fa fa-file"></i>Agregar Documentos</a></li>
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
			</nav>
        </div>

      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="row">


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Inventario <small>Custodia</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <p class="text-muted font-13 m-b-30">
                    De muestra todos los registro existentes en custodia.
                  </p>
                  <table id="datatable-buttons" class="table table-striped table-bordered table-responsive" width="100%">
                    <thead>
                      <tr>
                        <th>B-Ingreso</th>
                        <th>F-Ingreso</th>
                        <th>Caso</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Condicion</th>
						<th>T_Custodia</th>
                        <th>T_Restante</th>
                        <th>Alerta</th>
                      </tr>
                    </thead>
					<tbody>

<?php $sSQL = "SELECT * FROM inventario order by(id)";
$result = mysqli_query($link,$sSQL);
while($row = mysqli_fetch_array($result)) { 
			$datetime2 = $row["f_ingreso"];
			$datetime1 = $fecha;
			$diff = (abs(strtotime($datetime1) - strtotime($datetime2)))/(3600*24);
			if($diff>180)
			{?>
                      <tr>
                        <td><?php echo $row["b_ingreso"];?></td>
                        <td><?php echo $row["f_ingreso"];?></td>
                        <td><?php echo $row["caso"];?></td>
                        <td><?php echo $row["descripcion"];?></td>
                        <td><?php echo $row["estado"];?></td>
                        <td><?php echo $row["condicion"];?></td>
						<td><?php echo $diff.' dias';?></td>
						 <?php
						  if($diff>180)
						  {?>
							<td><?php echo 180-$diff.' dias'?></td>
                        	<td><font color="#ED1014">Vencido</font></td>
						 <?php
						  }
					  		else
					  		{?>
					  	<td><?php echo 180-$diff.' dias'?></td>
                        <td>En custodia</td>
						<?php
					  		}
						  ?>
                        
					  		<?php
			} //fin del if principal
							} //fin de while ?> 
						</tbody>
                  </table>
                </div>
              </div>
            </div>


              <!-- footer content -->
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
