<?php   
error_reporting(E_STRICT);
 
date_default_timezone_set('America/Lima');
 
require_once('PHPMailer/class.phpmailer.php');
  
$mail             = new PHPMailer();
$body             = 'Holassssss';
  
$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
$mail->Username   = "informatica.mpfn@gmail.com";  // GMAIL username
$mail->Password   = "Ministerio#07";            // GMAIL password
 
$mail->SetFrom('informatica.mpfn@gmail.com', 'Informática Cajamarca');
 
$mail->AddReplyTo("informatica.mpfn@gmail.com");
 
$mail->Subject    = "subject";
  
$mail->MsgHTML($body);
 
$address = "upgerard@gmail.com";
$mail->AddAddress($address);
 
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
?>