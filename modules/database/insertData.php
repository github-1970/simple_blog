<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';

function insertData($table, $fields, $values){
  global $conn;

  $str_fields = strFields($fields);
  $str_fields_for_prepare = questionMarkForPrepare($fields);

  try{
    $query = "INSERT INTO $table ($str_fields) VALUES ($str_fields_for_prepare)";
    $stmt = $conn->prepare($query);
    $stmt->execute($values);

    return true;
  }
  catch(Exception $e){
    return false;
  }
}

function fieldsForPrepare($fields){
  $fields = array_map(function($_field){
    return ':' . $_field;
  }, $fields);

  return strFields($fields);
}

function questionMarkForPrepare($fields){
  $fields = array_map(function($_field){
    return '?';
  }, $fields);

  return strFields($fields);
}

function strFields($fields){
  $str_fields = '';
  $fields_count = count($fields);
  $counter = 0;

  foreach ($fields as $field) {
    $counter++;
    if($counter == $fields_count){
      $str_fields .= $field;
      continue;
    }

    $str_fields .= $field . ', ';
  }
  return $str_fields;
}