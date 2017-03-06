<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
?>
        <div class="form-group valida">
          <label for="des" class="col-sm-3 control-label">Descripción</label>
          <div class="col-sm-9">
            <input type="text" name="des" id="des" class="form-control">
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
              ?>
              <option value="<?php echo $rcat['idCatDocumento']; ?>"><?php echo $rcat['CatDocumento']; ?></option>
              <?php
                }
              }
              mysqli_free_result($ccat);
              ?>
            </select>
          </div>
        </div>
        <div class="form-group valida">
          <label for="doc" class="col-sm-3 control-label">Documento</label>
          <div class="col-sm-9">
            <input type="file" name="doc" id="doc" class="form-control">
            <p class="help-block">Hasta 2Mb.</p>
          </div>
        </div>
<?php
}else{
  echo accrestringidoa();
}
?>
