<?php
// As of January 1st this project has changed CeresCP for
// my distrobution purposes. I have rewritten major componets
// to fit my needs of the software.

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'adminquery.php';
include_once 'functions.php';

if (!isset($_SESSION[$CONFIG_name.'level']) || $_SESSION[$CONFIG_name.'level'] < $CONFIG['cp_admin'])
	die ("Not Authorized");

if (isset($GET_frm_name) && isset($GET_id)) {
	if (notnumber($GET_id) || inject($GET_login) || inject($GET_password) || inject($GET_email))
		alert($lang['INCORRECT_CHARACTER']);

	$query = sprintf(ACCOUNTS_SEARCH_ACCOUNT_ID, trim($GET_id));
	$result = execute_query($query, 'adminaccedit.php');
	if ($line = $result->fetch_row()) {
		if ($GET_sex != 'M' && $GET_sex != 'F')
			$GET_sex = $line[2];

		if ($GET_level > 99 || $GET_level < 0)
			$GET_level = $line[4];

		if ($GET_level > $_SESSION[$CONFIG_name.'level'])
			alert("You can not set a player's GM level higher than your own");

		if ($_SESSION[$CONFIG_name.'level'] <= $line[4] || ($GET_level >= $_SESSION[$CONFIG_name.'level'] && $_SESSION[$CONFIG_name.'level'] != 99))
			$GET_level = $line[4];

		$query = sprintf(ACCEDIT_UPDATE, $GET_login, $GET_password, $GET_sex, $GET_email, $GET_level, trim($GET_id));
		$result = execute_query($query, 'adminaccedit.php');

		alert("Account Updated");
	}
}

opentable("Account Edit");
if (isset($GET_back)) {
	$back = base64_decode($GET_back);
	echo "<span title=\"Back\" onClick=\"return LINK_ajax('adminaccounts.php?$back','accounts_div');\">&lt;-back</span>";
}

if (isset($GET_id)) {
	$query = sprintf(ACCOUNTS_SEARCH_ACCOUNT_ID, trim($GET_id));
	$result = execute_query($query, 'adminaccedit.php');
	if ($line = $result->fetch_row()) {
		$sex = $line[2];
		echo "
		<form id=\"accedit\" onSubmit=\"return GET_ajax('adminaccedit.php','accounts_div','accedit');\">
			<table width=\"490\">
				<tr>
					<td align=\"right\">Account_id</td><td align=\"left\">$line[0]<input type=\"hidden\" name=\"id\" value=\"$line[0]\"></td>
				</tr><tr>
					<td align=\"right\">Login</td><td align=\"left\"><input type=\"text\" name=\"login\" value=\"$line[1]\" maxlength=\"23\" size=\"23\"></td>
				</tr><tr>
					<td align=\"right\">Password</td><td align=\"left\"><input type=\"text\" name=\"password\" value=\"$line[8]\" maxlength=\"32\" size=\"23\"></td>
				</tr><tr>
					<td align=\"right\">Sex</td>
					<td align=\"left\">
						<select name=\"sex\">
		";
		if (strcmp($line[2], 'M'))
			echo "<option value=\"M\">".$lang['SEX_MALE']."<option selected value=\"F\">".$lang['SEX_FEMALE'];
		else
			echo "<option selected value=\"M\">".$lang['SEX_MALE']."<option value=\"F\">".$lang['SEX_FEMALE'];
		echo "
						</select>
					</td>
				</tr><tr>
					<td align=\"right\">Email</td><td align=\"left\"><input type=\"text\" name=\"email\" value=\"$line[3]\" maxlength=\"60\" size=\"23\"></td>
				</tr><tr>
					<td align=\"right\">Level</td><td align=\"left\"><input type=\"text\" name=\"level\" value=\"$line[4]\" maxlength=\"2\" size=\"2\"></td>
				</tr><tr>
					<td>&nbsp;</td><td align=\"left\"><input type=\"submit\" value=\"".$lang['CHANGEMAIL_CHANGE']."\">
				</td></tr>
			</table>
		</form>
		";
	}

} else echo "Not Found";

closetable();


ending();
?>
