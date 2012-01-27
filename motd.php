<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

opentable($lang['NEWS_MESSAGE']);
?>
<table width="504">
This is the CSMP, Complete Server Management Panel. It will be finished for full use as soon as possible.
</table>
<?php
closetable();
fim();
?>
