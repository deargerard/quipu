<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],3)){
?>
    <!-- Cabecera -->
    <section class="content-header">
      <h1>
      Vacaciones
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Vacaciones</li>
        <li class="active">Vacaciones</li>
      </ol>
    </section>
    <!-- /.Cabecera -->
    <!-- Sección de Busqueda -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Programación</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <!--Formulario-->
                    <form action="" id="f_vacper" class="form-inline">
                      <div class="form-group">
                        <label for="per" class="sr-only">Personal</label>
                        <select name="per" id="per" class="form-control select2" style="width: 400px;">
                          <?php
                            $cper=mysqli_query($cone,"SELECT e.idEmpleado, CONCAT(ApellidoPat, ' ', ApellidoMat, ', ', Nombres) as NombreCompleto FROM empleado e INNER JOIN  empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE ec.idEstadoCar=1 ORDER BY NombreCompleto ASC");
                            while($rper=mysqli_fetch_assoc($cper)){
                          ?>
                          <option value="<?php echo $rper['idEmpleado']; ?>"><?php echo $rper['NombreCompleto']; ?></option>
                          <?php
                            }
                            mysqli_free_result($cper);
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="pervac" class="sr-only">Período</label>
                        <select name="pervac" id="pervac" class="form-control" >
                          <option value="" disabled selected>Período</option>
                          <!-- <option value="t">TODOS</option> -->
                          <?php
                            $cpv=mysqli_query($cone,"SELECT idPeriodoVacacional, PeriodoVacacional FROM periodovacacional WHERE Estado=1 ORDER BY PeriodoVacacional DESC");
                            while($rpv=mysqli_fetch_assoc($cpv)){
                          ?>
                          <option value="<?php echo $rpv['idPeriodoVacacional']; ?>"><?php echo $rpv['PeriodoVacacional']; ?></option>
                          <?php
                            }
                            mysqli_free_result($cpv);
                          ?>
                        </select>
                      </div>
                      <button class="btn btn-default" type="button" id="b_nperiodo" data-toggle="modal" data-target="#m_nperiodo"><i class="fa fa-calendar-plus-o" ></i></button>
                      <div class="checkbox">
                        <label><input type="checkbox" name="can" id="can" value="2"> Ver Canceladas</label>
                      </div>
                      <button type="submit" id="b_bvacper" class="btn btn-default">Buscar</button>
                </form>
                    <!--Fin Formulario-->
                    <!--div resultados-->
                    <div class="row">
                      <hr>
                      <div class="col-md-12" id="r_vacper">

                      </div>
                    </div>
                    <!--fin div resultados-->
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">

              </div>
              <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.Sección de Busqueda -->
    <!--Modal Nuevas vacaciones-->
    <div class="modal fade" id="m_nvacaciones" role="dialog" aria-labelledby="myModalLabel">
      <form id="f_nuevacaciones" action="" class="form-horizontal">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nuevas Vacaciones</h4>
          </div>
          <div class="modal-body" id="r_nuevacaciones">

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-teal" id="b_gnvac">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
      </form>
    </div>
    <!--Fin Modal Nuevas Vacaciones-->
    <!--Modal editar vacaciones-->
    <div class="modal fade" id="m_evacaciones" role="dialog" aria-labelledby="myModalLabel">
      <form id="f_evacaciones" action="" class="form-horizontal">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Editar Vacaciones</h4>
          </div>
          <div class="modal-body" id="r_evacaciones">

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-teal" id="b_gevacaciones">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
      </form>
    </div>
    <!--Fin Modal editar Vacaciones-->
    <!--Modal Cancelar vacaciones-->
    <div class="modal fade" id="m_cvacaciones" role="dialog" aria-labelledby="myModalLabel">
      <form id="f_cvacaciones" action="" class="form-horizontal">
      <div class="modal-dialog modal-ls" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Cancelar Vacaciones</h4>
          </div>
          <div class="modal-body" id="r_cvacaciones">

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-teal" id="b_sicvacaciones">Sí</button>
            <button type="button" class="btn btn-default" id="b_nocvacaciones" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
      </form>
    </div>
    <!--Fin Modal Cancelar Vacaciones-->
    <!--Modal Nuevo Período-->
    <div class="modal fade" id="m_nperiodo" role="dialog" aria-labelledby="myModalLabel">
      <form id="f_nperiodo" action="" class="form-horizontal">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nuevo Período Vacacional</h4>
          </div>
          <div class="modal-body" id="r_nperiodo">

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-teal" id="b_gnperiodo">Guardar</button>
            <button type="button" class="btn btn-default" id="b_cnperiodo" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
      </form>
    </div>
    <!--Fin Modal Nuevo Período-->

<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
