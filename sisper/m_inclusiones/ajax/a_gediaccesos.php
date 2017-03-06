<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],7)){
  if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ediaccesos"){
  $idpe=iseguro($cone,$_POST['idpe']);
  $fec=@date("Y/m/d");
  $por=$_SESSION['identi'];
  $cm=mysqli_query($cone,"SELECT * FROM modulo WHERE Estado=1 ORDER BY Modulo ASC");
  echo "<h4 class='text-olive'>Accesos asignados:</h4><br>";
  while($rm=mysqli_fetch_assoc($cm)){
    $mod=$rm['idModulo'];
    $nmod=$rm['Modulo'];
    $idmod=@$_POST["$mod"];
    $val=iseguro($cone,$idmod);
    $cme=mysqli_query($cone,"SELECT * FROM empleadomodulo WHERE idEmpleado=$idpe AND idModulo=$mod");
    if($rce=mysqli_fetch_assoc($cme)){
      if(empty($val)){
        $q="UPDATE empleadomodulo SET Administrar=0, Consultar=0, Fecha='$fec', Por=$por WHERE idEmpleado=$idpe AND idModulo=$mod";
        if (mysqli_query($cone, $q)) {
            echo "<p>Módulo $nmod se DENEGÓ el acceso</p>";
        } else {
            echo "<p>Error: ".mysqli_error($cone)."</p>";
        }
      }elseif($val=='ADMINISTRAR'){
        $q="UPDATE empleadomodulo SET Administrar=1, Consultar=0, Fecha='$fec', Por=$por WHERE idEmpleado=$idpe AND idModulo=$mod";
        if (mysqli_query($cone, $q)) {
            echo "<p>Módulo $nmod con acceso para ADMINISTRAR</p>";
        } else {
            echo "<p>Error: ".mysqli_error($cone)."</p>";
        }
      }elseif($val=='CONSULTAR'){
        $q="UPDATE empleadomodulo SET Administrar=0, Consultar=1, Fecha='$fec', Por=$por WHERE idEmpleado=$idpe AND idModulo=$mod";
        if (mysqli_query($cone, $q)) {
            echo "<p>Módulo $nmod con acceso para CONSULTAR</p>";
        } else {
            echo "<p>Error: ".mysqli_error($cone)."</p>";
        }
      }
    }else{
      if($val=='ADMINISTRAR'){
        $q="INSERT INTO empleadomodulo (idEmpleado, idModulo, Administrar, Consultar, Fecha, Por) VALUES ($idpe, $mod, 1, 0, '$fec', $por)";
        if (mysqli_query($cone, $q)) {
            echo "<p>Módulo $nmod con acceso para ADMINISTRAR</p>";
        } else {
            echo "<p>Error: ".mysqli_error($cone)."</p>";
        }
      }elseif($val=='CONSULTAR'){
        $q="INSERT INTO empleadomodulo (idEmpleado, idModulo, Administrar, Consultar, Fecha, Por) VALUES ($idpe, $mod, 0, 1, '$fec', $por)";
        if (mysqli_query($cone, $q)) {
            echo "<p>Módulo $nmod con acceso para Consultar</p>";
        } else {
            echo "<p>Error: ".mysqli_error($cone)."</p>";
        }
      }
    }
    mysqli_free_result($cme);
  }
  mysqli_free_result($cm);
  mysqli_close($cone);
  }
}else{
  echo accrestringidoa();
}
?>