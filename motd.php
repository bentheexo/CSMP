<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

opentable($lang['NEWS_MESSAGE']);
?>
<center>
<table width="490"><tr><td>
This is the CSMP, Complete Server Management Panel. It will be finished for full use as soon as possible.
</td></tr></table></center>
<?php
closetable();
end();
?>
