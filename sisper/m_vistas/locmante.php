<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],6)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Local
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><a href="locmante.php">Mantenimiento</a></li>
        <li class="active">Local</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Locales</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="r_blocal">
                      <table id="dtlocales" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>DIRECCIÓN</th>
                            <th>DISTRITO</th>
                            <th>TELÉFONO</th>
                            <th>ESTADO</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(accesoadm($cone,$_SESSION['identi'],6)){
                              $cdep=mysqli_query($cone,"SELECT idLocal, Direccion, idDistrito, Telefono, Estado FROM local ORDER BY Direccion ASC");
                            }else{
                              $cdep=mysqli_query($cone,"SELECT idLocal, Direccion, idDistrito, Telefono, Estado FROM local WHERE Estado=1 ORDER BY Direccion ASC");
                            }
                            $est="";
                            while($rdep=mysqli_fetch_assoc($cdep)){
                              if ($rdep['Estado']=='1') {
                                $est="<span class='label label-success'>Activo</span>";
                              }else{
                                $est="<span class='label label-danger'>Inactivo</span>";
                              }
                          ?>
                          <tr>
                            <td><?php echo $rdep['Direccion'] ?></td>
                            <td><?php echo nomdistrito($cone,$rdep['idDistrito']) ?></td>
                            <td><?php echo $rdep['Telefono'] ?></td>
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
                                  <li><a href="#" data-toggle="modal" data-target="#m_detlocal" onclick="detlocal(<?php echo $rdep['idLocal'] ?>)">Detalle</a></li>
                                  <?php
                                  }
                                  if(accesoadm($cone,$_SESSION['identi'],6)){
                                  ?>
                                  <li class="divider"></li>
                                  <li><a href="#" data-toggle="modal" data-target="#m_edilocal" onclick="edilocal(<?php echo $rdep['idLocal'] ?>)">Editar</a></li>
                                  <li><a href="#" data-toggle="modal" data-target="#m_deslocal" onclick="deslocal(<?php echo $rdep['idLocal'] ?>)">Desactivar</a></li>
                                  <?php
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
                            <th>DIRECCIÓN</th>
                            <th>DISTRITO</th>
                            <th>TELÉFONO</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </tfoot>
                      </table>
                  </div>
                </div>
                <?php if(accesoadm($cone,$_SESSION['identi'],6)){ ?>
                <div class="row">
                  <div class="col-md-12 col-sm-12 form-group">
                    <button type="button" class="btn btn-info" id="b_nuelocal" data-toggle="modal" data-target="#m_nuelocal"><i class="fa fa-plus"></i> Nuevo</button>
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
<div class="modal fade" id="m_detlocal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Local</h4>
      </div>
      <div class="modal-body" id="r_detlocal">
        
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
<div class="modal fade" id="m_edilocal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edilocal" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Local</h4>
      </div>
      <div class="modal-body" id="r_edilocal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedilocal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Dependencia-->
<!--Modal Desactivar Dependencia-->
<div class="modal fade" id="m_deslocal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_deslocal" action="">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Local</h4>
      </div>
      <div class="modal-body" id="r_deslocal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_gdeslocal">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Desactivar Dependencia-->
<!--Modal Nuevo Local-->
<div class="modal fade" id="m_nuelocal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_nuelocal" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Local</h4>
      </div>
      <div class="modal-body" id="r_nuelocal">
        

        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnuelocal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Nuevo Local-->
<?php
  }
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>