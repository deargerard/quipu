<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],6)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Coordinaciones
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Organizacional</li>
        <li class="active">Coordinación</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"><h4>Coordinación</h4></a></li>
              <li><a href="#tab_2" data-toggle="tab"><h4>Coordinador</h4></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">


                <div class="row">
                  <div class="col-md-12" id="r_blocal">
                      <table id="dtcoordinaciones" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>COORDINACIÓN</th>
                            <th>OFICIAL</th>
                            <th>COORDINADOR</th>
                            <th>ESTADO</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(accesoadm($cone,$_SESSION['identi'],6)){
                              $cdep=mysqli_query($cone,"SELECT idCoordinacion, Denominacion, Oficial, Estado FROM coordinacion ORDER BY Denominacion ASC;");
                            }else{
                              $cdep=mysqli_query($cone,"SELECT idCoordinacion, Denominacion, Oficial, Estado FROM coordinacion WHERE Estado=1 ORDER BY Denominacion ASC;");
                            }
                            while($rdep=mysqli_fetch_assoc($cdep)){
                              $idcoor=$rdep['idCoordinacion'];
                              $c1=mysqli_query($cone,"SELECT idEmpleado FROM coordinador WHERE idCoordinacion=$idcoor AND FecFin='0000-00-00';");
                              $idcoordinador="";
                              if($r1=mysqli_fetch_assoc($c1)){
                                $idcoordinador=$r1['idEmpleado'];
                              }
                          ?>
                          <tr>
                            <td><span class="text-blue"><?php echo $rdep['Denominacion'] ?></span></td>
                            <td><?php echo $rdep['Oficial']==1 ? Si : No ?></td>
                            <td><?php echo $idcoordinador == "" ? '<span class="text-maroon">SIN COORDINADOR</span>' : nomempleado($cone, $idcoordinador); ?></td>
                            <td><?php echo estado($rdep['Estado']) ?></td>
                            <td>
                              <div class="btn-group">
                                <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-cog"></i>&nbsp;
                                  <span class="caret"></span>
                                  <span class="sr-only">Desplegar menú</span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                  <?php
                                  if(accesocon($cone,$_SESSION['identi'],6)){
                                  ?>
                                  <li><a href="#" data-toggle="modal" data-target="#m_detcoordinacion" onclick="detcoordinacion(<?php echo $rdep['idCoordinacion'] ?>)">Detalle</a></li>
                                  <?php
                                  }
                                  if(accesoadm($cone,$_SESSION['identi'],6)){
                                  ?>
                                  <li class="divider"></li>
                                  <li><a href="#" data-toggle="modal" data-target="#m_edicoordinacion" onclick="edicoordinacion(<?php echo $rdep['idCoordinacion'] ?>)">Editar</a></li>
                                  <?php
                                    if($rdep['Estado']==1){
                                  ?>
                                  <li><a href="#" data-toggle="modal" data-target="#m_descoordinacion" onclick="descoordinacion(<?php echo $rdep['idCoordinacion'] ?>)">Desactivar</a></li>
                                  <?php
                                    }else{
                                  ?>
                                  <li><a href="#" data-toggle="modal" data-target="#m_actcoordinacion" onclick="actcoordinacion(<?php echo $rdep['idCoordinacion'] ?>)">Activar</a></li>
                                  <?php
                                    }
                                  }
                                  ?>
                                </ul>
                              </div>
                            </td>
                          </tr>
                          <?php
                            }
                            mysqli_free_result($cdep);
                          ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>COORDINACIÓN</th>
                            <th>OFICIAL</th>
                            <th>COORDINADOR</th>
                            <th>ESTADO</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
                <?php if(accesoadm($cone,$_SESSION['identi'],6)){ ?>
                <div class="row">
                  <div class="col-md-12 col-sm-12 form-group">
                    <button type="button" class="btn btn-info" id="b_nuecoordinacion" data-toggle="modal" data-target="#m_nuecoordinacion"><i class="fa fa-plus"></i> Nuevo</button>
                  </div>
                </div>
                <?php } ?>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <div class="row">
                  <div class="col-md-12" id="r_blocal">
                      <table id="dtcoordinadores" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>COORDINADOR</th>
                            <th>COORDINACIÓN</th>
                            <th>CONDICIÓN</th>
                            <th>FECHA INICIÓ</th>
                            <th>FECHA FINALIZÓ</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(accesoadm($cone,$_SESSION['identi'],6)){
                              $cdep=mysqli_query($cone,"SELECT idCoordinador, FecInicio, FecFin, Condicion, ApellidoPat, ApellidoMat, Nombres, Denominacion FROM coordinador c INNER JOIN coordinacion co ON c.idCoordinacion=co.idCoordinacion INNER JOIN empleado e ON c.idEmpleado=e.idEmpleado ORDER BY ApellidoPat ASC, ApellidoMat ASC, Nombres ASC, FecInicio DESC;");
                            }else{
                              $cdep=mysqli_query($cone,"SELECT idCoordinador, FecInicio, FecFin, Condicion, ApellidoPat, ApellidoMat, Nombres, Denominacion FROM coordinador c INNER JOIN coordinacion co ON c.idCoordinacion=co.idCoordinacion INNER JOIN empleado e ON c.idEmpleado=e.idEmpleado WHERE FecFin<=Now() ORDER BY ApellidoPat ASC, ApellidoMat ASC, Nombres ASC;");
                            }
                            while($rdep=mysqli_fetch_assoc($cdep)){

                          ?>
                          <tr>
                            <td><span class="text-blue"><?php echo $rdep['ApellidoPat']." ".$rdep['ApellidoMat'].", ".$rdep['Nombres'] ?></span></td>
                            <td><?php echo $rdep['Denominacion'] ?></td>
                            <td><?php echo $rdep['Condicion']==1 ? 'OFICIAL' : 'ENCARGADO'; ?></td>
                            <td><?php echo fnormal($rdep['FecInicio']); ?>
                            <td><?php echo $rdep['FecFin'] == "0000-00-00" ? "SIN FIN" : '<span class="text-maroon">'.fnormal($rdep['FecFin']).'</span>'; ?></td>
                            
                            <td>
                            <?php if($rdep['FecFin'] == "0000-00-00"){ ?>
                              <div class="btn-group">
                                <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-cog"></i>&nbsp;
                                  <span class="caret"></span>
                                  <span class="sr-only">Desplegar menú</span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                  <?php
                                  if(accesoadm($cone,$_SESSION['identi'],6)){
                                  ?>
                                  <li><a href="#" data-toggle="modal" data-target="#m_edicoordinador" onclick="edicoordinador(<?php echo $rdep['idCoordinador'] ?>)">Editar</a></li>
                                  <?php
                                  }
                                  ?>
                                </ul>
                              </div>
                            <?php } ?>
                            </td>

                          </tr>
                          <?php
                            }
                            mysqli_free_result($cdep);
                          ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>COORDINADOR</th>
                            <th>COORDINACIÓN</th>
                            <th>CONDICIÓN</th>
                            <th>FECHA INICIO</th>
                            <th>FECHA FINALIZÓ</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
                <?php if(accesoadm($cone,$_SESSION['identi'],6)){ ?>
                <div class="row">
                  <div class="col-md-12 col-sm-12 form-group">
                    <button type="button" class="btn btn-info" id="b_asicoordinador" data-toggle="modal" data-target="#m_asicoordinador"><i class="fa fa-plus"></i> Asignar Coordinador</button>
                  </div>
                </div>
                <?php } ?>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
      </div>

    </section>
    <!-- /.content -->


