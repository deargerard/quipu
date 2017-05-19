<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],4)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes Licencias
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Licencias</li>
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
              <li class="active"><a href="#tab_1" data-toggle="tab">Personal/Tipo Licencia/Año</a></li>
              <li><a href="#tab_2" data-toggle="tab">Tipo Licencia/Año</a></li>
              <li><a href="#tab_3" data-toggle="tab">C. Laboral/Mes</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">

                <!--Formulario-->
                <form id="f_pertlicano" class="form-inline">
                  <div class="form-group">
                    <label for="per" class="sr-only">Personal</label>
                    <select name="per" id="per" class="form-control select2peract col-sm-5" style="width: 300px;">
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="tlic" class="sr-only">Tipo Licencia</label>
                    <select class="form-control select2tiplic" id="tlic" name="tlic" style="width: 300px;">
                    <?php
                    $c=mysqli_query($cone, "SELECT * FROM tipolic WHERE Estado=1 ORDER BY TipoLic, MotivoLic ASC;");
                    if(mysqli_num_rows($c)>0){
                      while ($r=mysqli_fetch_assoc($c)) {
                    ?>
                      <option value="<?php echo $r['idTipoLic']; ?>"><?php echo $r['TipoLic']." - ".$r['MotivoLic']; ?></option>
                    <?php
                      }
                    }
                    mysqli_free_result($c);
                    ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="ano" class="sr-only">Año</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="ano" id="ano" value="<?php echo date('Y'); ?>">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="vcan" value="c" id="vcan"> Ver Canceladas
                    </label>
                  </div>
                      <button type="submit" id="b_pertlicano" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <hr>
                  <div class="col-md-12" id="r_pertlicano">
                    <h4 class="text-aqua"><strong>Resultados</strong></h4>
                  </div>
                </div>
                <!--fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">

                <!--Formulario-->
                <form id="f_tlicano" class="form-inline">
                  <div class="form-group">
                    <label for="tlice" class="sr-only">Tipo Licencia</label>
                    <select class="form-control select2tiplice" id="tlice" name="tlice" style="width: 300px;">
                      <option value="t">Todas</option>
                    <?php
                    $c=mysqli_query($cone, "SELECT * FROM tipolic WHERE Estado=1 ORDER BY TipoLic, MotivoLic ASC;");
                    if(mysqli_num_rows($c)>0){
                      while ($r=mysqli_fetch_assoc($c)) {
                    ?>
                      <option value="<?php echo $r['idTipoLic']; ?>"><?php echo $r['TipoLic']." - ".$r['MotivoLic']; ?></option>
                    <?php
                      }
                    }
                    mysqli_free_result($c);
                    ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="anio" class="sr-only">Año</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="anio" id="anio" value="<?php echo date('Y'); ?>">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="vcanc" value="c" id="vcanc"> Ver Canceladas
                    </label>
                  </div>
                      <button type="submit" id="b_tlicano" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <hr>
                  <div class="col-md-12" id="r_tlicano">
                    <h4 class="text-aqua"><strong>Resultados</strong></h4>
                  </div>
                </div>
                <!--fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">

                <!--Formulario-->
                <form id="f_clabmes" class="form-inline">
                  <div class="form-group">
                    <label for="clab" class="sr-only">C. Laboral</label>
                    <select class="form-control select2clab" id="clab" name="clab" style="width: 200px;">
                      <option value="t">TODAS</option>
                    <?php
                    $c=mysqli_query($cone, "SELECT * FROM condicionlab WHERE Estado=1 ORDER BY Tipo ASC;");
                    if(mysqli_num_rows($c)>0){
                      while ($r=mysqli_fetch_assoc($c)) {
                    ?>
                      <option value="<?php echo $r['idCondicionLab']; ?>"><?php echo $r['Tipo']; ?></option>
                    <?php
                      }
                    }
                    mysqli_free_result($c);
                    ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="mes" class="sr-only">Mes</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="mes" id="mes" value="<?php echo date('m/Y'); ?>">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="vcancm" value="c" id="vcancm"> Ver Canceladas
                    </label>
                  </div>
                      <button type="submit" id="b_clabmes" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <hr>
                  <div class="col-md-12" id="r_clabmes">
                    <h4 class="text-aqua"><strong>Resultados</strong></h4>
                  </div>
                </div>
                <!--fin div resultados-->

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