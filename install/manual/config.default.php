<?php
//sql connections
$CONFIG['rag_serv']		=	'localhost';	// SQL Ragnarok Host
$CONFIG['rag_user']		=	'ragnarok';		// SQL Ragnarok User
$CONFIG['rag_pass']		=	'ragnarok';		// SQL Ragnarok Password
$CONFIG['rag_db']			=	'ragnarok';		// SQL Ragnarok Database name
$CONFIG['log_db']			=	'log';		// SQL Ragnarok Log Database name

$CONFIG['cp_serv']		=	'localhost';	// SQL CP Host
$CONFIG['cp_user']		=	'ragnarok';		// SQL CP User
$CONFIG['cp_pass']		=	'ragnarok';		// SQL CP Password
$CONFIG['cp_db']			=	'cp';			// SQL CP Database name

$CONFIG['md5_pass']		=	'0';			// Use MD5 password (enable = 1, disable = 0)
$CONFIG['safe_pass']		=	'1';			// Force the use of a safer password with size 6 and at least 2 letter and 2 numbers (enable = 1, disable = 0)

//Optional Configurations
$CONFIG['sendmail']		=	'1';			// Allow use of the Character Mailing System (enable = 1, disable = 0)
$CONFIG['v4p']			=	'1';			// Allow the use of the Vote 4 Points Script (enable = 1, disable = 0)
$CONFIG['VOTE_TIME']	=	'24'; 
define ('VOTE_LINK', serialize (array ( 
                                        1 => 'http://www.voteseite1.com?id=123456', 
                                        2 => 'http://www.voteseite2.com?id=123456', 
                                        3 => 'http://www.voteseite3.com?id=123456' 
                            )) 
        );
$CONFIG['mypaypalemail']	=	'test@test.com';	//Put your PayPal Email Address here

//Admin Area
$CONFIG['cp_admin']		=	'99';			// CP admin functions
$CONFIG['gm_level']		=	'70';			// CP GM funtions
$CONFIG['gm_hide']		=	'40';			// GMs this level and above will be hidden from whoisonline.php

//WOE
// sun = sunday, mon = monday, tue = tuesday, wed = wednesday, thu = thursday, fri = friday, sun = sunday
// place week_day(start_time, end_time) and a ';' between the times the freya default woe times is set as an example
// there is no limit you can place as many as you want, no spaces are needed, but using it you can understand.
$CONFIG['woe_time']		=	'tue(2100, 2300); sat(1600, 1800); ';
$CONFIG['agit_check']		=	'0';			// This WILL NOT WORK unless you installed the npc script AND you updated your ragsrvinfo table, read the installation notes for more info.

//server name, rates
$CONFIG['name']			=	'CSMP';	// name of the server
$CONFIG['rate']			=	'1/1/1';		// rates of the server
date_default_timezone_set('America/New_York');		// game server Timezone (useful if your webserver's timezone is different than game server).
$CONFIG['dynamic_info']		=	'0';			// Use info (rates) from the server itself?
$CONFIG['dynamic_name']		=	'CSMP';	// The name of the server in ragsrvinfo's server name column (Used for dynamic info)
$CONFIG['show_rates']		=	'0';			// Show rates below server status?

//map,char,login servers settings
$CONFIG['accip']			=	'127.0.0.1';	// Account/Login Server IP
$CONFIG['accport']		=	'6900';		// Account/Login Server Port
$CONFIG['charip']			=	'127.0.0.1';	// Char Server IP
$CONFIG['charport']		=	'6121';		// Char Server Port
$CONFIG['mapip']			=	'127.0.0.1';	// Zone/Map Server IP
$CONFIG['mapport']		=	'5121';		// Zone/Map Server Port

//default language
$CONFIG['language']		=	'English';		// default language (remember to check if the translation exist before set)

//cp features
$CONFIG['disable_account']	=	'0';			// disable the account creation disable = 1, enable = 0
$CONFIG['auth_image']		=	'1';			// enable the verification code image, to check if it's a real person using the cp, instead of a bot (brute-force atack) - Recommended, but requires gd library (enable = 1 disable = 0)
$CONFIG['max_accounts']		=	'0';			// Max accounts allowed to be in the DB (0 = disabled)
$CONFIG['password_recover']	=	'0';			// password recover enable = 1, disable = 0
$CONFIG['reset_enable']		=	'1';			// reset position enable = 1, disable = 0
$CONFIG['reset_cost']		=	'300';		// reset position cost, disable cost = 0
$CONFIG['money_transfer']	=	'0';			// money transfer enable = 1, disable = 0
$CONFIG['money_cost']		=	'0';			// money transfer cost (100 = 1%), disable cost = 0
$CONFIG['set_slot']		=	'1';			// change char slot enable = 1, disable = 0
$CONFIG['reset_look']		=	'1';			// reset char equips and colors with error enable = 1, disable = 0
$CONFIG['marry_enable']		=	'1';			// enable marriage view and divorce
$CONFIG['prison_map']		=	'sec_pri';		// Name of the map that is used as your jail (mapname.gat)

//About Information
$CONFIG['classlist_show']	=	'1';			// Show the class list on about.php? (disable = 0, enable = 1)

//Mail
$CONFIG['smtp_server']		=	'localhost';	// the smtp server, the cp will use to send mails
$CONFIG['smtp_port']		=	'25';			// the smtp server port
$CONFIG['smtp_mail']		=	'gamemaster@youremail.com';		// the email of the admin
$CONFIG['smtp_username']	=	'';			// the username of the smtp server
$CONFIG['smtp_password']	=	'';			// the password of the smtp server


//DO NOT MESS WITH THIS
extract($CONFIG, EXTR_PREFIX_ALL, "CONFIG");
extract($_GET, EXTR_PREFIX_ALL, "GET");
extract($_POST, EXTR_PREFIX_ALL, "POST");
extract($_SERVER, EXTR_PREFIX_ALL, "SERVER");
error_reporting(0);
?>
