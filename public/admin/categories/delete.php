<?php

try{
  // if false, not do any work
  if( isset($_GET['id']) && isset($_GET['delete']) ){
    $id = sanitizeNumber($_GET['id']);
    $delete = sanitizeString($_GET['delete']);

    if($id && $delete){
      $delete_query = 'DELETE FROM categories WHERE id = :id';
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
  $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url() . '/public/admin/categories';
  redirect($referer);
}