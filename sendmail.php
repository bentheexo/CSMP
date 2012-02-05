<?php
// As of January 1st this project has changed CeresCP for
// my distrobution purposes. I have rewritten major componets
// to fit my needs of the software.

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

if (check_ban())
	redir("motd.php", "main_div", "Disabled");

if (isset($POST_opt)) {
	if ($POST_opt == 1 && isset($POST_frm_name) && !strcmp($POST_frm_name, "sendmail")) {
		$session = $_SESSION[$CONFIG_name.'sessioncode'];
		if ($CONFIG_auth_image && function_exists("gd_info")
			&& strtoupper($POST_code) != substr(strtoupper(md5("Mytext".$session['sendmail'])), 0,6))
			alert($lang['INCORRECT_CODE']);

		if (strlen($POST_title) < 3 )
			alert("A better Title is needed");

		$query = sprintf(SENDMAIL, $POST_send_name, $POST_dest_name, $POST_title, $POST_message);
		$result = execute_query($query, 'sendmail.php');


		redir("motd.php", "main_div", 'Mail Sent Successfully');
	}
}

if (isset($_SESSION[$CONFIG_name.'sessioncode']))
	$session = $_SESSION[$CONFIG_name.'sessioncode'];
$session['sendmail'] = rand(12345, 99999);
$_SESSION[$CONFIG_name.'sessioncode'] = $session;
$var = rand(10, 9999999);

	opentable("In Game Character Mailing");
	
	echo "
	<form id=\"sendmail\" onSubmit=\"return POST_ajax('sendmail.php','main_div','sendmail');\"><table>
	<tr><td align=\"right\">Senders Name:</td><td align=\"left\">
	<input type=\"text\" name=\"send_name\" maxlength=\"23\" size=\"23\" onKeyPress=\"return force(this.name,this.form.id,event);\">
	</td></tr>
	<tr><td align=\"right\">Receivers Name:</td><td align=\"left\">
	<input type=text name=\"dest_name\" maxlength=\"23\" size=\"23\" onKeyPress=\"return force(this.name,this.form.id,event);\">
	</td></tr>
	<tr><td align=\"right\">Message Title:</td><td align=\"left\">
	<input type=text name=\"title\" maxlength=\"23\" size=\"23\" onKeyPress=\"return force(this.name,this.form.id,event);\">
	</td></tr>
	<tr><td align=\"right\">Message:</td><td align=\"left\">
	<textarea name=\"message\" rows=\"8\" cols=\"40\" onKeyPress=\"return force(this.name,this.form.id,event);\"></textarea>
	<input type=\"hidden\" name=\"opt\" value=\"1\"></td></tr>";
	if ($CONFIG_auth_image && function_exists("gd_info")) { 
		echo "<tr><td></td><td align=left><img src=\"img.php?img=sendmail&var=$var\" alt=\"".$lang['SECURITY_CODE']."\">
		</td></tr><tr><td align=right>".$lang['CODE'].":</td>
		<td align=\"left\">
		<input type=\"text\" name=\"code\" maxlength=\"6\" size=\"6\" onKeyPress=\"return force(this.name,this.form.id,event);\">
		&nbsp;</td></tr>";
	}

	echo "
	<tr><td>&nbsp;</td><td><input type=\"submit\" name=\"send\" value=\"Send\"></td></tr>
	</table></form>
	";
	
	closetable();

	ending();

?>
