<?php

function ecorreo($cdes, $ndes, $cpar, $npar, $asu, $cue, $acue){
	date_default_timezone_set('America/Lima');

	require_once 'PHPMailer/PHPMailerAutoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Tell PHPMailer to use SMTP
	$mail->isSMTP();
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;
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
	$mail->setFrom($cdes, $ndes);
	//Set an alternative reply-to address
	$mail->addReplyTo($cdes, $ndes);
	//Set who the message is to be sent to
	$mail->addAddress($cpar, $npar);
	//Set the subject line
	$mail->Subject = $asu;
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML($cue);
	//Replace the plain text body with one created manually
	$mail->AltBody = $acue;
	//Attach an image file
	//$mail->addAttachment('PHPMailer/examples/images/phpmailer_mini.png');

	//send the message, check for errors
	if (!$mail->send()) {
	    return date("d/m/Y H:i:s")." Mailer Error: " .$asu." - ".$npar." - ". $mail->ErrorInfo;
	} else {
	    return date("d/m/Y H:i:s")." Message sent! ".$asu." - ".$npar;
	}
}
