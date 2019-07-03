<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],17)){
    $ide=$_SESSION['identi'];
    $mpm=false;
    $cm=mysqli_query($cone, "SELECT idtdpersonalmp FROM tdpersonalmp WHERE idEmpleado=$ide AND estado=1;");
    if(mysqli_num_rows($cm)>0){
      $mpm=true;
    }
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
              <?php if($mpm){ ?>
              <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-circle-o text-gray"></i> Recibir/Revertir</a></li>
              <?php } ?>
              <li <?php echo $mpm ? '' : 'class="active"'; ?>><a href="#tab_2" data-toggle="tab"><i class="fa fa-circle-o text-gray"></i> Registrar/Derivar</a></li>
              <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-circle-o text-gray"></i> Asignar</a></li>
              <li><a href="#tab_4" data-toggle="tab"><i class="fa fa-circle-o text-gray"></i> Reportar Ntf.</a></li>
              <li><a href="#tab_5" data-toggle="tab"><i class="fa fa-circle-o text-gray"></i> Atender/Archivar</a></li>
              <?php if($mpm){ ?>
              <li><a href="#tab_6" data-toggle="tab"><i class="fa fa-circle-o text-gray"></i> Guías</a></li>
              <?php } ?>
            </ul>
            <div class="tab-content">
              <?php if($mpm){ ?>
              <div class="tab-pane active" id="tab_1">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn bg-yellow" onclick="li_ban1();"><i class="fa fa-refresh"></i> Actualizar</button>
                  </div>
                </div>
                <div class="row" id="r_ban1">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <?php } ?>
              <div class="tab-pane <?php echo $mpm ? '' : 'active'; ?>" id="tab_2">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-md-5">
                    <button type="button" class="btn bg-teal" onclick="f_bandeja('agrdoc',0,0);"><i class="fa fa-file-text-o"></i> Registrar</button>
                    <button type="button" class="btn bg-yellow" onclick="li_ban2();"><i class="fa fa-refresh"></i> Actualizar</button>
                  </div>
                  <div class="col-md-7">
                    <form class="form-inline pull-right">
                      <div class="form-group">
                        <label for="smpar">Derivar a</label>
                        <select class="form-control" name="smpar" id="smpar" style="width: 350px;">
                          
                        </select>
                      </div>
                      <button type="button" class="btn bg-orange" id="b_lim2"><i class="fa fa-eraser"></i> Limpiar</button>
                    </form>
                  </div>
                </div>
                <div class="row" id="r_ban2">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-md-5">
                    <button type="button" class="btn bg-yellow" onclick="li_ban3();"><i class="fa fa-refresh"></i> Actualizar</button>
                  </div>
                  <div class="col-md-7">
                    <form class="form-inline pull-right">
                      <div class="form-group">
                        <label for="sper">Asignar a</label>
                        <select class="form-control" name="sper" id="sper" style="width: 350px;">
                          
                        </select>
                      </div>
                      <button type="button" class="btn bg-orange" id="b_lim3"><i class="fa fa-eraser"></i> Limpiar</button>
                    </form>
                  </div>
                </div>
                <div class="row" id="r_ban3">

                </div>
                <!--Fin div resultados-->
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn bg-yellow" onclick="li_ban4();"><i class="fa fa-refresh"></i> Actualizar</button>
                  </div>
                </div>
                <div class="row" id="r_ban4">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_5">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn bg-yellow" onclick="li_ban5();"><i class="fa fa-refresh"></i> Actualizar</button>
                  </div>
                </div>
                <div class="row" id="r_ban5">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <?php if($mpm){ ?>
              <div class="tab-pane" id="tab_6">
                <!--Div resultados-->
                <div class="row" id="r_ban6">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <?php } ?>
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
        <h4 class="modal-title" id="myModalLabel">Titulo</h4>
      </div>
      <div class="modal-body">
        <form id="f_modal" autocomplete="off">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-green" id="b_guardar" form="f_modal"><i class="fa fa-save"></i> Guardar</button>
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
