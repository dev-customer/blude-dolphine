<?php if (!defined('DIR_APP')) die('Your have not permission'); 
$uonline = $user_online * rand(1,4);
$total = $uonline;

$hisCount = file_get_contents('count.dat');
$hisCount = $hisCount+$uonline;
file_put_contents('count.dat', $hisCount);
$totalNew = file_get_contents('count.dat');

?>
<div> <i class="fa fa-user clr-sdt2" aria-hidden="true"></i> Online: <?=$total?></div>
<div> <i class="fa fa-user clr-sdt2" aria-hidden="true"></i> Total: <?=$totalNew ?></div>
