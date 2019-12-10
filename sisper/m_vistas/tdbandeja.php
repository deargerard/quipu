<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],17)){
    $ide=$_SESSION['identi'];

    $cm=mysqli_query($cone, "SELECT mp.tipo FROM tdpersonalmp pm INNER JOIN tdmesapartes mp ON pm.idtdmesapartes=mp.idtdmesapartes WHERE pm.idEmpleado=$ide AND pm.estado=1 AND mp.estado=1;");
    if($rm=mysqli_fetch_assoc($cm)){
      $tmp=$rm['tipo'];
    }
    mysqli_free_result($cm);
    $en=false;
    $cn=mysqli_query($cone, "SELECT ec.idEmpleadoCargo FROM empleadocargo ec INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia WHERE ec.idEmpleado=$ide AND ec.idEstadoCar=1 AND cd.Estado=1 AND (d.Denominacion LIKE '%NOTIFICACIONES%');");
    if(mysqli_num_rows($cn)>0){
      $en=true;
    }
    mysqli_free_result($cn);
    $eno=false;
    if(cargoe($cone, $ide)=='ASISTENTE ADMINISTRATIVO - NTF'){
      $eno=true;
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
              <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Recibir</a></li>
              <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Registrar</a></li>
              <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Derivar <?php echo $tmp ? "a MP" : ""; ?> </a></li>
              <?php if($tmp==1){ ?>
              <li><a href="#tab_9" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Derivar a Per.</a></li>
              <?php } ?>
              <?php if($tmp==2){ ?>
              <li><a href="#tab_4" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Derivar Ntf.</a></li>
              <?php } ?>
              <li><a href="#tab_5" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Atender</a></li>
              <?php if($en || $eno){ ?>
              <li><a href="#tab_6" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Reportar Ntf.</a></li>
              <?php } ?>
              <?php if($tmp){ ?>
              <li><a href="#tab_7" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Pend. Recepción</a></li>
              <?php } ?>
              <?php if(!is_null($tmp)){ ?>
              <li><a href="#tab_8" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Guías</a></li>
              <?php } ?>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn bg-yellow" onclick="li_ban1();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                  </div>
                </div>
                <div class="row" id="r_ban1">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-md-5">
                    <button type="button" class="btn bg-yellow" onclick="li_ban2();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                    <button type="button" class="btn bg-teal" onclick="f_bandeja('agrdoc',0,0);"><i class="fa fa-file-text-o"></i> Registrar</button>
                    <?php if($tmp){ ?>
                    <button type="button" class="btn bg-purple" onclick="f_bandeja('gencar',0,0);"><i class="fa fa-files-o"></i> Generar Cargo</button>
                    <?php } ?>
                  </div>
                  <div class="col-md-7">
                    
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
                    <button type="button" class="btn bg-yellow" onclick="li_ban3();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                  </div>
                  <div class="col-md-7">
                    <?php if($tmp){ ?>
                    <form class="form-inline pull-right">
                      <div class="form-group">
                        <label for="smpar">Derivar a</label>
                        <select class="form-control" name="smpar" id="smpar" style="width: 350px;">
                          
                        </select>
                      </div>
                      <button type="button" class="btn bg-orange" id="b_lim3"><i class="fa fa-eraser"></i> Limpiar</button>
                    </form>
                    <?php } ?>
                  </div>
                </div>
                <div class="row" id="r_ban3">

                </div>
                <!--Fin div resultados-->
                
              </div>
              <!-- /.tab-pane -->
              <?php if($tmp==1){ ?>
              <div class="tab-pane" id="tab_9">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-md-5">
                    <button type="button" class="btn bg-yellow" onclick="li_ban9();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                  </div>
                  <div class="col-md-7">
                    <form class="form-inline pull-right">
                      <div class="form-group">
                        <label for="sper">Derivar a</label>
                        <select class="form-control" name="sper1" id="sper1" style="width: 350px;">
                          
                        </select>
                      </div>
                      <button type="button" class="btn bg-orange" id="b_lim9"><i class="fa fa-eraser"></i> Limpiar</button>
                    </form>
                  </div>
                </div>
                <div class="row" id="r_ban9">

                </div>
                <!--Fin div resultados-->
                
              </div>
              <!-- /.tab-pane -->
              <?php } ?>
              <?php if($tmp==2){ ?>
              <div class="tab-pane" id="tab_4">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-5">
                    <button type="button" class="btn bg-yellow" onclick="li_ban4();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                  </div>
                  <div class="col-sm-7">
                    <form class="form-inline pull-right">
                      <div class="form-group">
                        <label for="sper">Derivar a</label>
                        <select class="form-control" name="sper" id="sper" style="width: 350px;">
                          
                        </select>
                      </div>
                      <button type="button" class="btn bg-orange" id="b_lim4"><i class="fa fa-eraser"></i> Limpiar</button>
                    </form>
                  </div>
                </div>
                <div class="row" id="r_ban4">

                </div>
                <!--Fin div resultados-->
              </div>
              <?php } ?>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_5">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn bg-yellow" onclick="li_ban5();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                  </div>
                </div>
                <div class="row" id="r_ban5">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <?php if($en || $eno){ ?>
              <div class="tab-pane" id="tab_6">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn bg-yellow" onclick="li_ban6();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                  </div>
                </div>
                <div class="row" id="r_ban6">

                </div>
                <!--Fin div resultados-->
              </div>
              <?php } ?>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_7">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn bg-yellow" onclick="li_ban7();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                  </div>
                </div>
                <div class="row" id="r_ban7">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <?php if(!is_null($tmp)){ ?>
              <div class="tab-pane" id="tab_8">
                <!--Div resultados-->
                <div class="row" id="r_ban8">

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
