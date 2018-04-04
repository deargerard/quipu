<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['idm']) && !empty($_POST['idm']) && isset($_POST['mar']) && !empty($_POST['mar']) ){
    $idm=iseguro($cone,$_POST['idm']);
    $mar=iseguro($cone,$_POST['mar']);
    $dni=$_SESSION['docide'];
    $cv=mysqli_query($cone, "SELECT idVigilante FROM vigilante WHERE DNI='$dni';");
    if($rv=mysqli_fetch_assoc($cv)){

?>

          <input type="hidden" name="idm" value="<?php echo $idm; ?>">
          <p class="text-center">¿Está seguro que desea eliminar la marcación?</p>
          <h3 class="text-red text-center"><?php echo date('h:i:s A - d/m/Y', strtotime($mar)); ?></h3>
          <div id="r_elmarcacion" class="text-center"></div>


<?php
    }else{
      echo mensajewa("No cuenta con permisos para eliminar las marcaciones.");
    }
    mysqli_free_result($cv);
  }else{
    echo mensajewa("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>