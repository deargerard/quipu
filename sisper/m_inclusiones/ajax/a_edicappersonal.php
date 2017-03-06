<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idca"]) && !empty($_POST["idca"])){
    $idca=iseguro($cone,$_POST["idca"]);
    $cca=mysqli_query($cone,"SELECT * FROM capacitacion WHERE idCapacitacion=$idca");
    if($rca=mysqli_fetch_assoc($cca)){
  ?>
                  <div class="form-group">
                    <label for="den" class="col-sm-3 control-label">Denominación</label>
                    <div class="col-sm-9 valida">
                      <input type="hidden" id="idca" name="idca" value="<?php echo $idca ?>">
                      <input type="text" id="den" name="den" class="form-control" placeholder="Denominación" value="<?php echo $rca['Denominacion'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tip" class="col-sm-3 control-label">Tipo</label>
                    <div class="col-sm-3 valida">
                      <select name="tip" id="tip" class="form-control">
                        <option value="">TIPO</option>
                      <?php
                      $ctc=mysqli_query($cone,"SELECT * FROM tipcap WHERE Estado=1");
                      while($rtc=mysqli_fetch_assoc($ctc)){
                        if($rca['idTipCap']==$rtc['idTipCap']){
                      ?>
                        <option value="<?php echo $rtc['idTipCap'] ?>" selected="selected"><?php echo $rtc['TipCap'] ?></option>
                      <?php
                        }else{
                      ?>
                        <option value="<?php echo $rtc['idTipCap'] ?>"><?php echo $rtc['TipCap'] ?></option>
                      <?php
                        }
                      }
                      mysqli_free_result($ctc);
                      ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="ins" name="ins" class="form-control" placeholder="Institución" value="<?php echo $rca['Institucion'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecini" class="col-sm-3 control-label">Fecha Inicio</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecini" name="fecini" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rca['FechaIni']) ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecfin" class="col-sm-3 control-label">Fecha Fin</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecfin" name="fecfin" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rca['FechaFin']) ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="dur" class="col-sm-3 control-label">Duración (Hrs)</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="dur" name="dur" class="form-control" placeholder="Duración en horas" value="<?php echo $rca['Duracion'] ?>">
                    </div>
                  </div>
<script>
  $('#fecini,#fecfin').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true
  });
</script>
  <?php
    }else{
      echo "<h4 class='text-maroon'>Error: No se seleccionó una capacitación válida.</h4>";
    }
    mysqli_free_result($cca);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se seleccionó ningún personal</h4>";
  }
}else{
  echo accrestringidoa();
}
?>