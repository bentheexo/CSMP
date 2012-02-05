<?php
// As of January 1st this project has changed CeresCP for
// my distrobution purposes. I have rewritten major componets
// to fit my needs of the software.

session_start();

include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

		$query = sprintf(GUILD_LADDER);
		$result = execute_query($query, "guild.php");

		opentable($lang['GUILD_TOP50']);
		echo "<center>
		<table width=\"530\" style=\"padding-left:10px;\">
		<tr>
			<td class=\"head\">".$lang['POS']."</td>
			<td class=\"head\">".$lang['GUILD_EMBLEM']."</td>
			<td class=\"head\">".$lang['GUILD_GNAME']."</td>
			<td class=\"head\">".$lang['GUILD_GLEVEL']."</td>
			<td class=\"head\">".$lang['GUILD_GEXPERIENCE']."</td>
			<td class=\"head\">".$lang['GUILD_MEMBERS']."</td>
			<td class=\"head\">".$lang['GUILD_GAVLEVEL']."</td>
		</tr>
		";
		for ($i = 1; $i < 51; $i++) {
			if (!($line = $result->fetch_row()))
				break;
			$gname = $line[0];
			$gname = htmlformat($line[0]);
			$emblems[$line[4]] = $line[1];
			$experience = moneyformat($line[3]);
			echo "
			<tr>
				<td align=\"right\">$i</td>
				<td align=\"center\"><img src=\"emblema.php?data=$line[4]\" alt=\"$gname\"></td>
				<td>&nbsp;</td>
				<td align=\"left\">$gname</td>
				<td>&nbsp;</td>
				<td align=\"left\">$line[2]</td>
				<td align=\"right\">$experience</td>
				<td>&nbsp;</td>
				<td align=\"center\">$line[6]</td>
				<td align=\"right\">$line[5]</td>
			</tr>";
		}
		echo "</table></center>";
		closetable();

		if (is_woe()) {
			opentable($lang['WOE_TIME']);
			closetable();
		} else {

			$query = sprintf(GUILD_CASTLE);
			$result = execute_query($query, "guild.php");
			opentable($lang['GUILD_GCASTLES']);
			$castles = $_SESSION[$CONFIG_name.'castles'];
			echo "
			<table>
			<tr>
				<td align=\"center\" class=\"head\">".$lang['GUILD_EMBLEM']."</td>
				<td>&nbsp;</td>
				<td align=\"left\" class=\"head\">".$lang['GUILD_GNAME']."</td>
				<td>&nbsp;</td>
				<td align=\"left\" class=\"head\">".$lang['GUILD_GCASTLE']."</td>
				</tr>
			";
			for ($i = $i; $line = $result->fetch_row(); $i++) {
				$gname = htmlformat($line[0]);
				if (isset($castles[$line[2]]))
					$cname = $castles[$line[2]];
				else 
					continue;
				$emblems[$line[3]] = $line[1];
				echo "
				<tr>
					<td align=\"center\"><img src=\"emblema.php?data=$line[3]\" alt=\"$gname\"></td>
					<td>&nbsp;</td>
					<td align=\"left\">$gname</td>
					<td>&nbsp;</td>
					<td align=\"left\">$cname</td>
				</tr>";
			}
			echo "</table>";
			closetable();
		}
		if (isset($emblems))
			$_SESSION[$CONFIG_name.'emblems'] = $emblems;
	ending();
?>
