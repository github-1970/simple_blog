<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/libs/checkError.php';
require_once MODULES . '/utilities/helper.php';

$title = 'Category | Simple Blog';

$post_not_found = false;
$search = isset($_GET['search']) && $_GET['search'] ? sanitizeString($_GET['search']) : '';

$search = notEmpty($search);

if($search){
  $query = "SELECT p.*, c.title AS category_title, u.name AS author_name FROM posts p INNER JOIN categories c ON p.category_id = c.id INNER JOIN users u ON p.author_id = u.id WHERE p.text like ? || p.title like ? || u.name like ? ORDER BY COALESCE(p.updated_at, p.created_at) DESC;";

  $stmt = $conn->prepare($query);
  $param = '%'.$search.'%';
  $stmt->execute([$param, $param, $param]);
  $main_posts = $stmt->fetchAll(PDO::FETCH_OBJ);
}
else{
  searchHasError();
}

if(isset($main_posts) && !(count($main_posts) > 0) ){
  searchHasError();
}

function searchHasError(){
  global $post_not_found, $post_not_found_message, $search;

  $post_not_found = true;
  $post_not_found_message = '
  <div class="alert alert-danger">' . 
    '<h4 class="mb-3">برای جستجوی عبارت ' .
    ($search ? '"' . $search . '"' : 'مورد نظر') .
    ' نتیجه‌ای یافت نشد!</h4>' .
    '<span>از طریق این لینک به صفحه اصلی بروید: </span>' .
    '<a class="text-primary" href="' . url() .'/public">صفحه اصلی</a>' .
  '</div>';
}


include_once TEMPLATES . '/layout/header.php';
include_once TEMPLATES . '/home/header.php';
include_once TEMPLATES . '/layout/main.php';
include_once TEMPLATES . '/home/searchMain.php';
include_once TEMPLATES . '/layout/footer.php';
