<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
  if(isset($_POST["idcs"]) && !empty($_POST["idcs"])){
    $idcs=iseguro($cone,$_POST["idcs"]);
    $ccs=mysqli_query($cone,"SELECT * FROM comservicios WHERE idComServicios=$idcs");
    $rcs=mysqli_fetch_assoc($ccs);
    $est="";
    ?>
      <table class="table">
        <thead>
          <tr>
            <th class="text-center"><?php echo "¿Está seguro que desea cancelar la comisión de servicio?"; ?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><h4 class="text-maroon text-center"><?php echo " Del: ". fnormal($rcs['FechaIni'])." Al:  ".fnormal($rcs['FechaFin']) ?></h4></td>
          </tr>
        </tbody>
      </table>
      <input type="hidden" name="idcs" value="<?php echo $idcs?>">
    <?php
      mysqli_free_result($ccs);
      mysqli_close($cone);

  }else{
    echo mensajewa("Error: No se eligio comisión de servicio para eliminar.");
  }
}else{
  echo accrestringidoa();
}
?>
