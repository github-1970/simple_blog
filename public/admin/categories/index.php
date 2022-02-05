<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

require_once PUBLIC_DIR . '/admin/categories/delete.php';

$active_category = ['categories' => true];

try{
  $categories = $conn->query('SELECT * FROM `categories` ORDER BY id DESC');
  $categories = $categories->fetchAll(PDO::FETCH_OBJ);
}
catch(Exception $e){
  redirect($_SERVER['HTTP_REFERRER']);
}

include_once TEMPLATES . '/admin/layout/header.php';
include_once TEMPLATES . '/admin/categories/index.php';
include_once TEMPLATES . '/admin/layout/footer.php';
