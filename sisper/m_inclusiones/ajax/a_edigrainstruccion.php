<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"])){
    $idp=iseguro($cone,$_POST["idp"]);
    $cdp=mysqli_query($cone,"SELECT * FROM empleado WHERE idEmpleado=$idp");
    $rdp=mysqli_fetch_assoc($cdp);
  ?>
            <div class="form-group">
              <label for="grains" class="col-sm-3 control-label">Grado Instrucción</label>
              <div class="col-sm-4 valida">
                <input type="hidden" id="idpe" name="idpe" value="<?php echo $idp ?>">
              <?php
              $idgi=$rdp['idGradoInstruccion'];
              $cgi=mysqli_query($cone,"SELECT Nivel, GradoInstruccion FROM gradoinstruccion WHERE idGradoInstruccion=$idgi");
              $rgi=mysqli_fetch_assoc($cgi);
              $ni=$rgi['Nivel'];
              $gr=$rgi['GradoInstruccion'];
              ?>
                <select name="grains" id="grains" class="form-control" onChange="cnivel(this.value)">
                  <option value="">GRADO</option>
                  <?php
                    $cgin=mysqli_query($cone,"SELECT distinct GradoInstruccion FROM gradoinstruccion");
                    while($rgin=mysqli_fetch_assoc($cgin)){
                      if($rgin['GradoInstruccion']==$gr){
                  ?>
                  <option value="<?php echo $rgin['GradoInstruccion'] ?>" selected><?php echo $rgin['GradoInstruccion'] ?></option>
                  <?php
                      }else{
                  ?>
                  <option value="<?php echo $rgin['GradoInstruccion'] ?>"><?php echo $rgin['GradoInstruccion'] ?></option>
                  <?php
                      }
                    }
                  mysqli_free_result($cgi);
                  mysqli_free_result($cgin);
                  ?>
                </select>
              </div>
              <div class="col-sm-4 valida">
                <select name="nivins" id="nivins" class="form-control">
                  <option value="">NIVEL</option>
                  <?php
                  $cgint=mysqli_query($cone,"SELECT idGradoInstruccion, Nivel FROM gradoinstruccion WHERE GradoInstruccion='$gr'");
                  while($rgint=mysqli_fetch_assoc($cgint)){
                    if($rgint['idGradoInstruccion']==$idgi){
                  ?>
                  <option value="<?php echo $rgint['idGradoInstruccion'] ?>" selected><?php echo $rgint['Nivel'] ?></option>
                  <?php
                    }else{
                  ?>
                  <option value="<?php echo $rgint['idGradoInstruccion'] ?>"><?php echo $rgint['Nivel'] ?></option>
                  <?php
                    }
                  }
                  mysqli_free_result($cgint);
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="esp" class="col-sm-3 control-label">Especialidad</label>
              <div class="col-sm-9 valida">
                <input type="text" id="esp" name="esp" class="form-control" placeholder="Especialidad" value="<?php echo $rdp['Especialidad'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="ins" class="col-sm-3 control-label">Institución</label>
              <div class="col-sm-9 valida">
                <input type="text" id="ins" name="ins" class="form-control" placeholder="Institución" value="<?php echo $rdp['Institucion'] ?>">
              </div>
            </div>
  <?php
    mysqli_free_result($cdp);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se seleccionó ningún personal.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>