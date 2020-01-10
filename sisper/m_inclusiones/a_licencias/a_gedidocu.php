<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],13)){
  if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['tdoc']) && !empty($_POST['tdoc']) && isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['adoc']) && !empty($_POST['adoc']) && isset($_POST['sig']) && !empty($_POST['sig']) && isset($_POST['fec']) && !empty($_POST['fec'])){
    $id=iseguro($cone,$_POST['id']);
    $tdoc=iseguro($cone,$_POST['tdoc']);
    $num=iseguro($cone,$_POST['num']);
    $adoc=iseguro($cone,$_POST['adoc']);
    $sig=imseguro($cone,$_POST['sig']);
    $fec=fmysql(iseguro($cone,$_POST['fec']));
    $des=iseguro($cone,$_POST['des']);
    $leg=iseguro($cone,$_POST['leg']);
    $ano=iseguro($cone,$_POST['ano']);
    $nd=iseguro($cone,$_POST['nd']);

    $c=mysqli_query($cone,"SELECT idDoc FROM doc WHERE (idTipoDoc=$tdoc AND Numero='$num' AND Ano='$adoc' AND Siglas='$sig') AND idDoc!=$id;");
    if(mysqli_num_rows($c)>0){
    	echo mensajewa("Error: El documento que intenta registrar ya existe.");
    }else{

        $nn=$nd;
        if($adoc!=$ano){
            $cn=mysqli_query($cone, "SELECT MAX(numdoc) nd FROM doc WHERE Ano=$adoc;");
            if($rn=mysqli_fetch_assoc($cn)){
                $nn=$rn['nd']+1;
            }else{
                $nn=0;
            }
            mysqli_free_result($cn);
            $tn=", numdoc='$nn'";
        }else{
            $tn="";
        }

    	$q="UPDATE doc SET Numero='$num', Ano='$adoc', Siglas='$sig', FechaDoc='$fec', idTipoDoc=$tdoc, Descripcion='$des', Legajo='$leg' $tn WHERE idDoc=$id;";
    	if(mysqli_query($cone,$q)){
    		echo mensajesu("Listo: Documento correctamente editado.<br># de Seguimiento: $nn");
    	}else{
    		echo mensajewa("Error: Error al editar el docuemnto.");
    	}
    }
    mysqli_free_result($c);
  }else{
    echo mensajewa("Error: Algunos campos del formulario son obligatorios.");
  }
}else{
  echo accrestringidoa();
}
?>
