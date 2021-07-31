<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Formulario A8 | MP</title>

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
		<?PHP		
		$id=$_GET["id"];
		date_default_timezone_set("America/Lima");
					$fecha= date('Y-m-d');
					$hora = date('H:i:s')
					?>
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="clearfix"></div>

          <div class="row">

                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
						
                      <div class="x_title">
                        <h2>REGISTRO DE CONTINUIDAD DE CUSTODIA DE ELEMENTOS MATERIALES, EVIDENCIAS Y BIENES INCAUTADOS <code>(*) </code></h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
			<form class="form-horizontal form-label-left" action="formato_a8_ag.php" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id?>">

                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 5%">FECHA</th>
                              <th style="width: 5%">HORA</th>
                              <th>NOMBRE (QUIEN RECIBE)</th>
                              <th style="width: 5%">DNI / CPI</th>
                              <th>CARGO / INSTITUCIÓN</th>
                              <th>CÓDIGO DE RECEPCIÓN</th>
                              <th>PROPOSITO DEL TRASLADO</th>
                              <th>AUTORIDAD (AUTORIZA TRASLADO)</th>
                              <th>OBSERV</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><input type="text" class="form-control" name="fecha" value="<?php echo $fecha; ?>" maxlength="10" size="10"></td>
                              <td><input type="text" class="form-control" name="hora" value="<?php echo $hora; ?>" maxlength="10" size="10"></td>
                              <td><input type="text" class="form-control" placeholder="nombre completo" name="nombre"></td>
                              <td><input type="text" class="form-control" placeholder="DNI" name="dni" maxlength="8" size="8"></td>
                              <td><input type="text" class="form-control" placeholder="cargo" name="cargo"></td>
                              <td><input type="text" class="form-control" placeholder="codigo" name="codigo"></td>
                              <td><input type="text" class="form-control" placeholder="proposito" name="proposito"></td>
                              <td><input type="text" class="form-control" placeholder="autorizacion" name="autorizacion"></td>
                              <td><input type="text" class="form-control" placeholder="observaciones" name="obs"></td>
                            </tr>
							<tr>
                              <td><input type="text" class="form-control" name="fecha1" value="<?php echo $fecha; ?>" maxlength="10" size="10"></td>
                              <td><input type="text" class="form-control" name="hora1" value="<?php echo $hora; ?>" maxlength="10" size="10"></td>
                              <td><input type="text" class="form-control" placeholder="nombre completo" name="nombre1" value="JONATHAN JACOB LAU ZAMORA"></td>
                              <td><input type="text" class="form-control" placeholder="DNI" name="dni1" maxlength="8" size="8" value="44096655"></td>
                              <td><input type="text" class="form-control" placeholder="cargo" name="cargo1" value="BIENES INCAUTADOS"></td>
                              <td><input type="text" class="form-control" placeholder="codigo" name="codigo1"></td>
                              <td><input type="text" class="form-control" placeholder="proposito" name="proposito1"></td>
                              <td><input type="text" class="form-control" placeholder="autorizacion" name="autorizacion1" value="BIENES INCAUTADOS"></td>
                              <td><input type="text" class="form-control" placeholder="observaciones" name="obs1"></td>
                            </tr>
                          </tbody>
                        </table>
                        <p class="text-muted font-13 m-b-30">
                          <i class="red">IMPORTANTE:</i> <b>Este formato de custodia debe permanecer con el bien <u><i class="red">incaudato</i></u>.</b>
                        </p>
                      </div>
                    </div>
                  </div>


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>FORMATO A - 8</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
					<center><b>REGISTRO DE CADENA DE CUSTODIA EN ALMACÉN DE ELEMENTOS MATERIALES, EVIDENCIAS Y BIENES INCAUTADOS</b></center>
					<center><b>FORMATO A - 8</b></center>
					<center>Nº. DE REGISTRO / CÓDIGO ÚNICO DE CASO N° <input type="text" name="caso" maxlength="10" size="10"></center>      
					<center>Nº  DE BOLETA  DE INTERNAMIENTO</center>

