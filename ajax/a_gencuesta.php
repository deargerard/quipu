<?php
    include ("../ajax/a_coneenc.php");
    include ("../sisper/m_inclusiones/php/funciones.php");
    $r=array();
    if(isset($_POST['ide']) && !empty($_POST['ide'])){
    	$ide=iseguro($con,$_POST['ide']);

    	$cp=mysqli_query($con,"SELECT idPregunta FROM pregunta WHERE idEncuesta=$ide;");
    	if(mysqli_num_rows($cp)>0){
    		$n=0;
    		$m="<strong><span class='text-orange'>Faltan las preguntas: </span></strong>";
    		$bien=true;
    		while($rp=mysqli_fetch_assoc($cp)){
    			$n++;
    			$idp=$rp['idPregunta'];
    			$npre='enc_'.$idp;
    			if(!isset($_POST[$npre]) && empty($_POST[$npre])){
    				$m.="<span class='text-orange'>$n. </span>";
    				$bien=false;
    			}
    		}
    		if($bien){
    			$namepc=gethostname();
    			$ie="INSERT INTO encuestado (Ip) VALUES ('$namepc');";
    			if(mysqli_query($con,$ie)){
    				$iden=mysqli_insert_id($con);
    				$cpr=mysqli_query($con,"SELECT idPregunta FROM pregunta WHERE idEncuesta=$ide;");
    				while($rpr=mysqli_fetch_assoc($cpr)){
    					$idpr=$rpr['idPregunta'];
    					$npreg='enc_'.$idpr;
    					$res=iseguro($con,$_POST[$npreg]);
    					mysqli_query($con, "INSERT INTO respuesta (Respuesta, idEncuestado, idPregunta) VALUES ('$res', $iden, $idpr);");
    				}

	    			$r['exito']=true;
			    	$r['mensaje']="<h4 class='text-center text-olive'><i class='fa fa-thumbs-up'></i> Encuesta enviada. Gracias por tu colaboración.</h4><p class='text-center'><a href='encuesta.php' class='btn btn-info'>Regresar a la encuesta</a><p>";
    			}else{
			    	$r['exito']=false;
			    	$r['mensaje']="<br><h4 class='text-center text-warning'><i class='fa fa-exclamation-triangle'></i> Error al registrar la encuesta. Vuelva a intentarlo.</h4>";
    			}
    		}else{
	    		$r['exito']=false;
		    	$r['mensaje']="<h4 class='text-red'><i class='fa fa-exclamation-triangle'></i> Por favor complete la encuesta.</h4> $m";
    		}
    	}else{
	    	$r['exito']=false;
	    	$r['mensaje']="<br><h4 class='text-center text-warning'><i class='fa fa-exclamation-triangle'></i> La encuesta no tiene preguntas.</h4>";
    	}
    	mysqli_free_result($cp);



    	// $r['exito']=true;
    	// $r['mensaje']="<h4 class='text-center text-olive'><i class='fa fa-thumbs-up'></i> Encuesta enviada. Gracias por tu colaboración. $enc_39</h4><p class='text-center'><a href='encuesta.php' class='btn btn-info'>Regresar a la encuesta</a><p>";
    }else{
    	$r['exito']=false;
    	$r['mensaje']="<br><h3 class='text-center text-warning'><i class='fa fa-exclamation-triangle'></i> Error.</h3>";
    }
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($r);
	exit();
	mysqli_close($cone);
?>