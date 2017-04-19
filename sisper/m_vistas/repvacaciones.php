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
              <li class="active"><a href="#tab_1" data-toggle="tab">Reporte 1</a></li>
              <li><a href="#tab_2" data-toggle="tab">Reporte 2</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">

                <!--Formulario-->
                <form action="" id="f_" class="form-horizontal">
                  <div class="form-group">
                    <label for="aaa" class="col-sm-1 control-label">AAA</label>
                    <div class="col-sm-4 valida">
                      <select name="aaa" id="aaa" class="form-control select2" style="width: 100%;">
                        <option value="">AAA</option>
                      </select>
                    </div>
                    <label for="bbb" class="col-sm-1 control-label">BBB</label>
                    <div class="col-sm-4 valida">
                      <select name="bbb" id="bbb" class="form-control select2" style="width: 100%;">
                        <option value="">BBB</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                      <button type="submit" id="b_bbb" class="btn btn-default">Buscar</button>
                    </div>
                  </div>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_rrr">

                  </div>
                </div>
                <!--fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">

                <!--Formulario-->
                <form action="" id="f_" class="form-horizontal">
                  <div class="form-group">
                    <label for="aaa" class="col-sm-1 control-label">AAA</label>
                    <div class="col-sm-4 valida">
                      <select name="aaa" id="aaa" class="form-control select2" style="width: 100%;">
                        <option value="">AAA</option>
                      </select>
                    </div>
                    <label for="bbb" class="col-sm-1 control-label">BBB</label>
                    <div class="col-sm-4 valida">
                      <select name="bbb" id="bbb" class="form-control select2" style="width: 100%;">
                        <option value="">BBB</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                      <button type="submit" id="b_bbb" class="btn btn-default">Buscar</button>
                    </div>
                  </div>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_rrr">

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