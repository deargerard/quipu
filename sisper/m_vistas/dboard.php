<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],1) || accesocon($cone,$_SESSION['identi'],9)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Inicio
        <small>Información</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-home"></i> Inicio</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
            <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php
              $ccu=mysqli_query($cone,"SELECT count(e.idEmpleado) AS NC FROM empleado AS e INNER JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado WHERE idEstadoCar!=3 AND date_format(FechaNac, '%m') = date_format(now(), '%m') ");
              $rcu=mysqli_fetch_assoc($ccu);
              ?>
              <h3><?php echo $rcu['NC'] ?></h3>
              <?php mysqli_free_result($ccu) ?>
              <p>Cumpleaños en <?php echo nombremes(@date(m)) ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-birthday-cake"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php
              $cea=mysqli_query($cone,"SELECT count(idEstadoCar) AS UA FROM empleadocargo WHERE idEstadoCar=1");
              $rea=mysqli_fetch_assoc($cea);
              ?>
              <h3><?php echo $rea['UA'] ?></h3>
              <?php mysqli_free_result($cea) ?>
              <p>Colaboradores activos</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php
              $cda=mysqli_query($cone,"SELECT count(Estado) AS DA FROM dependencia WHERE Estado=1");
              $rda=mysqli_fetch_assoc($cda);
              ?>
              <h3><?php echo $rda['DA'] ?></h3>
              <?php mysqli_free_result($cda) ?>
              <p>Dependencias activas</p>
            </div>
            <div class="icon">
              <i class="fa fa-university"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <?php
              $cla=mysqli_query($cone,"SELECT count(Estado) AS LA FROM local WHERE Estado=1");
              $rla=mysqli_fetch_assoc($cla);
              ?>
              <h3><?php echo $rla['LA'] ?></h3>
              <?php mysqli_free_result($cla) ?>
              <p>Locales</p>
            </div>
            <div class="icon">
              <i class="fa fa-building"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-6">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-birthday-cake"></i> Cumpleañer@s de <?php echo nombremes(@date(m)) ?></h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body chat" id="cumples">
                
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>CUMPLEAÑER@</th>
                      <th>DÍA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ccum=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres, date_format(FechaNac, '%d') AS FEC FROM empleado AS e INNER JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado WHERE idEstadoCar=1 AND date_format(FechaNac, '%m') = date_format(now(), '%m') ORDER BY FEC, ApellidoPat ASC");
                    $n=0;
                    $dia=@date(d);

                    if(mysqli_num_rows($ccum)>0){
                    while($rcum=mysqli_fetch_assoc($ccum)){
                      $n++;
                      if($rcum['FEC']==$dia){
                        $nom='<span class="text text-maroon"><i class="fa fa-birthday-cake"></i></span> <span class="text text-maroon">'.$rcum['ApellidoPat']." ".$rcum['ApellidoMat'].", ".$rcum['Nombres'].'</span>';
                      }else{
                         $nom=$rcum['ApellidoPat']." ".$rcum['ApellidoMat'].", ".$rcum['Nombres'];
                      }
                    ?>
                    <tr>
                      <td><?php echo $n ?></td>
                      <td><?php echo $nom ?></td>
                      <td><?php echo $rcum['FEC'] ?></td>
                    </tr>
                    <?php
                    }
                    }else{
                    ?>
                      <h4 class="text-maroon">No existen cumpleaños para este mes.</h4>
                    <?php
                    }
                    mysqli_free_result($ccum);
                    ?>
                  </tbody>
                </table>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
              </div>
              <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-6">
          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-pie-chart"></i> Personal por sistema laboral</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-7">
                  <div class="chart-responsive">
                    <canvas id="pieChart" style="height:250px"></canvas>
                  </div>
                </div>
                <div class="col-md-5">
                  <ul class="chart-legend clearfix">
                    <?php
                      $cg=mysqli_query($cone,"SELECT SistemaLab, count(*) AS cant FROM empleadocargo AS e INNER JOIN cargo AS ca ON e.idCargo=ca.idCargo INNER JOIN sistemalab AS sl ON ca.idSistemaLab=sl.idSistemaLab Where idEstadoCar=1 group by SistemaLab");
                      $b=0;
                      $t=0;
                      $par = "";
                      while($rg=mysqli_fetch_assoc($cg)){
                        $col1=colorc($b);
                        $col2=colort($b);
                        $b++;
                        $t=$t+$rg['cant'];
                        $par.='{value: '.$rg['cant'].', color: "'.$col1.'", highlight: "'.$col1.'", label: "'.$rg['SistemaLab'].'"},'."\n";
                    ?>
                    <li><i class="fa fa-circle-o <?php echo $col2; ?>"></i> <?php echo $rg['SistemaLab']." (".$rg['cant'].")"; ?></li>
                    <?php
                      }
                      mysqli_free_result($cg);
                    ?>
                    
                  </ul>
                </div>
              </div>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
                <?php
                $cg=mysqli_query($cone,"SELECT SistemaLab, count(*) AS cant FROM empleadocargo AS e INNER JOIN cargo AS ca ON e.idCargo=ca.idCargo INNER JOIN sistemalab AS sl ON ca.idSistemaLab=sl.idSistemaLab Where idEstadoCar=1 group by SistemaLab");
                $b=0;
                while($rg=mysqli_fetch_assoc($cg)){
                  $col2=colort($b);
                  $b++;
                ?>
                <li><a href="#"><?php echo $rg['SistemaLab']; ?>
                  <span class="pull-right <?php echo $col2 ?>"><i class="fa fa-pie-chart"></i> <?php echo round((100*$rg['cant'])/$t,2); ?>%</span>
                </a></li>
                <?php
                }
                mysqli_free_result($cg);
                ?>
              </ul>
            </div>
            <!-- /.footer -->
          </div>
          <!-- /.box -->
          
        </div>
      </div>

    </section>
    <!-- /.content -->
<?php

  $sc='<script>
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = ['.$par.'];
    var pieOptions = {
      segmentShowStroke: true,
      segmentStrokeColor: "#fff",
      segmentStrokeWidth: 2,
      percentageInnerCutout: 50,
      animationSteps: 100,
      animationEasing: "easeOutBounce",
      animateRotate: true,
      animateScale: false,
      responsive: true,
      maintainAspectRatio: true,
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    pieChart.Doughnut(PieData, pieOptions);
    </script>'."\n";
?>
<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>