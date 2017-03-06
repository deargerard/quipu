<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $ccat=mysqli_query($cone,"SELECT * FROM catdocumento WHERE idCatDocumento=$id");
    if($rcat=mysqli_fetch_assoc($ccat)){
?>
        <div class="form-group valida">
          <label for="cat" class="col-sm-3 control-label">Categoría Doc.</label>
          <div class="col-sm-9">
            <input type="hidden" name="idcat" value="<?php echo $id; ?>">
            <input type="text" name="cat" id="cat" class="form-control" value="<?php echo $rcat['CatDocumento']; ?>">
          </div>
        </div>
<?php
    }else{
      echo mensajeda("Error: Los datos enviados no son correctos.");
    }
  }else{
    echo mensajeda("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>
