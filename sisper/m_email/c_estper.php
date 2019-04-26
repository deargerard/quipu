<?php
$cc=mysqli_query($cone, "SELECT ApellidoPat, ApellidoMat, Nombres FROM empleado e INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE idEmpleadoCargo=$idec;");
if(mysqli_num_rows($cc)>0){
	$npar="";
	$cono=array();
	if($rc=mysqli_fetch_assoc($cc)){
		$npar=$rc['ApellidoPat']." ".$rc['ApellidoMat']." ".$rc['Nombres'];
		$cono['yovasquez@mpfn.gob.pe']='YONY VASQUEZ CUBAS';
		$cono['arlopezdj@mpfn.gob.pe']='ARNALDO GUSTAVO LOPEZ ALVAREZ';
		$cono['emendozadj@mpfn.gob.pe']='EDILBERTO MORENO MENDOZA';
		//$cono['gintor@mpfn.gob.pe']='GERARDO SEVERINO INTOR OSORIO';
		//$cono['mcotrina@mpfn.gob.pe']='MARCO WILSON COTRINA VARGAS';
	}
		$cdes="admcaj.mpfn@gmail.com";
		$ndes="ADMINISTRACION CAJAMARCA MPFN";
		$asu="Personal Cambio estado";
		$acue="Personal Cambio estado";
		$cue="<!DOCTYPE html>
<html lang='es'>
<head>
	<meta charset='UTF-8'>
	<title>QUIPU - Estado Personal</title>
</head>
<body>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='center' valign='top' bgcolor='#f6f3e4' style='background-color:#f6f3e4;'>
				<br>
				<table width='600' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td align='center' valign='top' style='padding-left:13px; padding-right:13px; background-color:#ffffff;'>
							<table width='100%' border='0' cellpadding='0' cellspacing='0'>
								<tr>
									<td>
										<table width='100%' border='0' cellpadding='0' cellspacing='0' style='border-bottom: 1px dotted #CCCCCC;'>
											<tr>
												<td><img src='https://sites.google.com/a/mpfn.gob.pe/yo-aprendo-apps-ministerio-publico/_/rsrc/1521219971697/config/customLogo.gif' width='200'></td>
												<td style='font-family:Arial, Helvetica, sans-serif; color: #173963; font-size: 18px; font-weight: bold;'>DISTRITO FISCAL DE CAJAMARCA</td>
											</tr>
										</table>
										<br>
									</td>
								</tr>
								<tr>
									<td align='center'>
										<img src='https://image.freepik.com/vector-gratis/empresario-sosteniendo-mano-oferta-trabajo_51635-1424.jpg' width='250'>
									</td>
								</tr>
								<tr>
									<td align='center' style='font-size: 16px; color: #999999; font-family:Arial, Helvetica, sans-serif;'><br>Se cambió el estado a:<br><br></td>
								</tr>
								<tr>
									<td align='center'>
										<span style='font-size: 20px; color: #0091B6; font-weight: bold; font-family:Arial, Helvetica, sans-serif;'>".$npar."</span><br>
										<span style='font-size: 22px; color: #ff0000; font-weight: bold; font-family:Arial, Helvetica, sans-serif;'>".estadocar($estcar)."</span><br>
										<span style='font-size: 18px; color: #999999; font-weight: bold; font-family:Georgia, Times, sans-serif;'>".fnormal($ini)."</span><br>
										<span style='font-family:Georgia, Times, sans-serif; color: #999999; font-size:15px;'>".$numres."</span><br>
										<span style='font-family:Georgia, Times, sans-serif; color: #999999; font-size:15px;'>".$mot."</span>
									</td>
								</tr>

								<tr>
									<td align='center' valign='middle'>
										<table width='100%' border='0' cellpadding='0' cellspacing='0' style='border-top: 1px solid #999; padding: 10px; margin-top: 10px; border-bottom: 1px solid #999; padding: 10px; margin-top: 10px;'>
											<tr>
												<td align='justify' style='font-family:Arial, Helvetica, serif; color: #777777; font-size:15px;'>
													<strong>Importante.</strong>
													<ul>
														<li>Que la presente información sirva para que tome acción de acuerdo a sus funciones.</li>
													</ul>
												</td>
											</tr>
											
										</table>
										<br>
										<br>
									</td>
								</tr>
								<tr>
									<td>
										<table width='100%' border='0' cellpadding='0' cellspacing='0' style='border-top:1px dotted #CCCCCC;'>
											<tr>
												<td align='center' style='font-family:Arial, Helvetica, sans-serif; color: #173963; font-size: 14px;'>
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
</html>";
		if(!empty($cono)){
			$msg=ecorreo($cdes, $ndes, $cono, $asu, $cue, $acue);
			$archivo=fopen("/var/www/html/sisper/logs/log_envio_estper.txt", "a") or die("Problemas al crear");
			fwrite($archivo,$msg);
			fwrite($archivo,"\n");
			fclose($archivo);
		}

}
mysqli_free_result($cc);

?>
