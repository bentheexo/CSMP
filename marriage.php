<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

		if (!empty($GET_opt)) {
			if ($GET_opt == 1 && $CONFIG_marry_enable) {
				if (is_online()) 
					alert($lang['NEED_TO_LOGOUT_F']);

				if (inject($GET_GID1) && inject($GET_GID2)) 
					alert($lang['INCORRECT_CHARACTER']);
				
				if (isset($GET_divorce) && $GET_divorce > 0) {
					$query = sprintf(PARTNER_ONLINE, $GET_GID2);
					$result = execute_query($query, "marriage.php");

					if ($result->fetch_row())
						alert($lang['MARRIAGE_COUPLE_OFF']);
		
					$query = sprintf(PARTNER_NULL, $GET_GID1);
					$result = execute_query($query, "marriage.php");
					
					$query = sprintf(PARTNER_NULL, $GET_GID2);
					$result = execute_query($query, "marriage.php");

					$query = sprintf(PARTNER_RING, $GET_GID1);
					$result = execute_query($query, "marriage.php");

					$query = sprintf(PARTNER_RING, $GET_GID2);
					$result = execute_query($query, "marriage.php");

					$ban_length = 2 * 60; // 2 minutos pra fazer efeito //testando vicous pucca
					$query = sprintf(PARTNER_BAN, $ban_length, $_SESSION[$CONFIG_name.'account_id']);
					$result = execute_query($query, "marriage.php");

					redir("marriage.php", "main_div", $lang['MARRIAGE_DIVORCE_OK']);
				}

				alert($lang['MARRIAGE_NOTHING']);
			}
		}

		$query = sprintf(PARTNER_GET, $_SESSION[$CONFIG_name.'account_id']);
		$result = execute_query($query, "marriage.php");

		if ($result->count() < 1)
			redir("motd.php", "main_div", $lang['ONE_CHAR']);

		opentable($lang['MARRIAGE']);
		echo "
		<table width=\"490\">
		<tr>
			<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
			<td align=\"left\" class=\"head\">".$lang['MARRIAGE_PARTNER']."</td>
			<td align=\"center\" class=\"head\">".$lang['MARRIAGE_DIVORCE']."</td>
		</tr>
		";
		while ($line = $result->fetch_row()) {
			$charname = htmlformat($line[0]);
			$GID1 = $line[1];
			$partnername = htmlformat($line[2]);
			if (strlen($partnername) < 4)
				$partnername = $lang['MARRIAGE_SINGLE'];
			$GID2 = $line[3];
			echo "    
			<tr>
				<td align=\"left\">$charname</td>
				<td align=\"left\">$partnername</td>
			";
			if ($CONFIG_marry_enable && $GID2 > 0) {
				echo "
				<td align=\"center\">
				<form id=\"marriage$GID1\" onsubmit=\"return GET_ajax('marriage.php','main_div','marriage$GID1');\">
					<input type=\"checkbox\" name=\"divorce\" value=\"1\">
					<input type=\"submit\" value=\"Confirm\" class=\"myctl\">
					<input type=\"hidden\" name=\"opt\" value=\"1\">
					<input type=\"hidden\" name=\"GID1\" value=\"$GID1\">
					<input type=\"hidden\" name=\"GID2\" value=\"$GID2\">
				</form>
				</td>
				";
			}
			echo "</tr>";
		}
		echo "</table>";
		if ($CONFIG_marry_enable)
			echo "
			<table>
				<tr><td align=\"left\">".$lang['MARRIAGE_PS1']."</td></tr>
				<tr><td align=\"left\">".$lang['MARRIAGE_PS2']."</td></tr>
			</table>";
//				<tr><td align=\"left\">".$lang['MARRIAGE_PS3']."</td></tr>

		closetable();
	}
	end();
}

redir("motd.php", "main_div", $lang['NEED_TO_LOGIN']);
?>
