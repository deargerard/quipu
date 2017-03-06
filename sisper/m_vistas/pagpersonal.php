<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],1)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Personal
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Personal</li>
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
                    if(accesoadm($cone,$_SESSION['identi'],1)){
                      $cp=mysqli_query($cone,"SELECT idEmpleado, NombreCom, NumeroDoc FROM enombre ORDER BY NombreCom ASC");
                    }else{
                      $cp=mysqli_query($cone,"SELECT idEmpleado, NombreCom, NumeroDoc FROM enombre WHERE Estado=1 ORDER BY NombreCom ASC");
                    }
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
                                  <li><a href="perpersonal.php?idp=<?php echo $rp["idEmpleado"] ?>">Ver Perfil</a></li>
                                </ul>
                              </div>
                            </td>
                          </tr>
                    <?php
                        }
                        mysqli_free_result($cp);
                    ?>
                        </tbody>
                          <tfoot>
                            <th>N° DOCUMENTO</th>
                            <th>NOMBRE</th>
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
<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>