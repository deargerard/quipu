<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],7)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Accesos
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Accesos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Buscar</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" id="r_bpersonal">
                    <?php
                      $cp=mysqli_query($cone,"SELECT idEmpleado, NombreCom, NumeroDoc FROM enombre WHERE Estado=1 ORDER BY NombreCom ASC");
                    ?>
                      <table id="dtpersonal" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>NOMBRE</th>
                            <th>N° DOCUMENTO</th>
                            <th>CARGO</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </thead>
                        <tbody>
                    <?php
                        while($rp=mysqli_fetch_assoc($cp)){
                    ?>
                          <tr>
                            <td><?php echo $rp["NombreCom"] ?></td>
                            <td><?php echo $rp["NumeroDoc"] ?></td>
                            <td><?php echo cargoe($cone,$rp["idEmpleado"]) ?></td>
                            <td>
                              <div class="btn-group">
                                <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-cog"></i>&nbsp;
                                  <span class="caret"></span>
                                  <span class="sr-only">Desplegar menú</span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                  <?php
                                  if(!accesoadm($cone,$_SESSION['identi'],7)){
                                  ?>
                                  <li><a href="#" data-toggle="modal" data-target="#m_ediaccesos" onclick="ediaccesos(<?php echo $rp["idEmpleado"] ?>)">Ver Accesos</a></li>
                                  <?php
                                  }
                                  if(accesoadm($cone,$_SESSION['identi'],7)){
                                  ?>
                                  <li><a href="#" data-toggle="modal" data-target="#m_ediaccesos" onclick="ediaccesos(<?php echo $rp["idEmpleado"] ?>)">Editar Accesos</a></li>
                                  <li><a href="#" data-toggle="modal" data-target="#m_camcontrasena" onclick="camcontrasena(<?php echo $rp["idEmpleado"] ?>)">Cambiar Contraseña</a></li>
                                  <?php
                                  }
                                  ?>
                                </ul>
                              </div>
                            </td>
                          </tr>
                    <?php
                        }
                    ?>
                        </tbody>
                          <tfoot>
                            <th>NOMBRE</th>
                            <th>N° DOCUMENTO</th>
                            <th>CARGO</th>
                            <th>ACCIÓN</th>
                          </tfoot>
                      </table>
                  </div>
                </div>
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
<?php if(accesoadm($cone,$_SESSION['identi'],7)){ ?>
<!--Modal cambiar contraseña-->
<div class="modal fade" id="m_camcontrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_camcontrasena" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CAMBIAR CONTRASEÑA</h4>
      </div>
      <div class="modal-body" id="r_camcontrasena">
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gcamcontrasena">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal cambiar contraseña-->
<?php } ?>
<!--Modal editar accesos-->
<div class="modal fade" id="m_ediaccesos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_ediaccesos" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ACCESOS</h4>
      </div>
      <div class="modal-body" id="r_ediaccesos">
        
      </div>
      <div class="modal-footer">
        <?php if(accesoadm($cone,$_SESSION['identi'],7)){ ?>
        <button type="submit" class="btn bg-teal" id="b_gediaccesos">Guardar</button>
        <?php } ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal editar accesos-->
  <?php
      mysqli_free_result($cp);
  }else{
    echo accrestringidop();
  }
}else{
header('Location: ../index.php');
}
?>