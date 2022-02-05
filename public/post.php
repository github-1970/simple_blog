<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

$title = 'Post | Simple Blog';

$post_id_in_url = isset($_GET['id']) && $_GET['id'] && $_GET['id'] > 0 ? (int)$_GET['id'] : 1;
$post_not_found = false;

try{
  // get post
  $stmt = $conn->prepare("SELECT p.*, c.title AS category_title, u.name AS author_name FROM posts p INNER JOIN categories c ON p.category_id = c.id INNER JOIN users u ON p.author_id = u.id where p.id = :id");
  $stmt->execute([':id' => $post_id_in_url]);
  $post = $stmt->fetch(PDO::FETCH_OBJ);

  if(!$post){
    throw new PDOException('پست مورد نظر شما یافت نشد!');
  }

  // get comments
  $comments = $conn->query("SELECT c.*, u.name as author_name FROM comments c INNER JOIN users u ON c.author_id = u.id where c.status = 1 && c.post_id = {$post->id} ORDER BY c.id DESC");

  $comments = $comments->fetchALl(PDO::FETCH_OBJ);

  // split parent and child comments
  $parent_comments = array_filter($comments, function($_comment){
    return $_comment->parent_id == null;
  });
  $child_comments = array_filter($comments, function($_comment){
    return $_comment->parent_id != null;
  });
}
catch(PDOException $e){
  $post_not_found = true;
  $post_not_found_message = '
  <div class="alert alert-danger">' . 
    '<h4 class="mb-3">' . $e->getMessage() . '</h4>' .
    '<span>از طریق این لینک به صفحه اصلی بروید: </span>' .
    '<a class="text-primary" href="' . url() .'/public">صفحه اصلی</a>' .
  '</div>';
  
  $script = '
  <script defer>
  document.querySelector("aside").style.marginTop = "2.5rem"
  </script>
  ';
}

include_once TEMPLATES . '/layout/header.php';
include_once TEMPLATES . '/layout/main.php';
include_once TEMPLATES . '/post/postMain.php';
include_once TEMPLATES . '/layout/footer.php';
?>
