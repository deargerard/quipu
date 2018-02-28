<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['idh']) && !empty($_POST['idh'])){
    $idh=iseguro($cone,$_POST['idh']);
    $cp=mysqli_query($cone,"SELECT * FROM horario WHERE idHorario=$idh;");
    if($rp=mysqli_fetch_assoc($cp)){

?>
    <h4 class="text-center">¿Seguro que desea <b class="text-orange"><?php echo $rp['Estado']==1 ? "cancelar" : "Activar"; ?></b> el horario?</h4>
    <input type="hidden" name="idh" value="<?php echo $idh; ?>">
    <div id="d_esthorario"></div>
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