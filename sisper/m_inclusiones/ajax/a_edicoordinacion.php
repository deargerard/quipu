<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
  if(isset($_POST['idco']) && !empty($_POST['idco'])){
    $idco=iseguro($cone, $_POST['idco']);
    $co=mysqli_query($cone,"SELECT * FROM coordinacion WHERE idCoordinacion=$idco");
    if($re=mysqli_fetch_assoc($co)){
?>
          <div class="form-group">
            <label for="den" class="col-sm-3 control-label">Denominación</label>
            <div class="col-sm-9 valida">
              <input type="hidden" name="idco" id="idco" value="<?php echo $idco; ?>">
              <input type="text" class="form-control" id="den" name="den" placeholder="Denominacion de la coordinación" value="<?php echo $re['Denominacion']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="ofi" class="col-sm-3 control-label">Oficial</label>
            <div class="col-sm-9 checkbox valida">
              <label>
                <input type="checkbox" id="ofi" name="ofi" value="1" <?php echo $re['Oficial']==1 ? "checked" : ""; ?>>
              </label>
            </div>
          </div>
<?php
    }else{
      echo mensajewa("Error: No se envió información válida.");
    }
  mysqli_close($cone);
  }else{
    echo mensajewa("Error: No se eligió una coordinación.");
  }
}else{
  echo accrestringidoa();
}
?>
