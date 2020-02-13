<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4) || accesoadm($cone,$_SESSION['identi'],3) || accesoadm($cone,$_SESSION['identi'],13)){
  if(isset($_POST['tdoc']) && !empty($_POST['tdoc']) && isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['adoc']) && !empty($_POST['adoc']) && isset($_POST['sig']) && !empty($_POST['sig']) && isset($_POST['fec']) && !empty($_POST['fec'])){
    $idreg=$_SESSION['identi'];
    $tdoc=iseguro($cone,$_POST['tdoc']);
    $num=iseguro($cone,$_POST['num']);
    $adoc=iseguro($cone,$_POST['adoc']);
    $sig=imseguro($cone,$_POST['sig']);
    $fec=fmysql(iseguro($cone,$_POST['fec']));
    $des=iseguro($cone,$_POST['des']);
    $leg=iseguro($cone,$_POST['leg']);
    $c=mysqli_query($cone,"SELECT idDoc FROM doc WHERE idTipoDoc=$tdoc AND Numero='$num' AND Ano='$adoc' AND Siglas='$sig';");
    if(mysqli_num_rows($c)>0){
    	echo mensajewa("Error: El documento que intenta registrar ya existe.");
    }else{
      //consultamos último número doc
      $cn=mysqli_query($cone, "SELECT MAX(numdoc) num FROM doc WHERE Ano='$adoc';");
      if($rn=mysqli_fetch_assoc($cn)){
          if(!is_null($rn['num'])){
              $nu=$rn['num']+1;
          }else{
              $nu=1;
          }
      }
      mysqli_free_result($cn);

    	$q="INSERT INTO doc (Numero, Ano, Siglas, FechaDoc, idTipoDoc, Descripcion, Legajo, numdoc, cargo, fecregistro, regpor) VALUES ('$num', '$adoc', '$sig', '$fec', $tdoc, '$des', '$leg', $nu, 0, NOW(), $idreg);";
    	if(mysqli_query($cone,$q)){
    		echo mensajesu("Listo: Documento correctamente registrado. <br> N° Doc:<b> $nu-$adoc</b>");
    	}else{
    		echo mensajewa("Error: Error al resgistrar el docuemnto.");
    	}
    }
    mysqli_free_result($c);
  }else{
    echo mensajewa("Error: todos los campos del formulario son obligatorios.");
  }
}else{
  echo accrestringidoa();
}
?>
