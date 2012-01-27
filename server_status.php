<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

$servers = server_status();
$quantos = moneyformat(online_count());

//Dynamic Info Check [ABOUT_RATES|RATES_AGIT]
if ($CONFIG_dynamic_info || $CONFIG_agit_check) {
	if ($CONFIG_agit_check)
		$query = sprintf(RATES_AGIT,$CONFIG_dynamic_name);
	else
		$query = sprintf(ABOUT_RATES,$CONFIG_dynamic_name);

	$result = execute_query($query, 'server_status.php');
	$line = $result->fetch_row();
	$rate_base = moneyformat($line[0] / 100);
	$rate_job = moneyformat($line[1] / 100);
	$rate_drop = moneyformat($line[2] / 100);
	if(isset($line[3])) {
		if ($line[3] == 1)
			$agit_status = "<font color=\"green\">".$lang['AGIT_ON']."</font>";
		else
			$agit_status = "<font color=\"red\">".$lang['AGIT_OFF']."</font>";
	}
}


opentable($CONFIG_name);

echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
if ($servers & 1) 
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_LOGIN']."&nbsp;</b></td><td> <font color=\"green\">".$lang['SERVERSTATUS_ONLINE']."</font></td></td></tr>";
else 
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_LOGIN']."&nbsp;</b></td><td> <font color=\"red\">".$lang['SERVERSTATUS_OFFLINE']."</font></td></td></tr>";

if ($servers & 2)
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_CHAR']."&nbsp;</b></td><td> <font color=\"green\">".$lang['SERVERSTATUS_ONLINE']."</font></td></td></tr>";
else
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_CHAR']."&nbsp;</b></td><td> <font color=\"red\">".$lang['SERVERSTATUS_OFFLINE']."</font></td></td></tr>";

if ($servers & 4) 
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_MAP']."&nbsp;</b></td><td> <font color=\"green\">".$lang['SERVERSTATUS_ONLINE']."</font></td></td></tr>";
else
	echo "<tr><td align=\"left\"><b>".$lang['SERVERSTATUS_MAP']."&nbsp;</b></td><td> <font color=\"red\">".$lang['SERVERSTATUS_OFFLINE']."</font></td></tr>";

if ($CONFIG_show_rates) {
	if ($CONFIG_dynamic_info)
		echo "<tr><td = align=\"left\"><b>".$lang['ABOUT_RATE']."&nbsp;</b></td><td align=\"right\">".$rate_base."/".$rate_job."/".$rate_drop."</td></tr>";
	else
		echo "<tr><td = align=\"left\"><b>".$lang['ABOUT_RATE']."&nbsp;</b></td><td align=\"right\">$CONFIG_rate</td></tr>";
}

if ($CONFIG_agit_check)
	echo "<tr><td = align=\"left\"><b>".$lang['AGIT']."&nbsp;</b></td><td>".$agit_status."</td></tr>";
if ($quantos)
	echo "<tr><td align=\"right\"><b><span title=\"See who is online\" onClick=\"LINK_ajax('whoisonline.php','main_div');\">".$lang['SERVERSTATUS_USERSONLINE']."&nbsp;</span></b></td><td align=\"right\">$quantos</td></tr>";
else
	echo "<tr><td align=\"right\"><b>".$lang['SERVERSTATUS_USERSONLINE']."&nbsp;</b></td><td align=\"right\">$quantos</td></tr>";

echo "</table>";
closetable();

fim();
?>