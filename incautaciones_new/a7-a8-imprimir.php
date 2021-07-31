<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Formato A7 y A8 | MP-FN</title>

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
	
<script language="Javascript">
	function imprSelec(nombre) {
	  var ficha = document.getElementById(nombre);
	  var ventimp = window.open(' ', 'popimpr');
	  ventimp.document.write( ficha.innerHTML );
	  ventimp.document.close();
	  ventimp.print( );
	  ventimp.close();
	}
	</script>
		
<script language="Javascript">
function imprimir(){
  var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
  ventana.document.close();  //cerramos el documento
  ventana.print();  //imprimimos la ventana
  ventana.close();  //cerramos la ventana
}
	</script>
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
                </a>
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
<div id="imprimeme">
                  <div class="col-md-12 col-sm-12 col-xs-12">
					
                    <div class="x_panel">
<?php
include("conect.php");
$id=$_GET["id"];
$caso=$_GET["caso"];
$link=conect();
$link1=conect();
$link2=conect();
?>
                      <div class="x_title">
                        <h2>FORMATO A7</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
          <div class="row top_tiles" style="margin: 10px 0;">
			  		<table id="datatable-buttons" class="table table-striped">
                      <tr>
						  <th><img src="estampa.png" alt="Sin Foto" style="width:65px;"/></th>
						  <th><h2>CODIGO UNICO DE CARPETA FISCAL</h2><h2>DISTRITO JUDICIAL</h2></th>
						  <th><h2>CASO: <?php echo $caso ?></h2><h3>CAJAMARCA</h3></th>
						  <th><h2>PRIORIDAD:</h2><h3></h3></th>	
                      </tr>
					</table>
          </div>
						<br>
						<br>
						  <center><b>CADENA DE CUSTODIA (*)</b></center>
                        <table class="table" cellspacing="1" width="100%">
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
<br>
<br>
<br>
						  <center><b>REGISTRO DE CONTINUIDAD DE CUSTODIA DE ELEMENTOS MATERIALES, EVIDENCIAS Y BIENES INCAUTADOS (*)</b></center>
						  <br>
                        <table class="table">
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
							  <th>FIRMA</th>
                              <th>OBSERV</th>
                            </tr>
                          </thead>
							<tbody>
<?php $sSQL1 = "SELECT * FROM detalle_2_a7 where id=$id order by(registro_recibe)";
$result1 = mysqli_query($link1,$sSQL1);
while($row1 = mysqli_fetch_array($result1)) { 
?>
                          
                            <tr>
                              <td><?php echo $row1["fecha_recibe"];?></td>
                        	  <td><?php echo $row1["hora_recibe"];?></td>
							  <td><?php echo $row1["nombre_recibe"];?></td>
                        	  <td><?php echo $row1["dni_recibe"];?></td>
                        	  <td><?php echo $row1["cargo_recibe"];?></td>
                              <td><?php echo $row1["codigo_recibe"];?></td>
                        	  <td><?php echo $row1["proposito_recibe"];?></td>
							  <td><?php echo $row1["autoridad_recibe"];?></td>
							  <td></td>
                        	  <td><?php echo $row1["obs_recibe"];?></td>
                            </tr>
<?php
}
?>
                          </tbody>
                        </table>

                        <p class="text-muted font-13 m-b-30">
                          <i class="red">IMPORTANTE:</i> <b>Este formato de custodia debe permanecer con el bien <u><i class="red">incaudato</i></u>.</b>
                        </p>
                      </div>
                    </div>
                  </div>
</div>
        			<div class="row no-print">
                      <div class="col-xs-12">
						<button class="btn btn-default" onclick="imprimir();"><i class="fa fa-print"></i> Imprimir Formato A7</button>
                      </div>
                    </div>
						
<div id="seleccion">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>FORMATO A8</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
          <div class="row top_tiles" style="margin: 10px 0;">
			  		<table id="datatable-buttons" class="table table-striped" width="100%">
                      <tr>
						  <th><img src="estampa.png" alt="Sin Foto" style="width:65px;"/></th>
						  <th><h4>CODIGO UNICO DE CARPETA FISCAL</h4><h4>DISTRITO JUDICIAL</h4></th>
						  <th><h4>CASO: <?php echo $caso ?></h2><h3>CAJAMARCA</h4></th>
						  <th><h4>PRIORIDAD:</h4><h3></h3></th>	
                      </tr>
					</table>
          </div>
