<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesoadm($cone,$_SESSION['identi'],12)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Directorio
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Directorio</li>
        <li class="active">Personal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Teléfono</a></li>
              <li><a href="#tab_2" data-toggle="tab">Correo</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">

                <!--Formulario busqueda-->
                <form class="form-inline" id="f_btelper">
                  <div class="form-group">
                    <div class="input-group valida">
                      <select class="form-control" name="ano" id="ano">
                        <option value="">PERSONAL</option>
                        <option value="2016">JUAN PEREZ</option>
                      </select>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-default" id="b_btelper">Buscar</button>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <div class="r_telefono">
                  <h2>Resultados</h2>
                </div>
                <!--Fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Formulario busqueda-->
                <form class="form-inline" id="f_bcorper">
                  <div class="form-group">
                    <div class="input-group valida">
                      <select class="form-control" name="ano" id="ano">
                        <option value="">PERSONAL</option>
                        <option value="2016">JUAN PEREZ</option>
                      </select>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-default" id="b_bcorper">Buscar</button>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <div class="r_correo">
                  <h2>Resultados</h2>
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

<!--Modal nuevo comunicado-->
<div class="modal fade" id="m_ncomunicado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="f_ncomunicado" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Comunicado</h4>
      </div>
      <div class="modal-body" id="d_ncomunicado">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gncomunicado">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
  
</div>
<!--Fin Modal nuevo comunicado-->


<!--Modal desactivar boletín-->
<div class="modal fade" id="m_dboletin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_dboletin" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Desactivar Boletín</h4>
      </div>
      <div class="modal-body" id="d_dboletin">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sidboletin">Si</button>
        <button type="button" class="btn btn-default" id="b_nodboletin" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal desactivar boletín-->

<?php
  }else{
    echo accrestringidop();
  }
}else{
header('Location: ../index.php');
}
?>