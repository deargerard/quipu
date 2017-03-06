<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_carpersonal"){
            $idper=iseguro($cone,$_POST['idper']);
            $sislab=iseguro($cone,$_POST['sislab']);
            $car=iseguro($cone,$_POST['car']);
            $dep=iseguro($cone,$_POST['dep']);
            $tiping=iseguro($cone,$_POST['tiping']);
            $numcon=imseguro($cone,$_POST['numcon']);
            $concar=iseguro($cone,$_POST['concar']);
            $conlab=iseguro($cone,$_POST['conlab']);
            $rol=imseguro($cone,$_POST['rol']);
            $fecasu=fmysql(iseguro($cone,$_POST['fecasu']));
            $fecjur=fmysql(iseguro($cone,$_POST['fecjur']));
            $fecven=fmysql(iseguro($cone,$_POST['fecven']));
            $rem=iseguro($cone,$_POST['rem']);
            $numres=imseguro($cone,$_POST['numres']);
            $numcont=imseguro($cone,$_POST['numcont']);
            $mot=iseguro($cone,$_POST['mot']);
            if(isset($idper) && !empty($idper) && isset($sislab) && !empty($sislab) && isset($car) && !empty($car) && isset($dep) && !empty($dep) && isset($fecasu) && !empty($fecasu)){
                  $sql="INSERT INTO empleadocargo (idEmpleado, idCargo, Rol, Concurso, idCondicionCar, idModAcceso, FechaAsu, FechaJur, FechaVen, Reemplazado, Motivo, idCondicionLab, NumResolucion, NumContrato, idEstadoCar) VALUES ($idper, $car, '$rol', '$numcon', $concar, '$tiping', '$fecasu', '$fecjur', '$fecven', $rem, '$mot', $conlab, '$numres', '$numcont',1)";
                  if(mysqli_query($cone,$sql)){
                        $idec=mysqli_insert_id($cone);
                        if(!mysqli_query($cone,"INSERT INTO cardependencia (idEmpleadocargo, idDependencia, idTipoDesplaza, FecInicio, NumResolucion, Motivo, Estado, Oficial) VALUES ($idec, $dep, 1, '$fecasu', 'numres', 'Nuevo Ingreso', 1, 1)")){
                              echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)." Al asignarle dependencia.</h4>";
                        }
                        if(!mysqli_query($cone,"INSERT INTO estadocargo (idEmpleadoCargo, idEstadoCar, FechaIni, Motivo, NumResolucion, Estado) VALUES ($idec, 1, '$fecasu', 'Nuevo Ingreso', 'numres', 1)")){
                              echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)." Al asignarle el estado al cargo.</h4>";
                        }
                        if(mysqli_query($cone,"UPDATE empleado SET Estado=1 WHERE idEmpleado=$idper")){
                              echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)." Al actualizar estado del empleado.</h4>";
                        }
                        echo "<h4 class='text-olive'>Listo: Cargo registrado correctamente.</h4><br>";
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