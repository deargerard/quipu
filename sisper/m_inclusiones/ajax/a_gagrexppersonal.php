<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_agrexppersonal"){
            $idpe=iseguro($cone,$_POST['idpe']);
            $ins=imseguro($cone,$_POST['ins']);
            $car=imseguro($cone,$_POST['car']);
            $fecini=fmysql(iseguro($cone,$_POST['fecini']));
            $fecfin=fmysql(iseguro($cone,$_POST['fecfin']));
            $con=iseguro($cone,$_POST['con']);
            $motces=imseguro($cone,$_POST['motces']);
            if(isset($idpe) && !empty($idpe) && isset($ins) && !empty($ins) && isset($car) && !empty($car) && isset($fecini) && !empty($fecini)){
                  if(empty($fecfin)){
                        $fecfin='0000-00-00';
                  }
                  $sql="INSERT INTO explaboral (idEmpleado, Institucion, Cargo, FechaIni, FechaFin, idConConExp, MotivoCese) VALUES ($idpe, '$ins', '$car', '$fecini', '$fecfin', $con, '$motces')";
                  if(mysqli_query($cone,$sql)){
                        echo "<h4 class='text-olive'>Listo: Experiencia laboral registrada correctamente.</h4><br>";
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