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
	opentable("View Accounts");
	echo "
	<form id=\"accounts\" onSubmit=\"return GET_ajax('adminaccounts.php','accounts_div','accounts');\">
		<table>
			<tr>
				<td>Search</td><td>
				<input type=\"text\" name=\"termo\" maxlength=\"23\" size=\"23\">
				<select name=\"tipo\">
				<option value=\"1\">account_id
				<option selected value=\"2\">login
				<option value=\"3\">email
				<option value=\"4\">IP
				</select></td><td>
				<input type=\"submit\" name=\"search\" value=\"search\"></td>
				<td><span title=\"Show All\" onClick=\"return LINK_ajax('adminaccounts.php?page=0','accounts_div');\">Show All</span></td>
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
			$query = sprintf(ACCOUNTS_SEARCH_ACCOUNT_ID, trim($GET_termo));
			break;
		case 3:
			$query = sprintf(ACCOUNTS_SEARCH_EMAIL, trim($GET_termo));
			break;
		case 4:
			$query = sprintf(ACCOUNTS_SEARCH_IP, trim($GET_termo));
			break;
		default:
			$query = sprintf(ACCOUNTS_SEARCH_USERID, trim($GET_termo));
			break;
	}
	$pages = 0;
	$back = "frm_name=".$GET_frm_name."&tipo=".$GET_tipo."&termo=".$GET_termo;
} else {
	if (!isset($GET_page))
		$GET_page = 0;
	else if (notnumber($GET_page))
		alert($lang['INCORRECT_CHARACTER']);


	$query = sprintf(TOTALACCOUNTS);
	$result = execute_query($query, 'adminaccounts.php');
	$result->fetch_row();
	$pages = (int)($result->row(0) / 100);
	
	$inicio = $GET_page * 100;
	$query = sprintf(ACCOUNTS_BROWSE, $inicio);

	$back = "page=".$GET_page;
}

$back = base64_encode($back);
$result = execute_query($query, 'adminaccounts.php');

echo "
<table width=\"550\">
	<tr>
		<td align=\"right\" class=\"head\">ID</td>
		<td align=\"left\" class=\"head\">Login</td>
		<td align=\"center\" class=\"head\">Sex</td>
		<td align=\"left\" class=\"head\">Email</td>
		<td align=\"center\" class=\"head\">Level</td>
		<td align=\"left\" class=\"head\">IP</td>
		<td align=\"center\" class=\"head\">BAN</td>
	</tr>
	";

while ($line = $result->fetch_row()) {
	if (strcmp($line[2], "S") === 0)
		continue;

	if ($line[6] > time() || $line[7] > 0)
		$ban = "<font color=\"red\">#</font>";
	else
		$ban = "-";
	
	if (strlen($line[3]) < 24)
		$email = $line[3];
	else
		$email = substr($line[3], 0, 21)."...";

	echo "
	<tr>
		<td align=\"right\">$line[0]</td>
		<td align=\"left\">$line[1]</td>
		<td align=\"center\">$line[2]</td>
		<td align=\"left\"><span title=\"$line[3]\">$email</span></td>
		<td align=\"center\">$line[4]</td>
		<td align=\"left\">$line[5]</td>
		<td align=\"center\">$ban</td>
		<td align=\"center\">
		<span title=\"Edit\" onClick=\"return LINK_ajax('adminaccedit.php?id=$line[0]&back=$back','accounts_div');\">Edit</span></td>
		<td align=\"center\">
		<span title=\"View Chars\" onClick=\"return LINK_ajax('adminaccchars.php?id=$line[0]&back=$back','accounts_div');\">Chars</span></td>
		<td align=\"center\">
		<span title=\"Ban, Block, Unban or Unblock\" onClick=\"return LINK_ajax('adminaccban.php?id=$line[0]&back=$back','accounts_div');\">Ban/Unban</span></td>
	</tr>
	";
}
echo "</table>";

if ($pages) {
	echo "
	<table><tr>
	<td><span title=\"0\" onClick=\"return LINK_ajax('adminaccounts.php?page=0','accounts_div');\">&lt;&lt;</span></td>";

	for ($i = ($GET_page - 10); $i <= ($GET_page + 10); $i++) {
		if ($i >= 0 && $i != $GET_page && $i <= $pages)
			echo "<td><span title=\"$i\" onClick=\"return LINK_ajax('adminaccounts.php?page=$i','accounts_div');\">$i</span></td>";
		else if ($i == $GET_page)
			echo "<td>$i</td>";
	}

	echo "
	<td><span title=\"$pages\" onClick=\"return LINK_ajax('adminaccounts.php?page=$pages','accounts_div');\">&gt;&gt;</span></td>
	</tr></table>";
}


if (isset($begin)) {
	echo "</div>";
	closetable();
}

ending();
?>
