<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],1)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Personal</li>
        <li class="active">Reportes</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Personal/Dependencia</a></li>
              <li><a href="#tab_2" data-toggle="tab">Cargos/Dependencia</a></li>
              <li><a href="#tab_3" data-toggle="tab">Ubicación/Personal</a></li>
              <li><a href="#tab_4" data-toggle="tab">Parientes/Personal</a></li>
              <li><a href="#tab_5" data-toggle="tab">Vencimientos</a></li>
              <li><a href="#tab_6" data-toggle="tab">Discapacidad</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Formulario-->
                <form action="" id="f_reppersonal" class="form-horizontal">
                  <div class="form-group">
                    <label for="depen" class="col-sm-1 control-label">Dependencia</label>
                    <div class="col-sm-6 valida">
                      <select name="depen" id="depen" class="form-control select2" style="width: 100%;">
                        <option value="t">TODAS</option>
                    <?php
                      $cdep=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 ORDER BY Denominacion ASC");
                      while($rdep=mysqli_fetch_assoc($cdep)){
                    ?>
                      <option value="<?php echo $rdep['idDependencia'] ?>"><?php echo $rdep['Denominacion'] ?></option>
                    <?php
                      }
                      mysqli_free_result($cdep);
                    ?>
                      </select>
                    </div>
                    <label for="cargo" class="col-sm-1 control-label">Cargo</label>
                    <div class="col-sm-4 valida">
                      <select name="cargo" id="cargo" class="form-control select2" style="width: 100%;">
                        <option value="t">TODOS</option>
                    <?php
                      $ccar=mysqli_query($cone,"SELECT idCargo, Denominacion, SistemaLab FROM cargo as ca INNER JOIN sistemalab as sl ON ca.idSistemaLab=sl.idSistemaLab WHERE ca.Estado=1 ORDER BY SistemaLab, Denominacion ASC");
                      while($rcar=mysqli_fetch_assoc($ccar)){
                    ?>
                      <option value="<?php echo $rcar['idCargo'] ?>"><?php echo substr($rcar['SistemaLab'],0,1).'-'.$rcar['Denominacion'] ?></option>
                    <?php
                      }
                      mysqli_free_result($ccar);
                    ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                      <button type="submit" id="b_rperdependencia" class="btn btn-default">Buscar</button>
                      <a href="m_exportar/e_personal.php" class="btn bg-purple" target="_blank"><i class="fa fa-file-excel-o"></i> Personal</a>
                      <a href="m_exportar/e_perdependencia.php" class="btn bg-purple" target="_blank"><i class="fa fa-file-excel-o"></i> Personal/Dependencia</a>
                    </div>
                  </div>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_rperdependencia">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Formulario-->
                <form action="" id="f_repcargos" class="form-horizontal">
                  <div class="form-group">
                    <label for="cargo" class="col-sm-1 control-label">Cargo</label>
                    <div class="col-sm-4 valida">
                      <select name="cargo" id="cargo" class="form-control select2" style="width: 100%;">
                        <option value="t">TODOS</option>
                    <?php
                      $ccar=mysqli_query($cone,"SELECT idCargo, Denominacion, SistemaLab FROM cargo as ca INNER JOIN sistemalab as sl ON ca.idSistemaLab=sl.idSistemaLab WHERE ca.Estado=1 ORDER BY SistemaLab, Denominacion ASC");
                      while($rcar=mysqli_fetch_assoc($ccar)){
                    ?>
                      <option value="<?php echo $rcar['idCargo'] ?>"><?php echo substr($rcar['SistemaLab'],0,1).'-'.$rcar['Denominacion'] ?></option>
                    <?php
                      }
                      mysqli_free_result($ccar);
                    ?>
                      </select>
                    </div>
                    <label for="depen" class="col-sm-1 control-label">Dependencia</label>
                    <div class="col-sm-6 valida">
                      <select name="depen" id="depen" class="form-control select2" style="width: 100%;">
                        <option value="t">TODAS</option>
                    <?php
                      $cdep=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 ORDER BY Denominacion ASC");
                      while($rdep=mysqli_fetch_assoc($cdep)){
                    ?>
                      <option value="<?php echo $rdep['idDependencia'] ?>"><?php echo $rdep['Denominacion'] ?></option>
                    <?php
                      }
                      mysqli_free_result($cdep);
                    ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                      <button type="submit" id="b_rcargos" class="btn btn-default">Buscar</button>
                    </div>
                  </div>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">

                  <div class="col-md-12" id="r_rcargos">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <!--Formulario-->
                <form action="" id="f_ubipersonal" class="form-horizontal">
                  <div class="form-group">
                    <label for="dis" class="col-sm-1 control-label">Distrito</label>
                    <div class="col-sm-4 valida">
                      <select name="dis" id="dis" class="form-control select2" style="width: 100%;">
                        <option value="t">TODOS</option>
                    <?php
                      $c=mysqli_query($cone, "SELECT DISTINCT d.idDistrito, NombreDis, NombrePro FROM local l INNER JOIN distrito d ON l.idDistrito=d.idDistrito INNER JOIN provincia p ON d.idProvincia=p.idProvincia WHERE l.Estado=1 ORDER BY NombrePro, NombreDis ASC;");
                      if(mysqli_num_rows($c)>0){
                        while ($r=mysqli_fetch_assoc($c)) {
                    ?>
                        <option value="<?php echo $r['idDistrito']; ?>"><?php echo $r['NombrePro']." - ".$r['NombreDis']; ?></option>
                    <?php
                        }
                      }
                      mysqli_free_result($c);
                    ?>
                      </select>
                    </div>
                    <label for="carg" class="col-sm-1 control-label">Cargo</label>
                    <div class="col-sm-4 valida">
                      <select name="carg" id="carg" class="form-control select2" style="width: 100%;">
                        <option value="t">TODOS</option>
                    <?php
                      $ccar=mysqli_query($cone,"SELECT idCargo, Denominacion, SistemaLab FROM cargo as ca INNER JOIN sistemalab as sl ON ca.idSistemaLab=sl.idSistemaLab WHERE ca.Estado=1 ORDER BY SistemaLab, Denominacion ASC");
                      while($rcar=mysqli_fetch_assoc($ccar)){
                    ?>
                      <option value="<?php echo $rcar['idCargo'] ?>"><?php echo substr($rcar['SistemaLab'],0,1).'-'.$rcar['Denominacion'] ?></option>
                    <?php
                      }
                      mysqli_free_result($ccar);
                    ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                      <button type="submit" id="b_rubipersonal" class="btn btn-default">Buscar</button>
                    </div>
                  </div>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_rubipersonal">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
                <!--Formulario-->
                <form action="" id="f_rephijos" class="form-horizontal">
                  <div class="form-group">
                    <label for="pers" class="col-sm-1 control-label">Personal</label>
                    <div class="col-sm-4 valida">
                      <select name="pers" id="pers" class="form-control select2" style="width: 100%;">
                    <?php
                      $c=mysqli_query($cone,"SELECT e.idEmpleado, ApellidoPat, ApellidoMat, Nombres FROM empleado e INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE ec.idEstadoCar=1 ORDER BY ApellidoPat, ApellidoMat ASC;");
                      while($r=mysqli_fetch_assoc($c)){
                    ?>
                      <option value="<?php echo $r['idEmpleado'] ?>"><?php echo $r['ApellidoPat'].' '.$r['ApellidoMat'].', '.$r['Nombres'] ?></option>
                    <?php
                      }
                      mysqli_free_result($c);
                    ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                      <button type="submit" id="b_rhijos" class="btn btn-default">Buscar</button>
                      <a href="m_exportar/e_perhijos.php" class="btn bg-purple" target="_blank"><i class="fa fa-file-excel-o"></i> Pers./Hijos</a>
                      <a href="m_exportar/e_perhijos10.php" class="btn bg-purple" target="_blank"><i class="fa fa-file-excel-o"></i> Pers./Hijos <= 10</a>
                    </div>
                  </div>
                </form>
                <!--Fin Formulario-->
                <div class="row">
                  <div class="col-md-12" id="r_rhijos">

                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_5">
                  <button id="b_rvencimientos" class="btn btn-default">Ver Vencimientos</button>
                  <div class="row">
                    <div class="col-md-12" id="r_rvencimientos">

                    </div>
                  </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_6">
                  <button id="b_rdiscapacidad" class="btn btn-default"><i class="fa fa-wheelchair"></i> Personal con discapacidad</button>
                  <a href="m_exportar/xls_discapacidad.php" class="btn bg-purple" target="_blank"><i class="fa fa-file-excel-o"></i> Exportar</a>
                  <div class="row">
                    <div class="col-md-12" id="r_discapacidad">

                    </div>
                  </div>
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
<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>