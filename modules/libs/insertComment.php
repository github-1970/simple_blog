<?php 

die('comments');

// $user_id = isset($_SESSION['user']['login']['id']) ? $_SESSION['user']['login']['id'] : '';


$require_fields = ['title', 'author', 'category', 'text'];

foreach ($require_fields as $field) {
  $field_value = isset($_POST[$field]) && $_POST[$field] ? $_POST[$field] : '';
  $field_value = sanitizeString($field_value);
  ${$field} = checkError($field, $field_value, $field);

  ${$field} ? '' : throwException("Error");
}