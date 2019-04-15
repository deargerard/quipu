<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
	if(isset($_POST['idp']) && !empty($_POST['idp'])){
		$idp=iseguro($cone, $_POST['idp']);
	
?>
				<div class="row">
                	<div class="col-md-12">
		                <div>
		                	<?php
		                	$c=mysqli_query($cone,"SELECT d.diamedico, d.otipayubio, d.cerdis, d.feccerdis, d.conadis, d.fecconadis, td.tipod, tab.tipoa, ts.tipos, tlp.tipol, gl.gradol, ol.origenl FROM discapacidad d INNER JOIN tipdiscapacidad td ON d.idtipdiscapacidad=td.idtipdiscapacidad INNER JOIN tipayubio tab ON d.idtipayubio=tab.idtipayubio INNER JOIN tipseg ts ON d.idtipseg=ts.idtipseg INNER JOIN tiplimper tlp ON d.idtiplimper=tlp.idtiplimper INNER JOIN gralim gl ON d.idgralim=gl.idgralim INNER JOIN orilim ol ON d.idorilim=ol.idorilim WHERE d.idEmpleado=$idp;");
		                	if($r=mysqli_fetch_assoc($c)){
		                		switch ($r['cerdis']) {
		                			case 1:
		                				$cer="Si";
		                				break;
		                			case 2:
		                				$cer="No";
		                				break;
		                			case 3:
		                				$cer="En trámite";
		                				break;
		                		}
		                		switch ($r['conadis']) {
		                			case 1:
		                				$con="Si";
		                				break;
		                			case 2:
		                				$con="No";
		                				break;
		                			case 3:
		                				$con="En trámite";
		                				break;
		                		}
		                	?>
		                	<table style="width: 100%;">
		                		<tr>
		                			<td>
		                				<h4 class="box-title text-orange"><i class="fa fa-wheelchair"></i> Discapacidad</h4>
		                			</td>
		                			<td align="right">
		                				<?php if(accesoadm($cone,$_SESSION['identi'],1)){ ?>
					                	<a href="#" class="btn btn-info btn-xs" onclick="discapacidad('agrdis', <?php echo $idp ?>)"><i class="fa fa-wheelchair"></i> Discapacidad</a>

					                	<a href="#" class="btn btn-danger btn-xs" onclick="discapacidad('elidis', <?php echo $idp ?>)"><i class="fa fa-trash"></i> Eliminar</a>
					                	<?php } ?>
		                			</td>
		                		</tr>
		                	</table>
		                	<table class="table table-hover table-bordered">
		                		<tr>
		                			<th>Tipo de Discapacidad</th>
		                			<td><?php echo $r['tipod']; ?></td>
		                			<th>Diagnóstico Médico</th>
		                			<td><?php echo $r['diamedico']; ?></td>
		                		</tr>
		                		<tr>
		                			<th>Tipo de ayuda biomecánica que utiliza</th>
		                			<td><?php echo $r['tipoa']; ?></td>
		                			<td colspan="2"><?php echo $r['otipayubio']; ?></td>
		                		</tr>
		                		<tr>
		                			<th>Tipo de seguro al que está afiliado</th>
		                			<td><?php echo $r['tipos']; ?></td>
		                			<th>Tiene limitaiones permanentes para</th>
		                			<td><?php echo $r['tipol']; ?></td>
		                		</tr>
		                		<tr>
		                			<th>La limitación que tiene es</th>
		                			<td><?php echo $r['gradol']; ?></td>
		                			<th>Cuál es el origen de esta limitación</th>
		                			<td><?php echo $r['origenl']; ?></td>
		                		</tr>
		                		<tr>
		                			<th>Certificado de discapacidad</th>
		                			<td><?php echo $cer; ?></td>
		                			<th>Fecha</th>
		                			<td><?php echo fnormal($r['feccerdis']); ?></td>
		                		</tr>
		                		<tr>
		                			<th>Inscripción en el CONADIS</th>
		                			<td><?php echo $con; ?></td>
		                			<th>Fecha</th>
		                			<td><?php echo fnormal($r['fecconadis']); ?></td>
		                		</tr>
		                	</table>
		                	<?php
		                	}else{
?>
							<table style="width: 100%;">
		                		<tr>
		                			<td>
		                				<h4 class="box-title text-orange"><i class="fa fa-wheelchair"></i> Discapacidad</h4>
		                			</td>
		                			<td align="right">
		                				<?php if(accesoadm($cone,$_SESSION['identi'],1)){ ?>
					                	<a href="#" class="btn btn-info btn-xs" onclick="discapacidad('agrdis', <?php echo $idp ?>)"><i class="fa fa-wheelchair"></i> Discapacidad</a>
					                	<?php } ?>
		                			</td>
		                		</tr>
		                	</table>
<?php
		                		echo mensajewa("Sin discapacidad registrada");
		                	}
		                	mysqli_free_result($c);
		                	?>
		                </div>
		            </div>
		        </div>
<?php
	}else{
		echo mensajewa("No envio datos.");
	}
}else{
  echo accrestringidoa();
}
?>