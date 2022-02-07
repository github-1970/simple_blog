<?php

try{
  // if false, not do any work
  if( isset($_GET['id']) && isset($_GET['delete']) ){
    $id = sanitizeNumber($_GET['id']);
    $delete = sanitizeString($_GET['delete']);

    if($id && $delete){
      // for delete post image
      $post_query = 'SELECT image FROM posts WHERE id = :id';
      $stmt = $conn->prepare($post_query);
      $stmt->execute(['id'=>$id]);
      $post_image = $stmt->fetch(PDO::FETCH_OBJ)->image;
      $image_path = PUBLIC_DIR . '/img/posts/' .$post_image;
      file_exists($image_path) ? unlink($image_path) : '';

      $delete_query = 'DELETE FROM posts WHERE id = :id';
      $stmt = $conn->prepare($delete_query);
      $stmt->execute(['id'=>$id]);

      throwException('Succuss');
    }
    else{
      throwException("Error Processing Request");
    }
  }
}
catch(Exception $e){
  $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url() . '/public/admin/articles';
  redirect($referer);
}