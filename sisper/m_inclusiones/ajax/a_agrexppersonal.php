<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"])){
    $idp=iseguro($cone,$_POST["idp"]);
  ?>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-9 valida">
                      <input type="hidden" id="idpe" name="idpe" value="<?php echo $idp ?>">
                      <input type="text" id="ins" name="ins" class="form-control" placeholder="Institución">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Cargo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="car" name="car" class="form-control" placeholder="Cargo">
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
                    <label for="con" class="col-sm-3 control-label">Condición</label>
                    <div class="col-sm-6 valida">
                      <select name="con" id="con" class="form-control">
                        <option value="">CONDICIÓN</option>
                        <?php
                        $ccce=mysqli_query($cone,"SELECT * FROM conconexp WHERE Estado=1");
                        while($rcce=mysqli_fetch_assoc($ccce)){
                        ?>
                        <option value="<?php echo $rcce['idConConExp'] ?>"><?php echo $rcce['ConConExp'] ?></option>
                        <?php
                        }
                        mysqli_free_result($ccce);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="motces" class="col-sm-3 control-label">Motivo Cese</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="motces" name="motces" class="form-control" placeholder="Motivo Cese">
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
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún personal</h4>";
  }
}else{
  echo accrestringidoa();
}
?>