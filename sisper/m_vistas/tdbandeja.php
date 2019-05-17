<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],17)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bandeja
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Trámite Doc.</li>
        <li class="active">Bandeja</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Bandeja</a></li>
              <li><a href="#tab_2" data-toggle="tab">Guía</a></li>
              <li><a href="#tab_3" data-toggle="tab">Pendientes de Recepción</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Div resultados-->
                <div class="r_ban1">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i> Documento</button>
                    <button type="button" class="btn btn-warning"><i class="fa fa-refresh"></i> Actualizar</button>
                    <hr>
                    <table class="table table-bordered table-hover" id="dt_ban1i">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>DOCUMENTO</th>
                          <th>F. EMITIDO</th>
                          <th>F. DERIVADO</th>
                          <th>F. RECIBIDO</th>
                          <th>GUÍA</th>
                          <th>ESTADO</th>
                          <th>ACCIÓN</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>12-2019-MPFN</td>
                          <td>12/12/2019</td>
                          <td>12/12/2019</td>
                          <td>12/12/2019</td>
                          <td>5-2019</td>
                          <td>Recibido</td>
                          <td>
                            <button type="button" class="btn btn-xs bg-purple"><i class="fa fa-plus"></i></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Div resultados-->
                <div class="r_ban2">
                  <button type="button" class="btn btn-info"><i class="fa fa-plus"></i> Guía</button>
                  <button type="button" class="btn btn-warning"><i class="fa fa-refresh"></i> Actualizar</button>
                  <hr>
                  <table class="table table-bordered table-hover" id="dt_ban1d">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>GUÍA</th>
                        <th>ESTADO</th>
                        <th>ACCIÓN</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>5-2019</td>
                        <td>Recibido</td>
                        <td>
                          <button type="button" class="btn btn-xs bg-purple"><i class="fa fa-plus"></i></button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!--Fin div resultados-->
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <!--Div resultados-->
                <div class="r_ban3">
                  <button type="button" class="btn btn-warning"><i class="fa fa-refresh"></i> Actualizar</button>
                  <hr>
                  <table class="table table-bordered table-hover" id="dt_ban3">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>DOCUMENTO</th>
                        <th>GUÍA</th>
                        <th>ESTADO</th>
                        <th>ACCIÓN</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>12-2019-MPFN</td>
                        <td>5-2019</td>
                        <td>Recibido</td>
                        <td>
                          <button type="button" class="btn btn-xs bg-purple"><i class="fa fa-plus"></i></button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
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
<div class="modal fade" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="m_tamaño">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel m_titulo">Titulo</h4>
      </div>
      <div class="modal-body">
        <form id="f_modal">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_guardar" form="f_modal">Guardar</button>
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
