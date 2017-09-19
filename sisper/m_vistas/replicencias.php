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
              <li class="active"><a href="#tab_1" data-toggle="tab">Personal/Cargo/Tipo Lic./Año</a></li>
              <li><a href="#tab_2" data-toggle="tab">Personal/Tipo Lic./Fechas</a></li>
              <li><a href="#tab_3" data-toggle="tab">Tipo Lic./Año</a></li>
              <li><a href="#tab_4" data-toggle="tab">C. Laboral/Mes</a></li>
              <li><a href="#tab_5" data-toggle="tab">Sis. Lab./Tipo Lic./Año</a></li>
              <li><a href="#tab_6" data-toggle="tab">Lic. sin goce</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">

                <!--Formulario-->
                <form id="f_pertlicano" class="form-inline">
                  <div class="form-group">
                    <label for="per" class="sr-only">Personal</label>
                    <select name="per" id="per" class="form-control select2pertot col-sm-5" style="width: 300px;">
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="car" class="sr-only">Cargo </label>
                    <select name="car" id="car" class="form-control select2" style="width: 250px;">

                    </select>
                  </div>
                  <div class="form-group">
                    <label for="tlic" class="sr-only">Tipo Licencia</label>
                    <select data-actions-box="true" id="tlic" name="tlic[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="Tipo Licencia">
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
                  <div class="form-group has-feedback">
                    <label for="ano" class="sr-only">Año</label>

                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" name="ano" id="ano" value="<?php echo date('Y'); ?>" style="width: 90px;">

                  </div>
                  <div class="form-group">
                    <label for="est" class="sr-only">Estado</label>
                    <select id="est" name="est[]" class="form-control selectpicker show-tick" multiple data-selected-text-format="count" title="Estado">
                      <option value="1" selected>Activos</option>
                      <option value="0">Cancelados</option>
                    </select>
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
                <form id="f_pertlicfec" class="form-inline">
                  <div class="form-group">
                    <label for="per" class="sr-only">Personal</label>
                    <select name="per" id="per" class="form-control select2pertodos col-sm-5" style="width: 300px;">
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="tlic" class="sr-only">Tipo Licencia</label>
                    <select data-actions-box="true" id="tlic" name="tlic[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="Tipo Licencia">
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
                  <div class="form-group has-feedback">
                    <label for="fini" class="sr-only">Inicio</label>

                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" name="f1" id="f1" style="width: 125px;">

                  </div>
                  <div class="form-group has-feedback">
                    <label for="ffin" class="sr-only">Fin</label>

                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" name="f2" id="f2" style="width: 125px;">

                  </div>
                  <div class="form-group">
                    <label for="est" class="sr-only">Estado</label>
                    <select id="est" name="est[]" class="form-control selectpicker show-tick" multiple data-selected-text-format="count" title="Estado">
                      <option value="1" selected>Activos</option>
                      <option value="0">Cancelados</option>
                    </select>
                  </div>
                      <button type="submit" id="b_pertlicfec" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <hr>
                  <div class="col-md-12" id="r_pertlicfec">
                    <h4 class="text-aqua"><strong>Resultados</strong></h4>
                  </div>
                </div>
                <!--fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">

                <!--Formulario-->
                <form id="f_tlicano" class="form-inline">
                  <div class="form-group">
                    <label for="tlic" class="sr-only">Tipo Licencia</label>
                    <select data-actions-box="true" id="tlic" name="tlice[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="Tipo Licencia">
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
                  <div class="form-group has-feedback">
                    <label for="anio" class="sr-only">Año</label>
                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" name="anio" id="anio" value="<?php echo date('Y'); ?>" style="width: 90px;">

                  </div>
                  <div class="form-group">
                    <label for="est" class="sr-only">Estado</label>
                    <select id="est" name="est[]" class="form-control selectpicker show-tick" multiple data-selected-text-format="count" title="Estado">
                      <option value="1" selected>Activos</option>
                      <option value="0">Cancelados</option>
                    </select>
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
              <div class="tab-pane" id="tab_4">

                <!--Formulario-->
                <form id="f_clabmes" class="form-inline">
                  <div class="form-group">
                    <label for="clab" class="sr-only">C. Laboral</label>
                    <select data-actions-box="true" id="clab" name="clab[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="CONDICIÓN LABORAL">
                      <?php
                      $c=mysqli_query($cone, "SELECT * FROM condicionlab WHERE Estado=1 AND Tipo<>'SECIGRA' AND Tipo<>'VOLUNTARIADO' ORDER BY Tipo ASC;");
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
                  <div class="form-group has-feedback">
                    <label for="mes" class="sr-only">Mes</label>

                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" name="mes" id="mes" value="<?php echo date('m/Y'); ?>" style="width: 110px;">

                  </div>
                  <div class="form-group">
                    <label for="est" class="sr-only">Estado</label>
                    <select id="est" name="est[]" class="form-control selectpicker show-tick" multiple data-selected-text-format="count" title="Estado">
                      <option value="1" selected>Activos</option>
                      <option value="0">Cancelados</option>
                    </select>
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
              <div class="tab-pane" id="tab_5">

                <!--Formulario-->
                <form id="f_slabtlicano" class="form-inline">
                  <div class="form-group">
                    <label for="slab" class="sr-only">S. Laboral</label>
                    <select data-actions-box="true" id="slab" name="slab[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="SISTEMA LABORAL">
                      <?php
                      $c=mysqli_query($cone, "SELECT * FROM sistemalab WHERE SistemaLab<>'SECIGRA' AND SistemaLab<>'VOLUNTARIADO' ORDER BY SistemaLab ASC;");
                      if(mysqli_num_rows($c)>0){
                        while ($r=mysqli_fetch_assoc($c)) {
                      ?>
                        <option value="<?php echo $r['idSistemaLab']; ?>"><?php echo $r['SistemaLab']; ?></option>
                      <?php
                        }
                      }
                      mysqli_free_result($c);
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="tlic" class="sr-only">Tipo Licencia</label>
                    <select data-actions-box="true" id="tlic" name="tlic[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="Tipo Licencia">
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
                  <div class="form-group has-feedback">
                    <label for="ano" class="sr-only">Año</label>

                      <span class="fa fa-calendar form-control-feedback"></span>
                      <input type="text" class="form-control" name="ano" id="ano" value="<?php echo date('Y'); ?>" style="width: 90px;">

                  </div>
                  <div class="form-group">
                    <label for="est" class="sr-only">Estado</label>
                    <select id="est" name="est[]" class="form-control selectpicker show-tick" multiple data-selected-text-format="count" title="Estado">
                      <option value="1" selected>Activos</option>
                      <option value="0">Cancelados</option>
                    </select>
                  </div>
                      <button type="submit" id="b_slabtlicano" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <hr>
                  <div class="col-md-12" id="r_slabtlicano">
                    <h4 class="text-aqua"><strong>Resultados</strong></h4>
                  </div>
                </div>
                <!--fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_6">

                <!--Formulario-->
                <form id="f_licsg" class="form-inline">
                  <div class="form-group">
                    <label for="per1" class="sr-only">Personal</label>
                    <select name="per1" id="per1" class="form-control select2pertot1 col-sm-5" style="width: 300px;">
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="car1" class="sr-only">Cargo </label>
                    <select name="car1" id="car1" class="form-control select2" style="width: 250px;">

                    </select>
                  </div>
                      <button type="submit" id="b_licsg" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <hr>
                  <div class="col-md-12" id="r_licsg">
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

<!--Modal Detalle Licencia-->
<div class="modal fade" id="m_detlic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Licencia</h4>
      </div>
      <div class="modal-body" id="r_detlic">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle Licencia-->
<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>