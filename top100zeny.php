<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

$jobs = $_SESSION[$CONFIG_name.'jobs'];

$query = sprintf(TOP100ZENY);
$result = execute_query($query, "top100zeny.php");

opentable($lang['TOP100ZENY_TOP100ZENY']);
echo "
<table width=\"490\">
<tr>
	<td align=\"right\" class=\"head\">".$lang['POS']."</td>
	<td>&nbsp;</td>
	<td align=\"left\" class=\"head\">".$lang['NAME']."</td>
	<td align=\"left\" class=\"head\">".$lang['CLASS']."</td>
	<td align=\"right\" class=\"head\">".$lang['ZENY']."</td>
</tr>
";
$nusers = 0;
if ($result) {
	while ($line = $result->fetch_row()) {
				$nusers++;
				if ($nusers > 100)
					break;

				$zeny = moneyformat($line[4]);
				$charname = htmlformat($line[0]);

				echo "    
				<tr>
					<td align=\"right\">$nusers</td>
					<td>&nbsp;</td>
					<td align=\"left\">$charname</td>
					<td align=\"left\">
				";
				if (isset($jobs[$line[1]]))
					echo $jobs[$line[1]];
				else
					echo $lang['UNKNOWN'];
				echo "
					</td>
					<td align=\"right\">$zeny</td>
				</tr>
				";
	}
}
echo "</table>";
closetable();
fim();
?>
