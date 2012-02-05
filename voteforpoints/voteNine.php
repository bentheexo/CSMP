<?php
		if(in_array($ip,$STOREip)==1)
		{
			if($unixrtime>=$highTimeForIPunix9)
			{
							$points = 1+$STOREpoints;
							mysql_query("UPDATE vote_point SET blockendedtime9 = '$expirationtime' WHERE account_id='$accountid'");
							mysql_query("UPDATE vote_point SET point='$points'WHERE account_id = '$accountid'");
							mysql_query("UPDATE vote_point SET ip_address='$ip' WHERE account_id = '$accountid'");
							mysql_query("UPDATE vote_point SET lastvisit='$rtime' WHERE account_id = '$accountid'");
							echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$vote9 \">";
			}
			else
			{
							echo "$ipblocked";
			}
		}
		else if($ip!=$STOREip)
		{
			if($unixrtime>=$lastRecordTimeBlockended9)
			{
								$points = 1+$STOREpoints;
								mysql_query("UPDATE vote_point SET blockendedtime9 = '$expirationtime' WHERE account_id='$accountid'");
								mysql_query("UPDATE vote_point SET point='$points'WHERE account_id = '$accountid'");
								mysql_query("UPDATE vote_point SET ip_address='$ip' WHERE account_id = '$accountid'");
								mysql_query("UPDATE vote_point SET lastvisit='$rtime' WHERE account_id = '$accountid'");	
								echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$vote9 \">";
			}				
			else
			{
							echo "$ipblocked";
			}		
		}
?>