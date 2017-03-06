<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_agrcappersonal"){
            $idpe=iseguro($cone,$_POST['idpe']);
            $den=imseguro($cone,$_POST['den']);
            $tip=iseguro($cone,$_POST['tip']);
            $ins=imseguro($cone,$_POST['ins']);
            $fecini=fmysql(iseguro($cone,$_POST['fecini']));
            $fecfin=fmysql(iseguro($cone,$_POST['fecfin']));
            $dur=iseguro($cone,$_POST['dur']);
            if(isset($idpe) && !empty($idpe) && isset($den) && !empty($den) && isset($tip) && !empty($tip) && isset($ins) && !empty($ins) && isset($dur) && !empty($dur)){
                  $sql="INSERT INTO capacitacion (idEmpleado, Denominacion, idTipCap, Institucion, fechaIni, FechaFin, Duracion) VALUES ($idpe, '$den', $tip, '$ins', '$fecini', '$fecfin', $dur)";
                  if(mysqli_query($cone,$sql)){
                        echo "<h4 class='text-olive'>Listo: Capacitación registrada correctamente.</h4><br>";
                  }else{
                        echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
                  }
                  mysqli_close($cone);  
            }else{
                  echo "<h4 class='text-maroon'>Error: No lleno correctamente el formulario.</h4>";
            }
      }
}else{
      echo accrestringidoa();
}
?>