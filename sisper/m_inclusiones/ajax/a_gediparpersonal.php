<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
      if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ediparpersonal"){
            $idpa=iseguro($cone,$_POST['idpa']);
            $tippar=iseguro($cone,$_POST['tippar']);
            $apepat=imseguro($cone,$_POST['apepat']);
            $apemat=imseguro($cone,$_POST['apemat']);
            $nom=imseguro($cone,$_POST['nom']);
            $sex=iseguro($cone,$_POST['sex']);
            $estciv=iseguro($cone,$_POST['estciv']);
            $fecnac=fmysql(iseguro($cone,$_POST['fecnac']));
            $tipdoc=iseguro($cone,$_POST['tipdoc']);
            $numdoc=imseguro($cone,$_POST['numdoc']);
            $ocu=imseguro($cone,$_POST['ocu']);
            $entlab=imseguro($cone,$_POST['entlab']);
            $telfij=iseguro($cone,$_POST['telfij']);
            $telmov=iseguro($cone,$_POST['telmov']);
            $eme=iseguro($cone,$_POST['eme']);
            $viv=iseguro($cone,$_POST['viv']);
            $cor=iseguro($cone,$_POST['cor']);
            $grains=iseguro($cone,$_POST['grains']);
            $nivins=iseguro($cone,$_POST['nivins']);
            $esp=imseguro($cone,$_POST['esp']);
            $ins=imseguro($cone,$_POST['ins']);
            if(isset($idpa) && !empty($idpa) && isset($tippar) && !empty($tippar) && isset($apepat) && !empty($apepat) && isset($apemat) && !empty($apemat) && isset($nom) && !empty($nom) && isset($fecnac) && !empty($fecnac) && isset($tipdoc) && !empty($tipdoc) && isset($numdoc) && !empty($numdoc)){
                  if($eme!=1){
                        $eme=0;
                  }
                  if($viv!=1){
                        $viv=0;
                  }
                  $fr=@date("Y-m-d");
                  $sql="UPDATE pariente SET idTipoPariente=$tippar, ApellidoPat='$apepat', ApellidoMat='$apemat', Nombres='$nom', Sexo='$sex', idEstadoCivil=$estciv, FechaNac='$fecnac', TipoDoc='$tipdoc', NumeroDoc='$numdoc', Ocupacion='$ocu', EntidadLab='$entlab', TelefonoFij='$telfij', TelefonoMov='$telmov', ContactoEme=$eme, Vive=$viv, Correo='$cor', idGradoInstruccion='$nivins', Especialidad='$esp', Institucion='$ins', FecRegistro='$fr' WHERE idPariente=$idpa";
                  if(mysqli_query($cone,$sql)){
                        echo "<h4 class='text-olive'>Listo: Pariente editado correctamente.</h4><br>";
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