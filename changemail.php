<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

		if (!empty($POST_opt)) {
			if ($POST_opt == 1 && isset($POST_frm_name) && !strcmp($POST_frm_name, "changemail")) {
				if (strlen($POST_email) < 7 || !strstr($POST_email, '@') || !strstr($POST_email, '.'))
					alert($lang['CHANGEMAIL_MAIL_INVALID']);

				if (inject($POST_email) || inject($POST_login_pass)) 
					alert($lang['INCORRECT_CHARACTER']);

				if (strlen($POST_login_pass) < 4 || strlen($POST_login_pass) > 23)
					alert($lang['PASSWORD_LENGTH_OLD']);

				if ($CONFIG_md5_pass)
					$POST_login_pass = md5($POST_login_pass);

				$query = sprintf(CHANGE_EMAIL, $POST_email, $POST_login_pass, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, 'changemail.php');
			}
		}


	$query = sprintf(CHECK_EMAIL, $_SESSION[$CONFIG_name.'account_id']);
	$result = execute_query($query, 'changemail.php');

	$cemail = $result->fetch_row();
	$cemail[0] = htmlformat($cemail[0]);

	opentable($lang['CHANGEMAIL_CHANGEMAIL']);
		echo "
		<form id=\"changemail\" onsubmit=\"return POST_ajax('changemail.php','main_div','changemail')\"><table>
		<tr><td align=\"right\">".$lang['CHANGEMAIL_CURRENT_MAIL'].":</td><td align=\"left\">$cemail[0]</td></tr>
		<tr><td align=\"right\">".$lang['CHANGEMAIL_NEW_MAIL'].":</td><td align=\"left\">
		<input type=\"text\" name=\"email\" maxlength=\"40\" size=\"40\" onKeyPress=\"return force(this.name,this.form.id,event);\">
			</td></tr>
		<tr><td align=right>".$lang['PASSWORD'].":</td><td align=\"left\">
		<input type=\"password\" name=\"login_pass\" maxlength=\"23\" size=\"23\" onKeyPress=\"return force(this.name,this.form.id,event);\">
		</td></tr>
		<input type=\"hidden\" name=\"opt\" value=\"1\">
		<tr><td>&nbsp;</td><td><input type=\"submit\" value=\"".$lang['CHANGEMAIL_CHANGE']."\"></td></tr>
		</table></form>
		";
	closetable();
	end();
	}
}
redir("motd.php", "main_div", $lang['NEED_TO_LOGIN']);
?>
