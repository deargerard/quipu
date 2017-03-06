<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idex"]) && !empty($_POST["idex"])){
    $idex=iseguro($cone,$_POST["idex"]);
    $cel=mysqli_query($cone,"SELECT * FROM explaboral AS el INNER JOIN conconexp AS cce ON el.idConConExp=cce.idConConExp WHERE idExpLaboral=$idex");
    if($rel=mysqli_fetch_assoc($cel)){
  ?>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Cargo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="car" name="car" class="form-control" placeholder="Cargo"  value="<?php echo $rel['Cargo'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-9 valida">
                      <input type="hidden" id="idex" name="idex" value="<?php echo $idex ?>">
                      <input type="text" id="ins" name="ins" class="form-control" placeholder="Institución" value="<?php echo $rel['Institucion'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecini" class="col-sm-3 control-label">Fecha Inicio</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecini" name="fecini" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rel['FechaIni']) ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecfin" class="col-sm-3 control-label">Fecha Fin</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecfin" name="fecfin" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormalsin($rel['FechaFin']) ?>">
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
                          if($rel['idConConExp']==$rcce['idConConExp']){
                        ?>
                        <option value="<?php echo $rcce['idConConExp'] ?>" selected="selected"><?php echo $rcce['ConConExp'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rcce['idConConExp'] ?>"><?php echo $rcce['ConConExp'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($ccce);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="motces" class="col-sm-3 control-label">Motivo Cese</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="motces" name="motces" class="form-control" placeholder="Motivo Cese" value="<?php echo $rel['MotivoCese'] ?>">
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
      echo "<h4 class='text-maroon'>Error: No se seleccionó una experiencia laboral válida.</h4>";
    }
    mysqli_free_result($cel);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se seleccionó ninguna experiencia laboral.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>