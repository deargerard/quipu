<?php
    include ("../ajax/a_coneenc.php");
    include ("../sisper/m_inclusiones/php/funciones.php");

    if(isset($_POST['enc']) && !empty($_POST['enc'])){
    	$ide=iseguro($con,$_POST['enc']);
    	$cp=mysqli_query($con,"SELECT idPregunta, Pregunta, TipoRespuesta FROM pregunta WHERE idEncuesta=$ide;");
    	if(mysqli_num_rows($cp)>0){
?>
<table class="table table-bordered table-hover" style="border: 2px solid #FFF !important;">
	<tr>
		<th><strong><h3 class="text-orange">Total Encuestados</h3></strong></th>
<?php
	$cne=mysqli_query($con, "SELECT COUNT(DISTINCT en.idEncuestado) as ne FROM encuesta e INNER JOIN pregunta p ON e.idEncuesta=p.idEncuesta INNER JOIN respuesta r ON p.idPregunta=r.idPregunta INNER JOIN encuestado en ON r.idEncuestado=en.idEncuestado WHERE e.idEncuesta=$ide;");
	if($rne=mysqli_fetch_assoc($cne)){
		$ne=$rne['ne'];
	}else{
		$ne=0;
	}
?>
		<th><h3 class="text-orange"><?php echo $ne; ?></h3></th>
	</tr>
<?php
			$n=0;
    		while ($rp=mysqli_fetch_assoc($cp)) {
    			$n++;
    			$idp=$rp['idPregunta'];
?>
	<tr>
		<th colspan="2" class="text-blue"><?php echo $n.'. '.$rp['Pregunta']; ?></th>
	</tr>
<?php
				if($rp['TipoRespuesta']==1){
					$ca=mysqli_query($con,"SELECT Alternativa FROM alternativa WHERE idPregunta=$idp;");
					if(mysqli_num_rows($ca)>0){
						while($ra=mysqli_fetch_assoc($ca)){
							$alt=$ra['Alternativa'];
							$cr=mysqli_query($con,"SELECT COUNT(idRespuesta) as num FROM respuesta WHERE idPregunta=$idp AND Respuesta='$alt';");
							if($rr=mysqli_fetch_assoc($cr)){
								$num=$rr['num'];
							}else{
								$num=0;
							}
							mysqli_free_result($cr);
?>
	<tr>
		<td><?php echo $alt; ?></td>
		<td><?php echo $num; ?></td>
	</tr>
<?php
						}
					}else{
?>
	<tr>
		<td colspan="2">No se encontraron alternativas</td>
	</tr>
<?php	
					}
					mysqli_free_result($ca);
				}elseif($rp['TipoRespuesta']==2){
					$crl=mysqli_query($con, "SELECT Respuesta FROM respuesta WHERE idPregunta=$idp;");
					if (mysqli_num_rows($crl)>0) {
						while($rrl=mysqli_fetch_assoc($crl)){
?>
	<tr>
		<td colspan="2"><?php echo $rrl['Respuesta']; ?></td>
	</tr>
<?php
						}
					}else{
?>
	<tr>
		<td colspan="2">Sin respuestas.</td>
	</tr>
<?php
					}
					mysqli_free_result($crl);
				}
    		}
?>
</table>
<?php
    	}else{
    		echo "<br><h4 class='text-center text-red'><i class='fa fa-exclamation-triangle'></i> Los datos enviados no son válidos.</h4>";
    	}
    	mysqli_free_result($cp);
    	//echo "<br><h4 class='text-center text-olive'><i class='fa fa-check-circle'></i> Bien.</h4>";
    }else{
    	echo "<br><h4 class='text-center text-red'><i class='fa fa-exclamation-triangle'></i> Elija una encuesta.</h4>";
    }

	exit();
	mysqli_close($cone);
?>