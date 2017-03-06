<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nuedesplazamiento"){
            $idec=iseguro($cone,$_POST['idec']);
            $dep=iseguro($cone,$_POST['dep']);
            $tipdes=iseguro($cone,$_POST['tipdes']);
            $ini=fmysql(iseguro($cone,$_POST['ini']));
            $fin=fmysql(iseguro($cone,$_POST['fin']));
            $numres=imseguro($cone,$_POST['numres']);
            $mot=iseguro($cone,$_POST['mot']);
            $ofi=iseguro($cone,$_POST['ofi']);
            $nfec=@strtotime('-1 day', strtotime($ini));
            $nfec=@date('Y-m-d', $nfec);
            if($ofi!=1){
                  $ofi=0;
            }
            if(isset($idec) && !empty($idec) && isset($dep) && !empty($dep) && isset($ini) && !empty($ini) && isset($numres) && !empty($numres)){
                  $sql="INSERT INTO cardependencia (idEmpleadoCargo, idDependencia, idTipoDesplaza, FecInicio, FecFin, NumResolucion, Motivo, Estado, Oficial) VALUES ($idec, $dep, $tipdes, '$ini', '$fin', '$numres', '$mot', '1', $ofi)";
                  if(mysqli_query($cone,$sql)){
                        $idcd=mysqli_insert_id($cone);
                        if(!mysqli_query($cone,"UPDATE cardependencia SET FecFin='$nfec' WHERE idEmpleadoCargo=$idec AND Estado=1 AND idCarDependencia!=$idcd")){
                              echo "<h4 class='text-maroon'>Error: ".mysqli_error($cone)." Al actualizar finalización del desplazamiento anterior.</h4>";
                        }
                        if(!mysqli_query($cone,"UPDATE cardependencia SET Estado=0 WHERE idEmpleadoCargo=$idec AND idCarDependencia!=$idcd")){
                              echo "<h4 class='text-maroon'>Error: ".mysqli_error($cone)." Al actualizar los estados de los desplazamientos anteriores.</h4>";
                        }
                        if($ofi==1){
                              if(!mysqli_query($cone,"UPDATE cardependencia SET Oficial=0 WHERE idEmpleadoCargo=$idec AND idCarDependencia!=$idcd")){
                                    echo "<h4 class='text-maroon'>Error: ".mysqli_error($cone)." Al actualizar el desplazamiento oficial para Lima anterior.</h4>";
                              }
                        }
                        echo "<h4 class='text-olive'>Listo: Desplazamiento registrado correctamente.</h4><br>";
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