<br><br>
<?php $sSQL2 = "SELECT * FROM formato_a8 where id=$id";
$result2 = mysqli_query($link1,$sSQL2);
while($row2 = mysqli_fetch_array($result2)) { 
	$caso=$row2["caso"];
?>
					<center><b>REGISTRO DE CADENA DE CUSTODIA EN ALMACÉN DE ELEMENTOS MATERIALES, EVIDENCIAS Y BIENES INCAUTADOS</b></center>
					<center><b>FORMATO A - 8</b></center>
					<center>Nº. DE REGISTRO / CÓDIGO ÚNICO DE CASO N° <?php echo $row2["caso"];?></center>      
					<center>Nº  DE BOLETA  DE INTERNAMIENTO</center>

<h2><u>DATOS  GENERALES DEL ALMACÉN</u></h2>
<p>Distrito Judicial   CAJAMARCA	Provincia 	CAJAMARCA	Departamento   CAJAMARCA</p>
<p>Entidad /Almacén receptor: <?php echo $row2["almacen"];?> Domicilio: <?php echo $row2["domicilio"];?>.
<?php $ubicacion=explode("-",$row2["ubicacion"]);?>
<p>Ubicación Física en el Almacén:  <?php echo $ubicacion[0];?> Nro. de Estante  <?php echo $ubicacion[1];;?> Nro. de Nivel  <?php echo $ubicacion[2];;?></p>
<?php $descripcion=explode("-",$row2["descripcion"]);?>
<p>Descripción del Embalaje utilizado en el almacenamiento: <?php echo $descripcion[0];?></p>	
<p>Ubicación en caja de valores del almacén: <?php echo $descripcion[1];?></p>						
<h2><u>DATOS DEL BIEN \ ELEMENTO MATERIAL \ INCAUTADO \ SECUESTRADO</u></h2>
<?php $aut_fis_juz=explode("-",$row2["autoridad"]);?>
<p>Autoridad que ordena internamiento: <?php echo $aut_fis_juz[0];?></p>
<p>Fiscalía:  <?php echo $aut_fis_juz[1];?></p>
<p>Juzgado:  <?php echo $aut_fis_juz[2];?></p>
<p>Delito Investigado:  <?php echo $row2["delito"];?> Presunto Autor:  <?php echo $row2["autor"];?> Agraviado:  <?php echo $row2["agraviado"];?></p>
<?php $origen=explode("-",$row2["origen"]);?>
<p>Lugar de origen de la Incautación: <?php echo $origen[0];?> Distrito: <?php echo $origen[1];?>  Provincia: <?php echo $origen[2];?></p>
<p>Tipo de embalaje utilizado: <?php echo $row2["embalaje"];?></p>
<?php $caracteristicas=explode("-",$row2["caracteristicas"]);?>
<p>Nro. De Serie: <?php echo $caracteristicas[0];?> Marca: <?php echo $caracteristicas[1];?> Año: <?php echo $caracteristicas[2];?> Estado: Malo Color: <?php echo $caracteristicas[3];?>  Tamaño: <?php echo $caracteristicas[4];?> Volumen: <?php echo $caracteristicas[5];?> Peso: <?php echo $caracteristicas[6];?> Otros: <?php echo $caracteristicas[7];?></p> 
<p>Naturaleza del bien incautado: <?php echo $row2["naturaleza"];?>.										 
<h2><u>RESPONSABLES DE LA CADENA DE CUSTODIA (*)</u></h2>
<p>Nombre del responsable de la Entrega /DNI:  <?php echo $row2["responsable_ent"];?></p>
<p>Nombre del responsable de la Recepción al Almacén/ DNI:  JONATHAN JACOB LAU ZAMORA / 44096655</p>
<p>Nombre de responsable de Custodia en Almacén: <?php echo $row2["custodia1"];?> Fechas de cambio de custodia: <?php echo $row2["fecha1"];?></p>	
<p>Nombre de responsable de Custodia en Almacén: <?php echo $row2["custodia2"];?> Fechas de cambio de custodia:  <?php echo $row2["fecha2"];?></p>	 
<p>OBSERVACIONES:   </p>
<p><?php echo $row2["observ"];?></p>
<?php
}
?>					
					<div class="ln_solid"></div>
				  </div>
              </div>

            </div>
</div>
        			<div class="row no-print">
                      <div class="col-xs-12">
						<a href="javascript:imprSelec('seleccion')" class="btn btn-default"><i class="fa fa-print"></i> Imprimir Formato A8</a>
                      </div>
                    </div>
			</div>
              </div>

              <!-- footer content -->
              <footer>
                <div class="copyright-info">
                  <p class="pull-right"><button class="btn btn-default btn-danger" onclick="window.print();"><i class="fa fa-print"></i> IMPRIMIR TODO</button></p>
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
