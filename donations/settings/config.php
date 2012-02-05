<?php
$slogan = 'Donations & Subscriptions Center'; //Server Slogan
$paragraph1 = 'Welcome please place your Donations & Subscriptions here.<br>
As always we thank you for showing your support!<br> After your done just login game for your cash points.'; // Frist paragraph after logging in to the center
$payPalURL = 'https://www.paypal.com/us/cgi-bin/webscr'; // paypals url
$CreditsExchangeRate="1"; // Donated Amount * CreditExchangeRate = Credits
$SubscriptionsExchangeRate="2"; // Subscriptions Amount * SubscriptionsExchangeRate = Credits Monthly
$ads1 = true; // set to true to turn on ads
$dlistname ="Donors & Subscribers Listings"; // Listing Name
$blistslogan = "Folks Who Showed Their Support for our Server."; // Listing Slogan
$dlist = true; // set to true to turn on listings
$admineditor = false; // lets Admins edit settings with browser set to ture to turn on

// Your goal in USD:
$goal = 100;

//YOU MUST CHANGE THIS VARIABLE!! if you move files around. Specify the full path to the directory of fileed.php
$filedir = getcwd();

// Demo mode is set - set it to false to enable donations.
// When enabled (ture) PayPal is bypassed.
$demoMode = false;
if($demoMode)
{
	$payPalURL = 'demo_mode.php';
}
$footer = true;
?>
