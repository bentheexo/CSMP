<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

$jobs = $_SESSION[$CONFIG_name.'jobs'];

if (is_woe())
	redir("motd.php", "main_div", $lang['WOE_TIME']);

$query = sprintf(WHOISONLINE);
$result = execute_query($query, "whoisonline.php");

opentable($lang['WHOISONLINE_WHOISONLINE']);
echo "
<table width=\"500\">
<tr>
	<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
	<td align=\"left\" class=\"head\">".$lang['CLASS']."</td>
	<td align=\"center\" class=\"head\">".$lang['BLVLJLVL']."</td>
	";
	if (isset($_SESSION[$CONFIG_name.'level']) && $_SESSION[$CONFIG_name.'level'] >= $CONFIG['cp_admin'])
	echo "<td align=\"center\" class=\"head\">".$lang['WHOISONLINE_COORDS']."</td>";
	echo "
	<td align=\"left\" class=\"head\">".$lang['MAP']."</td>
</tr>
";
if ($result) {
	while ($line = $result->fetch_row()) {
		$charname = htmlformat($line[0]);
		if ($line[9] >= $CONFIG_gm_hide) {
			if (!isset($_SESSION[$CONFIG_name.'level']) || (isset($_SESSION[$CONFIG_name.'level']) && $_SESSION[$CONFIG_name.'level'] < $line[9]))
				continue;
		}
			echo "    
				<tr>
					<td align=\"left\">$charname</td>
					<td align=\"left\">
				";
				if (isset($jobs[$line[1]]))
					echo $jobs[$line[1]];
				else
					echo $lang['UNKNOWN'];
				echo "
					</td>
					<td align=\"center\">$line[2]/$line[3]</td>
					";
				if (isset($_SESSION[$CONFIG_name.'level']) && $_SESSION[$CONFIG_name.'level'] >= $CONFIG['cp_admin'])
					echo "<td align=\"center\">$line[4],$line[5]</td>";
				echo "
					<td align=\"left\">$line[6]</td>
				</tr>
			";
	}
}
echo "</table>";
closetable();
fim();
?>
