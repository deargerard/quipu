<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
  if(isset($_POST["idvac"]) && !empty($_POST["idvac"]) && isset($_POST["nom"]) && !empty($_POST["nom"])){
    $idvac=iseguro($cone,$_POST["idvac"]);
    $nom=iseguro($cone,$_POST["nom"]);
    $cvac=mysqli_query($cone,"SELECT * FROM provacaciones WHERE idProVacaciones=$idvac");
    $rvac=mysqli_fetch_assoc($cvac);
    $est="";
    $est= $rvac['Condicion']==1 ? "programadas" : "reprogramadas";
    if ($rvac['Estado']==1 || $rvac['Estado']==2 || $rvac['Estado']==3 || $rvac['Estado']==4 || $rvac['Estado']==5){
      ?>
      <thead>
        <tr>
          <?php
            echo mensajewa("Error: Las vacaciones que ha elegido no se pueden ejecutar.");
           ?>
        </tr>
      </thead>
      <?php
    }else{
      ?>
        <table class="table">
          <thead>
            <tr>
              <th class="text-center"><?php echo "¿Está seguro que desea poner en ejecución las vacaciones ". $est. " para <br>".$nom."?"; ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><h4 class="text-maroon text-center"><?php echo " Del: ". fnormal($rvac['FechaIni'])." Al:  ".fnormal($rvac['FechaFin']) ?></h4></td>
            </tr>
          </tbody>
        </table>
        <input type="hidden" name="idvac" value="<?php echo $idvac?>">
        <input type="hidden" name="nom" value="<?php echo $nom?>">
      <?php
        mysqli_free_result($cvac);
        mysqli_close($cone);
}
  }else{
    echo mensajewa("Error: No se eligio vacaciones para ejecutar.");
  }
}else{
  echo accrestringidoa();
}
?>
