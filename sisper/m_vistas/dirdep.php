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
        <li class="active">Dependencia</li>
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
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">

                <!--Formulario busqueda-->
                  <form id="f_bteldep">
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group valida">
                                  <select name="dep" id="dep" class="form-control select2" style="width:100%" >
                                    <option value="">DEPENDENCIA</option>
                                    <?php
                                      $cdep=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 ORDER BY Denominacion ASC");
                                      while($rdep=mysqli_fetch_assoc($cdep)){
                                    ?>
                                    <option value="<?php echo $rdep['idDependencia']; ?>"><?php echo $rdep['Denominacion']; ?></option>
                                    <?php
                                      }
                                      mysqli_free_result($cdep);
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-2">
                                <button type="submit" class="btn btn-default" id="b_bteldep">Buscar</button>
                              </div>
                            </div>
                          </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <hr>
                <div class="r_telefono">
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

<!--Modal nuevo telefono-->
<div class="modal fade" id="m_ntelefono" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_ntelefono" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Telefono</h4>
      </div>
      <div class="modal-body" id="d_ntelefono">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gntelefono">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>

</div>
<!--Fin Modal nuevo telefono-->
<!--Modal editar telefono-->
<div class="modal fade" id="m_editel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_etelefono" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Telefono</h4>
      </div>
      <div class="modal-body" id="d_etelefono">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_getelefono">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>

</div>
<!--Fin Modal editar telefono-->

<!--Modal eliminar telefono-->
<div class="modal fade" id="m_elitelefono" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="f_elitelefono" action="" class="form-horizontal">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Telefono</h4>
      </div>
      <div class="modal-body" id="d_elitelefono">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sielitelefono">Sí</button>
        <button type="button" class="btn btn-default" id="b_noelitelefono" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal eliminar telefono-->

<?php
  }else{
    echo accrestringidop();
  }
}else{
header('Location: ../index.php');
}
?>
