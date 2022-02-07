<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/database/insertData.php';
require_once MODULES . '/utilities/helper.php';
require_once MODULES . '/libs/checkError.php';
include_once MODULES . '/libs/ImageUpload.php';

setReferer($_SERVER['HTTP_REFERER']);
$active_category = ['articles' => true];

$operation_type = isset($_GET['type']) ? $_GET['type'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$operation_type = sanitizeString($operation_type);
$id = sanitizeNumber($id);

if($operation_type === 'edit' && $id)
{
  try{
    $get_query = 'SELECT p.*, u.name AS author_name FROM posts p INNER JOIN categories c ON p.category_id = c.id INNER JOIN users u ON p.author_id = u.id WHERE p.id = ?';
    $stmt = $conn->prepare($get_query);
    $stmt->execute([$id]);
    $article = $stmt->fetchAll(PDO::FETCH_OBJ)[0];

    $article ? '' : throwException('Error');
  }
  catch(Exception $e){
    redirect(url() . '/public/admin/articles');
  }
}

try{
  $categories = $conn->query('SELECT * FROM `categories`');
  $categories = $categories->fetchAll(PDO::FETCH_OBJ);

  $users = $conn->query('SELECT * FROM `users`');
  $users = $users->fetchAll(PDO::FETCH_OBJ);
}
catch(Exception $e){
  redirect($_SERVER['HTTP_REFERRER']);
}

include_once PUBLIC_DIR . '/admin/articles/actions.php';

include_once TEMPLATES . '/admin/layout/header.php';
include_once TEMPLATES . '/admin/articles/operations.php';
include_once TEMPLATES . '/admin/layout/footer.php';
