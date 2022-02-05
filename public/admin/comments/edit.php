<?php

try{
  // if false, not do any work
  if( isset($_GET['id']) && isset($_GET['edit']) ){
    $id = sanitizeNumber($_GET['id']);
    $edit = sanitizeString($_GET['edit']);

    if($id && $edit){
      $get_query = 'SELECT * FROM comments WHERE id = ?';
      $stmt = $conn->prepare($get_query);
      $stmt->execute([$id]);
      $comment = $stmt->fetchAll(PDO::FETCH_OBJ);

      $comment ? '' : throwException('Error');

      $update_query = 'UPDATE comments SET status = :status WHERE id = :id';
      $status = set_status($comment[0]->status);
      $stmt = $conn->prepare($update_query);
      $stmt->execute(['status'=>$status, 'id'=>$id]);
      throwException('Succuss');
    }
    else{
      throwException("Error Processing Request");
    }
  }
}
catch(Exception $e){
  $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url() . '/public/admin/comments';
  redirect($referer);
}

function set_status($status){
  return $status == 0 ? 1 : 0;
}