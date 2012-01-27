<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

		if (!empty($POST_opt)) {
			if ($POST_opt == 1 && isset($POST_frm_name) && !strcmp($POST_frm_name, "password")) {
				if (strcmp($POST_newpass, $POST_confirm) != 0) 
					alert($lang['PASSWORD_NOT_MATCH']);

				if (inject($POST_login_pass) || inject($POST_newpass)) 
					alert($lang['INCORRECT_CHARACTER']);

				if (strlen($POST_login_pass) < 4 || strlen($POST_login_pass) > 23)
					alert($lang['PASSWORD_LENGTH_OLD']);

				if ($CONFIG_safe_pass && (strlen(trim($POST_newpass)) < 6 || strlen(trim($POST_newpass)) > 23))
					alert($lang['PASSWORD_LENGTH']);

				if (strlen(trim($POST_newpass)) < 4 || strlen(trim($POST_newpass)) > 23)
					alert($lang['PASSWORD_LENGTH_OLD']);

				if ($CONFIG_safe_pass && thepass(trim($POST_newpass)))
					alert($lang['PASSWORD_REJECTED']);

				if ($CONFIG_md5_pass) {
					$POST_login_pass = md5($POST_login_pass);
					$POST_newpass = md5($POST_newpass);
				}

				$query = sprintf(CHECK_PASSWORD, trim($POST_login_pass), $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, 'password.php');

				if (!$result->fetch_row())
					alert($lang['INCORRECT_PASSWORD']);

				$query = sprintf(CHANGE_PASSWORD, trim($POST_newpass), $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, 'password.php');

				redir("password.php", "main_div", $lang['PASSWORD_CHANGED']);
			}
		}

	opentable($lang['CHANGE_PASSWORD']);
		echo "
		<form id=\"password\" onsubmit=\"return POST_ajax('password.php','main_div','password')\"><table>
		<tr><td align=right>".$lang['PASSWORD'].":</td><td>
			<input type=\"password\" name=\"login_pass\" maxlength=\"23\" size=\"23\" onKeyPress=\"return force(this.name,this.form.id,event);\">
			</td></tr>
		<tr><td align=right>".$lang['NEW_PASSWORD'].":</td><td>
			<input type=\"password\" name=\"newpass\" maxlength=\"23\" size=\"23\" onKeyPress=\"return force(this.name,this.form.id,event);\">
			</td></tr>
		<tr><td align=right>".$lang['NEW_PASSWORD'].":</td><td>
			<input type=\"password\" name=\"confirm\" maxlength=\"23\" size=\"23\" onKeyPress=\"return force(this.name,this.form.id,event);\">
			</td></tr>
		<input type=\"hidden\" name=\"opt\" value=\"1\">
		<tr><td>&nbsp;</td><td><input type=\"submit\" value=".$lang['CHANGE']."></td></tr>
		</table></form>
		";
	closetable();
	fim();
	}
}
redir("motd.php", "main_div", $lang['NEED_TO_LOGIN']);
?>
