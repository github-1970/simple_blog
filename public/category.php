<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

$title = 'Category | Simple Blog';
$post_not_found = false;
$category_id = isset($_GET['category_id']) && $_GET['category_id'] ? (int)sanitizeString($_GET['category_id']) : false;

try{
  $query = "SELECT p.*, c.title AS category_title, u.name AS author_name FROM posts p INNER JOIN categories c ON p.category_id = c.id INNER JOIN users u ON p.author_id = u.id ORDER BY COALESCE(p.updated_at, p.created_at) DESC;";
  if($category_id){
    $query = "SELECT p.*, c.title AS category_title, u.name AS author_name FROM posts p INNER JOIN categories c ON p.category_id = c.id INNER JOIN users u ON p.author_id = u.id WHERE p.category_id = ? ORDER BY COALESCE(p.updated_at, p.created_at) DESC;";
  }
  
  $stmt = $conn->prepare($query);
  $stmt ? $stmt->execute([$category_id]) : $stmt->execute();
  $main_posts = $stmt->fetchAll(PDO::FETCH_OBJ);

  if(!$main_posts){
    throw new PDOException('دسته بندی مورد نظر شما یافت نشد!');
  }
}
catch(Exception $e){
  $post_not_found = true;
  $post_not_found_message = '
  <div class="alert alert-danger">' . 
    '<h4 class="mb-3">' . $e->getMessage() . '</h4>' .
    '<span>از طریق این لینک به صفحه اصلی بروید: </span>' .
    '<a class="text-primary" href="' . url() .'/public">صفحه اصلی</a>' .
  '</div>';
}

include_once TEMPLATES . '/layout/header.php';
include_once TEMPLATES . '/home/header.php';
include_once TEMPLATES . '/layout/main.php';
include_once TEMPLATES . '/home/categoryMain.php';
include_once TEMPLATES . '/layout/footer.php';
