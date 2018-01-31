<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['mesano']) && !empty($_POST['mesano']) && isset($_POST['emp']) && !empty($_POST['emp'])){
    $emp=iseguro($cone,$_POST['emp']);
    $mesano=explode("/", iseguro($cone,$_POST['mesano']));
    if(strlen($mesano[0])==2 && strlen($mesano[1])==4){
?>
<h3><i class='fa fa-user text-gray'></i> <span class="text-orange"><?php echo nomempleado($cone,$emp); ?></span></h3>
<h4><i class='fa fa-calendar-check-o text-gray'></i> <span class="text-orange"><?php echo strtoupper(nombremes($mesano[0])).' - '.$mesano[1]; ?></span></h4>

<?php
    }else{
      echo mensajewa("Error: El mes/año no es válido.");
    }
  }else{
    echo mensajeda("Error: No se enviaron los datos.");
  }
}else{
  echo accrestringidoa();
}
                  ?>