<?php
// As of January 1st this project has changed CeresCP for
// my distrobution purposes. I have rewritten major componets
// to fit my needs of the software.

extension_loaded('mysqli')
	or die ("Mysqli extension not loaded. Please verify your PHP configuration.");

is_file("./config.php")
	or die("<a href=\"./install/install.php\">Run Installation Script</a>");

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

$_SESSION[$CONFIG_name.'castles'] = readcastles();
$_SESSION[$CONFIG_name.'jobs'] = readjobs();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>
			<?php echo htmlformat($CONFIG_name); ?> - CSMP
		</title>
		<link rel="stylesheet" type="text/css" href="./style.css">

		<script type="text/javascript" language="javascript" src="jfunctions.js"></script>
	</head>

	<body>
		<center>
		<table style="height:100%" width="802px" align=center>
			<tr>
				<td><div id="logo"><span><?php echo htmlformat($CONFIG_name); ?></span></div>
				</td>
			</tr>
			<tr>
				<td>
					<div id="rss"><a href="http://ro.doddlercon.com/home/?feed=rss2"><span>Doddler's RO News RSS Feed</span></a></div>
					<ul id="main_menu"></ul>
					<ul id="sub_menu"></ul>
					<div id="load_div" style="visibility:hidden;"></div>
					<div id="menu_load" style="visibility:hidden;"></div>
				</td>
			</tr>
			<tr>
				<td>
					<table valign="top">
						<tr>
							<td>
								<div id="left">
		 							<div class="leftpost">
										<div class="main_div_top">Server <span class="color">Info</span></div>
										<div class="main_div" id="main_div"></div>
										<div class="main_div_bottom"></div>
									</div>
								</div>
							</td>
							<td>
								<div class="login_top">Account <span class="color">Info</span></div>
								<div class="login">
								<div id="login_div">
								</div>
								<div id="new_div">
								</div>
								<div id="status_div">
								</div>
								<div id="selectlang_div">
								</div>
								</div>
								<div class="login_bottom"></div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td id="footer" valign="middle" align="center">
					<p style="font-size: 9px; margin-top: 7"><font color="#FFFFFF">Copyright © 2012 <span style="cursor:pointer" class="copyright_link" onClick="window.open('http://athena-host.info/');">
						Complete Server Management Panel</span> by BenTheExo ~ Powered by <span style="cursor:pointer" onClick="window.open('http://php.net);">
						<img src="http://www.php.net/images/logos/php-med-trans.png" alt="PHP.net" height="10" width="20"></span></font></p>
				</td>
			</tr>
		</table>
		<script type="text/javascript">
			load_menu();
			LINK_ajax('motd.php', 'main_div');
			LINK_ajax('login.php', 'login_div');
			login_hide(2);
			server_status();
			LINK_ajax('selectlang.php', 'selectlang_div');
		</script>
		</center>
	</body>
</html>

<?php
end();
?>
