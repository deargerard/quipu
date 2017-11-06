<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(escoordinador($cone,$_SESSION['identi'])){
?>
    <!-- Cabecera -->
    <section class="content-header">
      <h1>
      Programación de Vacaciones
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Vacaciones</li>
        <li class="active">Programación</li>
      </ol>
    </section>
    <!-- /.Cabecera -->
    <section class="content" id="r_provacacionesc">



        <div class="row">
          <div class="col-md-12">
            <div class="box box-solid">
              <div class="box-header with-border">

              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="box-group" id="accordion">
                <?php
                  $ide=$_SESSION['identi'];
                  $cco=mysqli_query($cone,"SELECT idCoordinacion FROM coordinador WHERE idEmpleado=$ide AND Condicion!=0;");
                  $c=0;
                  while($rco=mysqli_fetch_assoc($cco)){
                    $idcoo=$rco['idCoordinacion'];
                    $ccoo=mysqli_query($cone,"SELECT Denominacion FROM coordinacion WHERE idCoordinacion=$idcoo");
                    if($rcoo=mysqli_fetch_assoc($ccoo)){
                      $c++;
                      $csv=mysqli_query($cone,"SELECT e.NumeroDoc, e.idEmpleado, ec.idEmpleadoCargo FROM dependencia d INNER JOIN cardependencia cd ON d.idDependencia=cd.idDependencia INNER JOIN empleadocargo ec ON cd.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN cargo ca ON ec.idCargo=ca.idCargo INNER JOIN sistemalab sl ON ca.idSistemaLab=sl.idSistemaLab WHERE cd.Estado=1 AND d.idCoordinacion=$idcoo AND ec.idEstadoCar=1 AND (d.Observacion!='e' OR sl.SistemaLab!='FISCAL') AND (ec.idCargo!=32 AND ec.idCargo!=34) ORDER BY e.ApellidoPat ASC, e.ApellidoMat ASC;");

                ?>
                  <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                  <div class="panel box box-info">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $c; ?>">
                          <i class="fa fa-location-arrow"></i> <?php echo $rcoo['Denominacion']; ?>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse<?php echo $c; ?>" class="panel-collapse collapse <?php echo $c==1 ? "in" : ""; ?>">
                      <div class="box-body">
                        <?php
                        if(!enviopv($cone, $idcoo)){

                          if (mysqli_num_rows($csv)>0) {

                        ?>
                            <table class="table table-bordered table-hover" id="dtableprova" > <!--Tabla que Lista las vacaciones-->
                              <thead>
                                <tr>
                                  <th>DNI</th>
                                  <th>EMPLEADO</th>
                                  <th>CARGO</th>
                                  <th>DEPENDENCIA</th>
                                  <th>DÍAS</th>
                                  <th>INICIA</th>
                                  <th>TERMINA</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $dt=0;
                                while($rsv=mysqli_fetch_assoc($csv)){

                                  $idec=$rsv['idEmpleadoCargo'];


                                  $qvac=mysqli_query($cone,"SELECT pv.idProVacaciones, pv.FechaIni, pv.FechaFin, pva.idPeriodoVacacional, pv.estado FROM provacaciones pv INNER JOIN periodovacacional pva ON pv.idPeriodoVacacional=pva.idPeriodoVacacional WHERE pv.idEmpleadoCargo=$idec AND pv.Estado=6;");
                                  if(mysqli_num_rows($qvac)>0){
                                    $nd=0;
                                    while($rpvac=mysqli_fetch_assoc($qvac)){
                                      $dt=intervalo ($rpvac['FechaFin'], $rpvac['FechaIni']);
                                      $pervac=$rpvac['idPeriodoVacacional'];
                                      include("m_inclusiones/a_vacaciones/a_ofechas.php");
                                ?>


                                  <tr> <!--Fila de vacaciones-->
                                    <td style="font-size:12px; "><?php echo $rsv['NumeroDoc']?></td> <!--columna DNI-->
                                    <td style="font-size:12px;"><?php echo nomempleado($cone,$rsv['idEmpleado']); ?></td> <!--columna EMPLEADO-->
                                    <td style="font-size:12px;"><?php echo cargoe($cone,$rsv['idEmpleado']) ?></td> <!--columna CARGO-->
                                    <td style="font-size:11px;"><?php echo dependenciae($cone,$rsv['idEmpleado']) ?></td> <!--DEPENDENCIA-->
                                    <td style="font-size:13px;"><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
                                    <td style="font-size:13px;" class="warning"><?php echo "<span class='hidden'>".$rpvac['FechaIni']."</span> ".fnormal($rpvac['FechaIni'])?></td> <!--columna INICIO-->
                                    <td style="font-size:13px;" class="warning"><?php echo fnormal($rpvac['FechaFin'])?></td> <!--columna FIN-->
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#m_editarprogramacionc"><i class="fa fa-pencil" onclick="ediproc(<?php echo $rpvac['idProVacaciones'].", '".$fii."', '".$ffi."', '".$fff."'" ?>)"></i></a>
                                    </td> <!--columna EDITAR-->
                                  </tr>


                                <?php
                                      $nd=$nd+$dt;
                                    }
                                    if($nd!=30){
                                      $dif=30-$nd;
                                ?>
                                  <tr> <!--Fila de vacaciones-->
                                    <td style="font-size:12px; "><?php echo $rsv['NumeroDoc']?></td> <!--columna DNI-->
                                    <td style="font-size:12px;"><?php echo nomempleado($cone,$rsv['idEmpleado']); ?></td> <!--columna EMPLEADO-->
                                    <td style="font-size:12px;"><?php echo cargoe($cone,$rsv['idEmpleado']) ?></td> <!--columna CARGO-->
                                    <td style="font-size:11px;"><?php echo dependenciae($cone,$rsv['idEmpleado']) ?></td> <!--DEPENDENCIA-->
                                    <td style="font-size:13px;">0</td> <!--columna CAMTIDAD DE DIAS-->
                                    <td style="font-size:13px;" class="danger" colspan="2">NO PROGRAMÓ <?php echo $dif; ?> DÍAS</td> <!--columna INICIO-->
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#m_programarvacacionesc"><i class="fa fa-plus" onclick="provacc(<?php echo $idec.",".$pervac.",'".$fii."', '".$ffi."',".$dif ?>)"></i></a>
                                    </td> <!--columna EDITAR-->
                                  </tr>
                                <?php
                                    }
                                  }else{
                                      $hoy = date("Y");
                                      $anos= $hoy + 1;
                                      $pv = trim($hoy." - ".$anos);
                                      $cpev=mysqli_query($cone,"SELECT idPeriodoVacacional FROM periodovacacional WHERE PeriodoVacacional='$pv'");
                                      if($rpev=mysqli_fetch_assoc($cpev)){
                                        $pervac=$rpev['idPeriodoVacacional'];
                                        include("m_inclusiones/a_vacaciones/a_ofechas.php");
                                ?>


                                  <tr> <!--Fila de vacaciones-->
                                    <td style="font-size:12px; "><?php echo $rsv['NumeroDoc']?></td> <!--columna DNI-->
                                    <td style="font-size:12px;"><?php echo nomempleado($cone,$rsv['idEmpleado']); ?></td> <!--columna EMPLEADO-->
                                    <td style="font-size:12px;"><?php echo cargoe($cone,$rsv['idEmpleado']) ?></td> <!--columna CARGO-->
                                    <td style="font-size:11px;"><?php echo dependenciae($cone,$rsv['idEmpleado']) ?></td> <!--DEPENDENCIA-->
                                    <td style="font-size:13px;">0</td> <!--columna CAMTIDAD DE DIAS-->
                                    <td style="font-size:13px;" class="danger" colspan="2">NO PROGRAMÓ</td> <!--columna INICIO-->
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#m_programarvacacionesc"><i class="fa fa-plus" onclick="provacc(<?php echo $idec.",".$pervac.",'".$fii."', '".$ffi."',30" ?>)"></i></a>
                                    </td> <!--columna EDITAR-->
                                  </tr>

                                <?php
                                      }

                                  }


                                ?>

                              <?php
                                }
                               ?>
                             </tbody>
                            </table>
                        <?php
                          }
                        ?>
                        <div class="col-sm-12">
                          <br>
                          <button id="b_envpro" class="btn btn-info" data-toggle="modal" data-target="#m_envprovacc" onclick="envprovacc(<?php echo $idcoo; ?>)">Aceptar y Enviar</button>
                        </div>
                        <?php
                        }else{
                        ?>
                        <div class="col-sm-12">
                          <p class="text-olive"><i class="fa fa-check-square"></i> Ya envió su programación de vacaciones.</p>
                          <a class="btn btn-info" href="pdf/exppdf/provaccoo.php?c=<?php echo $idcoo; ?>" target="_blank">Imprimir programación</a>
                        </div>
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                <?php
                    }
                  }
                ?>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>








    </section>

<!--Modal Nuevas programacion-->
<div class="modal fade" id="m_programarvacacionesc" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_provacaciones" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Programación de Oficio</h4>
      </div>
      <div class="modal-body" id="r_provacaciones">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gpvac">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Nueva programacion-->
<!--Modal editar programacion-->
<div class="modal fade" id="m_editarprogramacionc" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_ediprogramacion" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Vacaciones <?php echo $pv ?></h4>
      </div>
      <div class="modal-body" id="r_ediprogramacion">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gepro">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal editar programacion-->
<!--Modal Envio programacion-->
<div class="modal fade" id="m_envprovacc" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_provacaciones" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Aprobar y enviar vacaciones</h4>
      </div>
      <div class="modal-body" id="r_envprovacc">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin ModalEnvio programacion-->


<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
