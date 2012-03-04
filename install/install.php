<?php
// As of January 1st this project has changed CeresCP for
// my distrobution purposes. I have rewritten major componets
// to fit my needs of the software.

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>
		CSMP Install Script
		</title>
	</head>
	<BODY style="margin-top:0; margin-bottom:0">

<?php
extension_loaded('mysqli')
	or die ("Mysqli extension not loaded. Please verify your PHP configuration.");

if (is_file("../config.php"))
	die("The Installation is complete. Please remove this directory or rename the install folder.");

extract($_POST, EXTR_PREFIX_ALL, "POST");

if (isset($POST_install)) {

	$rag_db = mysqli_connect($POST_sql_rag_host,$POST_sql_rag_user,$POST_sql_rag_pass)
		or die("Can't connect to Ragnarok MySQL server. Press back and check your MySQL host, user, password.");

	mysqli_select_db($rag_db, $POST_sql_rag_db)
		or die("Can't open ".$POST_sql_rag_db." database. Remember to create it before the Control Panel. Press back and check your configurations.");

	$cp_db = mysqli_connect($POST_sql_cp_host,$POST_sql_cp_user,$POST_sql_cp_pass)
		or die("Can't connect to Ragnarok MySQL server. Press back and check your MySQL host, user, password.");

	if (!mysqli_select_db($cp_db, $POST_sql_cp_db)) {
		$query = "CREATE DATABASE ".$POST_sql_cp_db;
		$result = mysqli_query($cp_db, $query)
			or die("Can't open or create ".$POST_sql_cp_db." database, press back and check your configurations.");
		mysqli_select_db($cp_db, $POST_sql_cp_db);
	}

	if ($POST_cp_adm_lvl < $POST_cp_gm_lvl)
		die ("Admin level can't be lower than GM level. Press back and fix it.");

	if ($POST_feat_pr && $POST_sql_md5)
		die ("Password Recovery will not work if MD5 is enabled. Press back and fix it.");

	$woe = "";
	if ($POST_woe_sun_start_h > 0 || $POST_woe_sun_end_h > 0) {
		$woe .= sprintf("sun(%02d%02d, %02d%02d); ", $POST_woe_sun_start_h, $POST_woe_sun_start_m, $POST_woe_sun_end_h, $POST_woe_sun_end_m);
	}
	if ($POST_woe_mon_start_h > 0 || $POST_woe_mon_end_h > 0) {
		$woe .= sprintf("mon(%02d%02d, %02d%02d); ", $POST_woe_mon_start_h, $POST_woe_mon_start_m, $POST_woe_mon_end_h, $POST_woe_mon_end_m);
	}
	if ($POST_woe_tue_start_h > 0 || $POST_woe_tue_end_h > 0) {
		$woe .= sprintf("tue(%02d%02d, %02d%02d); ", $POST_woe_tue_start_h, $POST_woe_tue_start_m, $POST_woe_tue_end_h, $POST_woe_tue_end_m);
	}
	if ($POST_woe_wed_start_h > 0 || $POST_woe_wed_end_h > 0) {
		$woe .= sprintf("wed(%02d%02d, %02d%02d); ", $POST_woe_wed_start_h, $POST_woe_wed_start_m, $POST_woe_wed_end_h, $POST_woe_wed_end_m);
	}
	if ($POST_woe_thu_start_h > 0 || $POST_woe_thu_end_h > 0) {
		$woe .= sprintf("thu(%02d%02d, %02d%02d); ", $POST_woe_thu_start_h, $POST_woe_thu_start_m, $POST_woe_thu_end_h, $POST_woe_thu_end_m);
	}
	if ($POST_woe_fri_start_h > 0 || $POST_woe_fri_end_h > 0) {
		$woe .= sprintf("fri(%02d%02d, %02d%02d); ", $POST_woe_fri_start_h, $POST_woe_fri_start_m, $POST_woe_fri_end_h, $POST_woe_fri_end_m);
	}
	if ($POST_woe_sat_start_h > 0 || $POST_woe_sat_end_h > 0) {
		$woe .= sprintf("sat(%02d%02d, %02d%02d); ", $POST_woe_sat_start_h, $POST_woe_sat_start_m, $POST_woe_sat_end_h, $POST_woe_sat_end_m);
	}

	//create the tables
	$query = "DROP TABLE IF EXISTS `cp_bruteforce`;";
	$result = mysqli_query($cp_db, $query)
		or die("MySQL: This user doesn't have the DROP privilege on the ".$POST_sql_cp_db." database.");

	$query = "CREATE TABLE `cp_bruteforce` (`action_id` int(11) NOT NULL auto_increment, `user` varchar(24) NOT NULL default '', `IP` varchar(20) NOT NULL default '', `date` int(11) NOT NULL default '0', `ban` int(11) NOT NULL default '0', PRIMARY KEY  (`action_id`), KEY `user` (`user`), KEY `IP` (`IP`)) ENGINE=MyISAM AUTO_INCREMENT=1 ;";
	$result = mysqli_query($cp_db, $query)
		or die("MySQL: This user doesn't have the CREATE privilege on the ".$POST_sql_cp_db." database.");

	$query = "DROP TABLE IF EXISTS `cp_links`;";
	$result = mysqli_query($cp_db, $query);

	$query = "CREATE TABLE `cp_links` (`cod` int(11) NOT NULL auto_increment, `name` varchar(30) NOT NULL, `url` varchar(255) NOT NULL, `desc` text NOT NULL, `size` int(11) default '0', PRIMARY KEY  (`cod`) ) ENGINE=MyISAM AUTO_INCREMENT=1 ;";
	$result = mysqli_query($cp_db, $query);

	$query = "DROP TABLE IF EXISTS `cp_querylog`;";
	$result = mysqli_query($cp_db, $query);

	$query = "CREATE TABLE `cp_querylog` (`action_id` int(11) NOT NULL auto_increment, `Date` datetime NOT NULL default '0000-00-00 00:00:00', `User` varchar(24) NOT NULL default '', `IP` varchar(20) NOT NULL default '', `page` varchar(24) NOT NULL default '', `query` text NOT NULL,   PRIMARY KEY  (`action_id`), KEY `action_id` (`action_id`) ) ENGINE=MyISAM AUTO_INCREMENT=1 ;";
	$result = mysqli_query($cp_db, $query);

	$query = "DROP TABLE IF EXISTS `cp_server_status`;";
	$result = mysqli_query($cp_db, $query);

	$query = "CREATE TABLE `cp_server_status` (`last_checked` datetime NOT NULL default '0000-00-00 00:00:00', `status` tinyint(1) NOT NULL default '0') ENGINE=MyISAM;";
	$result = mysqli_query($cp_db, $query);
	
	$query = "DROP TABLE IF EXISTS `vote_point`;";
	$result = mysqli_query($rag_db, $query);

	$query = "CREATE TABLE `vote_point` (`account_id` int(11) NOT NULL default '0',`point` int(11) NOT NULL default '0',`last_vote1` int(11) NOT NULL default '0',`last_vote2` int(11) NOT NULL default '0',`last_vote3` int(11) NOT NULL default '0',`date` text NOT NULL,PRIMARY KEY  (`account_id`)) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$result = mysqli_query($rag_db, $query);
	
	$query = "DROP TABLE IF EXSISTS `dc_comments`;";
	$result = mysqli_query($rag_db, $query);
	
	$query = "CREATE TABLE IF NOT EXISTS `dc_comments` ( `id` int(10) unsigned NOT NULL auto_increment, `transaction_id` varchar(64) collate utf8_unicode_ci NOT NULL default '', `name` varchar(128) collate utf8_unicode_ci NOT NULL default '', `amount` varchar(255) collate utf8_unicode_ci NOT NULL default '', `account_id` int(11) NOT NULL, `dt` timestamp NOT NULL default CURRENT_TIMESTAMP, PRIMARY KEY  (`id`), UNIQUE KEY `transaction_id` (`transaction_id`) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	$result = mysqli_query($rag_db, $query);
	
	$query = "DROP TABLE IF EXSISTS `dc_donations`;";
	$result = mysqli_query($rag_db, $query);
	
	$query = "CREATE TABLE IF NOT EXISTS `dc_donations` ( `transaction_id` varchar(64) collate utf8_unicode_ci NOT NULL default '', `donor_email` varchar(255) collate utf8_unicode_ci NOT NULL default '', `amount` double NOT NULL default '0', `account_id` int(11) NOT NULL, `original_request` text collate utf8_unicode_ci NOT NULL`dt` timestamp NOT NULL default CURRENT_TIMESTAMP, PRIMARY KEY  (`transaction_id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	$result = mysqli_query($rag_db, $query);
	
	$query = "DROP TABLE IF EXSISTS `dc_subscription`;";
	$result = mysqli_query($rag_db, $query);
	
	$query = "CREATE TABLE IF NOT EXISTS `dc_Subscription` ( `transaction_id` varchar(64) collate utf8_unicode_ci NOT NULL default '', `donor_email` varchar(255) collate utf8_unicode_ci NOT NULL default '', `amount` varchar(255) collate utf8_unicode_ci NOT NULL default '', `account_id` int(11) NOT NULL, `original_request` text collate utf8_unicode_ci NOT NULL, `dt` timestamp NOT NULL default CURRENT_TIMESTAMP, PRIMARY KEY  (`transaction_id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
	$result = mysqli_query($rag_db, $query);
	
	$query = "DROP TABLE IF EXSISTS `cash_points`;";
	$result = mysqli_query($rag_db, $query);
	
	$query = "CREATE TABLE IF NOT EXISTS `cash_points` ( `account_id` int(11) NOT NULL, `points_to_add` int(11) NOT NULL DEFAULT '0', UNIQUE KEY `account_id` (`account_id`))";
	$result = mysqli_query($rag_db, $query);
	
	if ($POST_woe_agit) {
		$query = "DROP TABLE IF EXISTS `ragsrvinfo`;";
		$result = mysqli_query($rag_db, $query)
			or die("MySQL: This user doesn't have the DROP privilege on the ".$POST_sql_rag_db." database.");

		$query = "CREATE TABLE IF NOT EXISTS `ragsrvinfo` (`index` int(11) NOT NULL default '0', `name` varchar(255) NOT NULL default '', `exp` int(11) unsigned NOT NULL default '0', `jexp` int(11) unsigned NOT NULL default '0', `drop` int(11) unsigned NOT NULL default '0', `agit_status` tinyint(1) unsigned NOT NULL default '0', `motd` varchar(255) NOT NULL default '', KEY `name` (`name`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$result = mysqli_query($rag_db, $query)
			or die("MySQL: This user doesn't have the CREATE privilege on the ".$POST_sql_rag_db." database.");
	}


	//write the config.php file
	$buffer = "<?php\n";
	$buffer .= "//sql connections\n";
	$buffer .= "\$CONFIG['rag_serv']		=	'".$POST_sql_rag_host."';	// SQL Ragnarok Host\n";
	$buffer .= "\$CONFIG['rag_user']		=	'".$POST_sql_rag_user."';		// SQL Ragnarok User\n";
	$buffer .= "\$CONFIG['rag_pass']		=	'".$POST_sql_rag_pass."';		// SQL Ragnarok Password\n";
	$buffer .= "\$CONFIG['rag_db']			=	'".$POST_sql_rag_db."';		// SQL Ragnarok Database name\n";
	$buffer .= "\$CONFIG['log_db']			=	'".$POST_sql_log_db."';		// SQL Ragnarok Log Database name\n";
	$buffer .= "\n";
	$buffer .= "\$CONFIG['cp_serv']		=	'".$POST_sql_cp_host."';	// SQL CP Host\n";
	$buffer .= "\$CONFIG['cp_user']		=	'".$POST_sql_cp_user."';		// SQL CP User\n";
	$buffer .= "\$CONFIG['cp_pass']		=	'".$POST_sql_cp_pass."';		// SQL CP Password\n";
	$buffer .= "\$CONFIG['cp_db']			=	'".$POST_sql_cp_db."';			// SQL CP Database name\n";
	$buffer .= "\n";
	$buffer .= "\$CONFIG['md5_pass']		=	'".$POST_sql_md5."';			// Use MD5 password (enable = 1, disable = 0)\n";
	$buffer .= "\$CONFIG['safe_pass']		=	'".$POST_sql_safe_pass."';			// Force the use of a safer password with size 6 and at least 2 letter and 2 numbers (enable = 1, disable = 0)\n";
	$buffer .= "\n";
	$buffer .= "//Optional Configurations\n";
	$buffer .= "\$CONFIG['sendmail']		=	'".$POST_sendmail."';			// Allow use of the Character Mailing System (enable = 1, disable = 0)\n";
	$buffer .= "\$CONFIG['v4p']		=	'".$POST_v4p."';			// Allow use of the Character Mailing System (enable = 1, disable = 0)\n";
	$buffer .= "\$CONFIG['VOTE_TIME']	=	'".$POST_VOTE_TIME."';	// Standard Vote Time\n";
	$buffer .= "define ('VOTE_LINK', serialize (array ( 
                                        1 => '".$POST_vote_link_1"', 
                                        2 => '".$POST_vote_link_2"',
                                        3 => '".$POST_vote_link_3"' 
                            )) 
        );";
	$buffer .= "\$CONFIG['donations']		=	'".$POST_donations."';			// Allow use of the Donation System (enable = 1, disable = 0)\n";
	$buffer .= "\$CONFIG['mypaypalemail']		=	'".$POST_mypaypalemail."';			// Paypal Email Address\n";
	$buffer .= "\n";
	$buffer .= "//Admin Area\n";
	$buffer .= "\$CONFIG['cp_admin']		=	'".$POST_cp_adm_lvl."';			// CP admin functions\n";
	$buffer .= "\$CONFIG['gm_level']		=	'".$POST_cp_gm_lvl."';			// CP GM funtions\n";
	$buffer .= "\$CONFIG['gm_hide']		=	'".$POST_cp_hide_lvl."';			// GMs this level and above will be hidden from whoisonline.php\n";
	$buffer .= "\n";
	$buffer .= "//WOE\n";
	$buffer .= "// sun = sunday, mon = monday, tue = tuesday, wed = wednesday, thu = thursday, fri = friday, sun = sunday\n";
	$buffer .= "// place week_day(start_time, end_time) and a ';' between the times the freya default woe times is set as an example\n";
	$buffer .= "// there is no limit you can place as many as you want, no spaces are needed, but using it you can understand.\n";
	$buffer .= "\$CONFIG['woe_time']		=	'".$woe."';\n";
	$buffer .= "\$CONFIG['agit_check']		=	'".$POST_woe_agit."';			// This WILL NOT WORK unless you installed the npc script AND you updated your ragsrvinfo table, read the installation notes for more info.\n";
	$buffer .= "\n";
	$buffer .= "//server name, rates\n";
	$buffer .= "\$CONFIG['name']			=	'".$POST_server_name."';	// name of the server\n";
	$buffer .= "\$CONFIG['rate']			=	'".$POST_server_rate."';		// rates of the server\n";
	$buffer .= "date_default_timezone_set('".$POST_timezone."');		// game server Timezone (useful if your webserver's timezone is different than game server).\n";
	$buffer .= "\$CONFIG['dynamic_info']		=	'".$POST_server_di."';			// Use info (rates) from the server itself?\n";
	$buffer .= "\$CONFIG['dynamic_name']		=	'".$POST_server_name."';	// The name of the server in ragsrvinfo's server name column (Used for dynamic info)\n";
	$buffer .= "\$CONFIG['show_rates']		=	'".$POST_server_dr."';			// Show rates below server status?\n";
	$buffer .= "\n";
	$buffer .= "//map,char,login servers settings\n";
	$buffer .= "\$CONFIG['accip']			=	'".$POST_server_lip."';	// Account/Login Server IP\n";
	$buffer .= "\$CONFIG['accport']		=	'".$POST_server_lport."';		// Account/Login Server Port\n";
	$buffer .= "\$CONFIG['charip']			=	'".$POST_server_cip."';	// Char Server IP\n";
	$buffer .= "\$CONFIG['charport']		=	'".$POST_server_cport."';		// Char Server Port\n";
	$buffer .= "\$CONFIG['mapip']			=	'".$POST_server_mip."';	// Zone/Map Server IP\n";
	$buffer .= "\$CONFIG['mapport']		=	'".$POST_server_mport."';		// Zone/Map Server Port\n";
	$buffer .= "\n";
	$buffer .= "//default language\n";
	$buffer .= "\$CONFIG['language']		=	'".$POST_cp_language."';		// default language (remember to check if the translation exist before set)\n";
	$buffer .= "\n";
	$buffer .= "//cp features\n";
	$buffer .= "\$CONFIG['disable_account']	=	'".$POST_feat_acc."';			// disable the account creation disable = 1, enable = 0\n";
	$buffer .= "\$CONFIG['auth_image']		=	'".$POST_feat_vc."';			// enable the verification code image, to check if it's a real person using the cp, instead of a bot (brute-force atack) - Recommended, but requires gd library (enable = 1 disable = 0)\n";
	$buffer .= "\$CONFIG['max_accounts']		=	'".$POST_feat_maa."';			// Max accounts allowed to be in the DB (0 = disabled)\n";
	$buffer .= "\$CONFIG['password_recover']	=	'".$POST_feat_pr."';			// password recover enable = 1, disable = 0\n";
	$buffer .= "\$CONFIG['reset_enable']		=	'".$POST_feat_rp."';			// reset position enable = 1, disable = 0\n";
	$buffer .= "\$CONFIG['reset_cost']		=	'".$POST_feat_rc."';		// reset position cost, disable cost = 0\n";
	$buffer .= "\$CONFIG['money_transfer']	=	'".$POST_feat_mt."';			// money transfer enable = 1, disable = 0\n";
	$buffer .= "\$CONFIG['money_cost']		=	'".$POST_feat_mc."';			// money transfer cost (100 = 1%), disable cost = 0\n";
	$buffer .= "\$CONFIG['set_slot']		=	'".$POST_feat_cs."';			// change char slot enable = 1, disable = 0\n";
	$buffer .= "\$CONFIG['reset_look']		=	'".$POST_feat_rl."';			// reset char equips and colors with error enable = 1, disable = 0\n";
	$buffer .= "\$CONFIG['marry_enable']		=	'".$POST_feat_divorce."';			// enable marriage view and divorce\n";
	$buffer .= "\$CONFIG['prison_map']		=	'".$POST_feat_pm."';		// Name of the map that is used as your jail (mapname.gat)\n";
	$buffer .= "\n";
	$buffer .= "//About Information\n";
	$buffer .= "\$CONFIG['classlist_show']	=	'".$POST_feat_acl."';			// Show the class list on about.php? (disable = 0, enable = 1)\n";
	$buffer .= "\n";
	$buffer .= "//Mail\n";
	$buffer .= "\$CONFIG['smtp_server']		=	'".$POST_smtp_server."';	// the smtp server, the cp will use to send mails\n";
	$buffer .= "\$CONFIG['smtp_port']		=	'".$POST_smtp_port."';			// the smtp server port\n";
	$buffer .= "\$CONFIG['smtp_mail']		=	'".$POST_smtp_mail."';		// the email of the admin\n";
	$buffer .= "\$CONFIG['smtp_username']	=	'".$POST_smtp_username."';			// the username of the smtp server\n";
	$buffer .= "\$CONFIG['smtp_password']	=	'".$POST_smtp_password."';			// the password of the smtp server\n";
	$buffer .= "\n";
	$buffer .= "\n";
	$buffer .= "//DO NOT MESS WITH THIS\n";
	$buffer .= "extract(\$CONFIG, EXTR_PREFIX_ALL, \"CONFIG\");\n";
	$buffer .= "extract(\$_GET, EXTR_PREFIX_ALL, \"GET\");\n";
	$buffer .= "extract(\$_POST, EXTR_PREFIX_ALL, \"POST\");\n";
	$buffer .= "extract(\$_SERVER, EXTR_PREFIX_ALL, \"SERVER\");\n";
	$buffer .= "error_reporting(0);\n";
	$buffer .= "?>\n";

	$handle = fopen ("../config.php", "w")
		or die("Can't create config.php. Check your permissions and press back.");
	fwrite($handle, $buffer);
	fclose($handle);

	echo "Installation Complete. Delete the install folder.\n";
	if ($POST_woe_agit)
		echo "<br>Agit Status: Copy ./install/npc/agit_status.txt to your rag npc folder and enable it.\n";
	echo "</body></html>";
	die();
}

