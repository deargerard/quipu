<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],15)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes Comisiones de Servicio
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Comisiones</li>
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
              <li class="active"><a href="#tab_1" data-toggle="tab">Comisiones por Trabajador</a></li>
              <li><a href="#tab_2" data-toggle="tab">Comisiones por Meses</a></li>
              <li><a href="#tab_3" data-toggle="tab">Comisiones por Resolución</a></li>

            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Formulario-->
                <form action="" id="f_rcomsertra" class="form-inline">
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Personal</label>
                    <select name="per" id="per" class="form-control select2pertot" style="width: 300px;">

                    </select>
                  </div>
                  <div class="form-group">
                    <label for="bbb" class="sr-only">Estado </label>
                    <select data-actions-box="true" name="estcs[]" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="ESTADO" >
                      <option value="1" selected="select">ACTIVAS</option>
                      <option value="2">CANCELADAS</option>
                    </select>
                  </div>

                    <button type="submit" id="b_bcomsertra" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->

                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_comsertra">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Formulario-->
                <form action="" id="f_rcomsermes" class="form-inline">
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Mes Inicial</label>
                    <input class="form-control" id="mesini" name="mesini" placeholder="MM/AAAA (INICIO)">
                  </div>

                  <div class="form-group">
                    <label for="aaa" class="sr-only">Mes Final</label>
                    <input class="form-control" id="mesfin" name="mesfin" placeholder="MM/AAAA (FIN)">
                  </div>
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Estado</label>
                    <select name="estcs[]" id="estcs" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="ESTADO">
                      <option value="1" selected="select">ACTIVAS</option>
                      <option value="2">CANCELADAS</option>
                    </select>
                  </div>
                  <button type="submit" id="b_bcomermes" class="btn btn-default">Buscar</button>
                  <button type="button" id="b_ecomsermes" class="btn bg-aqua">Exportar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_comsermes">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">

                <!--Formulario-->
                <form action="" id="f_rcomserres" class="form-inline">
                  <div class="form-group">
                    <label for="doc" class="sr-only">Documento</label>
                    <select name="doc" id="doc" class="form-control select2doc" style="width:400px;">
                    </select>
                  </div>
                  <button type="button" id="b_bcomserres" class="btn btn-default">Buscar</button>
                  <button type="button" id="b_ecomserres" class="btn btn-info">Exportar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_comserres">

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
