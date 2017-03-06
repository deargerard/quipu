<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edimovpersonal"){
            $idmd=iseguro($cone,$_POST['idmd']);
            $dep=iseguro($cone,$_POST['dep']);
            $ini=fmysql(iseguro($cone,$_POST['ini']));
            $fin=fmysql(iseguro($cone,$_POST['fin']));
            $nummem=imseguro($cone,$_POST['nummem']);
            $numres=imseguro($cone,$_POST['numres']);
            $mot=iseguro($cone,$_POST['mot']);
            if(isset($idmd) && !empty($idmd) && isset($dep) && !empty($dep) && isset($ini) && !empty($ini) && isset($fin) && !empty($fin) && isset($mot) && !empty($mot)){
                  $sql="UPDATE movdependencia SET idDependencia=$dep, FecInicio='$ini', FecFin='$fin', NumMemo='$nummem', NumResolucion='$numres', Motivo='$mot' WHERE idMovDependencia=$idmd";
                  if(mysqli_query($cone,$sql)){
                        echo "<h4 class='text-olive'>Listo: Movimiento de dependencia editado correctamente.</h4><br>";
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