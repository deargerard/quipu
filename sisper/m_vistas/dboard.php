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
        <div class="col-md-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php
              $ccu=mysqli_query($cone,"SELECT count(e.idEmpleado) AS NC FROM empleado AS e INNER JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado WHERE idEstadoCar=1 AND date_format(FechaNac, '%m') = date_format(now(), '%m') ");
              $rcu=mysqli_fetch_assoc($ccu);
              ?>
              <h3><?php echo $rcu['NC'] ?></h3>
              <?php mysqli_free_result($ccu) ?>
              <p>Cumples en <?php echo nombremes(@date(m)) ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-birthday-cake"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-3 col-xs-6">
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
        <div class="col-md-3 col-xs-6">
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
        <div class="col-md-3 col-xs-6">
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
        <?php
        $idem=$_SESSION['identi'];
        //votos por distrito
        //$q="SELECT ec.idEmpleado FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadocargo=cd.idEmpleadocargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN dependencialocal dl ON d.idDependencia=dl.idDependencia INNER JOIN local l ON dl.idLocal=l.idLocal WHERE ec.idEmpleado=$idem AND ec.idEstadoCar=1 AND cd.Estado=1 AND l.idDistrito=561 AND (c.idSistemaLab=1 OR c.idSistemaLab=3);";
        $q="SELECT idEmpleado FROM empleado WHERE idEmpleado=$idem AND elector=1;";
        //echo $q;
      $cel=mysqli_query($cone, $q);
      if (mysqli_num_rows($cel)>0) {
      
        $ce=mysqli_query($cone, "SELECT * FROM elecciones WHERE estado=1 AND (now() BETWEEN inicio AND fin);");
        if(mysqli_num_rows($ce)>0){
          while($re=mysqli_fetch_assoc($ce)){
            $id=$re['id'];
            

            
        ?>
        <div class="col-md-12">
          <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title text-orange"><i class="fa fa-archive"></i> <?php echo $re['nombre'] ?></h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
              <?php
              $cv=mysqli_query($cone, "SELECT * FROM eleccione_empleado WHERE eleccione_id=$id AND empleado_id=$idem;");
              if(mysqli_num_rows($cv)>0){
                echo mensajesu("Ya emitió su voto.");
              }else{
              ?>
                <div class="row" id="relecciones<?php echo $id ?>">
                  
                    <form id="f_elecciones<?php echo $id ?>">

                      <input type="hidden" name="eleccione_id" value="<?php echo $id ?>">

                    <?php
                      $cl=mysqli_query($cone, "SELECT * FROM listas WHERE eleccione_id=$id;");
                      if(mysqli_num_rows($cl)>0){
                        while($rl=mysqli_fetch_assoc($cl)){
                    ?>
                        <div class="col-md-6 col-xs-12">
                          <div style="border: 1px solid #CCC; border-radius: 10px;">
                          <table class="table table-hover text-center">
                            <thead>
                            <tr>
                              <th class="text-center text-maroon"><h3 style="text-transform: uppercase;"><?php echo $rl['nombre'] ?></h3></th>
                            </tr>
                            </thead>
                            <tr>
                              <td class="text-muted"><?php echo html_entity_decode($rl['descripcion']) ?></td>
                            </tr>
                            <tr>
                              <td>
                                <div class="radio">
                                  <label>
                                    <input type="radio" name="ele<?php echo $id ?>" value="<?php echo $rl['id'] ?>">
                                    Marque aquí
                                  </label>
                                </div>
                              </td>
                            </tr>
                          </table>
                          </div>
                        </div>
                        
                    <?php
                        }
                    ?>
                    <div class="col-xs-12 text-center" style="margin-top: 10px;">
                      <button type="submit" class="btn btn-primary" id="b_votar<?php echo $id ?>">Votar</button>
                    </div>
                    <?php
                      }else{
                        echo mensajewa("No hay listas");
                      }
                      mysqli_free_result($cl);
                    ?>
                      
                    </form>
                      <div class="col-xs-12 text-center" id="r_votos<?php echo $id ?>">

                      </div>
                  
                </div>
              <?php
              }
              mysqli_free_result($cv);
              ?>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <?php
            
          }
        }
        mysqli_free_result($ce);
      }
        ?>
        <div class="col-md-6">



          <!-- Default box -->
          <!-- <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title text-yellow"><i class="fa fa-clock-o"></i> Horas por recuperar</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body chat">
                  <p class="text-center text-muted">Calculando...</p>
                  <img src="https://st3.depositphotos.com/1010613/32105/i/600/depositphotos_321053042-stock-photo-close-up-of-businessmans-hands.jpg" class="img-responsive img-rounded">
                  <br>
              </div>
          </div> -->
          <!-- /.box -->





           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title text-aqua"><i class="fa fa-birthday-cake"></i> Cumples en <?php echo nombremes(@date('m')) ?></h3>

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
          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title text-red"><i class="fa fa-pie-chart"></i> Personal por condición laboral</h3>

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
                    <canvas id="pieChartcl" style="height:250px"></canvas>
                  </div>
                </div>
                <div class="col-md-5">
                  <ul class="chart-legend clearfix">
                    <?php
                      $cg=mysqli_query($cone,"SELECT Tipo, count(*) AS cant FROM empleadocargo AS e INNER JOIN condicionlab AS cl ON e.idCondicionLab=cl.idCondicionLab Where idEstadoCar=1 group by Tipo");
                      $b=0;
                      $t=0;
                      $par = "";
                      while($rg=mysqli_fetch_assoc($cg)){
                        $col1=colorc($b);
                        $col2=colort($b);
                        $b++;
                        $t=$t+$rg['cant'];
                        $parcl.='{value: '.$rg['cant'].', color: "'.$col1.'", highlight: "'.$col1.'", label: "'.$rg['Tipo'].'"},'."\n";
                    ?>
                    <li><i class="fa fa-circle-o <?php echo $col2; ?>"></i> <?php echo $rg['Tipo']." (".$rg['cant'].")"; ?></li>
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
                $cg=mysqli_query($cone,"SELECT Tipo, count(*) AS cant FROM empleadocargo AS e INNER JOIN condicionlab AS cl ON e.idCondicionLab=cl.idCondicionLab Where idEstadoCar=1 group by Tipo");
                $b=0;
                while($rg=mysqli_fetch_assoc($cg)){
                  $col2=colort($b);
                  $b++;
                ?>
                <li><a href="#"><?php echo $rg['Tipo']; ?>
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
        <div class="col-md-6">
          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title text-red"><i class="fa fa-pie-chart"></i> Personal por sistema laboral</h3>

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
          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title text-red"><i class="fa fa-pie-chart"></i> Personal por sexo</h3>

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
                    <canvas id="pieCharts" style="height:250px"></canvas>
                  </div>
                </div>
                <div class="col-md-5">
                  <ul class="chart-legend clearfix">
                    <?php
                      $cg=mysqli_query($cone,"SELECT Sexo, count(*) AS cant FROM empleadocargo AS e INNER JOIN empleado AS em ON e.idEmpleado=em.idEmpleado Where idEstadoCar=1 group by Sexo");
                      $b=0;
                      $t=0;
                      $pars = "";
                      while($rg=mysqli_fetch_assoc($cg)){
                        $nsex=$rg['Sexo']=="M" ? "Masculino" : "Femenino";
                        $col1=colorc($b);
                        $col2=colort($b);
                        $b++;
                        $t=$t+$rg['cant'];
                        $pars.='{value: '.$rg['cant'].', color: "'.$col1.'", highlight: "'.$col1.'", label: "'.$nsex.'"},'."\n";
                    ?>
                    <li><i class="fa fa-circle-o <?php echo $col2; ?>"></i> <?php echo $nsex." (".$rg['cant'].")"; ?></li>
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
                $cg=mysqli_query($cone,"SELECT Sexo, count(*) AS cant FROM empleadocargo AS e INNER JOIN empleado AS em ON e.idEmpleado=em.idEmpleado Where idEstadoCar=1 group by Sexo");
                $b=0;
                while($rg=mysqli_fetch_assoc($cg)){
                  $nsex=$rg['Sexo']=="M" ? "Masculino" : "Femenino";
                  $col2=colort($b);
                  $b++;
                ?>
                <li><a href="#"><?php echo $nsex; ?>
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
    var pieChartCanvas = $("#pieChartcl").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = ['.$parcl.'];
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

  $sc.='<script>
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

  $sc.='<script>
    var pieChartCanvas = $("#pieCharts").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = ['.$pars.'];
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