<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
  if(isset($_POST["idvac"]) && !empty($_POST["idvac"])){
    $idvac=iseguro($cone,$_POST["idvac"]);
    $cvac=mysqli_query($cone,"SELECT * FROM provacaciones WHERE idProVacaciones=$idvac");
    $rvac=mysqli_fetch_assoc($cvac);
    $est="";
    $est= $rvac['Condicion']==1 ? "PROGRAMADAS" : "REPROGRAMADAS";
    if ($rvac['Estado']!=0){
      ?>
      <thead>
        <tr>
          <th class="text-center">Las vacaciones que ha elegido no se pueden Cancelar</th>
        </tr>
      </thead>
      <?php
    }else{
      ?>
        <table class="table">
          <thead>
            <tr>
              <th class="text-center"><?php echo "¿Está seguro que desea cancelar las vacaciones ". $est. "?"; ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><h4 class="text-maroon text-center"><?php echo " Del: ". fnormal($rvac['FechaIni'])." Al:  ".fnormal($rvac['FechaFin']) ?></h4></td>
            </tr>
          </tbody>
        </table>
        <input type="hidden" name="idvac" value="<?php echo $idvac?>">
      <?php
        mysqli_free_result($cvac);
        mysqli_close($cone);
}
  }else{
    echo mensajewa("Error: No se eligio vacaciones para eliminar.");
  }
}else{
  echo accrestringidoa();
}
?>
