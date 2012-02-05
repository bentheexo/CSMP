<?php
// As of January 1st this project has changed CeresCP for
// my distrobution purposes. I have rewritten major componets
// to fit my needs of the software.

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

if (!empty($_SESSION[$CONFIG_name.'account_id']) && $CONFIG_reset_enable) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

		if (!empty($GET_opt)) {
			if ($GET_opt == 1) {
				if (is_online()) 
					alert($lang['NEED_TO_LOGOUT_F']);

				if (inject($GET_GID1)) 
					alert($lang['POSITION_RESET']);

				$query = sprintf(GET_SAVE_POSITION, $GET_GID1, $GET_GID1);
				$result = execute_query($query, "position.php");
				if ($result->count() < 1) alert($lang['POSITION_JAIL']);
				$line = $result->fetch_row();
				$last_map = $line[1];
				$last_x = $line[2];
				$last_y = $line[3];
				$zeny = $line[4];
				if ($zeny < $CONFIG_reset_cost)
					alert($lang['POSITION_NO_ZENY']);
				$zeny = $zeny - $CONFIG_reset_cost;
				$query = sprintf(FINAL_POSITION, $last_map, $last_x, $last_y, $zeny, $GET_GID1);
				$result = execute_query($query, "position.php");
				redir("position.php", "main_div", $lang['POSITION_OK']);
			}
		}

		$query = sprintf(CHAR_GET_CHARS, $_SESSION[$CONFIG_name.'account_id'], $_SESSION[$CONFIG_name.'account_id']);
		$result = execute_query($query, "position.php");

		if ($result->count() < 1)
			redir("motd.php", "main_div", $lang['ONE_CHAR']);

		opentable($lang['POSITION_TITLE']);
		echo "
		<table width=\"490\">
		<tr>
			<td align=\"right\" class=\"head\">".$lang['SLOT']."</td>
			<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
			<td align=\"center\" class=\"head\">".$lang['POSITION_LEVEL']."</td>
			<td align=\"left\" class=\"head\">".$lang['MAP']."</td>
			<td align=\"center\" class=\"head\">".$lang['POSITION_SELECT']."</td>
		</tr>
		";
		while ($line = $result->fetch_row()) {
			$GID = $line[0];
			$slot = $line[1];
			$charname = htmlformat($line[2]);
			$clevel = $line[4];
			$joblevel = $line[5];
			$lastmap = $line[6];
			echo "    
			<tr>
				<td align=\"right\">$slot</td>
				<td align=\"left\">$charname</td>
				<td align=\"center\">$clevel/$joblevel</td>
				<td align=\"left\">$lastmap</td>
				<td align=\"center\">
				<form id=\"position$slot\" onsubmit=\"return GET_ajax('position.php','main_div','position$slot')\">
					<input type=\"submit\" value=\"".$lang['POSITION_RESET']."\">
					<input type=\"hidden\" name=\"charnum\" value=\"$slot\">
					<input type=\"hidden\" name=\"opt\" value=\"1\">
					<input type=\"hidden\" name=\"GID1\" value=\"$GID\">
				</form>
				</td>
			</tr>
			";
		}
		echo "</table>";
		if ($CONFIG_reset_cost) {
			$lang['POSITION_PS1'] = sprintf($lang['POSITION_PS1'], $CONFIG_reset_cost);
			echo "
				<table>
					<tr><td align=\"left\">".$lang['POSITION_PS1']."</td></tr>
				</table>
			";
		}
		closetable();
	}
	ending();
}

redir("motd.php", "main_div", $lang['NEED_TO_LOGIN']);
?>
