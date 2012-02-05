<?php 
require "config.php";
require($_SERVER['DOCUMENT_ROOT'] . '/csmp/config.php');

if($dlist){
		echo '<h3>';
		echo $dlistname;
		echo '</h3>';
        echo '<h4>';
		echo $blistslogan;
		echo '</h4> <div class="comments">';

		$comments = mysql_query("SELECT * FROM dc_comments ORDER BY id DESC");
			
		if(mysql_num_rows($comments))
		{
				while($row = mysql_fetch_assoc($comments))
				{
                 echo '<div class="entry"><div class="name">';
                 echo $row['name'];
				 echo ' ';
				 echo ',';
				 echo ' ';
				 echo $row['amount'];
				 echo '$';
                 echo '</div></div>';
				}
			}
                 echo '</div> ';
}
?>