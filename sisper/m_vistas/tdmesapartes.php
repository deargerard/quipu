<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],17)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mesa de Partes
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Trámite Doc.</li>
        <li class="active">Mesa de Partes</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-archive text-gray"></i> Mesas de Partes</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn bg-teal" onclick="f_mpartes('agrmpar',0,0);"><i class="fa fa-archive"></i> Mesa de Partes</button>
                  </div>
                  <div class="col-sm-12" id="r_mpar1">

                  </div>
                </div>
                <!--Fin div resultados-->
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

<!--Modal-->
<div class="modal fade" id="m_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" id="m_tamano" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title titulo" id="myModalLabel">Titulo</h4>
      </div>
      <div class="modal-body">
        <form id="f_mmodal" autocomplete="off">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-green" id="b_guardar" form="f_mmodal"><i class="fa fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle Dependencia-->
<!--Modal-->
<div class="modal fade" id="m_modalp" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" id="m_tamanop" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title titulop" id="myModalLabel">Titulo</h4>
      </div>
      <div class="modal-body">
        <form id="f_mmodalp" autocomplete="off">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-green" id="b_guardarp" form="f_mmodalp"><i class="fa fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
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
