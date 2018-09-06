<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idec"]) && !empty($_POST["idec"])){
    $idec=iseguro($cone,$_POST["idec"]);
    $cca=mysqli_query($cone,"SELECT FechaVac FROM empleadocargo WHERE idEmpleadoCargo=$idec");
    if($rca=mysqli_fetch_assoc($cca)){
  ?>

                  <div class="form-group">
                    <label for="fvac" class="col-sm-6 control-label">Fecha Vacaciones</label>
                    <div class="col-sm-6 valida">
                      <input type="hidden" name="idec" value="<?php echo $idec; ?>">
                      <input type="text" id="fvac" name="fvac" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rca['FechaVac']) ?>">
                    </div>
                  </div>
                  <div id="r_fvac">
                    
                  </div>
<script>
  $('#fvac').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true
  });
  $("#b_gefvac").show();
</script>
  <?php
    }else{
      echo "<h4 class='text-maroon'>Error: datos incorrectos.</h4>";
    }
    mysqli_free_result($cca);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se envio datos</h4>";
  }
}else{
  echo accrestringidoa();
}
?>