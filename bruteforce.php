<?php
include_once 'config.php'; // loads config variables
include_once 'functions.php';

DEFINE('BF_IP', "SELECT `ban`, `user` FROM `cp_bruteforce` WHERE `IP` = '%s' AND (`date` > '%d' OR `ban` > '%d')");
DEFINE('BF_USER', "SELECT `ban` FROM `cp_bruteforce` WHERE `user` = '%s' AND (`date` > '%d' OR `ban` > '%d')");
DEFINE('BF_ADD', "INSERT INTO `cp_bruteforce` (`user`, `IP`, `date`, `ban`) VALUES('%s', '%s', '%d', '%d')");


function bf_check_user($username) {
	$log_ip = $_SERVER['REMOTE_ADDR'];
	$current = time();
	
	$query = sprintf(BF_IP, $log_ip, $current - 300, $current);
	$result = execute_query($query, "check_user", 1, 0);
	$tentativas = $result->count();
	while ($line = $result->fetch_row()) {
		if ($line[0] > $current)
			return (int)(($line[0] - $current) / 60);
	}
	$result->free();

	if ($tentativas > 9) {
		$query = sprintf(BF_ADD, "Random Try", $log_ip, $current, $current + 600);
		$result = execute_query($query, "check_user", 1, 0);
		return (int)(600 / 60);
	}

	if (inject($username))
		return 0;

	$query = sprintf(BF_USER, $username, $current - 300, $current);
	$result = execute_query($query, "check_user", 1, 0);
	$tentativas = $result->count();
	while ($line = $result->fetch_row()) {
		if ($line[0] > $current)
			return (int)(($line[0] - $current) / 60);
	}
	$result->free();

	if ($tentativas > 2) {
		$query = sprintf(BF_ADD, $username, $log_ip, $current, $current + 300);
		$result = execute_query($query, "check_user", 1, 0);
		return (int)(300 / 60);
	}
	
	return 0;
}

function bf_error($username) {
	$log_ip = $_SERVER['REMOTE_ADDR'];
	$current = time();

	$query = sprintf(BF_ADD, $username, $log_ip, $current, 0);
	$result = execute_query($query, "check_user", 1, 0);
	return 1;
}

?>
