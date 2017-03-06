<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
?>
        <div class="form-group valida">
          <label for="bol" class="col-sm-2 control-label">Boletín</label>
          <div class="col-sm-10">
            <input type="hidden" name="idbol" value="<?php echo $id; ?>">
            <input type="file" name="bol" id="bol" class="form-control" accept="application/pdf">
            <p class="help-block">Hasta 6Mb.</p>
          </div>
        </div>
<?php
  }else{
    echo mensajeda("Error: No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>
