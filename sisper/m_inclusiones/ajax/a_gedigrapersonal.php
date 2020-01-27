<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edigrapersonal"){
            $idg=iseguro($cone,$_POST['idg']);
            $niv=iseguro($cone,$_POST['niv']);
            $den=imseguro($cone,$_POST['den']);
            $fecexp=fmysql(iseguro($cone,$_POST['fecexp']));
            $ins=imseguro($cone,$_POST['ins']);
            $numcol=imseguro($cone,$_POST['numcol']);
            $feccol=vacio(fmysql(iseguro($cone,$_POST['feccol'])));
            $numdip=imseguro($cone,$_POST['numdip']);
            if(isset($idg) && !empty($idg) && isset($niv) && !empty($niv) && isset($den) && !empty($den) && isset($fecexp) && !empty($fecexp) && isset($ins) && !empty($ins)){
                  $sql="UPDATE gradotitulo SET idNivGraTit=$niv, Denominacion='$den', FechaExp='$fecexp', Institucion='$ins', NumeroCol='$numcol', FechaCol=$feccol, NumeroDip='$numdip' WHERE idGradoTitulo=$idg";
                  if(mysqli_query($cone,$sql)){
                        echo "<h4 class='text-olive'>Listo: Grado y/o título, editado correctamente.</h4><br>";
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