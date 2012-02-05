<?php
require "paypal_integration_class/paypal.class.php";
require "settings/config.php";
require "settings/connect.php";
require($_SERVER['DOCUMENT_ROOT'] . '/csmp/config.php');

$p = new paypal_class;
$p->paypal_url=$payPalURL;

if ($p->validate_ipn()) {

	if($p->ipn_data['payment_status']=='Completed')	{
		
		$amount=$p->ipn_data['mc_gross'];
		$donationCredits=($amount*$CreditsExchangeRate);
		$SubscrCash=($amount*$SubscriptionsExchangeRate);
						
		mysql_query("INSERT INTO dc_comments (transaction_id,name,amount,account_id)
						VALUES (
							'".esc($p->ipn_data['txn_id'])."',
							'".esc($p->ipn_data['first_name'])."',
							'".esc($p->ipn_data['mc_gross'])."',
							'".esc($p->ipn_data['custom'])."'
						)");
		
	if($p->ipn_data['txn_type']=='subscr_payment')	{
		
		mysql_query("INSERT INTO dc_Subscription (transaction_id,donor_email,amount,cash_points,account_id,original_request)
						VALUES (
							'".esc($p->ipn_data['txn_id'])."',
							'".esc($p->ipn_data['payer_email'])."',
							'".esc($p->ipn_data['mc_gross'])."',
							'".$SubscrCash."',
							'".esc($p->ipn_data['custom'])."',
							'".esc(http_build_query($_POST))."'
						)");
		
		mysql_query("INSERT INTO $db_database.`cash_points` VALUES('".esc($p->ipn_data['custom'])."','$SubscrCash')");
		
	} else {
		
		mysql_query("INSERT INTO $db_database.`cash_points` VALUES('".esc($p->ipn_data['custom'])."','$donationCredits')"); 
				
		mysql_query("INSERT INTO dc_donations (transaction_id,donor_email,amount,cash_points,account_id,original_request)
						VALUES (
							'".esc($p->ipn_data['txn_id'])."',
							'".esc($p->ipn_data['payer_email'])."',
							'".esc($p->ipn_data['mc_gross'])."',
							'".$donationCredits."',
							'".esc($p->ipn_data['custom'])."',
							'".esc(http_build_query($_POST))."'
						)");
	}

}

}

function esc($str)

{

	global $link;

	return mysql_real_escape_string($str,$link);

}

?>