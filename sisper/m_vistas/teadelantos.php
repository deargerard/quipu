<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],16)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pagos
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Tesorería</li>
        <li class="active">Pagos</li>
      </ol>
    </section>
    <style type="text/css">
      
    </style>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Pagos</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">

                <form class="form-inline">                  
                  <label for="tra" class="col-sm-1" >Trabajador </label>
                  <select name="tra" id="tra" class="form-control select2pertot col-sm-5" style="width: 250px;">
                    <option value="t">TODOS</option>
                  </select>                  
                  <button type="button" class="btn btn-default" id="b_btra" name="b_btra"><i class="fa fa-search"></i> Buscar</button>                  
                </form>

                <div class="row">
                  <div class="col-md-12" id="en_resultado">

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
        <form id="f_entregas" class="form-horizontal">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_guardar" form="f_entregas">Guardar</button>
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
