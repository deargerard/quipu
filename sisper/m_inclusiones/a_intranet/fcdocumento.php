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
          <label for="doc" class="col-sm-3 control-label">Documento</label>
          <div class="col-sm-9">
            <input type="hidden" name="iddoc" value="<?php echo $id; ?>">
            <input type="file" name="doc" id="doc" class="form-control">
            <p class="help-block">Hasta 2Mb.</p>
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
