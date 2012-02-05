<?php
// As of January 1st this project has changed CeresCP for
// my distrobution purposes. I have rewritten major componets
// to fit my needs of the software.

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

if (check_ban())
	redir("motd.php", "main_div", "Disabled");

if ($CONFIG_donations == 0) {
		redir("motd.php", "main_div", "Donations are disabled");
}

opentable('Donations Panel');
?>
<center>
<table width="490"><tr><td>
<a href="donations/admin/index.php" style="color:blue;">Click to be Re-Directed to the Secure Donations Panel</a>
</td></tr></table></center>
<?php
closetable();
ending();
?>
