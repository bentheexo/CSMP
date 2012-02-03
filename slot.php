<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

if (!empty($_SESSION[$CONFIG_name.'account_id']) && $CONFIG_set_slot) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

		if (is_online())
			redir("index.php", "main_div", $lang['NEED_TO_LOGOUT_F']);

		if (!empty($GET_opt)) {
			if ($GET_opt == 1) {
				if (!isset($GET_newslot) || $GET_newslot == $GET_slot)
					alert($lang['SLOT_NOT_SELECTED']);

				if (notnumber($GET_char_id) || notnumber($GET_newslot) || notnumber($GET_slot))
					alert($lang['SLOT_CHANGE_FAILED']);

				if ($GET_newslot < 0 || $GET_newslot > 8 || $GET_slot < 0 ||  $GET_slot > 8)
					alert($lang['SLOT_WRONG_NUMBER']);
				
				$query = sprintf(CHECK_SLOT, $GET_newslot, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, "slot.php");

				if ($line = $result->fetch_row()) {
					$query = sprintf(CHANGE_SLOT, $GET_slot, $line[0], $_SESSION[$CONFIG_name.'account_id']);
					$result = execute_query($query, "slot.php");
				}

				$query = sprintf(CHANGE_SLOT, $GET_newslot, $GET_char_id, $_SESSION[$CONFIG_name.'account_id']);
				$result = execute_query($query, "slot.php");
			}
		}
		$query = sprintf(GET_SLOT, $_SESSION[$CONFIG_name.'account_id']);
		$result = execute_query($query, "slot.php");

		if ($result->count() < 1)
			redir("slot.php", "main_div", $lang['ONE_CHAR']);

		opentable($lang['SLOT_CHANGE_SLOT']);
		echo "
		<table width=\"490\">
		<tr>
			<td align=\"right\" class=\"head\">".$lang['SLOT']."</td>
			<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
			<td align=\"center\" class=\"head\">".$lang['SLOT_NEW_SLOT']."</td>
		</tr>
		";
		for ($j = 0; $line = $result->fetch_row(); $j++) {
			$GID = $line[0];
			$slot = $line[1];
			$charname = htmlformat($line[2]);
			echo "
			<tr>
				<td align=\"right\">$slot</td>
				<td align=\"left\">$charname</td>
				<td align=\"center\">
				<form id=\"slot$j\" onsubmit=\"return GET_ajax('slot.php','main_div','slot$j')\">
					<select name=\"newslot\">";
			for ($i = 0; $i < 9; $i++) {
				if ($slot == $i)
					echo "<option value=\"$i\" selected>$i";
				else
					echo "<option value=\"$i\">$i";
			}
			echo "</select>
						<input type=\"submit\" value=\"".$lang['CHANGE']."\">
						<input type=\"hidden\" name=\"opt\" value=\"1\">
						<input type=\"hidden\" name=\"slot\" value=\"$slot\">
						<input type=\"hidden\" name=\"char_id\" value=\"$GID\">
				</form>
				</td>
			</tr>
			";
		}
		echo "</table>
			<table>
				<tr><td align=\"left\">".$lang['SLOT_PS1']."</td></tr>
				<tr><td align=\"left\">".$lang['SLOT_PS2']."</td></tr>
			</table>";
		closetable();
	}
	end();
}

redir("motd.php", "main_div", $lang['NEED_TO_LOGIN']);
?>
