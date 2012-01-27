<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

	$query = sprintf(GET_LINKS);
	$result = execute_query($query, 'links.php', 1, 0);


	opentable($lang['LINKS_LINKS']);
echo "<table>";

for ($i = 1; $i < 10; $i++) {
			if (!($clinks = $result->fetch_row()))
				break;

	$name = htmlspecialchars(utf8_encode($clinks[0]));
	$url = htmlspecialchars($clinks[1]);
	$desc = nl2br(htmlspecialchars(utf8_encode($clinks[2])));
	$size = $clinks[3];

	if ($size==0) {
		$size="";
		$url=" <a href=$url class=\"link\" target=_blank>$name</a> $size";
		}
	else{
		$size=" ($size Mb)";
		$url=" <a href=$url class=\"link\">$name</a> $size";
		};

			echo "
				<tr><td align=\"left\"><b>".$lang['LINKS_NAME']."</b>:</td><td align=\"left\">$url</td></tr>
				<tr><td align=\"left\">&nbsp;</td><td align=\"left\">$desc</td></tr>
				<tr><td align=\"left\">&nbsp;</td></tr>
				";
}

		echo "</table>";
	closetable();
	fim();



?>
