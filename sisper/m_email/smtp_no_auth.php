<?php
/**
 * This example shows making an SMTP connection without using authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
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
$mail->setFrom('informatica.cajamarca@djmail.mpfn.gob.pe', 'Informática Cajamarca');
//Set an alternative reply-to address
$mail->addReplyTo('informatica.cajamarca@djmail.mpfn.gob.pe', 'Informática Cajamarca');
//Set who the message is to be sent to
$mail->addAddress('gintor@djmail.mpfn.gob.pe', 'Gerardo Severino Intor Osorio');
//Set the subject line
$mail->Subject = 'Prueba';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->AltBody = 'Este es un mensaje de informática';
//Attach an image file
//$mail->addAttachment('PHPMailer/examples/images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
