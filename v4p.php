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

if ($CONFIG_sendmail == 0) {
		redir("motd.php", "main_div", "Vote 4 Points has been disabled.");
}

opentable('Vote for Points');
?>
<center>
<table width="490"><tr><td>
<a href="voteforpoints/index.php" style="color:blue;">Click to be taken to Points Authenticator System</a>
</td></tr></table></center>
<?php
closetable();
ending();
?>
