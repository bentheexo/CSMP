<html>
	<head><title>Voting Page</title></head>
<body bgcolor="#000000">
<br/>
<br/>
<?php
	function notinDB($offset,$accountid,$con,$defaultip,$ip,$mysql_datetime)
	{
		echo "<br/>";
		echo "<center>Please Wait The Page Will Refreshed</center>";
		echo "<br/>";
		//Check
			$high = $mysql_datetime;
			$high2 = $mysql_datetime;
			$high3 = $mysql_datetime;
			$high4 = $mysql_datetime;
			$high5 = $mysql_datetime;
			$high6 = $mysql_datetime;
			$high7 = $mysql_datetime;
			$high8 = $mysql_datetime;
			$high9 = $mysql_datetime;
			$high10 = $mysql_datetime;
			$points=0;
			$dt = time();
			$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S", $dt+$offset);
			$rtime = $mysql_datetime;
			$stringRTime = settype($rtime,"String");
			mysql_query("INSERT INTO vote_point(account_id,date,ip_address,blockendedtime,blockendedtime2,blockendedtime3,blockendedtime4,blockendedtime5,blockendedtime6,blockendedtime7,blockendedtime8,blockendedtime9,blockendedtime10,lastvisit) VALUES($accountid,$stringRTime,'$ip','$high','$high2','$high3','$high4','$high5','$high6','$high7','$high8','$high9','$high10','$high10')",$con);
			echo "<span style=\"color:#FFF;font-family:Arial,Tahoma;font-size:10px;\">Recording User To The Database Please Login Again</span>";
			echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"1; url=index.php\">";
	}
	function inDB($offset,$accountid,$con,$ip,$user,$points,$lastvisit)
	{
	include ('adminstaff.php');
	echo "<center>";

	//Put The Design Here
			$dt = time();
			$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S", $dt+$offset);
			$rtime = $mysql_datetime;
				echo "<form action=resultpage.php method=POST >";
				echo "<table>";
					echo "<tr>";
					echo "<td colspan=\"5\" align=\"center\">";
						echo "<span style=\"color:#FFF;font-family:Arial,Tahoma;font-weight:bolder;font-size:13px;\">Username: $user</span><br/><br/>";
						echo "<span style=\"color:#FFF;font-family:Arial,Tahoma;font-weight:bolder;font-size:13px;\">Current Points: $points</span><br/><br/>";
						echo "<span style=\"color:#FFF;font-family:Arial,Tahoma;font-weight:bolder;font-size:13px;\">Your Last Visit: $lastvisit</span><br/><br/><br/>";
					echo "</td>";
					echo "</tr>";
				echo "<tr>";
					echo "<td align=\"center\">";
						if($enablevote1==1){
						echo "<img src=$image1 /><br/>";
						echo"<input type=submit value=\"$voteName1\" name=vote1 />";}
					echo "</td>";					
					echo "</tr>";
					echo "<tr>";
					echo "<td align=\"center\">";						
						if($enablevote2==1){
						echo "<img src=$image2 /><br/>";
						echo"<input type=submit value=\"$voteName2\" name=vote2 />";}
					echo "</td>";					
					echo "</tr>";
					echo "<tr>";						
					echo "<td align=\"center\">";						
						if($enablevote3==1){
						echo "<img src=$image3 /><br/>";
						echo "<input type=submit value=\"$voteName3\" name=vote3 />";}
					echo "</td>";					
					echo "</tr>";
					echo "<tr>";						
					echo "<td align=\"center\">";	
						if($enablevote4==1){
						echo "<img src=$image4 /><br/>";
						echo "<input type=submit value=\"$voteName4\" name=vote4 />";}
					echo "</td>";					
					echo "</tr>";
					echo "<tr>";	
					echo "<td align=\"center\">";
						if($enablevote5==1){
						echo "<img src=$image5 /><br/>";
						echo "<input type=submit value=\"$voteName5\" name=vote5 />";}
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td align=\"center\">";
						if($enablevote6==1){
						echo "<img src=$image6 /><br/>";
						echo "<input type=submit value=\"$voteName6\" name=vote6 />";}
					echo "</td>";					
					echo "</tr>";
					echo "<tr>";
					echo "<td align=\"center\">";
						if($enablevote7==1){
						echo "<img src=$image7 /><br/>";
						echo "<input type=submit value=\"$voteName7\" name=vote7	/>";}
					echo "</td>";					
					echo "</tr>";
					echo "<tr>";
					echo "<td align=\"center\">";
						if($enablevote8==1){
						echo "<img src=$image8 /><br/>";
						echo "<input type=submit value=\"$voteName8\" name=vote8	/>";}
					echo "</td>";					
					echo "</tr>";
					echo "<tr>";
					echo "<td align=\"center\">";
						if($enablevote9==1){
						echo "<img src=$image9 /><br/>";
						echo "<input type=submit value=\"$voteName9\" name=vote9 />";}
					echo "</td>";					
					echo "</tr>";
					echo "<tr>";
					echo "<td align=\"center\">";						
						if($enablevote10==1){
						echo "<img src=$image10 /><br/>";
						echo "<input type=submit value=\"$voteName10\" name=vote10 />";}
					echo "</td>";					
					echo "</tr>";
					echo "<tr>";												
						echo "
								<input type=hidden value=$user name=username />
								<input type=hidden value=$accountid name=accountid />
								<input type=hidden value=$points name=points />
								<input type=hidden value=$ip name=ip />
								<input type=hidden value=$rtime name=rtime />
								</form>
								";
				echo "</tr>";
				echo "</table>";
		echo "</center>";
			}		
?>
</body>
</html>