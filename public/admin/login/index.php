<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

$title = 'Admin Panel Login | Simple Blog';
$_SESSION['auth']['target_url'] = url() . '/public/admin/dashboard';
checkUserLoggedIn(url() . '/public/admin/dashboard');


include_once TEMPLATES . '/layout/header.php';
include_once TEMPLATES . '/admin/login/index.php';
include_once TEMPLATES . '/layout/footer.php';
