<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
  $idd=iseguro($cone,$_POST["idd"]);
  if(isset($idd) && !empty($idd)){
    $cdep=mysqli_query($cone,"SELECT Denominacion FROM dependencia WHERE idDependencia=$idd");
    $rdep=mysqli_fetch_assoc($cdep);
  ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Esta seguro que desea desactivar la dependencia:</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><h4 class="text-maroon"><?php echo $rdep['Denominacion'] ?></h4></td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="iddep" value="<?php echo $idd ?>">
  <?php
    mysqli_free_result($cdep);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se selecciono ninguna dependencia</h4>";
  }
}else{
  echo accrestringidoa();
}
?>