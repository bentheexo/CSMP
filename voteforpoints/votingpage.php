<base target="_blank" />
<?php
//DB CONNECTIONS
include ('connection.php');
$con = mysql_connect ($dbaddress,$dbusername,$dbpassword) or die('Error'. mysql_error());
$dbs = mysql_select_db($dbschema);
$user = $_POST['username'];
if($user=="")
{
	echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=index.php \">";
}
else
{
	//Variables Used
			include('variables.php');
			include("query.php");
	//FETCHING
		for($ctr = 0; $ctr<$ctr3;$ctr++)
		{
			$fetchaccountid = $arrayAccountId[$ctr];
		}
	//VERIFRIYING THE IP
	//	$verifyIP = in_array($ip,$theip);
		$verifyUSER = in_array($user,$arrayUSERID);
		$verifyACCOUNTID = in_array($accountid,$verifyAccountId);
		include('checking.php');
	//THE COMPARISON
		if($verifyUSER==1&&$verifyACCOUNTID==0)
		{
			notinDB($offset,$accountid,$con,$defaultip,$ip,$mysql_datetime);
		}
		else if($verifyUSER==1&&$verifyACCOUNTID==1)
		{
			inDB($offset,$accountid,$con,$ip,$user,$points,$lastvisit);
		}
		else
		{
			echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=index.php \">";
		}
}
?>
<center><span style="font-size:12px;font-family:Arial,Tahoma;font-weight:bolder;color:#FFF;">Vote For Points Per IP System  - Developed By: JayPee Mateo</span></center>
