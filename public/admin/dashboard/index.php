<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

$active_category = ['dashboard' => true];

try{
  $posts = $conn->query('SELECT p.*, c.title AS category_title, u.name AS author_name FROM `posts` p INNER JOIN `categories` c ON p.category_id = c.id INNER JOIN `users` u ON p.author_id = u.id ORDER BY COALESCE(p.updated_at, p.created_at) DESC LIMIT 5;');
  $posts = $posts->fetchAll(PDO::FETCH_OBJ);

  $comments = $conn->query('SELECT c.*, u.name as author_name FROM comments c INNER JOIN users u ON c.author_id = u.id ORDER BY c.id DESC LIMIT 5;');
  $comments = $comments->fetchAll(PDO::FETCH_OBJ);

  $categories = $conn->query('SELECT * FROM `categories` ORDER BY id DESC');
  $categories = $categories->fetchAll(PDO::FETCH_OBJ);
}
catch(Exception $e){
  redirect($_SERVER['HTTP_REFERRER']);
}

include_once TEMPLATES . '/admin/layout/header.php';
include_once TEMPLATES . '/admin/dashboard/index.php';
include_once TEMPLATES . '/admin/layout/footer.php';
