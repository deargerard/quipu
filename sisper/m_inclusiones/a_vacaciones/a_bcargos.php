<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(acceso($cone,$_SESSION['identi'])){
$per=iseguro($cone,$_POST["per"]);

$ccar=mysqli_query($cone,"SELECT ec.idEmpleadoCargo, c.Denominacion, cc.CondicionCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleado=$per ORDER BY ec.idEstadoCar ASC, ec.idEmpleadoCargo DESC;");

  if (mysqli_num_rows($ccar)>0){
    while ($rcar=mysqli_fetch_array($ccar)) {
      $co= $rcar['CondicionCar']=="NINGUNO" ? "" : "(".substr($rcar['CondicionCar'], 0, 1).")";
      ?>
      <option value="<?php echo $rcar['idEmpleadoCargo'] ?>"><?php echo $rcar['Denominacion']." ".$co ?></option>
      <?php
    }
  }else{
    ?>
    <option value="">Sin cargos</option>
    <?php
  }
}
?>
