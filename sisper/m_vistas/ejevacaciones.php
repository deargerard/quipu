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
    <li class="active">Ejecución</li>
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
            <h3 class="box-title">Ejecución</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <!--Formulario-->
                <form action="" id="f_ejva" class="form-inline">
                    <div class="form-group">
                      <label for="aaa" class="sr-only">Sistema</label>
                        <select name="sislab[]" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="SISTEMA">
                          <?php
                            $csl=mysqli_query($cone,"SELECT idSistemaLab, SistemaLab FROM sistemalab WHERE idSistemaLab!=4 AND  idSistemaLab!=5 ORDER BY idSistemaLab ASC");
                            while($rsl=mysqli_fetch_assoc($csl)){
                          ?>
                          <option value="<?php echo $rsl['idSistemaLab']; ?>"><?php echo $rsl['SistemaLab']; ?></option>
                          <?php
                            }
                            mysqli_free_result($csl);
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="bbb" class="sr-only">Periodo </label>
                      <select name="pervac[]" data-actions-box="true" class="form-control selectpicker" multiple="multiple" multiple data-selected-text-format="count" title="PERÍODO">
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
                    <div class="form-group">
                      <label for="aaa" class="sr-only">Mes</label>
                      <input class="form-control" id="meseje" name="mes" placeholder="MM//AAAA" autocomplete="off">
                    </div>
                    <button type="submit" id="b_bejva" class="btn btn-default">Buscar</button>
                </form>
                <!--Fin Formulario-->
                <!--div resultados-->
                <div class="row">
                  <hr>
                    <div class="col-md-12" id="r_ejva">

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

  <!--Modal Cancelar vacaciones-->
  <div class="modal fade" id="m_ejvacaciones" role="dialog" aria-labelledby="myModalLabel">
    <form id="f_ejvacaciones" action="" class="form-horizontal">
    <div class="modal-dialog modal-ls" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Ejecutar Vacaciones</h4>
        </div>
        <div class="modal-body" id="r_ejvacaciones">

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn bg-teal" id="b_siejvacaciones">Sí</button>
          <button type="button" class="btn btn-default" id="b_noejvacaciones" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
    </form>
  </div>
  <!--Fin Modal Cancelar Vacaciones-->

  <?php
  }else{
  echo accrestringidop();
  }
  }else{
  header('Location: ../index.php');
  }
  ?>
