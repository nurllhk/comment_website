<?php
include('../init.php');

$db->query("update users set last_login=now() where editor='1'");

?>