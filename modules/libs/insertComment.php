<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/database/insertData.php';
require_once MODULES . '/utilities/helper.php';
require_once MODULES . '/libs/checkError.php';

try{
  $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : '';
  $post_id = sanitizeNumber($post_id);
  $post_id ? '' : throwException('Error');

  $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';
  $parent_id = sanitizeNumber($parent_id);

  // $require_fields = ['text'];
  $require_fields = $parent_id ? ['responseText'] : ['text'];

  foreach ($require_fields as $field) {
    $field_value = isset($_POST[$field]) && $_POST[$field] ? $_POST[$field] : '';
    $field_value = sanitizeString($field_value);
    ${$field} = checkError($field, $field_value, $field);
  
    ${$field} ? '' : throwException("Error");
  }

  $text = isset($responseText) && $responseText ? $responseText : $text;
  
  $user_id = isset($_SESSION['user']['login']['id']) ? $_SESSION['user']['login']['id'] : '';
  $user_id ? '' : throwException('Error');

  $role = isset($_SESSION['user']['login']['role']) ? $_SESSION['user']['login']['role'] : '';
  $role ? '' : throwException('Error');

  $result = '';
  if($role == 'admin'){
    if(!$parent_id){
      $result = insertData( 'comments',
      ['text', 'author_id', 'post_id', 'status'],
      [$text, $user_id, $post_id, 1] );
    }else{
      $result = insertData( 'comments',
      ['text', 'author_id', 'post_id', 'status', 'parent_id'],
      [$text, $user_id, $post_id, 1, $parent_id] );
    }
    

  }
    else{
      if(!$parent_id){
        $result = insertData( 'comments',
        ['text', 'author_id', 'post_id'],
        [$text, $user_id, $post_id] );
      }else{
        $result = insertData( 'comments',
        ['text', 'author_id', 'post_id', 'parent_id'],
        [$text, $user_id, $post_id, $parent_id] );
      }
  }

  $result ? throwException('Success') : throwException('Error');
}
catch(Exception $e){
  redirect($_SERVER['HTTP_REFERER']);
}