$langdir = opendir ("../language/");
while ($file = readdir($langdir)) {
	if (substr($file, strlen($file) - 4, 4) == ".php") {
		$file = substr($file, 0, strlen($file) - 4);
		if (strcmp($file, "index") != 0 && strcmp($file, "language") != 0)
			$idiom[] = $file;
	}
}
closedir($langdir);

?>
		<form action="./install.php" method="post">
			<center><table border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<th height="28" style="font-size: 36px; font-weight: bold; color: #000000;">CSMP Install Script</th>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>Control Panel Language</b></legend>
								<table border="0" width="400">
									<tr>
										<td width="185" align="left">Default Language</td>
										<td align="left"><select name="cp_language">
<?php
for ($i = 0; isset($idiom[$i]); $i++) {
	if (strcmp("English", $idiom[$i]) === 0)
		echo "<option selected value=\"$idiom[$i]\">$idiom[$i]</option>"; 
	else
		echo "<option value=\"$idiom[$i]\">$idiom[$i]</option>";
}
?>
										</select></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>MySQL Settings</b></legend>
								<table border="0" width="400">
									<tr>
										<td width="200" align="left"><span title="MySQL host adress">Ragnarok Host</span></td>
										<td align="left"><input type="text" name="sql_rag_host" size="30" value="localhost"></td>
									</tr>
									<tr>
										<td align="left">Ragnarok User</td>
										<td align="left"><input type="text" name="sql_rag_user" size="30" value="ragnarok"></td>
									</tr>
									<tr>
										<td align="left">Ragnarok Password</td>
										<td align="left"><input type="text" name="sql_rag_pass" size="30" value="ragnarok"></td>
									</tr>
									<tr>
										<td align="left">Ragnarok DB</td>
										<td align="left"><input type="text" name="sql_rag_db" size="30" value="ragnarok"></td>
									</tr>
									<tr>
										<td align="left">Ragnarok Log DB</td>
										<td align="left"><input type="text" name="sql_log_db" size="30" value="log"></td>
									</tr>
									<tr>
										<td width="200" align="left"><span title="MySQL host adress">CSMP Host</span></td>
										<td align="left"><input type="text" name="sql_cp_host" size="30" value="localhost"></td>
									</tr>
									<tr>
										<td align="left">CSMP User</td>
										<td align="left"><input type="text" name="sql_cp_user" size="30" value="ragnarok"></td>
									</tr>
									<tr>
										<td align="left">CSMP Password</td>
										<td align="left"><input type="text" name="sql_cp_pass" size="30" value="ragnarok"></td>
									</tr>
									<tr>
										<td align="left">CSMP DB</td>
										<td align="left"><input type="text" name="sql_cp_db" size="30" value="cp"></td>
									</tr>
									<tr>
										<td align="left">MD5 Pass</td>
										<td align="left"><select name="sql_md5"><option selected value="0">No</option><option value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Safe Pass</td>
										<td align="left"><select name="sql_safe_pass"><option value="0">No</option><option selected value="1">Yes</option></select></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>Optional Configurations</b></legend>
								<table>
									<tr>
										<td align="left">Character Mailer</td>
										<td align="left"><select name="sendmail"><option selected value="0">No</option><option value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Vote For Points</td>
										<td align="left"><select name="v4p"><option selected value="0">No</option><option value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Vote For Points Wait Time</td>
										<td align="left"><input type="text" name="VOTE_TIME" size="3" value="24"></td>
									</tr>
									<tr>
										<td align="left">Vote For Points Link 1</td>
										<td align="left"><input type="text" name="vote_link_3" size="50" value="http://gtop100.com"></td>
									</tr>
									<tr>
										<td align="left">Vote For Points Link 2</td>
										<td align="left"><input type="text" name="vote_link_3" size="50" value="http://xtremetop100.com"></td>
									</tr>
									<tr>
										<td align="left">Vote For Points Link 3</td>
										<td align="left"><input type="text" name="vote_link_3" size="50" value="http://mmorpg100.com"></td>
									</tr>
									<tr>
										<td align="left">Donations</td>
										<td align="left"><select name="sendmail"><option selected value="0">No</option><option value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Donations Paypal Email</td>
										<td align="left"><input type="text" name="mypaypalemail" size="30" value="paypalemail@your-ro.com"></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>Control Panel Admin Access</b></legend>
								<table border="0" width="400">
									<tr>
										<td width="200" align="left">Admin Level</td>
										<td align="left"><input type="text" name="cp_adm_lvl" maxlength="2" size="30" value="99"></td>
									</tr>
									<tr>
										<td align="left">GM Level</td>
										<td align="left"><input type="text" name="cp_gm_lvl" maxlength="2" size="30" value="70"></td>
									</tr>
									<tr>
										<td align="left">Hide from whoisonline.php</td>
										<td align="left"><input type="text" name="cp_hide_lvl" maxlength="3" size="5" value="40"> (min GM level)</td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>Server Info Settings</b></legend>
								<table border="0" width="400">
									<tr>
										<td width="200" align="left">Name</td>
										<td align="left"><input type="text" name="server_name" size="30" value="CSMP"></td>
									</tr>
									<tr>
										<td align="left">Rate</td>
										<td align="left"><input type="text" name="server_rate" size="30" value="1/1/1"></td>
									</tr>
									<tr>
										<td align="left"><a href="http://www.php.net/timezones" target="_blank">Time Zone</a></td>
										<td align="left"><input type="text" name="timezone" size="30" value="America/New_York"></td>
									</tr>
									<tr>
										<td align="left">Dynamic Info</td>
										<td align="left"><select name="server_di"><option selected value="0">No</option><option value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Show Rates</td>
										<td align="left"><select name="server_dr"><option selected value="0">No</option><option value="1">Yes</option></select></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>Server Status Settings</b></legend>
								<table border="0" width="400">
									<tr>
										<td width="200" align="left">Login IP</td>
										<td><input type="text" name="server_lip" size="30" value="127.0.0.1"></td>
									</tr>
									<tr>
										<td align="left">Login Port</td>
										<td align="left"><input type="text" name="server_lport" size="30" value="6900"></td>
									</tr>
									<tr>
										<td align="left">Char IP</td>
										<td align="left"><input type="text" name="server_cip" size="30" value="127.0.0.1"></td>
									</tr>
									<tr>
										<td align="left">Char Port</td>
										<td align="left"><input type="text" name="server_cport" size="30" value="6121"></td>
									</tr>
									<tr>
										<td align="left">Map IP</td>
										<td align="left"><input type="text" name="server_mip" size="30" value="127.0.0.1"></td>
									</tr>
									<tr>
										<td align="left">Map Port</td>
										<td align="left"><input type="text" name="server_mport" size="30" value="5121"></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>WoE Settings</b></legend>
								<table border="0" width="400">
									<tr>
										<td width="190" align="left">Weekday</td>
										<td align="left">Start</td>
										<td align="left">Stop</td>
									<tr>
										<td align="left">Sunday</td>
										<td align="left"><input type="text" name="woe_sun_start_h" maxlength="2" size="2" value="00">:
										<input type="text" name="woe_sun_start_m" maxlength="2" size="2" value="00"></td>
										<td align="left"><input type="text" name="woe_sun_end_h" maxlength="2" size="2" value="00">:
										<input type="text" name="woe_sun_end_m" maxlength="2" size="2" value="00"></td>
									</tr>
									<tr>
										<td align="left">Monday</td>
										<td align="left"><input type="text" name="woe_mon_start_h" maxlength="2" size="2" value="00">:
										<input type="text" name="woe_mon_start_m" maxlength="2" size="2" value="00"></td>
										<td align="left"><input type="text" name="woe_mon_end_h" maxlength="2" size="2" value="00">:
										<input type="text" name="woe_mon_end_m" maxlength="2" size="2" value="00"></td>
									</tr>
									<tr>
										<td align="left">Tuesday</td>
										<td align="left"><input type="text" name="woe_tue_start_h" maxlength="2" size="2" value="21">:
										<input type="text" name="woe_tue_start_m" maxlength="2" size="2" value="00"></td>
										<td align="left"><input type="text" name="woe_tue_end_h" maxlength="2" size="2" value="23">:
										<input type="text" name="woe_tue_end_m" maxlength="2" size="2" value="00"></td>
									</tr>
									<tr>
										<td align="left">Wednesday</td>
										<td align="left"><input type="text" name="woe_wed_start_h" maxlength="2" size="2" value="00">:
										<input type="text" name="woe_wed_start_m" maxlength="2" size="2" value="00"></td>
										<td align="left"><input type="text" name="woe_wed_end_h" maxlength="2" size="2" value="00">:
										<input type="text" name="woe_wed_end_m" maxlength="2" size="2" value="00"></td>
									</tr>
									<tr>
										<td align="left">Thursday</td>
										<td align="left"><input type="text" name="woe_thu_start_h" maxlength="2" size="2" value="00">:
										<input type="text" name="woe_thu_start_m" maxlength="2" size="2" value="00"></td>
										<td align="left"><input type="text" name="woe_thu_end_h" maxlength="2" size="2" value="00">:
										<input type="text" name="woe_thu_end_m" maxlength="2" size="2" value="00"></td>
									</tr>
									<tr>
										<td align="left">Friday</td>
										<td align="left"><input type="text" name="woe_fri_start_h" maxlength="2" size="2" value="00">:
										<input type="text" name="woe_fri_start_m" maxlength="2" size="2" value="00"></td>
										<td align="left"><input type="text" name="woe_fri_end_h" maxlength="2" size="2" value="00">:
										<input type="text" name="woe_fri_end_m" maxlength="2" size="2" value="00"></td>
									</tr>
									<tr>
										<td align="left">Saturday</td>
										<td align="left"><input type="text" name="woe_sat_start_h" maxlength="2" size="2" value="16">:
										<input type="text" name="woe_sat_start_m" maxlength="2" size="2" value="00"></td>
										<td align="left"><input type="text" name="woe_sat_end_h" maxlength="2" size="2" value="18">:
										<input type="text" name="woe_sat_end_m" maxlength="2" size="2" value="00"></td>
									</tr>
									<tr>
										<td align="left">WoE Status</td>
										<td align="left"><select name="woe_agit"><option selected value="0">No</option><option value="1">Yes</option></select></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>Control Panel Features</b></legend>
								<table border="0" width="400">
									<tr>
										<td width="200" align="left">Disable Account Creation</td>
										<td align="left"><select name="feat_acc"><option selected value="0">No</option><option value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Verification Code</td>
										<td align="left"><select name="feat_vc"><option value="0">No</option><option  selected value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Max Accounts Allowed</td>
										<td align="left"><input type="text" name="feat_maa" size="30" value="0"></td>
									</tr>
									<tr>
										<td align="left">About Class List</td>
										<td align="left"><select name="feat_acl"><option value="0">No</option><option  selected value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Password Recover</td>
										<td align="left"><select name="feat_pr"><option selected value="0">No</option><option value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Reset Position</td>
										<td align="left"><select name="feat_rp"><option value="0">No</option><option selected 			value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Reset Position Cost</td>
										<td align="left"><input type="text" name="feat_rc" size="30" value="300"></td>
									</tr>
									<tr>
										<td align="left">Money Transfer</td>
										<td align="left"><select name="feat_mt"><option selected value="0">No</option><option value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Money Transfer Cost</td>
										<td align="left"><input type="text" name="feat_mc" maxlength="2" size="30" value="0"></td>
									</tr>
									<tr>
										<td align="left">Change Slot</td>
										<td align="left"><select name="feat_cs"><option value="0">No</option><option selected value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Reset Look</td>
										<td align="left"><select name="feat_rl"><option value="0">No</option><option selected value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Divorce</td>
										<td align="left"><select name="feat_divorce"><option value="0">No</option><option selected value="1">Yes</option></select></td>
									</tr>
									<tr>
										<td align="left">Prison Map</td>
										<td align="left"><input type="text" name="feat_pm" size="30" value="sec_pri"></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend><b>Control Panel Mail Send</b></legend>
								<table border="0" width="400">
									<tr>
										<td width="200" align="left">Smtp Server</td>
										<td align="left"><input type="text" name="smtp_server" size="30" value="localhost"></td>
									</tr>
									<tr>
										<td align="left">Smtp Port</td>
										<td align="left"><input type="text" name="smtp_port" size="30" value="25"></td>
									</tr>
									<tr>
										<td align="left">Admin e-Mail</td>
										<td align="left"><input type="text" name="smtp_mail" size="30" value="gamemaster@youremail.com"></td>
									</tr>
									<tr>
										<td align="left">Username</td>
										<td align="left"><input type="text" name="smtp_username" size="30"></td>
									</tr>
									<tr>
										<td align="left">Password</td>
										<td align="left"><input type="text" name="smtp_password" size="30"></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<fieldset>
								<legend></legend>
								<table border="0" width="400">
									<tr>
										<td align="center"><input type="submit" name="install" value="Install"></td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table></center>
		</form>
	</BODY>
</html>
