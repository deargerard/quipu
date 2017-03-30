<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],6)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ambiente
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><a href="ambmante.php">Mantenimiento</a></li>
        <li class="active">Ambiente</li>
      </ol>
    </section>
    <!-- Fin Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Ambientes</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="r_blocal">
                      <table id="dtambiente" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>TIPO</th>
                            <th>DEPENDENCIA</th>
                            <th>LOCAL</th>
                            <th>PISO</th>
                            <th>AMBIENTE</th>
                            <th>ESTADO</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(accesoadm($cone,$_SESSION['identi'],6)){
                              $camb=mysqli_query($cone,"SELECT dl.idDependenciaLocal, tl.Tipo, de.Denominacion, dl.idLocal, p.Piso, dl.Oficina, dl.Estado  FROM dependencialocal dl INNER JOIN tipolocal tl ON dl.idTipoLocal=tl.idTipoLocal INNER JOIN piso p ON dl.idPiso=p.idPiso INNER JOIN dependencia de ON dl.idDependencia=de.idDependencia ORDER BY de.Denominacion ASC");
                            }else{
                              $camb=mysqli_query($cone,"SELECT dl.idDependenciaLocal, tl.Tipo, de.Denominacion, dl.idLocal, p.Piso, dl.Oficina, dl.Estado  FROM dependencialocal dl INNER JOIN tipolocal tl ON dl.idTipoLocal=tl.idTipoLocal INNER JOIN piso p ON dl.idPiso=p.idPiso INNER JOIN dependencia de ON dl.idDependencia=de.idDependencia WHERE dl.Estado=1 ORDER BY de.Denominacion ASC");
                            }
                              while($ramb=mysqli_fetch_assoc($camb)){

                          ?>
                          <tr>
                            <td><?php echo $ramb['Tipo'] ?></td>
                            <td><?php echo $ramb['Denominacion'] ?></td>
                            <td><?php echo nomlocal($cone,$ramb['idLocal'])?></td>
                            <td><?php echo $ramb['Piso'] ?></td>
                            <td><?php echo $ramb['Oficina'] ?></td>
                            <td><?php echo estado($ramb['Estado']) ?></td>
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
                                  <li><a href="#" data-toggle="modal" data-target="#m_detambiente" onclick="detambiente(<?php echo $ramb['idDependenciaLocal'] ?>)">Detalle</a></li>
                                  <?php
                                  }
                                  if(accesoadm($cone,$_SESSION['identi'],6))
                                  {
                                  ?>
                                  <li class="divider"></li>
                                  <li><a href="#" data-toggle="modal" data-target="#m_ediambiente" onclick="ediambiente(<?php echo $ramb['idDependenciaLocal'] ?>)">Editar</a></li>
                                  <?php
                                  if($ramb['Estado']== 1){
                                    ?>
                                  <li><a href="#" data-toggle="modal" data-target="#m_desambiente" onclick="desambiente(<?php echo $ramb['idDependenciaLocal'] ?>)">Desactivar</a></li>
                                  <?php
                                  }else{
                                    ?>
                                   <li><a href="#" data-toggle="modal" data-target="#m_desambiente" onclick="desambiente(<?php echo $ramb['idDependenciaLocal'] ?>)">Activar</a></li>
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
                            mysqli_free_result($camb);
                          ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>TIPO</th>
                            <th>DEPENDENCIA</th>
                            <th>LOCAL</th>
                            <th>PISO</th>
                            <th>AMBIENTE</th>
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
                    <button type="button" class="btn btn-info" id="b_nueambiente" data-toggle="modal" data-target="#m_nueambiente"><i class="fa fa-plus"></i> Nuevo</button>
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
<!--Modal Detalle Ambiente-->
<div class="modal fade" id="m_detambiente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Ambiente</h4>
      </div>
      <div class="modal-body" id="r_detambiente">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle Ambiente-->
<?php if(accesoadm($cone,$_SESSION['identi'],6)){ ?>
<!--Modal Editar Ambiente-->
<div class="modal fade" id="m_ediambiente" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_ediambiente" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Ambiente</h4>
      </div>
      <div class="modal-body" id="r_ediambiente">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gediambiente">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Ambiente-->
<!--Modal Desactivar Ambiente-->
<div class="modal fade" id="m_desambiente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_desambiente" action="">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Ambiente</h4>
      </div>
      <div class="modal-body" id="r_desambiente">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_gdesambiente">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Desactivar Ambiente-->
<!--Modal Nuevo Ambiente-->
<div class="modal fade" id="m_nueambiente" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_nueambiente" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Ambiente</h4>
      </div>
      <div class="modal-body" id="r_nueambiente">



      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnueambiente">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Nuevo Ambiente-->
<?php
  }
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
