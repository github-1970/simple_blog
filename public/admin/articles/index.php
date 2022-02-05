<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

include_once PUBLIC_DIR . '/admin/articles/delete.php';

$active_category = ['articles' => true];

try{
  $posts = $conn->query('SELECT p.*, c.title AS category_title, u.name AS author_name FROM `posts` p INNER JOIN `categories` c ON p.category_id = c.id INNER JOIN `users` u ON p.author_id = u.id ORDER BY COALESCE(p.updated_at, p.created_at) DESC');
  $posts = $posts->fetchAll(PDO::FETCH_OBJ);
}
catch(Exception $e){
  redirect($_SERVER['HTTP_REFERRER']);
}

include_once TEMPLATES . '/admin/layout/header.php';
include_once TEMPLATES . '/admin/articles/index.php';
include_once TEMPLATES . '/admin/layout/footer.php';
