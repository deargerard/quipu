<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],16)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Asignaciones
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"><a href="depmante.php">Tesorería</a></li>
        <li class="active">Asignaciones</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">

              <div class="box-header with-border">
                <h3 class="box-title">Asignaciones</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">

                <form action="" id="f_basignaciones" class="form-inline">
                  <div class="form-group has-feedback">
                    <label for="fecb">Mes/Año</label>
                    <input type="text" class="form-control" id="fecb" placeholder="mm/aaaa" value="<?php echo date("m/Y"); ?>" autocomplete="off">
                    <span class="fa fa-calendar form-control-feedback"></span>
                  </div>
                  <button type="button" id="b_basig" class="btn btn-default"><i class="fa fa-search"></i> Buscar</button>
                  
                </form>

                <div class="row">

                  <div class="col-md-12" id="a_resultado">

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
<!--Modal-->
<div class="modal fade" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="m_tamaño">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel m_titulo">Titulo</h4>
      </div>
      <div class="modal-body">
        <form id="f_asignaciones" class="form-horizontal">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_guardar" form="f_asignaciones">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle Dependencia-->


<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
