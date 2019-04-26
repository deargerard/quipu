<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesoadm($cone,$_SESSION['identi'],16)){
    //$mes="2";
    //$anio="2019";
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Tesorería</li>
        <li class="active">Reportes</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Libro Auxiliar</a></li>
              <li><a href="#tab_2" data-toggle="tab">Gastos por Específica</a></li>
              <li><a href="#tab_3" data-toggle="tab">Pagos Pendientes</a></li>
              <li><a href="#tab_4" data-toggle="tab">Documentos Registrados</a></li>
              <li><a href="#tab_5" data-toggle="tab">Consumo de Viáticos</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">

                <!--Formulario busqueda-->
                <form  action="" id="f_rep1" class="form-inline">
                  
                  <div class="form-group has-feedback">
                    <label for="fecb">Mes/Año</label>
                    <input type="text" class="form-control" name="fecb" id="fecb" placeholder="mm/aaaa" value="<?php echo date("m/Y"); ?>" autocomplete="off">
                    <span class="fa fa-calendar form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <label for="fon">Fondo</label>
                    <select name="fon" id="fon" class="form-control" title="FONDO">
                      <?php
                        $cf=mysqli_query($cone,"SELECT idtefondo, nombre FROM tefondo");
                        while($rf=mysqli_fetch_assoc($cf)){
                      ?>
                      <option value="<?php echo $rf['idtefondo']; ?>"><?php echo $rf['nombre']; ?></option>
                      <?php
                        }
                        mysqli_free_result($cf);
                      ?>
                    </select>
                  </div>
                  <button type="button" id="b_exla" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Exportar</button>       

                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <hr>
                <div class="r_rep1">
                  <h4 class="text-aqua"><strong>Resultados</strong></h4>
                </div>
                <!--Fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Formulario busqueda-->
                <form  action="" id="f_rep2" class="form-inline">
                  
                  <div class="form-group has-feedback">
                    <label for="anob">Año</label>
                    <input type="text" class="form-control" name="anob" id="anob" placeholder="aaaa" value="<?php echo date("Y"); ?>" autocomplete="off">
                    <span class="fa fa-calendar form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <label for="fon">Específica</label>
                    <select name="esp" id="esp" class="form-control" title="ESPECÍFICA">
                      <?php
                        $ce=mysqli_query($cone,"SELECT idteespecifica, nombre, codigo  FROM teespecifica");
                        while($re=mysqli_fetch_assoc($ce)){
                      ?>
                      <option value="<?php echo $re['idteespecifica']; ?>"><?php echo $re['nombre'] . " - ". $re['codigo']; ?></option>
                      <?php
                        }
                        mysqli_free_result($ce);
                      ?>
                    </select>
                  </div>
                  <button type="button" id="b_exge" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Exportar</button>       

                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <hr>
                <div class="r_rep2">
                  <h4 class="text-aqua"><strong>Resultados</strong></h4>
                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_3">

                <!--Formulario busqueda-->
                <form  action="" id="f_rep3" class="form-inline">                
                  <div class="form-group has-feedback">
                    <label for="fon">Fondo: </label>
                    <select name="fon1" id="fon1" class="form-control" title="FONDO">
                      <?php
                        $cf=mysqli_query($cone,"SELECT idtefondo, nombre FROM tefondo");
                        while($rf=mysqli_fetch_assoc($cf)){
                      ?>
                      <option value="<?php echo $rf['idtefondo']; ?>"><?php echo $rf['nombre']; ?></option>
                      <?php
                        }
                        mysqli_free_result($cf);
                      ?>
                    </select>
                  </div>
                  <button type="button" id="b_bpagpen" class="btn btn-default"><i class="fa fa-search"></i> buscar</button>       

                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->                
                <div id="r_rep3">
                  
                </div>
                <!--Fin div resultados-->

              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_4">
                <!--Formulario busqueda-->
                <form  action="" id="f_rep4" class="form-inline">
                  
                  <div class="form-group has-feedback">
                    <label for="anobcp">Año</label>
                    <input type="text" class="form-control" name="anobcp" id="anobcp" placeholder="aaaa" value="<?php echo date("Y"); ?>" autocomplete="off">
                    <span class="fa fa-calendar form-control-feedback"></span>
                  </div>                  
                  <button type="button" id="b_bdocreg" class="btn btn-default"><i class="fa fa-search"></i> buscar</button>       

                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <hr>
                <div id="r_rep4">
                  <h4 class="text-aqua"><strong>Resultados</strong></h4>
                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_5">
                <!--Formulario busqueda-->
                <form  action="" id="f_rep5" class="form-inline">
                  
                  <div class="form-group has-feedback">
                    <label for="anobcv">Año</label>
                    <input type="text" class="form-control" name="anobcv" id="anobcv" placeholder="aaaa" value="<?php echo date("Y"); ?>" autocomplete="off">
                    <span class="fa fa-calendar form-control-feedback"></span>
                  </div>                  
                  <button type="button" id="b_bconvia" class="btn btn-default"><i class="fa fa-search"></i> buscar</button>       

                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <hr>
                <div id="r_rep5">
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