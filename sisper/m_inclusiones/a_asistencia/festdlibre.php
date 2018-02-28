<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['iddl']) && !empty($_POST['iddl'])){
    $iddl=iseguro($cone,$_POST['iddl']);
    $cp=mysqli_query($cone,"SELECT * FROM dialibre WHERE idDiaLibre=$iddl;");
    if($rp=mysqli_fetch_assoc($cp)){

?>
    <h4 class="text-center">¿Seguro que desea <b class="text-orange"><?php echo $rp['Estado']==1 ? "cancelar" : "Activar"; ?></b> el día libre?</h4>
    <input type="hidden" name="iddl" value="<?php echo $iddl; ?>">
    <div id="d_estdlibre"></div>
<?php
    }else{
      echo mensajewa("No envió datos validos.");
    }
    mysqli_free_result($cp);
  }else{
    echo mensajewa("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>