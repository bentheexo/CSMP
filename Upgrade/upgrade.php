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

if (file_exsists("../config.php"))
	{
	require_once("../config.php");
    echo "<center><h1>Upgrade Installation</h1>
	<p>This will remove update your revision to the latest version by removing all files not needed in the current version</p>";
	echo "<p>The deletion of the useless directory and files will start now.</p>";
	closdir(opendir("../voteforpoints"));
	rmdir("../voteforpoints");
	echo "Now we will update the database.";
	$rag_db = mysqli_connect($POST_sql_rag_host,$POST_sql_rag_user,$POST_sql_rag_pass)
		or die("Can't connect to Ragnarok MySQL server. Press back and check your MySQL host, user, password.");

	mysqli_select_db($rag_db, $POST_sql_rag_db)
		or die("Can't open ".$POST_sql_rag_db." database. Remember to create it before the Control Panel. Press back and check your configurations.");

	$cp_db = mysqli_connect($POST_sql_cp_host,$POST_sql_cp_user,$POST_sql_cp_pass)
		or die("Can't connect to Ragnarok MySQL server. Press back and check your MySQL host, user, password.");
		$query = "DROP TABLE IF EXISTS `vote_point`;";
	$result = mysqli_query($rag_db, $query);

	$query = "CREATE TABLE `vote_point` (`account_id` int(11) NOT NULL default '0',`point` int(11) NOT NULL default '0',`last_vote1` int(11) NOT NULL default '0',`last_vote2` int(11) NOT NULL default '0',`last_vote3` int(11) NOT NULL default '0',`date` text NOT NULL,PRIMARY KEY  (`account_id`)) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$result = mysqli_query($rag_db, $query);
	echo "<p>Everything should be finished updating.</p></center>";
} else {
    echo "<meta http-equiv=\"refresh\" content=\"2;url=../install/install.php\">";