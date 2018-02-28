<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
?>
        <div class="form-group valida">
          <label for="ape" class="col-sm-2 control-label">Apellidos</label>
          <div class="col-sm-10">
            <input type="text" name="ape" id="ape" class="form-control">
          </div>
        </div>
        <div class="form-group valida">
          <label for="nom" class="col-sm-2 control-label">Nombres</label>
          <div class="col-sm-10">
            <input type="text" name="nom" id="nom" class="form-control">
          </div>
        </div>
        <div class="form-group valida">
          <label for="dni" class="col-sm-2 control-label">DNI</label>
          <div class="col-sm-5">
            <input type="text" name="dni" id="dni" class="form-control">
          </div>
        </div>

<?php
}else{
  echo accrestringidoa();
}
?>
