<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],13)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Documentario
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Documentario</li>
        <li class="active">Registro/Busqueda</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Registro/Busqueda</h3>
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
                      <button type="button" id="b_ndoc" class="btn btn-info" data-toggle="modal" data-target="#m_nuedocu"><i class="fa fa-file-text"></i> Nuevo</button>
                      <div class="form-group">
                        <select name="numdoc" id="numdoc" class="form-control select2doc" style="width: 300px;">
                        </select>
                      </div>
                      <button type="button" id="b_doc" class="btn bg-orange"><i class="fa fa-search"></i></button>
                      <div class="form-group">
                        <input type="text" class="form-control" name="ndoc" id="ndoc" style="width: 70px;" placeholder="N° Doc">
                      </div>
                      <div class="form-group">
                        <div class="input-group date" id="d_adoc">
                          <input type="text" class="form-control" name="adoc" id="adoc" style="width: 80px;" placeholder="aaaa" value="<?php echo date('Y'); ?>">
                          <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                        </div>
                      </div>
                      <button type="button" id="b_num" class="btn bg-orange"><i class="fa fa-search"></i></button>
                      <div class="form-group">
                        <div class="input-group date" id="d_fini">
                          <input type="text" class="form-control" name="fini" id="fini" style="width: 110px;" placeholder="dd/mm/aaaa">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="input-group date" id="d_ffin">
                          <input type="text" class="form-control" name="ffin" id="ffin" value="<?php echo date('d/m/Y'); ?>" style="width: 110px;">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                      <button type="button" id="b_fec" class="btn bg-orange"><i class="fa fa-search"></i></button>
                    </form>
                    <!--Fin Formulario-->
                    <!--div resultados-->
                    <div class="row">
                      <hr>
                      <div class="col-md-12" id="r_bdoc">
                        <h4 class="text-muted text-center"><i class="fa fa-file-text text-yellow"></i> Documentos</h4>
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
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-file-text text-gray"></i> Nuevo Documento</h4>
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
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit text-gray"></i> Editar Documento</h4>
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