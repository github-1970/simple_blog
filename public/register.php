<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

include_once TEMPLATES . '../templates/layout/header.php';
include_once TEMPLATES . '../templates/auth/register.php';
include_once TEMPLATES . '../templates/layout/footer.php';
?>