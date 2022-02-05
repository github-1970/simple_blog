<?php

try{
  $action = isset($_GET['action']) ? $_GET['action'] : '';
  $action_id = isset($_GET['id']) ? $_GET['id'] : '';
  $action = sanitizeString($action);
  $action_id = sanitizeNumber($id);

  if($action == 'edit' && $action_id){
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $title = sanitizeString($title);
    $edit_id = isset($_POST['edit_input']) ? $_POST['edit_input'] : '';
    $edit_id = sanitizeString($edit_id);
    $title = checkError('title', $title);
    
    if($title && $edit_id){
      $update_query = 'UPDATE categories SET title = :title WHERE id = :id';
      $stmt = $conn->prepare($update_query);
      $stmt->execute(['title'=>$title, 'id'=>$edit_id]);

      throwException('Success');
    }
    
    throwException('Error');
  }
  elseif($action == 'create' && !$action_id){
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $title = sanitizeString($title);
    $title = checkError('title', $title);

    if($title){
      insertData('categories', ['title'], [$title]);
      throwException('Success');
    }
    
    throwException('Error');
  }
}
catch(Exception $e){
  if($e->getMessage() == 'Success'){
    $referer = getDoubleReferer() ? getDoubleReferer() : url() . '/public/admin/categories';
  }else{
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url() . '/public/admin/categories';
  }
  redirect($referer);
}