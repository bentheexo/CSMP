<?php 
require "../settings/config.php";
require "../settings/connect.php";
require($_SERVER['DOCUMENT_ROOT'] . '/csmp/config.php');

echo '<h3>Last 5 Subscription made.</h3>
	Transaction Id , Donor eMail , Amount , Cash Points , Account Id , Date and Time
      <div class="comments">';
	  
$comments = mysql_query("SELECT * FROM  dc_Subscription ORDER BY transaction_id DESC LIMIT 5");

if(mysql_num_rows($comments))
			{
				while($row = mysql_fetch_assoc($comments))
				{
                    
echo '<div class="entry">';
echo nl2br($row['transaction_id']);
echo ' , ';
echo $row['donor_email'];
echo ' , ';
echo $row['amount'];
echo '$ , ';
echo $row['cash_points'];
echo ' , ';
echo $row['account_id'];
echo ' , ';
echo $row['dt'];
echo '</div>';
				}
			}
echo '</div> <!-- Closing the comments div -->';

?>