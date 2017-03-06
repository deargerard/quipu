<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idg"]) && !empty($_POST["idg"])){
    $idg=iseguro($cone,$_POST["idg"]);
    $cgt=mysqli_query($cone,"SELECT * FROM gradotitulo WHERE idGradoTitulo=$idg");
    if($rgt=mysqli_fetch_assoc($cgt)){
  ?>
                  <div class="form-group">
                    <label for="niv" class="col-sm-3 control-label">Grado</label>
                    <div class="col-sm-4 valida">
                      <input type="hidden" id="idg" name="idg" value="<?php echo $idg ?>">
                      <select name="niv" id="niv" class="form-control">
                        <option value="">GRADO</option>
                        <?php
                        $cngt=mysqli_query($cone,"SELECT * FROM nivgratit WHERE Estado=1");
                        while($rngt=mysqli_fetch_assoc($cngt)){
                          if($rgt['idNivGraTit']==$rngt['idNivGraTit']){
                        ?>
                        <option value="<?php echo $rngt['idNivGraTit'] ?>" selected="selected"><?php echo $rngt['NivGraTit'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rngt['idNivGraTit'] ?>"><?php echo $rngt['NivGraTit'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($cngt);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="den" class="col-sm-3 control-label">Denominación</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="den" name="den" class="form-control" placeholder="Denominación" value="<?php echo $rgt['Denominacion'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecexp" class="col-sm-3 control-label">Fecha Expedición</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecexp" name="fecexp" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rgt['FechaExp']) ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="ins" name="ins" class="form-control" placeholder="Institución" value="<?php echo $rgt['Institucion'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numdip" class="col-sm-3 control-label">N° Diploma</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numdip" name="numdip" class="form-control" placeholder="N° Diploma" value="<?php echo $rgt['NumeroDip'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numcol" class="col-sm-3 control-label">N° Colegiatura</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numcol" name="numcol" class="form-control" placeholder="N° Colegiatura" value="<?php echo $rgt['NumeroCol'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="feccol" class="col-sm-3 control-label">Fecha Colegiatura</label>
                    <div class="col-sm-3 valida">
                      <?php if(!empty($rgt['FechaCol']) && $rgt['FechaCol']!='1970-01-01'){ ?>
                      <input type="text" id="feccol" name="feccol" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rgt['FechaCol']) ?>">
                      <?php }else{ ?>
                      <input type="text" id="feccol" name="feccol" class="form-control" placeholder="dd/mm/aaaa">
                      <?php } ?>
                    </div>
                  </div>
<script>
  $('#fecexp,#feccol').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true
  });
</script>
<?php
    }else{
      echo "<h4 class='text-maroon'>Error: No se elegió un grado y/o título válido.</h4>";
    }
    mysqli_free_result($cgt);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún personal.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>