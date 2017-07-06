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
                    <form id="f_licper" class="form-inline">
                      <div class="form-group">
                        <label for="licper" class="sr-only">Personal</label>
                        <select name="licper" id="licper" class="form-control select2peract" style="width: 350px;">
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
                          <button type="submit" id="b_blicper" class="btn btn-default">Buscar</button>
                    </form>
                    <!--Fin Formulario-->
                    <!--div resultados-->
                    <div class="row">
                      <hr>
                      <div class="col-md-12" id="r_licper">
                        <h4 class="text-aqua"><strong>Licencias</strong></h4>
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
<!--Modal Nueva Dependencia-->
<div class="modal fade" id="m_nuelic" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_nuelic" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Licencia</h4>
      </div>
      <div class="modal-body" id="r_nuelic">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnuelic">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Nueva Dependencia-->
<!--Modal Editar Dependencia-->
<div class="modal fade" id="m_edilic" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edilic" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Licencia</h4>
      </div>
      <div class="modal-body" id="r_edilic">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedilic">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Dependencia-->
<!--Modal Editar Dependencia-->
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
<!--Fin Modal Editar Dependencia-->
<!--Modal estado licencia-->
<div class="modal fade" id="m_estlic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cambiar Estado</h4>
      </div>
      <form id="f_estlic" action="" class="form-horizontal">
      <div class="modal-body" id="r_estlic">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_siestlic">Si</button>
        <button type="button" class="btn btn-default" id="b_noestlic" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal estado licencia-->
<!--Modal nuevo documento-->
<div class="modal fade" id="m_nuedocu" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_nuedocu" action="" class="form-horizontal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Documento</h4>
      </div>
      <div class="modal-body" id="r_nuedocu">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnuedocu">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal nuevo documento-->
<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>