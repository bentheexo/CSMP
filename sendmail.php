<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

if (!empty($_SESSION[$CONFIG_name.'account_id'])) {
	if ($_SESSION[$CONFIG_name.'account_id'] > 0) {

	opentable("Soon...");
	closetable();

	fim();

	}
}
redir("motd.php", "main_div", $lang['NEED_TO_LOGIN']);
?>
