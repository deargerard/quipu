<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edidatpersonales"){
            $idpe=iseguro($cone,$_POST['idpe']);
            $apepat=imseguro($cone,$_POST['apepat']);
            $apemat=imseguro($cone,$_POST['apemat']);
            $nom=imseguro($cone,$_POST['nom']);
            $sex=iseguro($cone,$_POST['sex']);
            $fecnac=fmysql(iseguro($cone,$_POST['fecnac']));
            $nac=imseguro($cone,$_POST['nac']);
            $disnac=iseguro($cone,$_POST['disnac']);
            $estciv=iseguro($cone,$_POST['estciv']);
            $libmil=imseguro($cone,$_POST['libmil']);
            $aut=imseguro($cone,$_POST['aut']);
            $ruc=iseguro($cone,$_POST['ruc']);
            $corins=inseguro($cone,$_POST['corins']);
            $corper=inseguro($cone,$_POST['corper']);
            $numcue=imseguro($cone,$_POST['numcue']);
            $entcts=imseguro($cone,$_POST['entcts']);
            $grusan=iseguro($cone,$_POST['grusan']);
            if(isset($apepat) && !empty($apepat) && isset($apemat) && !empty($apemat) && isset($nom) && !empty($nom) && isset($fecnac) && !empty($fecnac) && isset($nac) && !empty($nac) && isset($disnac) && !empty($disnac)){
                  $sql="UPDATE empleado SET ApellidoPat='$apepat', ApellidoMat='$apemat', Nombres='$nom', Sexo='$sex', FechaNac='$fecnac', idDistrito=$disnac, Nacionalidad='$nac', LibretaMil='$libmil', Autogenerado='$aut', RUC='$ruc', idEstadoCivil=$estciv, CorreoIns='$corins', CorreoPer='$corper', NumeroCuenta='$numcue', GrupoSan='$grusan', EntidadCts='$entcts' WHERE idEmpleado=$idpe";
                  if(mysqli_query($cone,$sql)){
                        echo "<h4 class='text-olive'>Listo: Los datos personales fueron editados correctamente.</h4>";
                  }else{
                        echo "<h4 class='text-maroon'>Error: " . mysqli_error($cone)."</h4>";
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