<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],3)){
    $hoy = date("Y");
    $mpp = date("m");
    $anos= $hoy + 1;
    $pv = trim($hoy." - ".$anos);
    $cpev=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE PeriodoVacacional='$pv'");
    if ($rpev=mysqli_fetch_assoc($cpev)) {
      $pervac=$rpev['idPeriodoVacacional'];
    }
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes Vacaciones
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Vacaciones</li>
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
              <li class="active"><a href="#tab_1" data-toggle="tab">Vacaciones por Trabajador</a></li>
              <li><a href="#tab_2" data-toggle="tab">Vacaciones por Período</a></li>
              <li><a href="#tab_3" data-toggle="tab">Vacaciones por Meses</a></li>
              <li><a href="#tab_4" data-toggle="tab">Vacaciones por Resolución</a></li>
              <?php if ($mpp>10): ?>
                <li><a href="#tab_5" data-toggle="tab">Programación de Vacaciones <?php echo $pv ?></a></li>
              <?php endif; ?>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Formulario-->
                <form action="" id="f_rreva" class="form-inline">
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Personal</label>
                    <select name="per" id="per" class="form-control select2pertot" style="width: 300px;">

                    </select>
                  </div>
                  <div class="form-group">
                    <label for="bbb" class="sr-only">Cargo </label>
                    <select name="car" id="car" class="form-control select2" style="width: 180px;">

                    </select>
                  </div>
                  <div class="form-group">
                    <label for="bbb" class="sr-only">Estado </label>
                    <select data-actions-box="true" name="estvac[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="ESTADO" >
                      <option value="4">PLANIFICADAS</option>
                      <option value="0">PENDIENTES</option>
                      <option value="3">EJECUTANDOSE</option>
                      <option value="1">EJECUTADAS</option>
                      <option value="2">CANCELADAS</option>
                      <option value="5">SUSPENDIDAS</option>
                    </select>
                  </div>


                  <div class="form-group">
                    <label for="aaa" class="sr-only">Condición</label>
                    <select name="convac[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="CONDICIÓN">
                      <option value="1">PROGRAMADAS</option>
                      <option value="0">REPROGRAMADAS</option>
                    </select>
                    </div>
                    <button type="submit" id="b_breva" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->

                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_reva">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">

                <!--Formulario-->
                <form action="" id="f_rvare" class="form-inline">
                  <div class="form-group">
                    <label for="bbb" class="sr-only">Período</label>
                    <select data-actions-box="true" name="pervac[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="PERÍODO">
                      <?php
                        $cpv=mysqli_query($cone,"SELECT idPeriodoVacacional, PeriodoVacacional FROM periodovacacional WHERE Estado=1 ORDER BY PeriodoVacacional DESC");
                        while($rpv=mysqli_fetch_assoc($cpv)){
                      ?>
                      <option value="<?php echo $rpv['idPeriodoVacacional']; ?>"><?php echo $rpv['PeriodoVacacional']; ?></option>
                      <?php
                        }
                        mysqli_free_result($cpv);
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="aaa" class="sr-only">Sistema</label>
                      <select name="sislab[]" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="SISTEMA">
                        <?php
                          $csl=mysqli_query($cone,"SELECT idSistemaLab, SistemaLab FROM sistemalab WHERE idSistemaLab!=4 AND  idSistemaLab!=5 ORDER BY idSistemaLab ASC");
                          while($rsl=mysqli_fetch_assoc($csl)){
                        ?>
                        <option value="<?php echo $rsl['idSistemaLab']; ?>"><?php echo $rsl['SistemaLab']; ?></option>
                        <?php
                          }
                          mysqli_free_result($csl);
                        ?>
                      </select>
                  </div>

                  <div class="form-group">
                    <label for="aaa" class="sr-only">Regimen</label>
                    <select data-actions-box="true" name="reglab[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="RÉGIMEN">
                      <?php
                        $crl=mysqli_query($cone,"SELECT idCondicionLab, Tipo FROM condicionlab WHERE Estado=1 AND idCondicionLab!=6 AND idCondicionLab!=7 ORDER BY Tipo ASC");
                        while($rrl=mysqli_fetch_assoc($crl)){
                      ?>
                      <option value="<?php echo $rrl['idCondicionLab']; ?>"><?php echo $rrl['Tipo']; ?></option>
                      <?php
                        }
                        mysqli_free_result($crl);
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="bbb" class="sr-only">Estado</label>
                    <select data-actions-box="true" name="estvac[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="ESTADO">
                      <option value="4">PLANIFICADAS</option>
                      <option value="0">PENDIENTES</option>
                      <option value="3">EJECUTANDOSE</option>
                      <option value="1">EJECUTADAS</option>
                      <option value="2">CANCELADAS</option>
                      <option value="5">SUSPENDIDAS</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="bbb" class="sr-only">Condición</label>
                    <select name="convac[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="CONDICIÓN">
                      <option value="1">PROGRAMADAS</option>
                      <option value="0">REPROGRAMADAS</option>
                    </select>
                  </div>
                  <button type="submit" id="b_bvare" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_vare">

                  </div>
                </div>
                <!--fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <!--Formulario-->
                <form action="" id="f_rejva" class="form-inline">
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Mes Inicial</label>
                    <input class="form-control" id="mesini" name="mesini" placeholder="MM/AAAA (INICIO)">
                  </div>

                  <div class="form-group">
                    <label for="aaa" class="sr-only">Mes Final</label>
                    <input class="form-control" id="mesfin" name="mesfin" placeholder="MM/AAAA (FIN)">
                  </div>

                  <div class="form-group">
                    <label for="aaa" class="sr-only">Sistema</label>
                      <select name="sislab[]" id="sislab" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="SISTEMA">
                        <?php
                          $csl=mysqli_query($cone,"SELECT idSistemaLab, SistemaLab FROM sistemalab WHERE idSistemaLab!=4 AND  idSistemaLab!=5 ORDER BY idSistemaLab ASC");
                          while($rsl=mysqli_fetch_assoc($csl)){
                        ?>
                        <option value="<?php echo $rsl['idSistemaLab']; ?>"><?php echo $rsl['SistemaLab']; ?></option>
                        <?php
                          }
                          mysqli_free_result($csl);
                        ?>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Régimen</label>
                      <select name="reglab[]" id="reglab" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="RÉGIMEN">
                        <?php
                          $crl=mysqli_query($cone,"SELECT idCondicionLab, Tipo FROM condicionlab WHERE Estado=1 AND idCondicionLab!=6 AND idCondicionLab!=7 ORDER BY Tipo ASC");
                          while($rrl=mysqli_fetch_assoc($crl)){
                        ?>
                        <option value="<?php echo $rrl['idCondicionLab']; ?>"><?php echo $rrl['Tipo']; ?></option>
                        <?php
                          }
                          mysqli_free_result($crl);
                        ?>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="bbb" class="sr-only">Periodo </label>
                    <select name="pervac[]" id="pervac" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="PERÍODO">
                      <?php
                        $cpv=mysqli_query($cone,"SELECT idPeriodoVacacional, PeriodoVacacional FROM periodovacacional WHERE Estado=1 ORDER BY PeriodoVacacional DESC");
                        while($rpv=mysqli_fetch_assoc($cpv)){
                      ?>
                      <option value="<?php echo $rpv['idPeriodoVacacional']; ?>"><?php echo $rpv['PeriodoVacacional']; ?></option>
                      <?php
                        }
                        mysqli_free_result($cpv);
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="aaa" class="sr-only">Estado</label>
                    <select name="estvac[]" id="estvac" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="ESTADO">
                      <option value="4">PLANIFICADAS</option>
                      <option value="0">PENDIENTES</option>
                      <option value="3">EJECUTANDOSE</option>
                      <option value="1">EJECUTADAS</option>
                      <option value="2">CANCELADAS</option>
                      <option value="5">SUSPENDIDAS</option>
                    </select>
                  </div>
                  <button type="submit" id="b_bejva" class="btn btn-default">Buscar</button>
                  <button type="button" id="b_evxm" class="btn bg-aqua">Exportar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_ejva">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">

                <!--Formulario-->
                <form action="" id="f_vacres" class="form-inline">
                  <div class="form-group">
                    <label for="doc" class="sr-only">Documento</label>
                    <select name="doc" id="doc" class="form-control select2doc" style="width:400px;">
                    </select>
                  </div>
                  <button type="button" id="b_bvacres" class="btn btn-default">Buscar</button>
                  <button type="button" id="b_exvacres" class="btn btn-info">Exportar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_vacres">

                  </div>
                </div>
                <!--fin div resultados-->

              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_5">

                <!--Formulario-->
                <form action="" id="f_rprovac" class="form-inline">

                  <div class="form-group">
                    <label for="aaa" class="sr-only">Dependencia</label>
                    <select name="dep" id="dep" class="form-control select2depact" style="width: 500px;">
                      <option value="t"> TODAS LAS DEPENDENCIAS</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <input type="hidden" name="pervac" value="<?php echo $pervac ?>">
                    <label for="aaa" class="sr-only">Sistema</label>
                      <select name="sislab[]" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="SISTEMA">
                        <?php
                          $csl=mysqli_query($cone,"SELECT idSistemaLab, SistemaLab FROM sistemalab WHERE idSistemaLab!=4 AND  idSistemaLab!=5 ORDER BY idSistemaLab ASC");
                          while($rsl=mysqli_fetch_assoc($csl)){
                        ?>
                        <option value="<?php echo $rsl['idSistemaLab']; ?>"><?php echo $rsl['SistemaLab']; ?></option>
                        <?php
                          }
                          mysqli_free_result($csl);
                        ?>
                      </select>
                  </div>

                  <div class="form-group">
                    <label for="aaa" class="sr-only">Regimen</label>
                    <select data-actions-box="true" name="reglab[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="RÉGIMEN">
                      <?php
                        $crl=mysqli_query($cone,"SELECT idCondicionLab, Tipo FROM condicionlab WHERE Estado=1 AND idCondicionLab!=6 AND idCondicionLab!=7 ORDER BY Tipo ASC");
                        while($rrl=mysqli_fetch_assoc($crl)){
                      ?>
                      <option value="<?php echo $rrl['idCondicionLab']; ?>"><?php echo $rrl['Tipo']; ?></option>
                      <?php
                        }
                        mysqli_free_result($crl);
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="bbb" class="sr-only">Estado</label>
                    <select data-actions-box="true" name="estvac[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="ESTADO">
                      <option value="6">SOLICITADAS</option>
                      <option value="7">ACEPTADAS</option>
                    </select>
                  </div>
                  <button type="submit" id="b_bprova" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_rprova">

                  </div>
                </div>
                <!--fin div resultados-->

              </div>
              <!-- /.tab-pane -->


            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div> <!-- /.col-md-12 -->
      </div> <!-- /.row -->

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
