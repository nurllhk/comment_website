<?php
require_once('../init.php');
$captcha = new captcha();
echo $captcha->captcha_image(280,60);
?>