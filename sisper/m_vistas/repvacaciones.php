<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],3)){
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
              <li class="active"><a href="#tab_1" data-toggle="tab">Record de Vacaciones</a></li>
              <li><a href="#tab_2" data-toggle="tab">Vacaciones por Régimen Laboral</a></li>
              <li><a href="#tab_3" data-toggle="tab">Ejecución de Vacaciones</a></li>
              <!--<li><a href="#tab_4" data-toggle="tab">Vacaciones Pendientes</a></li>-->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Formulario-->
                <form action="" id="f_rreva" class="form-inline">
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Personal</label>
                    <select name="per" id="per" class="form-control select2pertot" style="width: 350px;">

                    </select>
                  </div>
                  <div class="form-group">
                    <label for="bbb" class="sr-only">Cargo </label>
                    <select name="car" id="car" class="form-control select2" style="width: 250px;">

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
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Condición</label>
                    <select name="convac[]" class="selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="CONDICIÓN" >
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
                    <label for="aaa" class="sr-only">Regimen</label>
                    <select data-actions-box="true" name="reglab[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="RÉGIMEN">
                      <?php
                        $crl=mysqli_query($cone,"SELECT idCondicionLab, Tipo FROM condicionlab WHERE Estado=1 ORDER BY Tipo ASC");
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
                    <label for="bbb" class="sr-only">Estado</label>
                    <select data-actions-box="true" name="estvac[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="ESTADO">
                      <option value="4">PLANIFICADAS</option>
                      <option value="0">PENDIENTES</option>
                      <option value="3">EJECUTANDOSE</option>
                      <option value="1">EJECUTADAS</option>
                      <option value="2">CANCELADAS</option>
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
                    <label for="bbb" class="sr-only">Periodo </label>
                    <select name="pervac[]" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="PERÍODO">
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
                    <label for="aaa" class="sr-only">Régimen</label>
                      <select name="reglab[]" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="RÉGIMEN">
                        <?php
                          $crl=mysqli_query($cone,"SELECT idCondicionLab, Tipo FROM condicionlab WHERE Estado=1 ORDER BY Tipo ASC");
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
                    <label for="aaa" class="sr-only">Mes</label>
                    <select name="mes" id="mes" class="form-control" style="width: 200px;">
                        <option value="" disabled selected>MES</option>
                        <option value="01">ENERO</option>
                        <option value="02">FEBRERO</option>
                        <option value="03">MARZO</option>
                        <option value="04">ABRIL</option>
                        <option value="05">MAYO</option>
                        <option value="06">JUNIO</option>
                        <option value="07">JULIO</option>
                        <option value="08">AGOSTO</option>
                        <option value="09">SETIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Estado</label>
                    <select name="estvac[]" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="ESTADO">
                      <option value="4">PLANIFICADAS</option>
                      <option value="0">PENDIENTES</option>
                      <option value="3">EJECUTANDOSE</option>
                      <option value="1">EJECUTADAS</option>
                      <option value="2">CANCELADAS</option>
                    </select>
                  </div>
                  <button type="submit" id="b_bejva" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_ejva">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>

              <div class="tab-pane" id="tab_4">
                <!--Formulario-->
                <form action="" id="f_rvape" class="form-inline">
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Régimen</label>
                      <select name="reglab[]" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="RÉGIMEN">
                        <?php
                          $crl=mysqli_query($cone,"SELECT idCondicionLab, Tipo FROM condicionlab WHERE Estado=1 ORDER BY Tipo ASC");
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
                    <label for="aaa" class="sr-only">Estado</label>
                    <select name="estvac[]" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="ESTADO">
                      <option value="4">PLANIFICADAS</option>
                      <option value="0">PENDIENTES</option>
                      <option value="3">EJECUTANDOSE</option>
                      <option value="1">EJECUTADAS</option>
                      <option value="2">CANCELADAS</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Mes</label>
                      <div class="input-group">
                        <input type="text" id="fecha" name="finvac" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo date('d/m/Y')?>">

                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>

                  <button type="submit" id="b_bvape" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_vape">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>

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
