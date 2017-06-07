<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4)){
	if(isset($_POST['NomForm']) && $_POST['NomForm']=="f_nuelic"){
	  if(isset($_POST['tlic']) && !empty($_POST['tlic']) && isset($_POST['dese']) && !empty($_POST['dese']) && isset($_POST['hase']) && !empty($_POST['hase']) && isset($_POST['mot']) && !empty($_POST['mot']) && isset($_POST['med']) && !empty($_POST['med']) && isset($_POST['col']) && !empty($_POST['col']) && isset($_POST['emed']) && !empty($_POST['emed']) && isset($_POST['tdoc']) && !empty($_POST['tdoc']) && isset($_POST['ndoc']) && !empty($_POST['ndoc']) && isset($_POST['docapr']) && !empty($_POST['docapr'])){
	    $id=iseguro($cone,$_POST['id']);
	    $idec=iseguro($cone,$_POST['idec']);
	    $tlic=iseguro($cone,$_POST['tlic']);
	    $des=fmysql(iseguro($cone,$_POST['dese']));
	    $has=fmysql(iseguro($cone,$_POST['hase']));
	    $mot=iseguro($cone,$_POST['mot']);
	    $med=imseguro($cone,$_POST['med']);
	    $col=iseguro($cone,$_POST['col']);
	    $emed=iseguro($cone,$_POST['emed']);
	    $tdoc=iseguro($cone,$_POST['tdoc']);
	    $ndoc=iseguro($cone,$_POST['ndoc']);
	    $docapr=iseguro($cone,$_POST['docapr']);

	    $c=mysqli_query($cone,"SELECT idLicencia FROM licencia WHERE idEmpleadoCargo=$idec AND idLicencia<>$id AND Estado=1 AND (('$des' BETWEEN FechaIni AND FechaFin) OR ('$has' BETWEEN FechaIni AND FechaFin));");
	    if(mysqli_num_rows($c)>0){
	    	echo mensajewa("Error: La licencia que desea editar incluyen días de otra licencia activa. No se guardaron los cambios.");
	    }else{
	    	$q="UPDATE licencia SET idTipoLic=$tlic, FechaIni='$des', FechaFin='$has', Motivo='$mot', Medico='$med', Colegiatura='$col', idEspMedica=$emed, idTipDocLicencia=$tdoc, NumDoc='$ndoc' WHERE idLicencia=$id;";
	    	//echo $q;
	    	if(mysqli_query($cone,$q)){
	    		echo mensajesu("Listo: Licencia registrada correctamente.");
	    		$qa="UPDATE aprlicencia SET idDoc=$docapr WHERE idLicencia=$id;";
	    		if(mysqli_query($cone,$qa)){
	    			echo mensajesu("Documentos de licencia actualizados.");
	    		}else{
	    			echo mensajeda("Error: No se pudo editar los documentos de la licencia. Reportar a informática.");
	    		}
	    	}else{
	    		echo mensajewa("Error: Error al editar la licencia.");
	    	}
	    }
	    mysqli_free_result($c);
	  }else{
	    echo mensajewa("Error: Todos los campos del formulario son obligatorios.");
	  }
	}else{
		echo mensajewa("Error: Formulario incorrecto.");
	}
}else{
  echo accrestringidoa();
}
?>