<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
?>
        <div class="form-group valida">
          <label for="cat" class="col-sm-3 control-label">Categoría Doc.</label>
          <div class="col-sm-9">
            <input type="text" name="cat" id="cat" class="form-control">
          </div>
        </div>
<?php
}else{
  echo accrestringidoa();
}
?>