<!--Modal Detalle Dependencia-->
<div class="modal fade" id="m_detcoordinacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Coordinación</h4>
      </div>
      <div class="modal-body" id="r_detcoordinacion">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle Dependencia-->
<?php if(accesoadm($cone,$_SESSION['identi'],6)){ ?>
<!--Modal Editar Dependencia-->
<div class="modal fade" id="m_edicoordinacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edicoordinacion" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Coordinación</h4>
      </div>
      <div class="modal-body" id="r_edicoordinacion">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedicoordinacion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Dependencia-->
<!--Modal Desactivar Dependencia-->
<div class="modal fade" id="m_descoordinacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_descoordinacion" action="">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Coordinación</h4>
      </div>
      <div class="modal-body" id="r_descoordinacion">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_gdescoordinacion">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Desactivar Dependencia-->
<!--Modal Desactivar Dependencia-->
<div class="modal fade" id="m_actcoordinacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_actcoordinacion" action="">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Activar Coordinación</h4>
      </div>
      <div class="modal-body" id="r_actcoordinacion">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="b_gactcoordinacion">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Desactivar Dependencia-->
<!--Modal Nueva coordinacion-->
<div class="modal fade" id="m_nuecoordinacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_nuecoordinacion" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva coordinación</h4>
      </div>
      <div class="modal-body" id="r_nuecoordinacion">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnuecoordinacion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Nueva coordinacion-->
<!--Modal asignar coordinador-->
<div class="modal fade" id="m_asicoordinador" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_asicoordinador" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Asignar coordinador</h4>
      </div>
      <div class="modal-body" id="r_asicoordinador">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_asicoordinador">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal asignar coordinador-->
<!--Modal Editar Dependencia-->
<div class="modal fade" id="m_edicoordinador" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edicoordinador" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Coordinador</h4>
      </div>
      <div class="modal-body" id="r_edicoordinador">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedicoordinador">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Dependencia-->
<?php
  }
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
