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
            $fven=vacio(fmysql(iseguro($cone,$_POST['fven'])));
            $numres=imseguro($cone,$_POST['numres']);
            $mot=iseguro($cone,$_POST['mot']);
            $ofi=iseguro($cone,$_POST['ofi']);
            $ffea=date('Y-m-d',strtotime('-1 day', strtotime($ini)));
            if($ofi!=1){
                  $ofi=0;
            }
            if(isset($idec) && !empty($idec) && isset($dep) && !empty($dep) && isset($ini) && !empty($ini) && isset($numres) && !empty($numres)){
                  $sql="INSERT INTO cardependencia (idEmpleadoCargo, idDependencia, idTipoDesplaza, FecInicio, Vence, NumResolucion, Motivo, Estado, Oficial) VALUES ($idec, $dep, $tipdes, '$ini', $fven, '$numres', '$mot', '1', $ofi)";
                  if(mysqli_query($cone,$sql)){
                        $idcd=mysqli_insert_id($cone);
                        if(!mysqli_query($cone,"UPDATE cardependencia SET Estado=0, FecFin='$ffea' WHERE idEmpleadoCargo=$idec AND Estado=1 AND idCarDependencia!=$idcd")){
                              echo mensajeda("Error: ".mysqli_error($cone)." Al actualizar el estado y la fecha fin en el desplazamiento anterior.");
                        }
                        if($ofi==1){
                              if(!mysqli_query($cone,"UPDATE cardependencia SET Oficial=0 WHERE idEmpleadoCargo=$idec AND idCarDependencia!=$idcd")){
                                    echo mensajeda("Error: ".mysqli_error($cone)." Al actualizar el desplazamiento oficial para Lima anterior.");
                              }
                        }
                        echo mensajesu("Listo: Desplazamiento registrado correctamente.");
                  }else{
                        echo mensajeda("Error: ". mysqli_error($cone));
                  }
                  mysqli_close($cone);
                  
            }else{
                  echo mensajesu("Error: No lleno correctamente el formulario.");
            }
      }
}else{
      echo accrestringidoa();
}
?>