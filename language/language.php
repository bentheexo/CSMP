<?php
include_once 'config.php'; // loads config variables
$load = "English.php";

if (isset($GET_lang)){ 
	$load = $GET_lang.".php";
} else if (isset($_COOKIE['language'])) {
	$load = $_COOKIE['language'].".php";
} else if (isset($CONFIG_language)) {
	$load = $CONFIG_language.".php";
}

if (!is_file("./language/".$load) || strpos($load, "..") !== false || inject($load))
	$load = "English.php";

include($load);

while (list($key, $val) = each($lang)) {  
	$lang[$key] = htmlentities($val);
}

?>
