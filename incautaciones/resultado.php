<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Custodias</title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">


  <script src="js/jquery.min.js"></script>


        <script src="../assets/js/ie8-responsive-file-warning.js"></script>


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        
</head>


<body class="">
<?php include("conect.php");
$link=conect();
$link2=conect();
$fecha1=explode("/",$_POST['fecha1']);
$fechai=$fecha1[2]."/".$fecha1[1]."/".$fecha1[0];
$fecha2=explode("/",$_POST['fecha2']);
$fechaf=$fecha2[2]."/".$fecha2[1]."/".$fecha2[0];
date_default_timezone_set("America/Lima");
$fecha= date('Y-m-d');
	$hoy= date('Y-m-d');?>
  <div class="container body">


    <div class="main_container">

      <!-- page content -->
      <div class="right_col" role="main">

        <div class="">

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_content">

                  <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                      <div class="col-xs-12 invoice-header">
                
                                  <center>REGISTRO DE INGRESO DE BIENES INCAUTADOS</center>
                                   
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                      <div class="">
                        <center>RESOLUCIÓN N° 729-20016-MP-FN</center>
                      </div>

                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                      <div class="col-xs-12 table">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                      <tr>
						  <th rowspan="2"><font size="-2">NRO</font></th>
						<th rowspan="2"><font size="-2">DF</font></th>
                        <th rowspan="2"><font size="-2">INTERNAM</font></th>
                        <th rowspan="2"><font size="-2">BOLETA</font></th>
                        <th rowspan="2"><font size="-2">C.F.</font></th>
                        <th rowspan="2"><font size="-2">DESCRIPCION</font></th>
                        <th rowspan="2"><font size="-2">MARCA</font></th>
                        <th rowspan="2"><font size="-2">SERIE</font></th>
						<th rowspan="2"><font size="-2">ESTADO</font></th>
                        <th rowspan="2"><font size="-2">FISCALIA</font></th>
                        <th rowspan="2"><font size="-2">FISCAL</font></th>
						<th rowspan="2"><font size="-2">DELITO</font></th>
						<th rowspan="2"><font size="-2">DIA</font></th>
                        <th rowspan="2"><font size="-2">ALMAC.</font></th>
                        <th rowspan="2"><font size="-2">RESTAN</font></th>
						<th colspan="2"><font size="-2">SITUACION FINAL</font></th>
                      </tr>
                     <tr>
						<th><font size="-2">TIPO</font></th>
                        <th><font size="-2">CONDICION</font></th>
                      </tr>
                    </thead>
					<tbody>

<?php $i=0;
$sSQL = "SELECT * FROM inventario where f_ingreso BETWEEN '$fechai' and '$fechaf' order by(id)";
$result = mysqli_query($link,$sSQL);
while($row = mysqli_fetch_array($result)) { 
						$i++;?>
                      <tr>
	                    <td><?php echo $i;?></td>
                        <td>Caj.</td>
                        <td><?php echo '<font size="-2">'.$row["f_ingreso"].'</font>';?></td>
                        <td><?php echo '<font size="-2">'.$row["b_ingreso"].'</font>';?></td>
                        <td><?php echo '<font size="-2">'.$row["caso"].'</font>';?></td>
                        <td><?php echo '<font size="-2">'.$row["descripcion"].'</font>';?></td>
						<td><?php echo '<font size="-2">'.$row["marca"].'</font>';?></td>
                        <td><?php echo '<font size="-2">'.$row["serie"].'</font>';?></td>
                        <td><?php echo '<font size="-2">'.$row["estado"].'</font>';?></td>
                        <td><?php echo '<font size="-2">'.$row["fiscalia"].'</font>';?></td>
                        <td><?php echo '<font size="-2">'.$row["fiscal"].'</font>';?></td>
                        <td><?php echo '<font size="-2">'.$row["delito"].'</font>';?></td>
						<td><?php echo '<font size="-2">'.$hoy.'</font>';?></td>
<?php
	$datetime2 = $row["f_ingreso"];
	$datetime1 = $fecha;
	$diff = (abs(strtotime($datetime1) - strtotime($datetime2)))/(3600*24);
?>					
						<td><?php echo '<font size="-2">'.$diff.'</font>';?></td>
                        <td><?php echo 180-$diff.' dias'?></td>
                        <td><?php echo '<font size="-2">'.$row["elem_bien"].'</font>';?></td>
                        <td><?php echo '<font size="-2">'.$row["condicion"].'</font>';?></td>
					  <?php
						}?>
						</tbody>
                  </table>
                      </div>
                      <!-- /.col -->
                    </div>

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                      <div class="col-xs-12">
                        <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                        <A href="home.php"><button class="btn btn-dark"><i class="fa fa-credit-card"></i> Regresar INICIO</button></a>
                        <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
                      </div>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>

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

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
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
