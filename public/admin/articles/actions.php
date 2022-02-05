<?php

try{
  $action = isset($_GET['action']) ? $_GET['action'] : '';
  $action_id = isset($_GET['id']) ? $_GET['id'] : '';
  $action = sanitizeString($action);
  $action_id = sanitizeNumber($id);

  if($action == 'edit' && $action_id){
    $require_fields = ['title', 'author', 'category', 'text'];

    foreach ($require_fields as $field) {
      $field_value = isset($_POST[$field]) && $_POST[$field] ? $_POST[$field] : '';
      $field_value = sanitizeString($field_value);
      ${$field} = checkError($field, $field_value, $field, 'login');
  
      ${$field} ? '' : throwException("Error");
    }

    $query = 'UPDATE posts SET title = ?, author_id = ?, category_id = ?, text = ? WHERE id = ?;';
    $values = [ $title, $author, $category, $text, $action_id ];

    if(checkRequestHasFile('image')){
      $image_path_array = imageUpload();

      $image_path_array ? '' : throwException("Error");

      $query = "UPDATE posts SET title = ?, author_id = ?, category_id = ?, text = ?, image = ? WHERE id = ?;";
      $values = [ $title, $author, $category, $text, $image_path_array['image_name'], $action_id ];
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($values);

    throwException('Success');
  }
  elseif($action == 'create' && !$action_id){
    $require_fields = ['title', 'author', 'category', 'text'];

    foreach ($require_fields as $field) {
      $field_value = isset($_POST[$field]) && $_POST[$field] ? $_POST[$field] : '';
      $field_value = sanitizeString($field_value);
      ${$field} = checkError($field, $field_value, $field);
  
      ${$field} ? '' : throwException("Error");
    }

    $image_path_array = imageUpload();

    $image_path_array ? '' : throwException("Error");

    $result = insertData( 'posts',
    ['title', 'author_id', 'category_id', 'text', 'image'],
    [$title, $author, $category, $text, $image_path_array['image_name']] );

    $result ? throwException('Success') : '';

    setErrorInSession('global', 'عملیات با خطا مواجه شد! لطفا دوباره امتحان کنید.');
  }
}
catch(Exception $e){
  if($e->getMessage() == 'Success'){
    $referer = getDoubleReferer() ? getDoubleReferer() : url() . '/public/admin/articles';
  }else{
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url() . '/public/admin/articles';
  }
  redirect($referer);
}