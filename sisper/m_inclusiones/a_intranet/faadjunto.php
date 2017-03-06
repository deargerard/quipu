<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
?>
        <div class="form-group valida">
          <label for="adj" class="col-sm-2 control-label">Adjunto</label>
          <div class="col-sm-10">
            <input type="hidden" name="idcom" value="<?php echo $id; ?>">
            <input type="file" name="adj" id="adj" class="form-control">
            <p class="help-block">En caso sean varios archivos, comprímalos.</p>
          </div>
        </div>
<?php
  }else{
    echo mensajesu("Error: No se envió ningún dato.");
  }
}else{
  echo accrestringidoa();
}
?>