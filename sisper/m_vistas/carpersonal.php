<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesoadm($cone,$_SESSION['identi'],1)){
    $per=iseguro($cone,$_GET['per']);
    if(isset($per) && !empty($per)){
      $ce=mysqli_query($cone,"SELECT idEmpleado FROM empleado WHERE idEmpleado=$per");
      if($re=mysqli_fetch_assoc($ce)){
      $cc=mysqli_query($cone,"SELECT idEmpleadoCargo FROM empleadocargo WHERE idEmpleado=$per AND Estado='ACTIVO'");
      if(!($rc=mysqli_fetch_assoc($cc))){
?>

<?php
      
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cargo
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="pagpersonal.php">Personal</a></li>
        <li class="active">Cargo</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Asignar Cargo</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <form action="" class="form-horizontal" id="f_carpersonal">
                <div class="box-body">
                <div id="r_carpersonal">
                  <fieldset class="fieldset">
                    <legend class="text-orange"><i class="fa fa-black-tie"></i> Cargo</legend>
                  <div class="form-group">
                    <label for="sislab" class="col-sm-3 control-label">Sistema / Cargo</label>
                    <div class="col-sm-3 valida">
                      <input type="hidden" id="idper" name="idper" value="<?php echo $per ?>">
                      <select name="sislab" id="sislab" class="form-control" onChange="ccargo(this.value)">
                        <option value="">SISTEMA</option>
                        <?php echo listaslab($cone) ?>
                      </select>
                    </div>
                    <div class="col-sm-6 valida">
                      <select name="car" id="car" class="form-control">
                        <option value="">CARGO</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tiping" class="col-sm-3 control-label">Modalidad Acceso</label>
                    <div class="col-sm-3 valida">
                      <select name="tiping" id="tiping" class="form-control">
                        <option value="">MODALIDAD ACCESO</option>
                      <?php
                        $cma=mysqli_query($cone,"SELECT * FROM modacceso");
                        while($rma=mysqli_fetch_assoc($cma)){
                      ?>
                        <option value="<?php echo $rma['idModAcceso'] ?>"><?php echo $rma['ModAcceso'] ?></option>
                      <?php
                        }
                        mysqli_free_result($cma);
                      ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numcon" class="col-sm-3 control-label">N° de Concurso</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numcon" name="numcon" class="form-control" placeholder="Num. Concurso">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="concar" class="col-sm-3 control-label">Condición Cargo</label>
                    <div class="col-sm-3 valida">
                      <select name="concar" id="concar" class="form-control">
                        <option value="">CONDICIÓN CARGO</option>
                        <?php
                        $ccoca=mysqli_query($cone,"SELECT * FROM condicioncar");
                        while($rcoca=mysqli_fetch_assoc($ccoca)){
                        ?>
                        <option value="<?php echo $rcoca['idCondicionCar'] ?>"><?php echo $rcoca['CondicionCar'] ?></option>
                        <?php
                        }
                        mysqli_free_result($ccoca);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="conlab" class="col-sm-3 control-label">Condición Laboral</label>
                    <div class="col-sm-3 valida">
                      <select name="conlab" id="conlab" class="form-control">
                        <option value="">CONDICIÓN LABORAL</option>
                        <?php echo listaclab($cone) ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="rol" class="col-sm-3 control-label">Rol</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="rol" name="rol" class="form-control" placeholder="Rol">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecasu" class="col-sm-3 control-label">Fecha Asume</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecasu" name="fecasu" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecjur" class="col-sm-3 control-label">Fecha Juramentación</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecjur" name="fecjur" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecven" class="col-sm-3 control-label">Fecha Vencimiento</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecven" name="fecven" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="rem" class="col-sm-3 control-label">Reemplaza a</label>
                    <div class="col-sm-6 valida">
                      <select name="rem" id="rem" class="form-control">
                        <option value="">REEMPLAZADO</option>
                        <option value="0">NO REEMPLAZA</option>
                        <?php echo listaper($cone) ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numres" class="col-sm-3 control-label">N° de Resolución</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numres" name="numres" class="form-control" placeholder="Número de resolución">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numcont" class="col-sm-3 control-label">N° de Contrato</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numcont" name="numcont" class="form-control" placeholder="Número de resolución">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mot" class="col-sm-3 control-label">Motivo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="mot" name="mot" class="form-control" placeholder="Motivo">
                    </div>
                  </div>
                  </fieldset>
                  <fieldset class="fieldset">
                    <legend class="text-orange"><i class="fa fa-institution"></i> Dependencia</legend>
                  <div class="form-group">
                    <label for="dep" class="col-sm-3 control-label">Dependencia</label>
                    <div class="col-sm-9 valida">
                      <select name="dep" id="dep" class="form-control">
                        <option value="">DEPENDENCIA</option>
                        <?php echo listadepe($cone) ?>
                      </select>
                    </div>
                  </div>
                  </fieldset>
                </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="reset" class="btn btn-default" id="b_rcarpersonal"><i class="fa fa-eraser"></i>  Restablecer</button>
                  <button type="submit" class="btn btn-info pull-right" id="b_gcarpersonal"><i class="fa fa-floppy-o"></i>  Guardar</button>
                </div>
                <!-- /.box-footer-->
              </form>
              <script>
                function ccargo(val){
                  $('#car').html('<option value="">Cargando...</option>');
                  $.ajax({
                    url: 'm_inclusiones/ajax/a_scarga.php',
                    data: 'idslab='+val,
                    success: function(resp){ 
                      $('#car').html(resp) 
                    }
                   });
                }
                </script>
            </div>
            <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
<?php
    }else{
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-maroon text-center"><i class="fa fa-warning"></i> Error: El personal ya cuenta con un cargo activo.</h4>
    </div>
  </div>
</section>
<?php
    }
    }else{
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-maroon text-center"><i class="fa fa-warning"></i> Error: No se eligió un personal válido para la asignación de cargo.</h4>
    </div>
  </div>
</section>
<?php
    }
  }
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>