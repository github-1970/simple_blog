<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

$title = 'Login | Simple Blog';
$_SESSION['auth']['target_url'] = url() . '/public';
checkUserLoggedIn(url() . '/public', true);

include_once TEMPLATES . '/layout/header.php';
include_once TEMPLATES . '/auth/login.php';
include_once TEMPLATES . '/layout/footer.php';
?>