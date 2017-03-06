<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"])){
    $idp=iseguro($cone,$_POST["idp"]);
  ?>
                  <div class="form-group">
                    <label for="niv" class="col-sm-3 control-label">Grado</label>
                    <div class="col-sm-3 valida">
                      <input type="hidden" id="idpe" name="idpe" value="<?php echo $idp ?>">
                      <select name="niv" id="niv" class="form-control">
                        <option value="">GRADO</option>
                        <?php
                        $cngt=mysqli_query($cone,"SELECT * FROM nivgratit WHERE Estado=1");
                        while($rngt=mysqli_fetch_assoc($cngt)){
                        ?>
                        <option value="<?php echo $rngt['idNivGraTit'] ?>"><?php echo $rngt['NivGraTit'] ?></option>
                        <?php
                        }
                        mysqli_free_result($cngt);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="den" class="col-sm-3 control-label">Denominación</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="den" name="den" class="form-control" placeholder="Denominación">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecexp" class="col-sm-3 control-label">Fecha Expedición</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecexp" name="fecexp" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="ins" name="ins" class="form-control" placeholder="Institución">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numdip" class="col-sm-3 control-label">N° Diploma</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numdip" name="numdip" class="form-control" placeholder="N° Diploma">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numcol" class="col-sm-3 control-label">N° Colegiatura</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numcol" name="numcol" class="form-control" placeholder="N° Colegiatura">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="feccol" class="col-sm-3 control-label">Fecha Colegiatura</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="feccol" name="feccol" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
<script>
  $('#fecexp,#feccol').datepicker({
    format: "dd/mm/yyyy",
    autoclose: true,
    language: "es",
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