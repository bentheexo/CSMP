<?php require "settings/connect.php"; require "settings/config.php"; require($_SERVER['DOCUMENT_ROOT'] . '/csmp/config.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['Username'])) {
  $loginUsername=$_POST['Username'];
  $password=$_POST['Password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "donate.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($db_database, $link);
  
  $LoginRS__query=sprintf("SELECT userid, user_pass FROM login WHERE userid=%s AND user_pass=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $link) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	
	 $LoginA_query = "SELECT account_id,userid FROM login WHERE userid='$loginUsername'"; 
	 $LoginA1_query = mysql_query($LoginA_query, $link) or die(mysql_error());
	 $LoginA1_query_r = mysql_fetch_array($LoginA1_query);
	 $account_id = $LoginA1_query_r[account_id];
	 
	$_SESSION['MM_Account'] = $account_id;
	
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="styles.css" />
<title><?php echo $name ?></title>
</head>
<body><center>

    <h1><?php echo $name ?></h1>
	  <h2><?php echo $slogan ?></h2>
<br><br>
  <h4>Login.</h4>
<form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" name="LoginD">
<input name="Username" type="text" value="Username" /><br />
<input name="Password" type="password" value="Password" /><br />
<input name="Login" type="submit" value="Login" />
</form><br />
<br>
<?php 
include "settings/ad1.php";

include "footer.php";
?>
</center>
</body>
</html>