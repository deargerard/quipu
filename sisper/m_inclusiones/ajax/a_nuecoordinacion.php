<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
?>

          <div class="form-group">
            <label for="den" class="col-sm-3 control-label">Denominación</label>
            <div class="col-sm-9 valida">
              <input type="text" class="form-control" id="den" name="den" placeholder="Denominación de la coordinación">
            </div>
          </div>
          <div class="form-group">
            <label for="ofi" class="col-sm-3 control-label">Oficial</label>
            <div class="col-sm-9 checkbox valida">
              <label>
                <input type="checkbox" id="ofi" name="ofi" value="1">
              </label>
            </div>
          </div>
<?php
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
