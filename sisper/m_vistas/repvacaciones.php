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
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Formulario-->
                <form action="" id="f_rreva" class="form-inline">
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Personal</label>
                    <select name="per" id="per" class="form-control select2" style="width: 350px;">
                      <?php
                        $cper=mysqli_query($cone,"SELECT e.idEmpleado, CONCAT(ApellidoPat, ' ', ApellidoMat, ', ', Nombres) as NombreCompleto FROM empleado e INNER JOIN  empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE ec.idEstadoCar=1 ORDER BY NombreCompleto ASC");
                        while($rper=mysqli_fetch_assoc($cper)){
                      ?>
                      <option value="<?php echo $rper['idEmpleado']; ?>"><?php echo $rper['NombreCompleto']; ?></option>
                      <?php
                        }
                        mysqli_free_result($cper);
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="bbb" class="sr-only">Estado </label>
                    <select name="estvac" id="estvac" class="form-control" style="width: 200px;">
                      <option value="" disabled selected>Estado</option>
                      <option value="0">PENDIENTE</option>
                      <option value="3">EJECUTANDOSE</option>
                      <option value="1">EJECUTADO</option>
                      <option value="2">CANCELADO</option>
                      <option value="t">TODOS</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Condición</label>
                    <select name="convac" id="convac" class="form-control" style="width: 200px;">
                      <option value="" disabled selected>Condición</option>
                      <option value="1">PROGRAMADAS</option>
                      <option value="t">REPROGRAMADAS</option>
                      <option value="t">TODOS</option>
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
                    <select name="reglab" id="reglab" class="form-control" style="width: 200px;" >
                      <option value="" disabled selected>Régimen</option>
                      <?php
                        $crl=mysqli_query($cone,"SELECT idCondicionLab, Tipo FROM condicionlab WHERE Estado=1 ORDER BY Tipo ASC");
                        while($rrl=mysqli_fetch_assoc($crl)){
                      ?>
                      <option value="<?php echo $rrl['idCondicionLab']; ?>"><?php echo $rrl['Tipo']; ?></option>
                      <?php
                        }
                        mysqli_free_result($crl);
                      ?>
                      <option value="t">TODOS</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="bbb" class="sr-only">Período</label>
                    <select name="pervac" id="pervac" class="form-control" style="width: 200px;" >
                      <option value="" disabled selected>Período</option>
                      <option value="t">TODOS</option>
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
                    <select name="estvac" id="estvac" class="form-control" style="width: 200px;">
                      <option value="" disabled selected>Estado</option>
                      <option value="t">TODOS</option>
                      <option value="0">PENDIENTE</option>
                      <option value="3">EJECUTANDOSE</option>
                      <option value="1">EJECUTADO</option>
                      <option value="2">CANCELADO</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="bbb" class="sr-only">Condición</label>
                    <select name="convac" id="convac" class="form-control" style="width: 200px;">
                      <option value="" disabled selected>Condición</option>
                      <option value="t">TODOS</option>
                      <option value="1">PROGRAMADAS</option>
                      <option value="t">REPROGRAMADAS</option>
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
                    <select name="pervac" id="pervac" class="form-control" style="width: 200px" >
                      <option value="" disabled selected>Período</option>
                      <option value="t">TODOS</option>
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
                      <select name="reglab" id="reglab" class="form-control" style="width: 200px;" >
                        <option value="" disabled selected>Régimen</option>
                        <option value="t">TODOS</option>
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
                        <option value="" disabled selected>Mes</option>
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
                    <select name="estvac" id="estvac" class="form-control" style="width: 200px;">
                      <option value="" disabled selected>Estado</option>
                      <option value="t">TODOS</option>
                      <option value="0">PENDIENTE</option>
                      <option value="3">EJECUTANDOSE</option>
                      <option value="1">EJECUTADO</option>
                      <option value="2">CANCELADO</option>
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
