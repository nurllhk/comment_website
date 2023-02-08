<?php
include('../init.php');


$db->query('DELETE FROM user_balances WHERE date<=DATE_SUB(NOW(), INTERVAL 15 DAY)');
$db->query('REPAR TABLE user_balances');