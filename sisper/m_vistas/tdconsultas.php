<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesoadm($cone,$_SESSION['identi'],16)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Consultas
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Trámite Doc.</li>
        <li class="active">Consultas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-circle-o text-gray"></i> Documento</a></li>
              <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-circle-o text-gray"></i> Guía</a></li>
              <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-circle-o text-gray"></i> Personal/Documentos</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">

                <!--Formulario busqueda-->
                <form class="form-inline" id="f_rep1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="numdoc" name="numdoc" placeholder="# Documento">
                    </div>
                    <div class="form-group">
                      <div class="input-group date" id="d_dano">
                        <input type="text" name="dano" id="dano" class="form-control" value="<?php echo date('Y'); ?>">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Buscar </button>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <hr>
                <div id="r_rep1">
                  <h4 class="text-aqua"><strong>Resultados</strong></h4>
                </div>
                <!--Fin div resultados-->
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Formulario busqueda-->
                <form class="form-inline" id="f_rep2">
                    <div class="form-group">
                        <input type="text" class="form-control" id="numgui" name="numgui" placeholder="# Guía">
                    </div>
                    <div class="form-group">
                      <div class="input-group date" id="d_gano">
                        <input type="text" name="gano" id="gano" class="form-control" value="<?php echo date('Y'); ?>">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <select class="form-control" name="mpar" id="mpar" style="width: 350px;">
                          
                      </select>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Buscar </button>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <hr>
                <div id="r_rep2">
                  <h4 class="text-aqua"><strong>Resultados</strong></h4>
                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_3">

                <!--Formulario busqueda-->
                <form class="form-inline" id="f_rep3">
                    <div class="form-group">
                        <select name="per" id="per" class="form-control" style="width: 350px;">
                            <option value="t">Todos</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="est" id="est" class="form-control">
                            <option value="t">Todos</option>
                          <?php
                          $ce=mysqli_query($cone, "SELECT * FROM tdestado WHERE estado=1;");
                          if(mysqli_num_rows($ce)>0){
                            while($re=mysqli_fetch_assoc($ce)){
                          ?>
                            <option value="<?php echo $re['idtdestado']; ?>"><?php echo $re['nombre']; ?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <div class="input-group date" id="d_des">
                        <input type="text" name="des" id="des" class="form-control">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group date" id="d_has">
                        <input type="text" name="has" id="has" class="form-control" value="<?php echo date('d/m/Y'); ?>">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Buscar </button>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->                
                <hr>
                <div id="r_rep3">
                  <h4 class="text-aqua"><strong>Resultados</strong></h4>
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
  <div class="modal-dialog" id="m_tamano" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Titulo</h4>
      </div>
      <div class="modal-body">
        <form id="f_cmodal" autocomplete="off">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_guardar" form="f_cmodal">Guardar</button>
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