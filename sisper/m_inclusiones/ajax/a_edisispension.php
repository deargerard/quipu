<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"])){
    $idp=iseguro($cone,$_POST["idp"]);
    $cdp=mysqli_query($cone,"SELECT * FROM pensionempleado WHERE idEmpleado=$idp");
    $rdp=mysqli_fetch_assoc($cdp);
    $idsp=$rdp['idSistemaPension'];
    if(empty($idsp)){
      $ti=0;
    }else{
      $ti=1;
    }
  ?>
            <div class="form-group">
              <label for="penins" class="col-sm-5 control-label">Institución</label>
              <div class="col-sm-7 valida">
                <input type="hidden" id="idpe" name="idpe" value="<?php echo $idp ?>">
                <input type="hidden" id="ti" name="ti" value="<?php echo $ti ?>">
                <select name="penins" id="penins" class="form-control">
                  <option value="">INSTITUCIÓN</option>
                  <?php
                  $csp=mysqli_query($cone,"SELECT * FROM sistemapension WHERE Estado=1");
                  while($rsp=mysqli_fetch_assoc($csp)){
                    if($rsp['idSistemaPension']==$idsp){
                  ?>
                  <option value="<?php echo $rsp['idSistemaPension'] ?>" selected><?php echo $rsp['Institucion'] ?></option>
                  <?php
                    }else{
                  ?>
                  <option value="<?php echo $rsp['idSistemaPension'] ?>"><?php echo $rsp['Institucion'] ?></option>
                  <?php
                    }
                  }
                  mysqli_free_result($csp);
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="cuspp" class="col-sm-5 control-label">Código CUSPP</label>
              <div class="col-sm-7 valida">
                <input type="text" id="cuspp" name="cuspp" class="form-control" placeholder="CUSPP" value="<?php echo $rdp['CUSPP'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="fecafi" class="col-sm-5 control-label">Fecha Afiliación</label>
              <div class="col-sm-7 valida">
                <input type="text" id="fecafi" name="fecafi" class="form-control" placeholder="CUSPP" value="<?php echo fnormal($rdp['FecAfiliacion']) ?>">
                <script>
                  $('#fecafi').datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    autoclose: true,
                    todayHighlight: true
                  });
                </script> 
              </div>
            </div>
  <?php
    mysqli_free_result($cdp);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún personal</h4>";
  }
}else{
  echo accrestringidoa();
}
?>