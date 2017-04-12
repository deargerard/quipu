<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edidesplazamiento"){
            $id=iseguro($cone,$_POST['id']);
            $dep=iseguro($cone,$_POST['dep']);
            $tipdes=iseguro($cone,$_POST['tipdes']);
            $ini=fmysql(iseguro($cone,$_POST['ini']));
            $fin=fmysql(iseguro($cone,$_POST['fin']));
            $numres=imseguro($cone,$_POST['numres']);
            $mot=iseguro($cone,$_POST['mot']);
            $ofi=iseguro($cone,$_POST['ofi']);
            $c=mysqli_query($cone,"SELECT idEmpleadoCargo FROM cardependencia WHERE idCarDependencia=$id");
            $r=mysqli_fetch_assoc($c);
            $idec=$r['idEmpleadoCargo'];
            mysqli_free_result($c);
            if($ofi!=1){
                  $ofi=0;
            }
            if(isset($dep) && !empty($dep) && isset($ini) && !empty($ini) && isset($numres) && !empty($numres)){
                  $sql="UPDATE cardependencia SET idDependencia=$dep, idTipoDesplaza=$tipdes, FecInicio='$ini', FecFin='$fin', NumResolucion='$numres', Motivo='$mot', Oficial=$ofi WHERE idCarDependencia=$id;";
                  if(mysqli_query($cone,$sql)){
                        $idcd=$id;
                        if($ofi==1){
                              if(!mysqli_query($cone,"UPDATE cardependencia SET Oficial=0 WHERE idEmpleadoCargo=$idec AND idCarDependencia!=$idcd")){
                                    echo mensajeda("Error: ".mysqli_error($cone)." Al actualizar el desplazamiento oficial para Lima anterior.");
                              }
                        }
                        echo mensajesu("Listo: Desplazamiento editado correctamente.");
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