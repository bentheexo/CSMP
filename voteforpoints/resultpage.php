<?php
include ('connection.php');
$con = mysql_connect ($dbaddress,$dbusername,$dbpassword) or die('Error'. mysql_error());
$dbs = mysql_select_db($dbschema);
	//$value = $_POST['vote1'];
	$user = $_POST['username'];
	$accountid = $_POST['accountid'];
	$STOREpoints = 0;
	$ip = $_POST['ip'];
	$arrayAccountId = array();
	$ctr = 0;
	//(8*60*60) This will convert te time into +8 Timezone Coz I live in PH
	$offset=(8*60*60); //converting 8 hours to seconds.
	$dt = time();
	$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S", $dt+$offset);
	$rtime = $mysql_datetime;
	//(12*60*60) This will determine the expiration time = 12 Hours
	$offsetEXP=(8*60*60)+(12*60*60); //converting 8 hours to seconds.
	$dtexp = time();
	$mysql_blockendedtime = strftime("%Y-%m-%d %H:%M:%S", $dtexp+$offsetEXP);
	$expirationtime = "$mysql_blockendedtime";

//	echo "The Real Time Is: $rtime<br/>";
//	echo $expirationtime."<br/>";

include ('adminstaff.php');
	
	$unixrtime = strtotime($rtime);

	
	echo "<br/>";
	
		$ctr = 0;
		$queryexpirationTimeLastRecord = mysql_query("SELECT blockendedtime,blockendedtime2,blockendedtime3,blockendedtime4,blockendedtime5,blockendedtime6,blockendedtime7,blockendedtime8,blockendedtime9,blockendedtime10,point,lastvisit FROM vote_point WHERE account_id='$accountid'",$con);
		while($row = mysql_fetch_array($queryexpirationTimeLastRecord)){
		$expirationTimeLastRecord = $row["blockendedtime"];
		$expirationTimeLastRecord2 = $row["blockendedtime2"];
		$expirationTimeLastRecord3 = $row["blockendedtime3"];
		$expirationTimeLastRecord4 = $row["blockendedtime4"];
		$expirationTimeLastRecord5 = $row["blockendedtime5"];
		$expirationTimeLastRecord6 = $row["blockendedtime6"];
		$expirationTimeLastRecord7 = $row["blockendedtime7"];
		$expirationTimeLastRecord8 = $row["blockendedtime8"];
		$expirationTimeLastRecord9 = $row["blockendedtime9"];
		$expirationTimeLastRecord10 = $row["blockendedtime10"];
		$lastvisit = $row['lastvisit'];
		$STOREpoints = $row["point"];
		$ctr++;
		}
		
		$ctr2 = 0;
		$STOREtimes =array();
		$STOREtimes2 =array();
		$STOREtimes3 =array();
		$STOREtimes4 =array();
		$STOREtimes5 =array();
		$STOREtimes6 =array();
		$STOREtimes7 =array();
		$STOREtimes8 =array();
		$STOREtimes9 =array();
		$STOREtimes10 =array();
		$STOREip = array();
		$queryexpirationIpTimeLastRecord = mysql_query("SELECT ip_address,blockendedtime,blockendedtime2,blockendedtime3,blockendedtime4,blockendedtime5,blockendedtime6,blockendedtime7,blockendedtime8,blockendedtime9,blockendedtime10 FROM vote_point WHERE ip_address = '$ip'",$con);
		while($row2 = mysql_fetch_array($queryexpirationIpTimeLastRecord)){
		$STOREip[$ctr2] = $row2["ip_address"];
		$STOREtimes[$ctr2] = $row2["blockendedtime"];
		$STOREtimes2[$ctr2] = $row2["blockendedtime2"];
		$STOREtimes3[$ctr2] = $row2["blockendedtime3"];
		$STOREtimes4[$ctr2] = $row2["blockendedtime4"];
		$STOREtimes5[$ctr2] = $row2["blockendedtime5"];
		$STOREtimes6[$ctr2] = $row2["blockendedtime6"];
		$STOREtimes7[$ctr2] = $row2["blockendedtime7"];
		$STOREtimes8[$ctr2] = $row2["blockendedtime8"];
		$STOREtimes9[$ctr2] = $row2["blockendedtime9"];
		$STOREtimes10[$ctr2] = $row2["blockendedtime10"];
		$ctr2++;
		}
		//GETTING THE HIGHEST TIME OF THE BLOCKED IP
		$verifyIP = in_array($ip,$STOREip);
		if($verifyIP == 1)
		{
			$high = $STOREtimes[0];
			$high2 = $STOREtimes2[0];
			$high3 = $STOREtimes3[0];
			$high4 = $STOREtimes4[0];
			$high5 = $STOREtimes5[0];
			$high6 = $STOREtimes6[0];
			$high7 = $STOREtimes7[0];
			$high8 = $STOREtimes8[0];
			$high9 = $STOREtimes9[0];
			$high10 = $STOREtimes10[0];
			for($check = 1 ; $check <$ctr2 ; $check++)
			{
				if($STOREtimes[$check]>$high)
				{
						$high = $STOREtimes[$check];
				}
				if($STOREtimes2[$check]>$high2)
				{
						$high2 = $STOREtimes2[$check];
				}
				if($STOREtimes3[$check]>$high3)
				{
						$high3 = $STOREtimes3[$check];
				}
				if($STOREtimes4[$check]>$high4)
				{
						$high4 = $STOREtimes4[$check];
				}
				if($STOREtimes5[$check]>$high5)
				{
						$high5 = $STOREtimes5[$check];
				}
				if($STOREtimes6[$check]>$high6)
				{
						$high6 = $STOREtimes6[$check];
				}
				if($STOREtimes7[$check]>$high7)
				{
						$high7 = $STOREtimes7[$check];
				}
				if($STOREtimes8[$check]>$high8)
				{
						$high8 = $STOREtimes8[$check];
				}
				if($STOREtimes9[$check]>$high9)
				{
						$high9 = $STOREtimes9[$check];
				}
				if($STOREtimes10[$check]>$high10)
				{
						$high10 = $STOREtimes10[$check];
				}
			}
		}
			$highTimeForIPunix = strtotime($high);
			$highTimeForIPunix2 = strtotime($high2);
			$highTimeForIPunix3 = strtotime($high3);
			$highTimeForIPunix4 = strtotime($high4);		
			$highTimeForIPunix5 = strtotime($high5);		
			$highTimeForIPunix6 = strtotime($high6);		
			$highTimeForIPunix7 = strtotime($high7);		
			$highTimeForIPunix8 = strtotime($high8);		
			$highTimeForIPunix9 = strtotime($high9);		
			$highTimeForIPunix10 = strtotime($high10);		
			
	$lastRecordTimeBlockended = strtotime($expirationTimeLastRecord);
	$lastRecordTimeBlockended2 = strtotime($expirationTimeLastRecord2);
	$lastRecordTimeBlockended3 = strtotime($expirationTimeLastRecord3);
	$lastRecordTimeBlockended4 = strtotime($expirationTimeLastRecord4);
	$lastRecordTimeBlockended5 = strtotime($expirationTimeLastRecord5);
	$lastRecordTimeBlockended6 = strtotime($expirationTimeLastRecord6);
	$lastRecordTimeBlockended7 = strtotime($expirationTimeLastRecord7);
	$lastRecordTimeBlockended8 = strtotime($expirationTimeLastRecord8);
	$lastRecordTimeBlockended9 = strtotime($expirationTimeLastRecord9);
	$lastRecordTimeBlockended10 = strtotime($expirationTimeLastRecord10);

	if(isset($_POST['vote1']))
	{
		include('voteOne.php');
	}
	else if(isset($_POST['vote2']))
	{
		include('voteTwo.php');
	}
	else if(isset($_POST['vote3']))
	{
		include('voteThree.php');
	}
	else if(isset($_POST['vote4']))
	{
		include('voteFour.php');
	}
	else if(isset($_POST['vote5']))
	{
		include('voteFive.php');
	}
	else if(isset($_POST['vote6']))
	{
		include('voteSix.php');
	}
	else if(isset($_POST['vote7']))
	{
		include('voteSeven.php');
	}
	else if(isset($_POST['vote8']))
	{
		include('voteEight.php');
	}
	else if(isset($_POST['vote9']))
	{
		include('voteNine.php');
	}
	else if(isset($_POST['vote10']))
	{
		include('voteTen.php');
	}
	else
	{
			echo "";
	}

?>