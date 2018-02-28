<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['idp']) && !empty($_POST['idp'])){
    $idp=iseguro($cone,$_POST['idp']);
    $cp=mysqli_query($cone,"SELECT Estado FROM permiso WHERE idPermiso=$idp;");
    if($rp=mysqli_fetch_assoc($cp)){

?>
    <h4 class="text-center">¿Seguro que desea <b class="text-orange"><?php echo $rp['Estado']==1 ? "cancelar" : "Activar"; ?></b> el permiso?</h4>
    <input type="hidden" name="idp" value="<?php echo $idp; ?>">
    <div id="d_estpermiso"></div>
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