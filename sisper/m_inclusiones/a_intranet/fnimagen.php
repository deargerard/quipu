<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
?>
        <div class="form-group valida">
          <label for="img" class="col-sm-2 control-label">Imagen</label>
          <div class="col-sm-10">
            <input type="file" name="img" id="img" class="form-control" accept="image/jpeg, image/png">
            <p class="help-block">Solo imagenes JPG y PNG de hasta 1Mb. (1000x550 pixeles)</p>
          </div>
        </div>
<?php
}else{
  echo accrestringidoa();
}
?>
