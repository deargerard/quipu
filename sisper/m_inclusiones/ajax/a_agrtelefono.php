<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST['ide']) && !empty($_POST['ide'])){
    $ide=iseguro($cone,$_POST['ide']);
?>
          <div class="form-group valida">
            <label for="tiptel" class="col-sm-5 control-label">Tipo Teléfono</label>
            <div class="col-sm-7">
              <input type="hidden" name="idpe" id="idpe" value="<?php echo $ide ?>">
              <select name="tiptel" id="tiptel" class="form-control">
                <option value="">TIPO TELÉFONO</option>
                <?php
                  $ctt=mysqli_query($cone,"SELECT idTipoTelefono, TipoTelefono FROM tipotelefono WHERE Estado=1 ORDER BY TipoTelefono ASC");
                  while($rtt=mysqli_fetch_assoc($ctt)){
                ?>
                <option value="<?php echo $rtt['idTipoTelefono'] ?>"><?php echo $rtt['TipoTelefono'] ?></option>
                <?php
                  }
                  mysqli_free_result($ctt);
                ?>
              </select>
            </div>
          </div>
          <div class="form-group valida">
            <label for="num" class="col-sm-5 control-label">Número</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" id="num" name="num" placeholder="Número">
            </div>
          </div>
<?php
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún personal.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>
        