<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4)){
	if(isset($_POST['NomForm']) && $_POST['NomForm']=="f_nuelic"){
	  if(isset($_POST['tlic']) && !empty($_POST['tlic']) && isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['has']) && !empty($_POST['has']) && isset($_POST['mot']) && !empty($_POST['mot']) && isset($_POST['med']) && !empty($_POST['med']) && isset($_POST['col']) && !empty($_POST['col']) && isset($_POST['emed']) && !empty($_POST['emed']) && isset($_POST['tdoc']) && !empty($_POST['tdoc']) && isset($_POST['ndoc']) && !empty($_POST['ndoc']) && isset($_POST['docapr']) && !empty($_POST['docapr'])){
	    $idec=iseguro($cone,$_POST['idec']);
	    $tlic=iseguro($cone,$_POST['tlic']);
	    $des=fmysql(iseguro($cone,$_POST['des']));
	    $has=fmysql(iseguro($cone,$_POST['has']));
	    $mot=iseguro($cone,$_POST['mot']);
	    $med=imseguro($cone,$_POST['med']);
	    $col=iseguro($cone,$_POST['col']);
	    $emed=iseguro($cone,$_POST['emed']);
	    $tdoc=iseguro($cone,$_POST['tdoc']);
	    $ndoc=iseguro($cone,$_POST['ndoc']);
	    $docapr=iseguro($cone,$_POST['docapr']);
	    $leg=iseguro($cone,$_POST['leg']);

	    $c=mysqli_query($cone,"SELECT idLicencia FROM licencia WHERE idEmpleadoCargo=$idec AND Estado=1 AND (('$des' BETWEEN FechaIni AND FechaFin) OR ('$has' BETWEEN FechaIni AND FechaFin));");
	    if(mysqli_num_rows($c)>0){
	    	echo mensajewa("Error: La licencia que desea registrar incluyen días de una licencia existente y activa.");
	    }else{
	    	$q="INSERT INTO licencia (idEmpleadoCargo, idTipoLic, FechaIni, FechaFin, Motivo, Medico, Colegiatura, idEspMedica, idTipDocLicencia, NumDoc, Estado) VALUES ($idec, $tlic, '$des', '$has', '$mot', '$med', '$col', $emed, $tdoc, '$ndoc', 1);";
	    	//echo $q;
	    	if(mysqli_query($cone,$q)){
	    		$idlic=mysqli_insert_id($cone);
	    		echo mensajesu("Listo: Licencia registrada correctamente.");
	    		$qa="INSERT INTO aprlicencia (idLicencia, Aprobado, Legajo, idDoc) VALUES ($idlic, 1, '$leg', $docapr);";
	    		if(mysqli_query($cone,$qa)){
	    			echo mensajesu("Licencia aprobada");
	    		}else{
	    			echo mensajeda("Error: No se pudo registrar documentos y aprobación de la licencia. Reportar a informática.");
	    		}
	    	}else{
	    		echo mensajewa("Error: Error al registrar la licencia.");
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