<?php 
require "settings/config.php";
if($footer){
echo '
<br>
<div class="footer" align="center">
Made By Hellflaem @ ToxicityRo.com Copyright © 2010. All rights reserved.
</div>
';
}
mysql_close($link);
?>
