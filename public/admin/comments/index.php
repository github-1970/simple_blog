<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

require_once PUBLIC_DIR . '/admin/comments/edit.php';
require_once PUBLIC_DIR . '/admin/comments/delete.php';

$active_category = ['comments' => true];

try{
  $comments = $conn->query('SELECT c.*, u.name as author_name FROM comments c INNER JOIN users u ON c.author_id = u.id ORDER BY c.id DESC;');
  $comments = $comments->fetchAll(PDO::FETCH_OBJ);
}
catch(Exception $e){
  redirect($_SERVER['HTTP_REFERRER']);
}

include_once TEMPLATES . '/admin/layout/header.php';
include_once TEMPLATES . '/admin/comments/index.php';
include_once TEMPLATES . '/admin/layout/footer.php';
