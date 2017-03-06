<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["idmd"]) && !empty($_POST["idmd"])){
    $idmd=iseguro($cone,$_POST["idmd"]);
    $cmd=mysqli_query($cone,"SELECT * FROM movdependencia WHERE idMovDependencia=$idmd");
    $rmd=mysqli_fetch_assoc($cmd);
  ?>
                  <div class="form-group">
                    <label for="dep" class="col-sm-3 control-label">Dependencia</label>
                    <div class="col-sm-9 valida">
                      <input type="hidden" id="idmd" name="idmd" value="<?php echo $idmd ?>">
                      <select name="dep" id="dep" class="form-control">
                        <option value="">DEPENDENCIA</option>
                        <?php
                        $cde=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 ORDER BY Denominacion ASC");
                        while($rde=mysqli_fetch_assoc($cde)){
                          if($rde['idDependencia']==$rmd['idDependencia']){
                        ?>
                        <option value="<?php echo $rde['idDependencia'] ?>" selected="selected"><?php echo $rde['Denominacion'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rde['idDependencia'] ?>"><?php echo $rde['Denominacion'] ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ini" class="col-sm-3 control-label">Inicia</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="ini" name="ini" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rmd['FecInicio']) ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fin" class="col-sm-3 control-label">Finaliza</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fin" name="fin" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rmd['FecFin']) ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="nummem" class="col-sm-3 control-label">N° Memo</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="nummem" name="nummem" class="form-control" placeholder="N° Memo" value="<?php echo $rmd['NumMemo'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numres" class="col-sm-3 control-label">N° Resolución</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numres" name="numres" class="form-control" placeholder="N° Resolución" value="<?php echo $rmd['NumResolucion'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mot" class="col-sm-3 control-label">Motivo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="mot" name="mot" class="form-control" placeholder="Motivo" value="<?php echo $rmd['Motivo'] ?>">
                    </div>
                  </div>
<script>
  $('#ini,#fin').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    todayHighlight: true
  });
</script>
  <?php
    mysqli_free_result($cmd);
    mysqli_close($cone);
  }else{
    echo "<h3 class='text-maroon'>No se selecciono ningún personal</h3>";
  }
}else{
  echo accrestringidoa();
}
?>