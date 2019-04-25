<?php
include("/var/www/html/sisper/m_inclusiones/php/conexion_sp.php");
include("/var/www/html/sisper/m_inclusiones/php/funciones.php");
include("/var/www/html/sisper/m_email/fcorreo.php");
$cc=mysqli_query($cone, "SELECT ApellidoPat, ApellidoMat, Nombres, CorreoIns FROM empleado e INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE date_format(FechaNac,'%m-%d')=date_format(now(),'%m-%d') AND idEstadoCar=1;");
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
		$asu="Feliz Cumple...!!!";
		$acue="Feliz Cumple...!!!";
		$cue='<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Feliz cumpleaños!!!</title>
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
												<td height="80" width="80" align="center" valign="middle" bgcolor="#FF7101" style="font-family: Arial, Helvetica, sans-serif; color:#ffffff;">
													<div style="font-size: 30px;">
														<b>'.date('d').'</b>
													</div>
													<div style="font-size: 12px;">
														<b>'.nombremes(date('m')).'</b>
													</div>
												</td>
												<td align="center" style="font-family:Georgia, Times, serif; font-size:40px; color: #FF7101">¡Feliz cumpleaños!</td>
											</tr>
										</table>
										<br>
									</td>
								</tr>
								<tr>
									<td align="center">
										<img src="http://www.freeiconspng.com/uploads/birthday-cake-icon-11.jpg" width="120">
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
										<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-top: 1px solid #7DA400; padding: 10px; margin-top: 10px; border-bottom: 1px solid #7DA400; padding: 10px; margin-top: 10px;">
											<tr>
												<td align="center" style="font-family:Georgia, Times, serif; color: #777777; font-size:15px;">
													
													Es un honor tener personas ejemplares como Usted(es) en la institución. En este día tan importante, le(s) deseamos muchas felicidades y esperamos de corazón tenerlo(s) con nosotros muchos cumpleaños más.
													
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
			$archivo=fopen("/var/www/html/sisper/logs/log_envio_cumples.txt", "a") or die("Problemas al crear");
			fwrite($archivo,$msg);
			fwrite($archivo,"\n");
			fclose($archivo);
		}

}
mysqli_free_result($cc);

?>
