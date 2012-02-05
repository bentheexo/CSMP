<?php

	$ctr1 = 0;
	$sql = mysql_query("SELECT * FROM vote_point",$con);
	while($row = mysql_fetch_array($sql)){
		$theaccountID[$ctr1] = $row["account_id"];
		$thepoints[$ctr1] = $row["point"];
		$thelastvote1[$ctr1] = $row["last_vote1"];
		$thelastvote2[$ctr1] = $row["last_vote2"];
		$thelastvote3[$ctr1] = $row["last_vote3"];
		$thelastvote4[$ctr1] = $row["last_vote4"];
		$theip[$ctr1] = $row["ip_address"];
		$thedate[$ctr1] = $row["date"];
		$ctr1++;
	}

	$ctr2 = 0;
	$sql1 = mysql_query("SELECT * FROM login",$con);
	while($row1 = mysql_fetch_array($sql1)){
		$arrayUSERID[$ctr2] = $row1["userid"];
		$ctr2++;
	}

	$ctr3 = 0;
	$sql2 = mysql_query("SELECT account_id FROM login WHERE userid='$user'");
	
	while($row2 = mysql_fetch_array($sql2)){
		$arrayAccountId[$ctr3] = $row2["account_id"];
		$accountid = $row2["account_id"];
		$ctr3++;
		}

	$ctr4 = 0;
	$sql3 = mysql_query("SELECT point,lastvisit FROM vote_point WHERE account_id='$accountid'");
	while($row4 = mysql_fetch_array($sql3)){
		$arrayPOINTS[$ctr4] = $row4["point"];
		$lastvisit = $row4["lastvisit"];
		$points = $arrayPOINTS[$ctr4];
		$ctr4++;
	}

	$ctr5 = 0;
	$sql4 = mysql_query("SELECT * FROM vote_point",$con);
	while($row3 = mysql_fetch_array($sql4)){
		$verifyAccountId[$ctr5] = $row3["account_id"];
		$ctr5++;
	}
?>