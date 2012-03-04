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

if ($CONFIG_v4p == 0) {
		redir("motd.php", "main_div", "Voting for Points has been disabled");
}

opentable('Voting for Points');
?>
<center>
<table width="490"><tr><td>
<a href="vote.php?site=1" target='_blank' style="color:blue;">Voting Link 1</a>
</td></tr>
<tr><td>
<a href="vote.php?site=2" target='_blank' style="color:blue;">Voting Link 2</a>
</td></tr>
<tr><td>
<a href="vote.php?site=3" target='_blank' style="color:blue;">Voting Link 3</a>
</td></tr></table></center>
<?php
closetable();
ending();
?>
