<?php
session_start();
include_once 'config.php'; // loads config variables
include_once 'functions.php';

if (!$CONFIG_disable_account) {
?>
<span title="Create a new account" style="cursor:pointer" onClick="return LINK_ajax('account.php','main_div');">
<b><?php echo $lang['NEW_ACCOUNT'] ?></b>
</span>
<?php
}
?>
<br>
<?php
if ($CONFIG_password_recover) {
?>
<span title="Send the account info to your e-mail" onClick="return LINK_ajax('recover.php','main_div');">
<b><?php echo $lang['RECOVER_PASSWORD'] ?></b>
</span>
<?php
}

end();
?>
