<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"])){
    $idp=iseguro($cone,$_POST["idp"]);
  ?>
                  <fieldset class="fieldset">
                    <legend class="text-orange"><i class="fa fa-black-tie"></i> Cargo</legend>
                  <div class="form-group">
                    <label for="sislab" class="col-sm-3 control-label">Sistema / Cargo</label>
                    <div class="col-sm-3 valida">
                      <input type="hidden" id="idpe" name="idpe" value="<?php echo $idp ?>">
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
                    <div class="col-sm-4 valida">
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
                    <div class="col-sm-6"><i class="fa fa-exclamation-circle text-orange"></i><small> Elegir <strong>Titular</strong> o <strong>Provisional</strong> sólo para cargos de fiscales según sea el caso, para el resto de cargos <strong>Ninguno</strong>.</small></div>
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
                      <select name="rem" id="rem" class="form-control select2" style="width: 100%;">
                        <option value="">REEMPLAZADO</option>
                        <option value="0">NO REEMPLAZA</option>
                        <?php
                        $c=mysqli_query($cone,"SELECT idEmpleado, ApellidoPat, ApellidoMat, Nombres FROM empleado ORDER BY ApellidoPat, ApellidoPat, Nombres ASC;");
                        if(mysqli_num_rows($c)>0){
                          while ($r=mysqli_fetch_assoc($c)) { 
                        ?>
                        <option value="<?php echo $r['idEmpleado']; ?>"><?php echo $r['ApellidoPat']." ".$r['ApellidoMat'].", ".$r['Nombres']; ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($c);
                        ?>
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
                      <select name="dep" id="dep" class="form-control select2" style="width: 100%;">
                        <option value="">DEPENDENCIA</option>
                        <?php echo listadepe($cone) ?>
                      </select>
                    </div>
                  </div>
                  </fieldset>
<script>
  $('#fecasu,#fecjur,#fecven').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true
  });
  $(".select2").select2();
</script>
  <?php
  }else{
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún personal.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>