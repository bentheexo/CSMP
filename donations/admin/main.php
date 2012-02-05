<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "90,91,92,93,94,95,96,97,98,99";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
require "../settings/config.php";
require "../settings/connect.php";
require "function.php";
require($_SERVER['DOCUMENT_ROOT'] . '/csmp/config.php');

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $servername ?></title>



<link rel="stylesheet" type="text/css" href="../styles.css" />



<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
</head>



<body>



<div id="main">

    <h1><?php echo $servername ?></h1>

  <h2>Admin Center</h2>
    <div class="clear" align="center">
<p><br /></p>
    </div>
  <div id="TabbedPanels1" class="TabbedPanels">
    <ul class="TabbedPanelsTabGroup">
      <li class="TabbedPanelsTab" tabindex="0">Home</li>
      <li class="TabbedPanelsTab" tabindex="0">Config Edits</li>
      <li class="TabbedPanelsTab" tabindex="0">Donations Logs</li>
      <li class="TabbedPanelsTab" tabindex="0">Subscriptions Logs</li>
    </ul>
    <div class="TabbedPanelsContentGroup">
      <div class="TabbedPanelsContent">
      
       <div class="lightSection0">
    
    <h3>Hello, <?php echo $_SESSION['MM_Username'] ?></h3>
    <a href="../logout.php" target="_self">Logout</a>
    
<br />
<?php 

if (isset($_POST['accountid'])) {
	
	$amount = intval($_POST['amount']);
	$accountid = intval($_POST['accountid']);
	if($amount > 0)
	{
		if(mysql_query("INSERT INTO $db_database.`cash_points` VALUES('$accountid','$amount')"))
		{
echo<<<ADMIN
 <CENTER>
  <DIV style='width:300px; border:2px solid #DEDEDE; background:#F8F8F8'><b>Cash Points Added!</b><br />
   Amount: $amount
  </DIV><br />
 </CENTER>
ADMIN;
		}
		else
		{
			alert("Error inserting donation: ".mysql_error());
		}
	}
}
else {
  print_form();
}
?>
<h6>
The Player must log in to the game after adding there Cash Points before you can add more to there account.
<br />
Only add one donation per account until the player has got there points after loging in.</h6>

</div>
      
      </div>
      <div class="TabbedPanelsContent">
        <iframe src="../settings/fileed.php" width="100%" height="450px" frameborder="0"></iframe>
      </div>
      <div class="TabbedPanelsContent">
        <?php include "../settings/dl.php"; ?>
      </div>
      <div class="TabbedPanelsContent">
      <?php include "../settings/sl.php"; ?>
      </div>
    </div>
  </div>
  
      <div class="clear" align="center">
<?php include "../settings/ad1.php"; ?>
    </div>
</div> <!-- Closing the main div -->





<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
<?php include "../footer.php"; ?>
</body>

</html>