<h2>DATOS  GENERALES DEL ALMACÉN</h2>
<p>Distrito Judicial   CAJAMARCA	Provincia 	CAJAMARCA	Departamento   CAJAMARCA</p>
<p>Entidad /Almacén receptor: <input type="text" name="almacen"> Domicilio	<input type="text" name="domicilio">.				 
<p>Ubicación Física en el Almacén: <input type="text" name="ubicacion"> Nro. de Estante <input type="text" name="estante" maxlength="8" size="8">Nro. de Nivel <input type="text" name="nivel" maxlength="8" size="8"></p>
<p>Descripción del Embalaje utilizado en el almacenamiento <input type="text" name="descripcion"></p>	
<p>Ubicación en caja de valores del almacén <input type="text" name="ubic_caja"></p>						
<h2>DATOS DEL BIEN \ ELEMENTO MATERIAL \ INCAUTADO \ SECUESTRADO</h2>
<p>Autoridad que ordena internamiento: <input type="text" name="autoridad"></p>
<p>Fiscalía: <input type="text" name="fiscalia"></p>
<p>Juzgado: <input type="text" name="juzgado"> </p>
<p>Delito Investigado: <input type="text" name="delito"> Presunto Autor: <input type="text" name="autor"> Agraviado: <input type="text" name="agraviado"></p>
<p>Lugar de origen de la Incautación: <input type="text" name="origen"> Distrito: <input type="text" name="distrito">  Provincia: <input type="text" name="provincia"> </p>
<p>Tipo de embalaje utilizado: <input type="text" name="embalaje"></p>
<p>Nro. De Serie: <input type="text" name="serie" maxlength="10" size="10"> Marca: <input type="text" name="marca" maxlength="10" size="10"> Año: <input type="text" name="anio" maxlength="4" size="4"> Estado: Malo Color: <input type="text" name="color" maxlength="10" size="10">  Tamaño: <input type="text" name="tamano" maxlength="10" size="10">	Volumen <input type="text" name="volumen" maxlength="10" size="10"> Peso <input type="text" name="peso" maxlength="6" size="6"> Otros	<input type="text" name="otro"></p> 
<p>Naturaleza del bien incautado: Física  <input type="checkbox" name="tipo[]" value="fisica"/> Química  <input type="checkbox" name="tipo[]" value="quimica"/> Orgánica	<input type="checkbox" name="tipo[]" value="organica"/> Biológica  <input type="checkbox" name="tipo[]" value="biologica"/> Otros <input type="text" name="otro_tipo"> Drogas: Especificar Tipo <input type="text" name="drogas"> </p>										 
<h2>RESPONSABLES DE LA CADENA DE CUSTODIA (*)</h2>
<p>Nombre del responsable de la Entrega /DNI  <input type="text" name="resp_entrega"></p>
<p>Nombre del responsable de la Recepción al Almacén/ DNI:  JONATHAN JACOB LAU ZAMORA / 44096655</p>
<p>Nombre de responsable de Custodia en Almacén	<input type="text" name="custodia1"> Fechas de cambio de custodia <input type="text" name="fecha2" value="<?php echo $fecha; ?>" maxlength="10" size="10"> </p>	
<p>Nombre de responsable de Custodia en Almacén	<input type="text" name="custodia2"> Fechas de cambio de custodia <input type="text" name="fecha3" value="<?php echo $fecha; ?>" maxlength="10" size="10"></p>	 
<p>OBSERVACIONES:   </p>
<textarea class="form-control" rows="3" placeholder='De existir alguna observacion adicional ingresarlo aqui' name="obs2"></textarea>
					
					<div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
						<input type="reset" name="Borrar" value="Borrar" class="btn btn-primary">
						<input type="submit" name="Registrar" value="Registrar" class="btn btn-success">
                      </div>
                    </div>
					
				  </div>
              </div>
            </div>
			  </form>
                </div>
              </div>
              <!-- footer content -->
              <footer>
                <div class="copyright-info">
                  <p class="pull-right">Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                  </p>
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
