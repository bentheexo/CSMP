<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/csmp/config.php');
/* End config */
$link = @mysql_connect($CONFIG_rag_serv,$CONFIG_rag_user,$CONFIG_rag_pass) or die('Unable to establish a DB connection');
mysql_set_charset('utf8');
mysql_select_db($CONFIG_rag_db,$link);
?>
