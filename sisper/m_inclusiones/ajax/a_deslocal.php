<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
  $idlo=iseguro($cone,$_POST["idlo"]);
  if(isset($idlo) && !empty($idlo)){
    $clo=mysqli_query($cone,"SELECT Direccion, idDistrito, Estado FROM local WHERE idLocal=$idlo");
    $rlo=mysqli_fetch_assoc($clo);
  ?>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <?php
          if ($rlo['Estado']==1){
           ?>
          <th>¿Está seguro que desea desactivar el local?</th>
          <?php
        } else {
          ?>
          <th>¿Está seguro que desea activar el local?</th>
          <?php
        }
           ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><h4 class="text-fuchsia"><?php echo $rlo['Direccion'] ?></h4></td>
        </tr>
        <tr>
          <td><?php echo disprodep($cone,$rlo['idDistrito']) ?></td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="idlo" id="idlo" value="<?php echo $idlo ?>">
  <?php
    mysqli_free_result($clo);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún local.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>
