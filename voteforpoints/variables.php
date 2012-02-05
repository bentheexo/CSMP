<?php
$ip= $_SERVER['REMOTE_ADDR'];

$theaccountID = array();
$thepoints = array();
$thelastvote1 = array();
$thelastvote2 = array();
$thelastvote3 = array();
$thelastvote4 = array();
$theip = array();
$thedate = array();
$arrayUSERID = array();
$arrayAccountId = array();
$verifyAccountId = array();
$arrayPOINTS = array();
$verifyACCOUNTID = 0;
$accountid=0;
$offset=(8*60*60);
settype($user,"String");
$defaultip = settype($ip,"String");

	$offset=(8*60*60); //converting 8 hours to seconds.
	$dt = time();
	$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S", $dt+$offset);
//	$rtime = settype($mysql_datetime,"String");
?>