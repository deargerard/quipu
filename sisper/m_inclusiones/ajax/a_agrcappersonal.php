<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"])){
    $idp=iseguro($cone,$_POST["idp"]);
  ?>
                  <div class="form-group">
                    <label for="den" class="col-sm-3 control-label">Denominación</label>
                    <div class="col-sm-9 valida">
                      <input type="hidden" id="idpe" name="idpe" value="<?php echo $idp ?>">
                      <input type="text" id="den" name="den" class="form-control" placeholder="Denominación">
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
                      ?>
                        <option value="<?php echo $rtc['idTipCap'] ?>"><?php echo $rtc['TipCap'] ?></option>
                      <?php
                      }
                      mysqli_free_result($ctc);
                      ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="ins" name="ins" class="form-control" placeholder="Institución">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecini" class="col-sm-3 control-label">Fecha Inicio</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecini" name="fecini" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecfin" class="col-sm-3 control-label">Fecha Fin</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecfin" name="fecfin" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="dur" class="col-sm-3 control-label">Duración (Hrs)</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="dur" name="dur" class="form-control" placeholder="Duración en horas">
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
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún personal.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>