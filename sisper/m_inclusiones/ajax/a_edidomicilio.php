<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"])){
    $idp=iseguro($cone,$_POST["idp"]);
    $cdp=mysqli_query($cone,"SELECT * FROM domicilio WHERE idEmpleado=$idp");
    $rdp=mysqli_fetch_assoc($cdp);
  ?>
            <div class="form-group">
              <label for="conviv" class="col-sm-3 control-label">Condición Vivienda</label>
              <div class="col-sm-3 valida">
                <input type="hidden" id="idpe" name="idpe" value="<?php echo $idp ?>">
                <select name="conviv" id="conviv" class="form-control">
                  <option value="">CONDICIÓN</option>
                <?php
                if($rdp['Condicion']=='PROPIA'){
                ?>
                  <option value="PROPIA" selected>PROPIA</option>
                <?php
                }else{
                ?>
                  <option value="PROPIA">PROPIA</option>
                <?php
                }
                ?>
                <?php
                if($rdp['Condicion']=='ALQUILER'){
                ?>
                  <option value="ALQUILER" selected>ALQUILER</option>
                <?php
                }else{
                ?>
                  <option value="ALQUILER">ALQUILER</option>
                <?php
                }
                ?>
                <?php
                if($rdp['Condicion']=='FAMILIAR'){
                ?>
                  <option value="FAMILIAR" selected>FAMILIAR</option>
                <?php
                }else{
                ?>
                  <option value="FAMILIAR">FAMILIAR</option>
                <?php
                }
                ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="dir" class="col-sm-3 control-label">Dirección</label>
              <div class="col-sm-9 valida">
                <input type="text" id="dir" name="dir" class="form-control" placeholder="Dirección" value="<?php echo $rdp['Direccion'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="urb" class="col-sm-3 control-label">Urbanización</label>
              <div class="col-sm-9 valida">
                <input type="text" id="urb" name="urb" class="form-control" placeholder="Urbanización" value="<?php echo $rdp['Urbanizacion'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="depubi" class="col-sm-3 control-label">Ubicación</label>
              <?php
              $iddis=$rdp['idDistrito'];
              $ti=0;
              if(!empty($iddis)){
              $cubi=mysqli_query($cone,"SELECT de.idDepartamento, pr.idProvincia FROM distrito AS di INNER JOIN provincia AS pr ON di.idProvincia=pr.idProvincia INNER JOIN departamento AS de ON pr.idDepartamento=de.idDepartamento WHERE di.idDistrito=$iddis");
              $rubi=mysqli_fetch_assoc($cubi);
              $ti=1;
              }
              ?>
              <div class="col-sm-3 valida">
                <input type="hidden" id="ti" name="ti" value="<?php echo $ti ?>">
                <select name="depubi" id="depubi" class="form-control" onChange="cprovinciad(this.value)">
                  <option value="">DEPARTAMENTO</option>
                  <?php
                  $cdep=mysqli_query($cone,"SELECT * FROM departamento");
                  while($rdep=mysqli_fetch_assoc($cdep)){
                    if($rdep['idDepartamento']==$rubi['idDepartamento']){
                  ?>
                  <option value="<?php echo $rdep['idDepartamento'] ?>" selected><?php echo $rdep['NombreDep'] ?></option>
                  <?php
                    }else{
                  ?>
                  <option value="<?php echo $rdep['idDepartamento'] ?>"><?php echo $rdep['NombreDep'] ?></option>
                  <?php
                    }                  
                  }
                  mysqli_free_result($cdep);
                  ?>
                </select>
              </div>
              <div class="col-sm-3 valida">
                <select name="proubi" id="proubi" class="form-control" onChange="cdistritod(this.value)">
                  <option value="">PROVINCIA</option>
                  <?php
                  $iddep=$rubi['idDepartamento'];
                  $cpro=mysqli_query($cone,"SELECT * FROM provincia WHERE idDepartamento=$iddep");
                  while($rpro=mysqli_fetch_assoc($cpro)){
                    if($rpro['idProvincia']==$rubi['idProvincia']){
                  ?>
                  <option value="<?php echo $rpro['idProvincia'] ?>" selected><?php echo $rpro['NombrePro'] ?></option>
                  <?php
                    }else{
                  ?>
                  <option value="<?php echo $rpro['idProvincia'] ?>"><?php echo $rpro['NombrePro'] ?></option>
                  <?php
                    }                  
                  }
                  mysqli_free_result($cpro);
                  ?>
                </select>
              </div>
              <div class="col-sm-3 valida">
                <select name="disubi" id="disubi" class="form-control">
                  <option value="">DISTRITO</option>
                  <?php
                  $idpro=$rubi['idProvincia'];
                  $cdis=mysqli_query($cone,"SELECT * FROM distrito WHERE idProvincia=$idpro");
                  while($rdis=mysqli_fetch_assoc($cdis)){
                    if($rdis['idDistrito']==$iddis){
                  ?>
                  <option value="<?php echo $rdis['idDistrito'] ?>" selected><?php echo $rdis['NombreDis'] ?></option>
                  <?php
                    }else{
                  ?>
                  <option value="<?php echo $rdis['idDistrito'] ?>"><?php echo $rdis['NombreDis'] ?></option>
                  <?php
                    }                  
                  }
                  mysqli_free_result($cdis);
                  mysqli_free_result($cubi);
                  ?>
                </select>
              </div>
            </div>
  <?php
    mysqli_free_result($cdp);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se seleccionó ningún personal</h4>";
  }
}else{
  echo accrestringidoa();
}
?>