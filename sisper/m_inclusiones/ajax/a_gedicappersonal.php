<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edicappersonal"){
            $idca=iseguro($cone,$_POST['idca']);
            $den=imseguro($cone,$_POST['den']);
            $tip=iseguro($cone,$_POST['tip']);
            $ins=imseguro($cone,$_POST['ins']);
            $fecini=fmysql(iseguro($cone,$_POST['fecini']));
            $fecfin=fmysql(iseguro($cone,$_POST['fecfin']));
            $dur=iseguro($cone,$_POST['dur']);
            if(isset($idca) && !empty($idca) && isset($den) && !empty($den) && isset($tip) && !empty($tip) && isset($ins) && !empty($ins) && isset($dur) && !empty($dur)){
                  $sql="UPDATE capacitacion SET Denominacion='$den', idTipCap='$tip', Institucion='$ins', fechaIni='$fecini', FechaFin='$fecfin', Duracion=$dur WHERE idCapacitacion=$idca";
                  if(mysqli_query($cone,$sql)){
                        echo "<h4 class='text-olive'>Listo: Capacitación editada correctamente.</h4><br>";
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