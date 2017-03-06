<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],1)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reporte
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
                <h3 class="box-title">Personal con hijos</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <a href="m_exportar/e_perhijos10.php" class="btn bg-purple btn-xs pull-right" target="_blank"><i class="fa fa-file-excel-o"></i> Exportar</a>
                    <br><br>
                  </div>
                  <div class="col-md-12" id="r_bpersonal">
                      <table id="dtpersonal" class="table table-bordered table-striped">
                        <?php
                          $cde=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1");
                          while ($rde=mysqli_fetch_assoc($cde)) {
                            $idde=$rde['idDependencia'];

                            $cp=mysqli_query($cone,"SELECT ec.idEmpleado, en.NumeroDoc, en.NombreCom FROM empleadocargo AS ec INNER JOIN enombre AS en ON ec.idEmpleado=en.idEmpleado INNER JOIN cardependencia as cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo WHERE ec.idEstadoCar=1 AND cd.Estado=1 AND cd.idDependencia=$idde ORDER BY en.NombreCom ASC");
                            if(mysqli_num_rows($cp)>0){
                        ?>
                          <tr>
                            <th colspan="5"><span class="text-orange"><?php echo $rde['Denominacion']; ?></span></th>
                          </tr>
                        <?php

                              while($rp=mysqli_fetch_assoc($cp)){
                                $idem=$rp["idEmpleado"];

                                $ch=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres, Sexo, FechaNac, NumeroDoc FROM pariente WHERE idEmpleado=$idem AND idTipoPariente=3");
                                if(mysqli_num_rows($ch)>0){


                                $cc=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres, NumeroDoc FROM pariente WHERE idEmpleado=$idem AND idTipoPariente=4");
                                if($rc=mysqli_fetch_assoc($cc)){
                                  $conyugue=$rc['ApellidoPat']." ".$rc['ApellidoMat'].", ".$rc['Nombres'];
                                }else{
                                  $conyugue="";
                                }
                                
                        ?>
                          <tr>
                            <th><span class="text-maroon">SERVIDOR</span></th>
                            <th><span class="text-maroon">CARGO</span></th>
                            <th><span class="text-maroon">DNI</span></th>
                            <th><span class="text-maroon">CÓNYUGE</span></th>
                            <th><span class="text-maroon">DNI CÓNYUGE</span></th>
                          </tr>
                          <tr>
                            <td><?php echo $rp["NombreCom"] ?></td>
                            <td><?php echo cargoe($cone, $idem) ?></td>
                            <td><?php echo $rp["NumeroDoc"] ?></td>
                            <td><?php echo $conyugue ?></td>
                            <td><?php echo $rc["NumeroDoc"] ?></td>
                          </tr>
                          
                        <?php
                                mysqli_free_result($cc);
                        ?>
                          <tr>
                            <td><span class="text-purple">HIJOS</span></td>
                            <td><span class="text-purple">SEXO</span></td>
                            <td><span class="text-purple">DNI</span></td>
                            <td><span class="text-purple">FECHA NAC.</span></td>
                            <td><span class="text-purple">EDAD</span></td>
                          </tr>
                        <?php
                                  while($rh=mysqli_fetch_assoc($ch)){
                                    $f1=@date("y-m-d");
                                    $f2=$rh['FechaNac'];
                                    $f1=@date_create($f1);
                                    $f2=@date_create($f2);
                                    $tie=date_diff($f1, $f2);

                        ?>
                          <tr>
                            <td><?php echo $rh['ApellidoPat'].' '.$rh['ApellidoMat'].', '.$rh['Nombres']; ?></td>
                            <td><?php echo $rh['Sexo']; ?></td>
                            <td><?php echo $rh['NumeroDoc']; ?></td>
                            <td><?php echo fnormal($rh['FechaNac']); ?></td>
                            <td><?php echo $tie->format('%y año(s), %m mes(es)'); ?></td>
                          </tr>
                        <?php
                                  }
                                }

                                //aca
                              }
                            }
                          }
                        ?>

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
    mysqli_free_result($cp);
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>