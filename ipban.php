<?php
function ipban() {
	$p = split('\.', $_SERVER['REMOTE_ADDR']);

	$query = sprintf(CHECK_IPBAN, $p[0], $p[0],$p[1], $p[0],$p[1],$p[2], $p[0],$p[1],$p[2],$p[3]);
	$result = execute_query($query, 'ipban.php', 0, 0);

	$result->fetch_row();

	return $result->row[0];
}

?>
