<?php
include("/var/www/html/sisper/m_inclusiones/php/conexion_sp.php");
include("/var/www/html/sisper/m_inclusiones/php/funciones.php");
include("/var/www/html/sisper/m_email/fcorreo.php");
$cc=mysqli_query($cone, "SELECT ApellidoPat, ApellidoMat, Nombres, CorreoIns, pv.FechaIni FROM empleado e INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleado INNER JOIN provacaciones pv ON ec.idEmpleadoCargo=pv.idEmpleadoCargo WHERE pv.FechaIni=date_format(date_add(now(), INTERVAL +6 DAY),'%Y-%m-%d') AND (pv.Estado='0' OR pv.Estado='4') AND idEstadoCar=1;");
if(mysqli_num_rows($cc)>0){
	$npar="";
	$cono=array();
	while ($rc=mysqli_fetch_assoc($cc)) {
		$npar.=$rc['Nombres']." ".$rc['ApellidoPat']." ".$rc['ApellidoMat']."<br>";
		if(!is_null($rc['CorreoIns'])){
			$cono[$rc['CorreoIns']]=$rc['Nombres']." ".$rc['ApellidoPat']." ".$rc['ApellidoMat'];
		}
	}
		$cdes="admcaj.mpfn@gmail.com";
		$ndes="ADMINISTRACION CAJAMARCA MPFN";
		$asu="Vacaciones a la vista!";
		$acue="Vacaciones a la vista!";
		$fvac=fnormal($rc['FechaIni']);
		$cue='<!DOCTYPE html>
<html lang="es-PE">
<head>
	<meta charset="UTF-8">
	<title>Vacaciones!!!</title>
</head>
<body>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center" valign="top" bgcolor="#f6f3e4" style="background-color:#f6f3e4;">
				<br>
				<table width="600" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center" valign="top" style="padding-left:13px; padding-right:13px; background-color:#ffffff;">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px dotted #CCCCCC;">
											<tr>
												<td><img src="https://sites.google.com/a/mpfn.gob.pe/yo-aprendo-apps-ministerio-publico/_/rsrc/1521219971697/config/customLogo.gif" width="200"></td>
												<td style="font-family:Arial, Helvetica, sans-serif; color: #173963; font-size: 18px; font-weight: bold;">DISTRITO FISCAL DE CAJAMARCA</td>
											</tr>
										</table>
										<br>
									</td>
								</tr>
								<tr>
									<td>
										<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #FF7101;">
											<tr>
												<td align="center" valign="middle" bgcolor="#FF7101" style="font-family: Georgia,  Times, serif; color:#ffffff; font-size: 40px;">
													En 6 días
												</td>
											</tr>
											<tr>
												<td align="center" style="font-family:Georgia, Times, serif; font-size:60px; color: #FF7101">¡Vacaciones!</td>
											</tr>
										</table>
										<br>
									</td>
								</tr>
								<tr>
									<td align="center">
										<img src="https://image.freepik.com/vector-gratis/fondo-vacaciones-dias-festivos-maleta-globo-realista-camara-fotos_1284-10476.jpg" width="250">
									</td>
								</tr>
								<tr>
									<td align="center" style="font-size: 16px; color: #7da400; font-family:Arial, Helvetica, sans-serif;"><br>Estimad@(s):<br><br></td>
								</tr>
								<tr>
									<td align="center" style="font-size: 18px; color: #0091B6; font-weight: bold; font-family:Arial, Helvetica, sans-serif;">
										'.$npar.'<br>
									</td>
								</tr>

								<tr>
									<td align="center" valign="middle">
										<table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 10px; margin-top: 10px; padding: 10px; margin-top: 10px;">
											<tr>
												<td align="center" style="font-family:Georgia, Times, serif; color: #777777; font-size:15px;">
													<span style="font-size: 24px">¡A Prepararse!<br>
													Este <strong><span style="color: #666666;">'.$fvac.'</span></strong> inician sus vacaciones. </span><br><br>
													- Coordina con tu jefe inmediato. <br>
													- Elabora tu entrega de cargo. <br>
													- Deja tu trabajo listo. <br><br>
													
												</td>
											</tr>
											
										</table>
										<br>
										<br>
									</td>
								</tr>
								<tr>
									<td>
										<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-top:1px dotted #CCCCCC;">
											<tr>
												<td align="center" style="font-family:Arial, Helvetica, sans-serif; color: #173963; font-size: 14px;">
												<br>
												Administración - Distrito Fiscal de Cajamarca
												</td>
											</tr>
										</table>
										<br>
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
					
				</table>
				<br>
			</td>
		</tr>
		
	</table>
</body>
</html>';
		if(!empty($cono)){
			$msg=ecorreo($cdes, $ndes, $cono, $asu, $cue, $acue);	
			$archivo=fopen("/var/www/html/sisper/logs/log_envio_vacas.txt", "a") or die("Problemas al crear");
			fwrite($archivo,$msg);
			fwrite($archivo,"\n");
			fclose($archivo);
		}

}

?>
