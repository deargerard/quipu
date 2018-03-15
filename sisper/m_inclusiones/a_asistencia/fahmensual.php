<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['mes']) && !empty($_POST['mes']) && isset($_POST['ndias']) && !empty($_POST['ndias']) && isset($_POST['idp']) && !empty($_POST['idp'])){
    $mes=iseguro($cone,$_POST['mes']);
    $ndias=iseguro($cone,$_POST['ndias']);
    $idp=iseguro($cone,$_POST['idp']);

?>
        <div class="form-group valida">
          <label for="hor" class="col-sm-3 control-label">Horario</label>
          <div class="col-sm-9">
            <input type="hidden" name="mes" value="<?php echo $mes; ?>">
            <input type="hidden" name="ndias" value="<?php echo $ndias; ?>">
            <input type="hidden" name="idp" value="<?php echo $idp; ?>">
            <select name="hor" id="hor" class="form-control">
              <?php
                $ch=mysqli_query($cone, "SELECT idHorario, Descripcion FROM horario WHERE Estado=1 ORDER BY Descripcion ASC;");
                if(mysqli_num_rows($ch)>0){
                  while($rh=mysqli_fetch_assoc($ch)){
              ?>
              <option value="<?php echo $rh['idHorario']; ?>"><?php echo $rh['Descripcion']; ?></option>
              <?php
                  }
                }
                mysqli_free_result($ch);
              ?>
            </select>
          </div>
        </div>
        <div id="d_ahmensual"></div>
<?php
  }else{
    echo mensajewa("Faltan datos.");
  }
}else{
  echo accrestringidoa();
}
?>