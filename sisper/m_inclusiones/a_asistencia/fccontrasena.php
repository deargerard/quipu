<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
?>
        <div class="form-group valida">
          <label for="con" class="col-sm-6 control-label">Contraseña</label>
          <div class="col-sm-6">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="password" name="con" id="con" class="form-control">
          </div>
        </div>
        <div class="form-group valida">
          <label for="ncon" class="col-sm-6 control-label">Repetir Contraseña</label>
          <div class="col-sm-6">
            <input type="password" name="ncon" id="ncon" class="form-control">
          </div>
        </div>

<?php
  }else{
    echo mensajeda("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>
