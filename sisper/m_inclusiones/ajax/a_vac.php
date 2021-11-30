<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"]) && isset($_POST["acc"]) && !empty($_POST["acc"])){
    $idp=iseguro($cone,$_POST["idp"]);
    $acc=iseguro($cone,$_POST["acc"]);

   if($acc=='agrvac'){

  ?>
      <div class="form-group">        
        <div class="col-sm-12">
          <label for="tvac" class="control-label">Tipo Vacuna <small class="text-red">*</small></label>
          <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          <input type="hidden" name="idp" value="<?php echo $idp; ?>">
          <select class="form-control" name="tvac" id="tvac" style="width: 100%;">
            <option value="1D Covid-19">1D Covid-19</option>
            <option value="2D Covid-19">2D Covid-19</option>
          </select>
        </div>
        <div class="col-sm-6">
        <label for="lab" class="control-label">Laboratorio <small class="text-red">*</small></label>
          <select class="form-control" name="lab" id="lab" style="width: 100%;">
            <option value="AstraZeneca">AstraZeneca</option>
            <option value="Pfizer">Pfizer</option>
            <option value="Sinopharm">Sinopharm</option>
          </select>
        </div>
        <div class="col-sm-6">
            <label for="fvac">Fecha <small class="text-red">*</small></label>
            <div class="has-feedback">
              <input type="text" class="form-control" id="fvac" name="fvac" placeholder="dd/mm/aaaa">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
        </div>
        <div class="col-sm-12">
          <label for="obs" class="control-label">Observaciones</label>
          <input type="text" name="obs" id="obs" class="form-control" placeholder="Observaciones">
        </div>

      </div>
      <div class="form-group" id="d_frespuesta">
          
      </div>
      <script>
        $('#fvac').datepicker({
          format: "dd/mm/yyyy",
          language: "es",
          autoclose: true,
          todayHighlight: true,
          maxViewMode: 2,
        });
      </script>
  <?php

   }elseif($acc=='edivac'){
    $cva=mysqli_query($cone, "SELECT * FROM vacuna WHERE idvacuna=$idp;");
    if($rva=mysqli_fetch_assoc($cva)){

  ?>
            <div class="form-group">        
        <div class="col-sm-12">
          <label for="tvac" class="control-label">Tipo Vacuna <small class="text-red">*</small></label>
          <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          <input type="hidden" name="idp" value="<?php echo $idp; ?>">
          <input type="hidden" name="ide" value="<?php echo $rva['idEmpleado']; ?>">
          <select class="form-control" name="tvac" id="tvac" style="width: 100%;">
            <option value="1D Covid-19" <?php echo $rva['tipo']=='1D Covid-19' ? 'selected' : ''; ?>>1D Covid-19</option>
            <option value="2D Covid-19" <?php echo $rva['tipo']=='2D Covid-19' ? 'selected' : ''; ?>>2D Covid-19</option>
          </select>
        </div>
        <div class="col-sm-6">
        <label for="lab" class="control-label">Laboratorio <small class="text-red">*</small></label>
          <select class="form-control" name="lab" id="lab" style="width: 100%;">
            <option value="AstraZeneca" <?php echo $rva['laboratorio']=='AstraZeneca' ? 'selected' : ''; ?>>AstraZeneca</option>
            <option value="Pfizer" <?php echo $rva['laboratorio']=='Pfizer' ? 'selected' : ''; ?>>Pfizer</option>
            <option value="Sinopharm" <?php echo $rva['laboratorio']=='Sinopharm' ? 'selected' : ''; ?>>Sinopharm</option>
          </select>
        </div>
        <div class="col-sm-6">
            <label for="fvac">Fecha <small class="text-red">*</small></label>
            <div class="has-feedback">
              <input type="text" class="form-control" id="fvac" name="fvac" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rva['fecha']); ?>">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
        </div>
        <div class="col-sm-12">
          <label for="obs" class="control-label">Observaciones</label>
          <input type="text" name="obs" id="obs" class="form-control" placeholder="Observaciones" value="<?php echo $rva['observaciones']; ?>">
        </div>

      </div>
      <div class="form-group" id="d_frespuesta">
          
      </div>
      <script>
        $('#fvac').datepicker({
          format: "dd/mm/yyyy",
          language: "es",
          autoclose: true,
          todayHighlight: true,
          maxViewMode: 2,
        });
      </script>
  <?php
    }else{
      echo mensajewa("Error, no se encontró al personal.");
    }
    mysqli_free_result($cva);
   }elseif($acc=='elivac'){
    $cg=mysqli_query($cone, "SELECT tipo, laboratorio, idEmpleado FROM vacuna WHERE idvacuna=$idp;");
    if($rg=mysqli_fetch_assoc($cg)){
      $ide=$rg['idEmpleado'];
?>
      <div class="form-group">
          <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          <input type="hidden" name="idp" value="<?php echo $idp; ?>">
          <input type="hidden" name="ide" value="<?php echo $ide; ?>">
          <h4 class="text-center"><i class="fa fa-info-circle text-orange"></i> Eliminará la vacuna: <b class="text-red"><?php echo $rg['tipo'].' - '.$rg['laboratorio'] ?></b>.<br>Si está seguro presione <b class="text-aqua">guardar</b>.</h4>
      </div>
      <div class="form-group" id="d_frespuesta">
          
      </div>
<?php
    }else{
      echo mensajewa("Datos inválidos.");
    }
    mysqli_free_result($cg);
   }
  }else{
    echo "<h4 class='text-maroon'>Error: No se envio datos</h4>";
  }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>