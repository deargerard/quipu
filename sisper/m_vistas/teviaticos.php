<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],16)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Viáticos
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><a href="#">Tesorería</a></li>
        <li class="active">Viáticos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Viáticos</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">

                <form class="form-inline" id="f_lviaticos">
                  <div class="form-group has-feedback">
                    <label for="fecb">Mes/Año</label>
                    <input type="text" class="form-control" name="fecb" id="fecb" placeholder="mm/aaaa" value="<?php echo date("m/Y"); ?>" autocomplete="off" style="width: 300px;">
                    <span class="fa fa-calendar form-control-feedback"></span>
                  </div>
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Buscar</button>
                </form>
                <div id="l_viaticos">
                  
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
<!-- Modal -->
<div class="modal fade" id="m_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" id="m_tamaño">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title m_titulo" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <form id="f_viaticos" autocomplete="off">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="b_guardar" form="f_rendiciones">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal1 -->
<div class="modal fade" id="m1_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document" id="m1_tamaño">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title m1_titulo" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <form id="f1_viaticos" autocomplete="off">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="b1_guardar" form="f1_viaticos">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Modal1-->


<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
