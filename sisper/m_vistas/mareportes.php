<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(solucionador($cone,$_SESSION['identi'])){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes Mesa de Ayuda
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Mesa de Ayuda</li>
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
              <li class="active"><a href="#tab_1" data-toggle="tab">Atenciones por solucionador y fechas</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Formulario-->
                <form action="" id="f_rama" class="form-inline">
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Solucionador</label>
                    <select name="soluc" id="soluc" class="form-control select2sol" style="width: 300px;">
                      <option value="t">TODOS LOS SOLUCIONADORES</option>
                      <?php
                        $csol=mysqli_query($cone,"SELECT idSolucionador, idEmpleado FROM masolucionador;");
                        while($rsol=mysqli_fetch_assoc($csol)){
                      ?>
                        <option value="<?php echo $rsol['idSolucionador'] ?>"><?php echo nomempleado($cone, $rsol['idEmpleado']) ?></option>
                      <?php
                        }
                        mysqli_free_result($csol);
                      ?>

                    </select>
                  </div>
                  <div class="form-group">
                    <label for="aaa" class="sr-only">Mes Inicial</label>
                    <input class="form-control" id="mesini" name="mesini" placeholder="dd/mm/aaaa (INICIO)">
                  </div>

                  <div class="form-group">
                    <label for="aaa" class="sr-only">Mes Final</label>
                    <input class="form-control" id="mesfin" name="mesfin" placeholder="dd/mm/aaaa (FIN)">
                  </div>
                    <button type="button" id="b_bama" class="btn btn-default">Buscar</button>
                    <button type="button" id="b_eama" class="btn bg-aqua"><i class="fa fa-file-excel-o"></i> Exportar</button>
                </form>
                <!--Fin Formulario-->

                <!--div resultados-->
                <div class="row">
                  <div class="col-md-12" id="r_ama">

                  </div>
                </div>
                <!--fin div resultados-->
              </div>
              <!-- /.tab-pane -->


            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div> <!-- /.col-md-12 -->
      </div> <!-- /.row -->

    </section>
    <!-- /.content -->

    <div class="modal fade" id="m_iatencion" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-info-circle"></i> Info de la Atención</h4>
          </div>
          <div class="modal-body" id="r_iatencion">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

<?php

}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
