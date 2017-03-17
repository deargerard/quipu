<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],6)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dependencia
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><a href="depmante.php">Mantenimiento</a></li>
        <li class="active">Dependencia</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Dependencias</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="r_bdependencia">
                      <table id="dtdependencias" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>DEPENDENCIA</th>
                            <th>SIGLAS</th>
                            <th>RESPONSABLE</th>
                            <th>ESTADO</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(accesoadm($cone,$_SESSION['identi'],6)){
                              $cdep=mysqli_query( $cone, "SELECT idDependencia, Denominacion, Siglas, d.Estado, concat(e.ApellidoPat, ' ', e.ApellidoMat, ', ', e.Nombres) as nombre FROM dependencia d LEFT JOIN empleado e ON e.idEmpleado=d.jefe ORDER BY Denominacion ASC" );
                            }else{
                              $cdep=mysqli_query( $cone, "SELECT idDependencia, Denominacion, Siglas, d.Estado, concat(e.ApellidoPat, ' ', e.ApellidoMat, ', ', e.Nombres) as nombre FROM dependencia d LEFT JOIN empleado e ON e.idEmpleado=d.jefe WHERE d.estado = 1 ORDER BY Denominacion ASC" );
                            }
                            $est="";
                            while($rdep=mysqli_fetch_assoc($cdep)){
                              if($rdep['Estado']=='1'){
                                $est="<span class='label label-success'>Activo</span>";
                              }else{
                                $est="<span class='label label-danger'>Inactivo</span>";
                              }
                          ?>
                          <tr>
                            <td><?php echo $rdep['Denominacion'] ?></td>
                            <td><?php echo $rdep['Siglas'] ?></td>
                            <td><?php echo $rdep['nombre'] ?></td>
                            <td><?php echo $est ?></td>
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
                                  <li><a href="#" data-toggle="modal" data-target="#m_detdependencia" onclick="detdependencia(<?php echo $rdep['idDependencia'] ?>)">Detalle</a></li>
                                  <?php
                                  }
                                  if(accesoadm($cone,$_SESSION['identi'],6)){
                                  ?>
                                  <li class="divider"></li>
                                  <li><a href="#" data-toggle="modal" data-target="#m_edidependencia" onclick="edidependencia(<?php echo $rdep['idDependencia'] ?>)">Editar</a></li>
                                  <?php
                                  if($rdep['Estado']== 1){
                                    ?>
                                   <li><a href="#" data-toggle="modal" data-target="#m_desdependencia" onclick="desdependencia(<?php echo $rdep['idDependencia'] ?>)">Desactivar</a></li>
                                   <?php
                                    }else{
                                      ?>
                                     <li><a href="#" data-toggle="modal" data-target="#m_desdependencia" onclick="desdependencia(<?php echo $rdep['idDependencia'] ?>)">Activar</a></li>
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
                            <th>DEPENDENCIA</th>
                            <th>SIGLAS</th>
                            <th>RESPONSABLE</th>
                            <th>ESTADO</th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
                <?php if(accesoadm($cone,$_SESSION['identi'],6)){ ?>
                <div class="row">
                  <div class="col-md-12 col-sm-12 form-group">
                    <button type="button" class="btn btn-info" id="b_nuedependencia" data-toggle="modal" data-target="#m_nuedependencia"><i class="fa fa-plus"></i> Nueva</button>
                  </div>
                </div>
                <?php } ?>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">

              </div>
              <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
<!--Modal Detalle Dependencia-->
<div class="modal fade" id="m_detdependencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Dependencia</h4>
      </div>
      <div class="modal-body" id="r_detdependencia">

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
<div class="modal fade" id="m_edidependencia" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edidependencia" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Dependencia</h4>
      </div>
      <div class="modal-body" id="r_edidependencia">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedidependencia">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Dependencia-->
<!--Modal Desactivar Dependencia-->
<div class="modal fade" id="m_desdependencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_desdependencia" action="">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Dependencia</h4>
      </div>
      <div class="modal-body" id="r_desdependencia">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_gdesdependencia">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Desactivar Dependencia-->
<!--Modal Nueva Dependencia-->
<div class="modal fade" id="m_nuedependencia" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_nuedependencia" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Dependencia</h4>
      </div>
      <div class="modal-body" id="r_nuedependencia">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnuedependencia">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Nueva Dependencia-->
<?php
  }
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
