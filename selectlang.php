<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'functions.php';

$langdir = opendir ("language/");
while ($file = readdir($langdir)) {
	if (strcmp(substr($file, strlen($file) - 4, 4), ".php") == 0) {
		$file = substr($file, 0, strlen($file) - 4);
		if (strcmp($file, "index") != 0 && strcmp($file, "language") != 0)
			$idiom[] = $file;
	}
}
closedir($langdir);

if (isset($_COOKIE['language']))
	$selected = $_COOKIE['language'];
else
	$selected = $CONFIG_language;

if (isset($GET_language)) {
	setcookie("language", $GET_language, time() + 3600 * 24 * 30);
	echo "
	<script type=\"text/javascript\">
		load_menu();
		login_hide(2);
		server_status();
		LINK_ajax('motd.php', 'main_div');
		LINK_ajax('login.php', 'login_div');
	</script>
	";
	$selected = $GET_language;
}

opentable("");
echo "
<form id=\"selectlang\">
	<select name = \"language\" onChange=\"javascript:GET_ajax('selectlang.php', 'selectlang_div', 'selectlang');\">
	";

for ($i = 0; isset($idiom[$i]); $i++) {
	if (strcmp($selected, $idiom[$i]) === 0)
		echo "<option selected value=\"$idiom[$i]\">$idiom[$i]</option>"; 
	else
		echo "<option value=\"$idiom[$i]\">$idiom[$i]</option>";
}

echo "
	</select>
</form>
";
closetable();
fim();
?>
