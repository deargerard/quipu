<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],4)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Licencias
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Licencias</li>
        <li class="active">Licencias</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Licencias</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <!--Formulario-->
                    <form action="" id="f_pervac" class="form-horizontal">
                      <div class="form-group">
                        <label for="perlic" class="col-sm-1 control-label">Personal</label>
                        <div class="col-sm-6 valida">
                          <select name="perlic" id="perlic" class="form-control select2" style="width: 100%;">
                            <option value="">Personal</option>
                          </select>
                        </div>
                        <label for="per" class="col-sm-1 control-label">Periodo</label>
                        <div class="col-sm-4 valida">
                          <select name="per" id="per" class="form-control select2" style="width: 100%;">
                            <option value="">Periodo</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-11">
                          <button type="submit" id="b_bpervac" class="btn btn-default">Buscar</button>
                        </div>
                      </div>
                    </form>
                    <!--Fin Formulario-->
                    <!--div resultados-->
                    <div class="row">
                      <hr>
                      <div class="col-md-12" id="r_perlic">

                      </div>
                    </div>
                    <!--fin div resultados-->
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