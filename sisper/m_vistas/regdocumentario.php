<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],13)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administracion Documentaria
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Licencias</li>
        <li class="active">Registro</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Registro</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <!--Formulario-->
                    <form id="f_bdoc" class="form-inline">
                      <div class="form-group">
                        <label for="numdoc" class="sr-only">Número</label>
                        <select name="numdoc" id="numdoc" class="form-control select2doc" style="width: 300px;">
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="fini" class="sr-only">Año</label>
                        <div class="input-group">
                          <input type="text" class="form-control" name="fini" id="fini">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="ffin" class="sr-only">Año</label>
                        <div class="input-group">
                          <input type="text" class="form-control" name="ffin" id="ffin" value="<?php echo date('d/m/Y'); ?>">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                          <button type="submit" id="b_bdoc" class="btn btn-default">Buscar</button>
                          <button type="button" id="b_ndoc" class="btn btn-info" data-toggle="modal" data-target="#m_nuedocu">Nuevo</button>
                    </form>
                    <!--Fin Formulario-->
                    <!--div resultados-->
                    <div class="row">
                      <hr>
                      <div class="col-md-12" id="r_bdoc">
                        <h4 class="text-aqua"><strong>Documentos</strong></h4>
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
<!--Modal Nueva doc-->
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
<!--Fin Modal Nueva doc-->
<!--Modal Editar doc-->
<div class="modal fade" id="m_edidocu" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edidocu" action="" class="form-horizontal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Documento</h4>
      </div>
      <div class="modal-body" id="r_edidocu">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedidocu">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar doc-->

<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>