<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/utilities/helper.php';
sessionStart();

function checkError($name, $value, $type='text', $belongsTo='global'){
  try{
    $value = trim($value, ' \'\"\\\/');
    $value = preg_replace('/^[\r\n]+|[\r\n]+$/', '', $value);

    notEmptyField($value);

    if($type == 'email'){
      isEmail($value);
    }

    if($belongsTo == 'register'){
      checkEmailIsUnique($value);
    }
    elseif($belongsTo == 'subscribe'){
      checkEmailIsUnique($value, 'subscribers');
    }
    
    clearErrorInSession($name);
    return $value;
  }
  catch(Exception $e){
    setErrorInSession($name, $e->getMessage());

    return false;
  }
}

function notEmptyField($value){
  return (isset($value) && !empty($value)) ? true : throwException("این فیلد نمی تواند خالی باشد");
  ;
}

function isEmail($email){
  return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : throwException("فرمت ایمیل وارد شده غلط می باشد");
}

function clearErrorInSession($name){
  if(isset($_SESSION['error']) && isset($_SESSION['error'][$name])){
    unset($_SESSION['error'][$name]);
  }
}

function setSessionForSubscribe($message=true, $name='subscribe'){
  $_SESSION[$name]['message'] = $message;
}

function checkEmailIsUnique($email, $table='users', $field='email'){
  global $conn;

  $stmt = $conn->prepare("SELECT $field FROM $table WHERE $field = ?");
  $stmt->execute([$email]);
  $result = $stmt->fetch();

  return $result ? throwException('یک حساب کاربری با این ایمیل از قبل موجود می باشد') : true;
}