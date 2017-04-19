<?php
include ("../../../m_inclusiones/php/conexion_sp.php");
$cco=mysqli_query($cone,"SELECT NumeroDoc, CorreoPer, NombreCom FROM enombre WHERE NumeroDoc='40450444'");
while($rco=mysqli_fetch_assoc($cco)){
$nombre=$rco['NombreCom'];
$correo=$rco['CorreoPer'];
$numdoc=$rco['NumeroDoc'];
echo $rco['NombreCom']."<br>";
/**
 * This example shows making an SMTP connection without using authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('America/Lima');

require_once '../PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
$mail->SMTPAutoTLS = false;
//Set the hostname of the mail server
$mail->Host = "djmail.mpfn.gob.pe";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = false;
$mail->CharSet = 'UTF-8';
//Set who the message is to be sent from
$mail->setFrom('gintor@djmail.mpfn.gob.pe', 'Gerardo Severino Intor Osorio');
//Set an alternative reply-to address
$mail->addReplyTo('gintor@djmail.mpfn.gob.pe', 'Gerardo Severino Intor Osorio');
//Set who the message is to be sent to
$mail->addAddress($correo, $nombre);
//Set the subject line
$mail->Subject = 'Actualización de datos personales';
$body="<!DOCTYPE html>
<html lang='es'>
<head>
	<meta charset='UTF-8'>
	<title>Link Sistema</title>
	<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	<style type='text/css'>
		body{
			margin: 0;
		}
		.cont{
			width: 600px;
			border-left: 1px solid #999999;
			border-right: 1px solid #999999;
		}
		.marco{
			width: 570px;
			padding: 15px;
			color: #777777;
			font-family: 'Ubuntu', sans-serif;
			font-size: 14px;
		}
	</style>
</head>
<body>
<div class='cont'>
	<div>
		<img src='http://mpfncaj.sytes.net/m_imagenes/upemail.jpg'>
	</div>
	<div class='marco'>
		<h4>Estimad@: $nombre </h4>
		<p>Como parte de las mejoras en nuestro distrito fiscal, es necesario su apoyo actualizando su información personal, para lo cual debe acceder al siguiente enlace:</p>
		<p><a style='color:#FF851B; text-decoration: none;' href='http://mpfncaj.sytes.net/'>http://mpfncaj.sytes.net/</a></p>
		<p>Los datos para ingresar son los siguientes:</p>
		<p>Usuario: <strong> $numdoc </strong></p>
		<p>Contraseña inicial: <strong>Fiscalia07</strong> (Respetando mayúsculas y minúsculas)</p>
		<p>Para guiarse, descargue <a style='color:#FF851B; text-decoration: none;' href='http://mpfncaj.sytes.net/Manual.pdf'>aquí</a> el manual.</p>
		<p>Dicho enlace sólo estará disponible hasta el 30 de Julio, por lo que se recomienda actualizar su información con tiempo para evitar congestionamientos de la página a último momento.</p>
	</div>
	<div>
		<img src='http://mpfncaj.sytes.net/m_imagenes/downemail.jpg'>
	</div>
</div>
</body>
</html>";
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($body);
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent! to $nombre<br>";
}

}