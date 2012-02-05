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
// Determining the URL of the page:
$url = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"]);

$cashquery = "SELECT account_id, value, str FROM global_reg_value WHERE str='#CASHPOINTS' AND account_id='".$_SESSION['MM_Account']."' LIMIT 1 ";
$cashresult = mysql_query($cashquery);

$credits = "SELECT account_id, balance FROM cp_credits WHERE account_id='".$_SESSION['MM_Account']."' ";
$cresult = mysql_query($credits);

// Fetching the number and the sum of the donations:
list($number,$sum) = mysql_fetch_array(mysql_query("SELECT COUNT(*),SUM(amount) FROM dc_donations"));

// Calculating how many percent of the goal were met:
$percent = round(min(100*($sum/$goal),100));

// Building a URL with Google's Chart API:
$chartURL = 'http://chart.apis.google.com/chart?chf=bg,s,f9faf7&amp;cht=p&amp;chd=t:'.$percent.',-'.(100-$percent).'&amp;chs=200x200&amp;chco=639600&amp;chp=1.57';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $name ?></title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="main">
    <h1><?php echo $name ?></h1>
    <h2><?php echo $slogan ?></h2>
<br /><br />
  <div id="TabbedPanels1" class="TabbedPanels">
      <ul class="TabbedPanelsTabGroup">
        <li class="TabbedPanelsTab" tabindex="0">Home</li>
        <li class="TabbedPanelsTab" tabindex="0">Goal</li>
        <li class="TabbedPanelsTab" tabindex="0">Donations</li>
        <li class="TabbedPanelsTab" tabindex="0">Subscriptions</li>
      </ul>
      <div class="TabbedPanelsContentGroup">
        <div class="TabbedPanelsContent">
          <div class="lightSection0">
            <h3>Hello , <?php echo $_SESSION['MM_Username'] ?> </h3>
            <?php 
	
	 echo "<TABLE>"; 

    while($cashr=mysql_fetch_array($cashresult))     

    {  

        echo "Cash Points: $cashr[value] <br>"; 
    } 

    while($cr=mysql_fetch_array($cresult))     

    {  

        echo "Credits: $cr[balance] <br>"; 
    } 
    echo "</TABLE>"; 
	
	?>
            <a href="logout.php" target="_self">Logout</a>
            <p align="center"><?php echo $paragraph1 ?></p>
            <p><br /></p>
          </div>
        </div>
        <div class="TabbedPanelsContent" id="goal">
        
  <div class="chart" style="background:url('<?php echo $chartURL?>');">
  <p>Our Donation's Goal</p>
  </div>
  <div class="donations">
   <?php echo $percent?>% done
    </div>
    
</div>
        
        <div class="TabbedPanelsContent">
        <p align="center">
        Donating 10$ = <?php $d1=(10*$CreditsExchangeRate); echo $d1 ?> Cash Points <br />
        </p>
          <form action="<?php echo $payPalURL?>" method="post" class="payPalForm">
            <div id="donate">
              <input type="hidden" name="cmd" value="_donations" />
              <input type="hidden" name="item_name" value="Donation" />
              <input type="hidden" name="business" value="<?php echo $CONFIG_mypaypalemail?>" />
              <input type="hidden" name="notify_url" value="<?php echo $url.'/ipn.php'?>" />
              <input type="hidden" name="return" value="<?php echo $url.'/thankyou.php'?>" />
              <input type="hidden" name="rm" value="2" />
              <input type="hidden" name="no_note" value="1" />
              <input type="hidden" name="cbt" value="Go Back To The Site" />
              <input type="hidden" name="no_shipping" value="1" />
              <input type="hidden" name="lc" value="US" />
              <input type="hidden" name="currency_code" value="USD" />
              <input type="hidden" name="frist_name" value="<?php echo $_SESSION['MM_Username'] ?>" />
              <input type="hidden" name="custom" value="<?php echo $_SESSION['MM_Account'] ?>" />
              <select name="amount">
                <option value="10">$10.00USD - One Time</option>
                <option value="20">$20.00USD - One Time</option>
                <option value="30">$30.00USD - One Time</option>
                <option value="40">$40.00USD - One Time</option>
                <option value="50">$50.00USD - One Time</option>
                <option value="60">$60.00USD - One Time</option>
                <option value="70">$70.00USD - One Time</option>
                <option value="80">$80.00USD - One Time</option>
                <option value="90">$90.00USD - One Time</option>
                <option value="100">$100.00USD - One Time</option>
              </select>
              <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest" />
              <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" />
              <img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" /> </div>
          </form>
        </div>
        <div class="TabbedPanelsContent">
        <p align="center">Subscribing 10$ Monthly = <?php $s1=(10*$SubscriptionsExchangeRate); echo $s1 ?> Cash Points Monthly<br />
        </p>
          <div id="Subscription">
<form action="<?php echo $payPalURL?>" method="post" class="payPalForm">
	<input type="hidden" name="cmd" value="_xclick-subscriptions">
	<input type="hidden" name="hosted_button_id" value="3NGXAQGFEPQFJ">
	<input type="hidden" name="item_name" value="Subscriptions">
	<input type="hidden" name="business" value="<?php echo $CONFIG_mypaypalemail?>" />
	<input type="hidden" name="notify_url" value="<?php echo $url.'/ipn.php'?>" /> 
	<input type="hidden" name="return" value="<?php echo $url.'/thankyou.php'?>" /> 
	<select name="a3">
	<option value="10">$10.00USD - Monthly</option>
	<option value="20">$20.00USD - Monthly</option>
	<option value="30">$30.00USD - Monthly</option>
    <option value="40">$40.00USD - Monthly</option>
	<option value="50">$50.00USD - Monthly</option>
    <option value="60">$60.00USD - Monthly</option>
     <option value="70">$70.00USD - Monthly</option>
     <option value="80">$80.00USD - Monthly</option>
     <option value="90">$90.00USD - Monthly</option>
     <option value="100">$100.00USD - Monthly</option>
	</select>
	<input type="hidden" name="p3" value="1">
	<input type="hidden" name="t3" value="M">
	<input type="hidden" name="src" value="1">
	<input type="hidden" name="sra" value="1">
	<input type="hidden" name="no_note" value="1" />
	<input type="hidden" name="cbt" value="Go Back To The Site" />
	<input type="hidden" name="no_shipping" value="1" />
	<input type="hidden" name="lc" value="US" />
	<input type="hidden" name="currency_code" value="USD" />
	<input type="hidden" name="frist_name" value="<?php echo $_SESSION['MM_Username'] ?>">
	<input type="hidden" name="custom" value="<?php echo $_SESSION['MM_Account'] ?>"> 
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div>  
        
        </div>
      </div>
  </div>
<div class="clear" align="center">
  <?php echo "<br><br>"; include "settings/ad1.php"; ?>
   </div> 
     
    <div class="donors">
 <?php include "settings/dlist.php"; ?>
     </div>
</div>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
<?php 
include "footer.php";
?>
</body>
</html>