<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
  $idco=iseguro($cone,$_POST["idco"]);
  if(isset($idco) && !empty($idco)){
    $c=mysqli_query($cone,"SELECT Denominacion FROM coordinacion WHERE idCoordinacion=$idco");
    $r=mysqli_fetch_assoc($c);
  ?>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th class="text-center">¿Está seguro que desea activar?</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center"><h4 class="text-fuchsia"><?php echo $r['Denominacion'] ?></h4></td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="idco" id="idco" value="<?php echo $idco ?>">
  <?php
    mysqli_free_result($c);
    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No se eligió una coordinación válida.");
  }
}else{
  echo accrestringidoa();
}
?>
