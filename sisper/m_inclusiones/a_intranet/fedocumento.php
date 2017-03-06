<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $cdoc=mysqli_query($cone,"SELECT * FROM documento WHERE idDocumento=$id");
    if($rdoc=mysqli_fetch_assoc($cdoc)){
?>
        <div class="form-group valida">
          <label for="des" class="col-sm-3 control-label">Descripción</label>
          <div class="col-sm-9">
            <input type="hidden" name="iddoc" value="<?php echo $id; ?>">
            <input type="text" name="des" id="des" class="form-control" value="<?php echo $rdoc['Descripcion']; ?>">
          </div>
        </div>
        <div class="form-group valida">
          <label for="cat" class="col-sm-3 control-label">Categoría Doc.</label>
          <div class="col-sm-5">
            <select name="cat" id="cat" class="form-control">
              <option value="">Categoría</option>
              <?php
              $ccat=mysqli_query($cone,"SELECT * FROM catdocumento WHERE Estado=1");
              if(mysqli_num_rows($ccat)>0){
                while($rcat=mysqli_fetch_array($ccat)){
                  if($rdoc['idCatDocumento']==$rcat['idCatDocumento']){
              ?>
              <option value="<?php echo $rcat['idCatDocumento']; ?>" selected><?php echo $rcat['CatDocumento']; ?></option>
              <?php
                  }else{
              ?>
              <option value="<?php echo $rcat['idCatDocumento']; ?>"><?php echo $rcat['CatDocumento']; ?></option>
              <?php
                  }
                }
              }
              mysqli_free_result($ccat);
              ?>
            </select>
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
