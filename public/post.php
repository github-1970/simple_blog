<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

$title = 'Post | Simple Blog';

include_once TEMPLATES . '/layout/header.php';
include_once TEMPLATES . '/layout/main.php';
include_once TEMPLATES . '/post/postMain.php';
include_once TEMPLATES . '/layout/footer.php';
?>
