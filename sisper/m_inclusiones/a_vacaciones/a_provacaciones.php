<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
    if(esResDespacho($cone,$_SESSION['identi'])){
    	$ide=$_SESSION['identi'];
      $pe=date('Y').' - '.(date(Y)+1);
      $cp=mysqli_query($cone, "SELECT idPeriodoVacacional FROM periodovacacional WHERE PeriodoVacacional='$pe';");
      if($rp=mysqli_fetch_assoc($cp)){
        $idpe=$rp['idPeriodoVacacional'];
      }
      mysqli_free_result($cp);
?>

<div class="row">
  <div class="col-md-12">


    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Programación de Vacaciones</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="box-group" id="accordion">
          <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
          <?php
          $a=0;
          $ce=mysqli_query($cone, "SELECT e.idorequipo, e.nombre, d.Denominacion FROM orequipo e INNER JOIN orintegrante i ON e.idorequipo=i.idorequipo INNER JOIN empleadocargo ec ON i.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN dependencia d ON e.idDependencia=d.idDependencia WHERE ec.idEmpleado=$ide AND ec.idEstadoCar=1 AND i.estado=1 AND e.estado=1 ORDER BY e.nombre;");
          if(mysqli_num_rows($ce)>0){
            while($re=mysqli_fetch_assoc($ce)){
              $ideq=$re['idorequipo'];
              $a++;
          ?>
          <div class="panel box" style="border: 1px solid #B0C4DE;">
            <div class="box-header with-border">
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $a; ?>"><i class="fa fa-codepen text-yellow"></i> 
                  <?php echo $re['Denominacion']." (".$re['nombre'].")"; ?>
                </a>
              </h4>
            </div>
            <div id="collapse<?php echo $a; ?>" class="panel-collapse collapse <?php echo $a==1 ? "in" : ""; ?>">
              <div class="box-body">
                <h4 class="text-red"><i class="fa fa-chevron-circle-right text-maroon"></i> Programación <?php echo $pe; ?></h4>
                <?php
                $ci=mysqli_query($cone, "SELECT e.idEmpleado, e.ApellidoPat, e.ApellidoMat, e.Nombres, e.NumeroDoc, ec.idEmpleadoCargo, ec.FechaVac FROM dependencia d INNER JOIN cardependencia cd ON d.idDependencia=cd.idDependencia INNER JOIN empleadocargo ec ON cd.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN cargo ca ON ec.idCargo=ca.idCargo INNER JOIN sistemalab sl ON ca.idSistemaLab=sl.idSistemaLab INNER JOIN orintegrante i ON ec.idEmpleadocargo=i.idEmpleadocargo WHERE i.idorequipo=$ideq AND cd.Estado=1 AND ec.idEstadoCar=1 AND i.estado=1 AND (d.Observacion!='e' OR sl.SistemaLab!='FISCAL') AND (ec.idCargo!=32 AND ec.idCargo!=34 AND ec.idCargo!=37) ORDER BY e.ApellidoPat ASC, e.ApellidoMat ASC;");
                if(mysqli_num_rows($ci)>0){

                ?>
                <table class="table table-bordered table-hover" id="dtable<?php echo $a; ?>" style="font-size: 11px;">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>DNI</th>
                      <th>APELLIDOS Y NOMBRES</th>
                      <th>CARGO</th>
                      <th>DEPENDENCIA</th>
                      <th>INICIA</th>
                      <th>TERMINA</th>
                      <th>DÍAS</th>
                      <th>ESTADO</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                <?php
                  $n=0;
                  $en=false;
                  while($ri=mysqli_fetch_assoc($ci)){
                    $idec=$ri['idEmpleadoCargo'];
                    //Obtenemos la programación
                    $co=mysqli_query($cone, "SELECT * FROM provacaciones WHERE idPeriodoVacacional=$idpe AND idEmpleadoCargo=$idec AND (Estado=6 OR Estado=7) ORDER BY FechaIni ASC;");
                    if(mysqli_num_rows($co)>0){
                      while($ro=mysqli_fetch_assoc($co)){
                        $n++;
                        //calculamos # de días
                        $dt=!is_null($ro['FechaFin']) ? intervalo($ro['FechaFin'], $ro['FechaIni']) : 0;
                ?>
                    <tr>
                      <td><?php echo $n; ?></td>
                      <td><?php echo $ri['NumeroDoc']; ?></td>
                      <td class="text-blue"><?php echo $ri['ApellidoPat'].' '.$ri['ApellidoMat'].' '.$ri['Nombres']; ?></td>
                      <td><?php echo cargoe($cone, $ri['idEmpleado']); ?></td>
                      <td><?php echo dependenciae($cone, $ri['idEmpleado']); ?></td>
                      <td><span class="hide"><?php echo $ro['FechaIni']; ?></span><?php echo fnormal($ro['FechaIni']); ?></td>
                      <td><span class="hide"><?php echo $ro['FechaFin']; ?></span><?php echo fnormal($ro['FechaFin']); ?></td>
                      <td class="warning text-orange"><?php echo $dt; ?></td>
                      <td><?php echo estadoVac($ro['Estado']); ?></td>
                      <td>
                      <?php
                        if($ro['Estado']==6){
                          $en=true;
                          //Calculamos fechas
                          $dnt=caldiant($cone, $idec);
                          $dnt=$dnt%365;
                          $fii=date('Y-').date('m-d',strtotime('+'.$dnt.' day', strtotime($ri['FechaVac'])));
                          $fii=date('Y-m-d', strtotime('+1 year', strtotime($fii)));
                          $ffi=date('Y-m-d', strtotime('+2 year', strtotime($fii)));
                      ?>
                        <a href="#" data-toggle="modal" data-target="#m_editarprogramacionc"><i class="fa fa-pencil" onclick="ediproc(<?php echo $ro['idProVacaciones'].", '".fnormal($fii)."', '".fnormal($ffi)."', '".fnormal($ffi)."', ".$dt ?>)"></i></a>
                      <?php
                        }
                      ?>
                      </td>
                    </tr>
                <?php
                      }
                    }else{
                          $en=true;
                          $n++;
                          //calcular días pendientes de vacaciones
                          $cdp=mysqli_query($cone, "SELECT DATEDIFF(FechaFin, FechaIni) dias FROM provacaciones WHERE idEmpleadoCargo=$idec AND idPeriodoVacacional=$idpe AND Estado!=2;");
                          if(mysqli_num_rows($cdp)>0){
                            $dp=0;
                            while($rdp=mysqli_fetch_assoc($cdp)){
                              $dp=$dp+$rdp['dias']+1;
                            }
                          }
                          mysqli_free_result($cdp);
                ?>
                    <tr>
                      <td><?php echo $n; ?></td>
                      <td><?php echo $ri['NumeroDoc']; ?></td>
                      <td class="text-blue"><?php echo $ri['ApellidoPat'].' '.$ri['ApellidoMat'].' '.$ri['Nombres']; ?></td>
                      <td><?php echo cargoe($cone, $ri['idEmpleado']); ?></td>
                      <td><?php echo dependenciae($cone, $ri['idEmpleado']); ?></td>
                      <td></td>
                      <td></td>
                      <td class="warning text-orange"><?php echo (30-$dp); ?></td>
                      <td></td>
                      <td>
                <?php
                          
                          //Calculamos fechas
                          $dnt=caldiant($cone, $idec);
                          $dnt=$dnt%365;
                          $fii=date('Y-').date('m-d',strtotime('+'.$dnt.' day', strtotime($ri['FechaVac'])));
                          $fii=date('Y-m-d', strtotime('+1 year', strtotime($fii)));
                          $ffi=date('Y-m-d', strtotime('+2 year', strtotime($fii)));
                ?>
                        <a href="#" data-toggle="modal" data-target="#m_programarvacacionesc"><i class="fa fa-plus" onclick="provacc(<?php echo $idec.",".$idpe.",'".fnormal($fii)."', '".fnormal($ffi)."',".(30-$dp) ?>)"></i></a>
                      </td>
                    </tr>
                <?php
                    }
                    mysqli_free_result($co);
                  }
                ?>
                 </tbody>
                </table>
                <div class="col-sm-12 text-center">
                <?php
                  if($en){
                ?>
                    <button id="b_envpro" class="btn bg-maroon" data-toggle="modal" data-target="#m_envprovacc" onclick="envprovacc(<?php echo $ideq.", ".$idpe; ?>)"><i class="fa fa-check-square"></i> Aceptar y Enviar</button>
                <?php
                  }else{
                ?>
                    <a class="btn bg-olive" href="pdf/exppdf/provaccoo.php?c=<?php echo $ideq; ?>&p=<?php echo $idpe; ?>" target="_blank"><i class="fa fa-print"></i> Imprimir programación</a>
                <?php
                  }
                ?>
                </div>
                <script>
                  $("#dtable<?php echo $a; ?>").DataTable();
                </script>
                <?php
                }else{
                  echo mensajewa("Despacho/Área sin personal asignado.");
                }
                mysqli_free_result($ci);
                ?>
                <h4 class="text-red"><i class="fa fa-chevron-circle-right text-maroon"></i> De periodos anteriores <small>(Para validación.)</small></h4>
                <?php
                $cve=mysqli_query($cone,"SELECT e.NumeroDoc, e.idEmpleado, e.ApellidoPat, e.ApellidoMat, e.Nombres, ec.idEmpleadoCargo, pv.FechaIni, pv.FechaFin, pv.Estado, ec.FechaVac FROM dependencia d INNER JOIN cardependencia cd ON d.idDependencia=cd.idDependencia INNER JOIN empleadocargo ec ON cd.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN cargo ca ON ec.idCargo=ca.idCargo INNER JOIN sistemalab sl ON ca.idSistemaLab=sl.idSistemaLab INNER JOIN orintegrante i ON ec.idEmpleadocargo=i.idEmpleadocargo INNER JOIN provacaciones pv ON ec.idEmpleadoCargo=pv.idEmpleadoCargo WHERE i.idorequipo=$ideq AND (pv.Estado=0 OR pv.Estado=3 OR pv.Estado=4) AND cd.Estado=1 AND ec.idEstadoCar=1 AND i.estado=1 AND (d.Observacion!='e' OR sl.SistemaLab!='FISCAL') AND (ec.idCargo!=32 AND ec.idCargo!=34 AND ec.idCargo!=37) ORDER BY e.ApellidoPat ASC, e.ApellidoMat ASC;");
                if(mysqli_num_rows($cve)>0){
                ?>
                  <table class="table table-hover table-bordered" id="dtablep<?php echo $a; ?>" style="font-size: 11px;">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>DNI</th>
                        <th>APELLIDOS Y NOMBRES</th>
                        <th>CARGO</th>
                        <th>DEPENDENCIA</th>
                        <th>INICIA</th>
                        <th>TERMINA</th>
                        <th>DÍAS</th>
                        <th>ESTADO</th>
                      </tr>
                    </thead>
                    <tbody> 
                <?php
                  $w=0;
                  while($rve=mysqli_fetch_assoc($cve)){
                    $w++;
                ?>
                      <tr>
                        <td><?php echo $w; ?></td>
                        <td><?php echo $rve['NumeroDoc']; ?></td>
                        <td class="text-blue"><?php echo $rve['ApellidoPat']." ".$rve['ApellidoMat']." ".$rve['Nombres']; ?></td>
                        <td><?php echo cargoe($cone, $rve['idEmpleado']); ?></td>
                        <td><?php echo dependenciae($cone, $rve['idEmpleado']); ?></td>
                        <td><span class="hide"><?php echo $rve['FechaIni']; ?></span><?php echo fnormal($rve['FechaIni']); ?></td>
                        <td><span class="hide"><?php echo $rve['FechaIni']; ?></span><?php echo fnormal($rve['FechaFin']); ?></td>
                        <td class="warning text-orange"><?php echo intervalo($rve['FechaFin'], $rve['FechaIni']); ?></td>
                        <td><?php echo estadoVac($rve['Estado']); ?></td>
                      </tr>
                <?php
                  }
                ?>
                    </tbody>
                  </table>
                <script>
                  $("#dtablep<?php echo $a; ?>").DataTable();
                </script>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
          <?php
            }
          }
          mysqli_free_result($ce);
          ?>


        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

  </div>
  <!-- /.col -->
</div>

<?php
	}else{
		echo mensajewa("Error, Ud. no es responsable de ningún despacho.");
	}
}else{
	echo mensajeda("Error, Acceso denegado.");
}
?>
