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

if (!isset($GET_frm_name) && !isset($GET_page)) {
	opentable("View Chars");
	echo "
	<form id=\"chars\" onSubmit=\"return GET_ajax('adminchars.php','accounts_div','chars');\">
		<table>
			<tr>
				<td>Search</td><td>
				<input type=\"text\" name=\"termo\" maxlength=\"23\" size=\"23\">
				<select name=\"tipo\">
				<option value=\"1\">account_id
				<option value=\"2\">char_id
				<option selected value=\"3\">name
				</select></td><td>
				<input type=\"submit\" name=\"search\" value=\"search\"></td>
				<td><span title=\"Show All\" onClick=\"return LINK_ajax('adminchars.php?page=0','accounts_div');\">Show All</span></td>
			</tr>
		</table>
	</form>

	<div id=\"accounts_div\">";
	$begin = 1;
}

if (isset($GET_tipo)) {
	if (inject($GET_tipo))
		alert($lang['INCORRECT_CHARACTER']);

	if (strlen($GET_termo) < 3)
		alert("Please type at least 3 chars");

	switch($GET_tipo) {
		case 1:
			$query = sprintf(CHARS_SEARCH_ACCOUNT_ID, trim($GET_termo));
			break;
		case 2:
			$query = sprintf(CHARS_SEARCH_CHAR_ID, trim($GET_termo));
			break;
		default:
			$query = sprintf(CHARS_SEARCH_NAME, trim($GET_termo));
			break;
	}
	$pages = 0;
	$back = "frm_name=".$GET_frm_name."&tipo=".$GET_tipo."&termo=".$GET_termo;
} else {
	if (!isset($GET_page))
		$GET_page = 0;
	else if (notnumber($GET_page))
		alert($lang['INCORRECT_CHARACTER']);


	$query = sprintf(CHARS_TOTAL);
	$result = execute_query($query, 'adminchars.php');
	$result->fetch_row();
	$pages = (int)($result->row(0) / 100);
	
	$inicio = $GET_page * 100;
	$query = sprintf(CHARS_BROWSE, $inicio);

	$back = "page=".$GET_page;
}

$back = base64_encode($back);
$result = execute_query($query, 'adminchars.php');

echo "
<table width=\"550\">
	<tr>
		<td align=\"right\" class=\"head\">Account_id</td>
		<td align=\"right\" class=\"head\">Char_id</td>
		<td align=\"left\" class=\"head\">Name</td>
		<td align=\"left\" class=\"head\">Class</td>
		<td align=\"center\" class=\"head\">Base/Job</td>
		<td align=\"left\" class=\"head\">Online</td>
	</tr>
	";

$jobs = $_SESSION[$CONFIG_name.'jobs'];

while ($line = $result->fetch_row()) {
	if ($line[6] != 0)
		$online = "<font color=\"green\">on</font>";
	else
		$online = "<font color=\"red\">off</font>";
	
	$job = "unknown";
	if (isset($jobs[$line[3]]))
		$job = $jobs[$line[3]];


	echo "
	<tr>
		<td align=\"right\">$line[0]</td>
		<td align=\"right\">$line[1]</td>
		<td align=\"left\">$line[2]</td>
		<td align=\"left\">$job</td>
		<td align=\"center\">$line[4]/$line[5]</td>
		<td align=\"center\">$online</td>

	</tr>
	";
}
echo "</table>";

if ($pages) {
	echo "
	<table><tr>
	<td><span title=\"0\" onClick=\"return LINK_ajax('adminchars.php?page=0','accounts_div');\">&lt;&lt;</span></td>";

	for ($i = ($GET_page - 10); $i <= ($GET_page + 10); $i++) {
		if ($i >= 0 && $i != $GET_page && $i <= $pages)
			echo "<td><span title=\"$i\" onClick=\"return LINK_ajax('adminchars.php?page=$i','accounts_div');\">$i</span></td>";
		else if ($i == $GET_page)
			echo "<td>$i</td>";
	}

	echo "
	<td><span title=\"$pages\" onClick=\"return LINK_ajax('adminchars.php?page=$pages','accounts_div');\">&gt;&gt;</span></td>
	</tr></table>";
}


if (isset($begin)) {
	echo "</div>";
	closetable();
}

ending();
?>
