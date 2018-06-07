<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edicarpersonal"){
            $idec=iseguro($cone,$_POST['idec']);
            $sislab=iseguro($cone,$_POST['sislab']);
            $car=iseguro($cone,$_POST['car']);
            $tiping=iseguro($cone,$_POST['tiping']);
            $numcon=imseguro($cone,$_POST['numcon']);
            $concar=iseguro($cone,$_POST['concar']);
            $conlab=iseguro($cone,$_POST['conlab']);
            $rol=imseguro($cone,$_POST['rol']);
            $fecasu=fmysql(iseguro($cone,$_POST['fecasu']));
            $fecjur=vacio(fmysql(iseguro($cone,$_POST['fecjur'])));
            $fecven=vacio(fmysql(iseguro($cone,$_POST['fecven'])));
            $rem=iseguro($cone,$_POST['rem']);
            $numres=imseguro($cone,$_POST['numres']);
            $numcont=imseguro($cone,$_POST['numcont']);
            $mot=iseguro($cone,$_POST['mot']);
            if(isset($idec) && !empty($idec) && isset($sislab) && !empty($sislab) && isset($car) && !empty($car) && isset($fecasu) && !empty($fecasu)){
                  $sql="UPDATE empleadocargo SET idCargo=$car, Rol='$rol', Concurso='$numcon', idCondicionCar=$concar, idModAcceso=$tiping, FechaAsu='$fecasu', FechaJur=$fecjur, FechaVen=$fecven, Reemplazado=$rem, Motivo='$mot', idCondicionLab=$conlab, NumResolucion='$numres', NumContrato='$numcont' WHERE idEmpleadoCargo=$idec";
                  if(mysqli_query($cone,$sql)){              
                        echo mensajesu("Listo: Cargo editado correctamente.");
                        $q1="UPDATE cardependencia SET FecInicio='$fecasu', NumResolucion='$numres' WHERE idEmpleadoCargo=$idec AND idTipoDesplaza=1";
                        if(mysqli_query($cone,$q1)){
                              echo mensajesu("Listo: Datos en desplazamiento inicial actualizados.");
                        }else{
                              echo mensajeda("Error: No se pudo actualizar la dependencia inicial.");
                        }
                        $q2="UPDATE estadocargo SET FechaIni='$fecasu', NumResolucion='$numres' WHERE idEmpleadoCargo=$idec AND Motivo='ESTADO INICIAL'";
                        if(mysqli_query($cone,$q2)){
                              echo mensajesu("Listo: Datos en estado inicial actualizados.");
                        }else{
                             echo mensajeda("Error: No se pudo actualizar la dependencia inicial."); 
                        }
                  }else{
                        echo mensajeda("Error: ". mysqli_error($cone)." - ".$sql);
                  }
                  mysqli_close($cone);
                  
            }else{
                  echo mensajeda("Error: No lleno correctamente el formulario.");
            }
      }
}else{
      echo accrestringidoa();
}
?>