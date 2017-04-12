<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["idc"]) && !empty($_POST["idc"])){
    $idc=iseguro($cone,$_POST["idc"]);
    $cecar=mysqli_query($cone,"SELECT * FROM empleadocargo WHERE idEmpleadoCargo=$idc");
    $recar=mysqli_fetch_assoc($cecar);
    $idcar=$recar['idCargo'];
    if($recar['FechaJur']=='1970-01-01'){
      $fjur="";
    }else{
      $fjur=fnormal($recar['FechaJur']);
    }
    if($recar['FechaVen']=='1970-01-01'){
      $fven="";
    }else{
      $fven=fnormal($recar['FechaVen']);
    }
    $ccar=mysqli_query($cone,"SELECT * FROM cargo WHERE idCargo=$idcar");
    $rcar=mysqli_fetch_assoc($ccar);
    $idsl=$rcar['idSistemaLab'];
  ?>
            <div class="form-group">
                    <label for="sislab" class="col-sm-3 control-label">Sistema / Cargo</label>
                    <div class="col-sm-3 valida">
                      <input type="hidden" id="idec" name="idec" value="<?php echo $idc ?>">
                      <select name="sislab" id="sislab" class="form-control" onChange="ccargo(this.value)">
                        <option value="">SISTEMA</option>
                        <?php
                        $csl=mysqli_query($cone,"SELECT * FROM sistemalab");
                        while($rsl=mysqli_fetch_assoc($csl)){
                          if($rsl['idSistemaLab']==$rcar['idSistemaLab']){
                        ?>
                        <option value="<?php echo $rsl['idSistemaLab'] ?>" selected><?php echo $rsl['SistemaLab'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rsl['idSistemaLab'] ?>"><?php echo $rsl['SistemaLab'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($csl);
                        ?>
                      </select>
                    </div>
                    <div class="col-sm-6 valida">
                      <select name="car" id="car" class="form-control">
                        <option value="">CARGO</option>
                        <?php
                        $cc=mysqli_query($cone,"SELECT * FROM cargo WHERE idSistemaLab=$idsl");
                        while($rc=mysqli_fetch_assoc($cc)){
                          if($rc['idCargo']==$idcar){
                        ?>
                        <option value="<?php echo $rc['idCargo'] ?>" selected><?php echo $rc['Denominacion'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rc['idCargo'] ?>"><?php echo $rc['Denominacion'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($cc);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tiping" class="col-sm-3 control-label">Modalidad Acceso</label>
                    <div class="col-sm-4 valida">
                      <select name="tiping" id="tiping" class="form-control">
                        <option value="">MODALIDAD ACCESO</option>
                        <?php
                        $cma=mysqli_query($cone,"SELECT * FROM modacceso WHERE Estado=1");
                        while($rma=mysqli_fetch_assoc($cma)){
                          if($recar['idModAcceso']==$rma['idModAcceso']){
                        ?>
                        <option value="<?php echo $rma['idModAcceso'] ?>" selected><?php echo $rma['ModAcceso'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rma['idModAcceso'] ?>"><?php echo $rma['ModAcceso'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($cma);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numcon" class="col-sm-3 control-label">Num. Concurso</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numcon" name="numcon" class="form-control" placeholder="Num. Concurso" value="<?php echo $recar['Concurso']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="concar" class="col-sm-3 control-label">Condición Cargo</label>
                    <div class="col-sm-3 valida">
                      <select name="concar" id="concar" class="form-control">
                        <option value="">CONDICIÓN CARGO</option>
                        <?php
                        $ccocar=mysqli_query($cone,"SELECT * FROM condicioncar WHERE Estado=1");
                        while($rcocar=mysqli_fetch_assoc($ccocar)){
                          if($recar['idCondicionCar']==$rcocar['idCondicionCar']){
                        ?>
                        <option value="<?php echo $rcocar['idCondicionCar'] ?>" selected><?php echo $rcocar['CondicionCar'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rcocar['idCondicionCar'] ?>"><?php echo $rcocar['CondicionCar'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($ccocar);
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
                        <?php
                        $ccl=mysqli_query($cone,"SELECT * FROM condicionlab WHERE Estado=1");
                        while($rcl=mysqli_fetch_assoc($ccl)){
                          if($rcl['idCondicionLab']==$recar['idCondicionLab']){
                        ?>
                        <option value="<?php echo $rcl['idCondicionLab'] ?>" selected='selected'><?php echo $rcl['Tipo'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rcl['idCondicionLab'] ?>"><?php echo $rcl['Tipo'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($ccl);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="rol" class="col-sm-3 control-label">Rol</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="rol" name="rol" class="form-control" placeholder="Rol" value="<?php echo $recar['Rol']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecasu" class="col-sm-3 control-label">Fecha Asume</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecasu" name="fecasu" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($recar['FechaAsu']); ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecjur" class="col-sm-3 control-label">Fecha Juramentación</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecjur" name="fecjur" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo $fjur; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecven" class="col-sm-3 control-label">Fecha Vencimiento</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecven" name="fecven" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo $fven; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="rem" class="col-sm-3 control-label">Reemplaza a</label>
                    <div class="col-sm-6 valida">
                      <select name="rem" id="rem" class="form-control select2" style="width: 100%;">
                        <option value="">REEMPLAZADO</option>
                        <?php
                        if($recar['Reemplazado']==0){
                        ?>
                        <option value="0" selected="selected">NO REEMPLAZA</option>
                        <?php
                        }else{
                        ?>
                        <option value="0">NO REEMPLAZA</option>
                        <?php
                        }
                        ?>
                        <?php
                        $cemp=mysqli_query($cone,"SELECT idEmpleado, NombreCom FROM enombre ORDER BY NombreCom ASC");
                        while($remp=mysqli_fetch_assoc($cemp)){
                          if($remp['idEmpleado']==$recar['Reemplazado']){
                        ?>
                        <option value="<?php echo $remp['idEmpleado'] ?>" selected='selected'><?php echo $remp['NombreCom'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $remp['idEmpleado'] ?>"><?php echo $remp['NombreCom'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($cemp);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numres" class="col-sm-3 control-label">N° de Resolución</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numres" name="numres" class="form-control" placeholder="Número de resolución" value="<?php echo $recar['NumResolucion']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numcont" class="col-sm-3 control-label">N° de Contrato</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numcont" name="numcont" class="form-control" placeholder="Número de resolución" value="<?php echo $recar['NumContrato']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mot" class="col-sm-3 control-label">Motivo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="mot" name="mot" class="form-control" placeholder="Motivo" value="<?php echo $recar['Motivo']; ?>">
                    </div>
                  </div>
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
    mysqli_free_result($cecar);
    mysqli_free_result($ccar);
    mysqli_close($cone);
  }else{
    echo "<h3 class='text-maroon'>Error: No se seleccionó ningún cargo.</h3>";
  }
}else{
  echo accrestringidoa();
}
?>