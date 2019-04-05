<?php
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
include("m_email/gcorreo.php");
if(isset($_POST['NomForm']) && $_POST['NomForm']='f_ocon'){
	if(isset($_POST['odni']) && !empty($_POST['odni']) && isset($_POST['ocor']) && !empty($_POST['ocor'])){
		$odni=iseguro($cone,$_POST['odni']);
		$ocor=iseguro($cone,$_POST['ocor']);
		$c=mysqli_query($cone,"SELECT idEmpleado, ApellidoPat, ApellidoMat, Nombres, CorreoIns FROM empleado WHERE NumeroDoc='$odni' AND CorreoIns='$ocor';");
		if($r=mysqli_fetch_assoc($c)){
			$ide=$r['idEmpleado'];
			$cpar=$r['CorreoIns'];
			$npar=$r['Nombres']." ".$r['ApellidoPat']." ".$r['ApellidoMat'];
			$pas=RandomString(8);
			$pas1=sha1($pas);
            $fec=@date("Y-m-d");
            $fec=strtotime('-8 month', strtotime($fec));
            $fec=date("Y-m-d", $fec);
            $q="UPDATE empleado SET Contrasena='$pas1', FecCamContra='$fec' WHERE idEmpleado=$ide;";
            if(mysqli_query($cone,$q)){
            	$cue="<!DOCTYPE html>
<html lang='es'>
<head>
	<meta charset='UTF-8'>
	<title>SISPER - Nueva Contraseña!!!</title>
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
												<td><img src='https://www.mpfn.gob.pe/Interface/Img/logo.png' width='200'></td>
												<td style='font-family:Arial, Helvetica, sans-serif; color: #173963; font-size: 18px; font-weight: bold;'>DISTRITO FISCAL DE CAJAMARCA</td>
											</tr>
										</table>
										<br>
									</td>
								</tr>
								<tr>
									<td>
										<table width='100%' border='0' cellpadding='0' cellspacing='0'>
											<tr>
												<td align='center' style='font-family:Georgia, Times, serif; font-size:30px; color: #FF7101'>QUIPU</td>
											</tr>
										</table>
										<br>
									</td>
								</tr>
								<tr>
									<td align='center' style='font-size: 16px; color: #555555; font-family:Arial, Helvetica, sans-serif;'><br>Se cambió su contraseña a:<br><br></td>
								</tr>
								<tr>
									<td align='center' style='font-size: 20px; color: #0091B6; font-weight: bold; font-family:Arial, Helvetica, sans-serif;'>".$pas."</td>
								</tr>

								<tr>
									<td align='center' valign='middle'>
										<table width='100%' border='0' cellpadding='0' cellspacing='0' style='border-top: 1px solid #999; padding: 10px; margin-top: 10px; border-bottom: 1px solid #999; padding: 10px; margin-top: 10px;'>
											<tr>
												<td align='justify' style='font-family:Georgia, Times, serif; color: #777777; font-size:15px;'>
													<strong>Importante.</strong> Cambie su contraseña teniendo en cuenta lo siguiente:
													<ul>
														<li>Construir las contraseñas con una mezcla de caracteres alfabéticos (donde se combinen las mayúsculas y las minúsculas), dígitos e incluso caracteres especiales (@, ¡, +, &).</li>
														<li>La contraseña no debe contener el nombre de usuario de la cuenta, o cualquier otra información personal fácil de averiguar (cumpleaños, nombres de hijos, conyuges, ...). Tampoco una serie de letras dispuestas adyacentemente en el teclado (qwerty) o siguiendo un orden alfabético o numérico (123456, abcde, etc.)</li>
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
				$cdes="informatica.cajamarcadj@mpfn.gob.pe";
				$ndes=utf8_decode("Informática Cajamarca");
				$asu=utf8_decode("QUIPU - Nueva contraseña");
				$acue=utf8_decode("QUIPU - Nueva contraseña");

				$msg=ecorreo($cdes, $ndes, $cpar, $npar, $asu, $cue, $acue);
				$archivo=fopen("/var/www/html/sisper/logs/log_ocontrasena.txt", "a") or die("Problemas al crear");
				fwrite($archivo,$msg);
				fwrite($archivo,"\n");
				fclose($archivo);

				echo mensajesu("Listo: Se envió su nueva contraseña a su correo.");

            }else{
            	echo mensajewa("Error: Vuelva a intentarlo.");
            }
		}else{
			echo mensajewa("Error: Los datos ingresados no corresponden. Contáctese con informática al 365577 Anexo 1015.");
		}
		mysqli_free_result($c);

	}else{
		echo mensajewa("Error: ingrese DNI y correo.");
	}
}else{
	echo mensajewa("Error");
}
mysqli_close($cone);
?>