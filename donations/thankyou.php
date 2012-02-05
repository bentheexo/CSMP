<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
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
require "settings/config.php";
require "settings/connect.php";
require($_SERVER['DOCUMENT_ROOT'] . '/csmp/config.php');

if(isset($_POST['submitform']) && isset($_POST['txn_id']))

{

	$_POST['nameField'] = esc($_POST['nameField']);

	$_POST['charname'] =  esc($_POST['charname']);

	$error = array();

	if(mb_strlen($_POST['nameField'],"utf-8")<2)

	{

		$error[] = 'Please fill in a valid name.';

	}



	$errorString = '';

	if(count($error))

	{

		$errorString = join('<br />',$error);

	}

	else

	{

		mysql_query("	INSERT INTO dc_comments (transaction_id, name, charname)

						VALUES (

							'".esc($_POST['txn_id'])."',

							'".$_POST['nameField']."',

							'".$_POST['charname']."'
						)");

		

		if(mysql_affected_rows($link)==1)

		{

			$messageString = '<a href="donate.php">You were added to our donor list! &raquo;</a>';

		}

	}

}

	

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Thank you!</title>



<link rel="stylesheet" type="text/css" href="styles.css" />



</head>



<body class="thankyouPage">



<div id="main">

    <h1>Thank you</h1>

    <h2>For showing your support for this project!</h2>



	<div class="lightSection">
<h3 align="center"><a href="donate.php">You were added to our donor list!</a></h3>
<p>
You can now Login and use your Cash Points at our Cash Shops! <br /> We want to thank you again for showing your support!.
</p>
   
   </div>




<?php include "footer.php"; ?>
</body>

</html>





<?php



function esc($str)

{

	global $link;

	

	if(ini_get('magic_quotes_gpc'))

			$str = stripslashes($str);

	

	return mysql_real_escape_string(htmlspecialchars(strip_tags($str)),$link);

}

?>