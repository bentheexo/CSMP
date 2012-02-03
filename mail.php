<?php
// As of January 1st this project has changed CeresCP for
// my distrobution purposes. I have rewritten major componets
// to fit my needs of the software.

include_once 'config.php'; // loads config variables
include("./classes/class.phpmailer.php");
include("./classes/class.smtp.php");


function email($contas) {
	global $CONFIG_smtp_server, $CONFIG_smtp_port, $CONFIG_smtp_username, $CONFIG_smtp_password, $CONFIG_smtp_mail, $CONFIG_name;

$mensagem = "----------------------------\n";
for ($i = 0; isset($contas[$i][0]); $i++) {
	$mensagem.= "Username: ".$contas[$i][0];
	$mensagem.= "\nPassword: ".$contas[$i][1];
	$mensagem.= "\n----------------------------\n";
}

$maildef = read_maildef("recover_password");
$maildef = str_ireplace("#account_info#",$mensagem,$maildef);
$maildef = str_ireplace("#server_name#",$CONFIG_name,$maildef);
$maildef = str_ireplace("#support_mail#",$CONFIG_smtp_mail,$maildef);
$maildef = nl2br($maildef);

$mail=new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth   = true;

$mail->Host       = $CONFIG_smtp_server;
$mail->Port       = $CONFIG_smtp_port;

$mail->Username   = $CONFIG_smtp_username;
$mail->Password   = $CONFIG_smtp_password;

$mail->From       = $CONFIG_smtp_mail;
$mail->FromName   = $CONFIG_name;
$mail->Subject    = "Password Recovery";
$mail->Body       = $maildef;

$mail->WordWrap   = 50;

$mail->AddAddress($contas[0][2],$contas[0][2]);
$mail->AddReplyTo($CONFIG_smtp_mail,$CONFIG_name);

$mail->IsHTML(true);

if(!$mail->Send()) {
  return $mail->ErrorInfo;
} else {
  return "Message has been sent";
}

}
?>
