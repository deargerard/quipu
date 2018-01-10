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
                <form id="f_btelper">
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="form-group valida">
                          <select class="form-control select2" name="per" id="per" style="width: 100%;">
                            <option value="">PERSONAL</option>
                            <?php
                            $c=mysqli_query($cone, "SELECT idEmpleado, concat(ApellidoPat, ' ', ApellidoMat, ', ', Nombres) as nombre FROM empleado WHERE Estado=1 ORDER BY nombre ASC;");
                            if(mysqli_num_rows($c)>0){
                              while($r=mysqli_fetch_assoc($c)){
                            ?>
                            <option value="<?php echo $r['idEmpleado']; ?>"><?php echo $r['nombre']; ?></option>
                            <?php
                              }
                            }
                            mysqli_free_result($c);
                            ?>
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <button type="submit" class="btn btn-default" id="b_btelper">Buscar</button>
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
              <div class="tab-pane" id="tab_2">
                <!--Formulario busqueda-->
                <form id="f_bcorper">
                  <div class="row">
                    <div class="col-sm-5">
                      <div class="form-group valida">
                          <select class="form-control select2" name="per1" id="per1" style="width: 100%;">
                            <option value="">PERSONAL</option>
                            <?php
                            $c=mysqli_query($cone, "SELECT idEmpleado, concat(ApellidoPat, ' ', ApellidoMat, ', ', Nombres) as nombre FROM empleado WHERE Estado=1 ORDER BY nombre ASC;");
                            if(mysqli_num_rows($c)>0){
                              while($r=mysqli_fetch_assoc($c)){
                            ?>
                            <option value="<?php echo $r['idEmpleado']; ?>"><?php echo $r['nombre']; ?></option>
                            <?php
                              }
                            }
                            mysqli_free_result($c);
                            ?>
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <button type="submit" class="btn btn-default" id="b_bcorper">Buscar</button>
                    </div>
                  </div>
                </form>
                <!--Fin formulario busqueda-->
                <!--Div resultados-->
                <hr>
                <div class="r_correo">
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

<!--Modal nuevo telefono personal-->
<div class="modal fade" id="m_nuetel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Teléfono</h4>
      </div>
      <form id="f_nuetel" action="" class="form-horizontal">
      <div class="modal-body" id="r_nuetel">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnuetel">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>  
</div>
<!--Fin Modal nuevo telefono personal-->

<!--Modal editar telefono personal-->
<div class="modal fade" id="m_editel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Teléfono</h4>
      </div>
      <form id="f_editel" action="" class="form-horizontal">
      <div class="modal-body" id="r_editel">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_geditel">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
  
</div>
<!--Fin Modal editar telefono personal-->

<!--Modal editar correo personal-->
<div class="modal fade" id="m_edicor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Correo</h4>
      </div>
      <form id="f_edicor" action="" class="form-horizontal">
      <div class="modal-body" id="r_edicor">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedicor">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
  
</div>
<!--Fin Modal editar correo personal-->

<!--Modal eliminar boletín-->
<div class="modal fade" id="m_elitel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar teléfono</h4>
      </div>
      <form id="f_elitel" action="" class="form-horizontal">
      <div class="modal-body" id="r_elitel">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_sielitel">Si</button>
        <button type="button" class="btn btn-default" id="b_noelitel" data-dismiss="modal">No</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Fin Modal eliminar boletín-->

<?php
  }else{
    echo accrestringidop();
  }
}else{
header('Location: ../index.php');
}
?>