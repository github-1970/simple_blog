<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/insertData.php';
require_once MODULES . '/utilities/helper.php';
require_once MODULES . '/libs/checkError.php';

sessionStart();
$require_fields = ['name', 'family', 'email', 'password', 'rePassword'];

try
{
  // destroy session error in start
  isset($_SESSION['error']) ? call_user_func(function(){unset($_SESSION['error']);} ) : "";

  foreach ($require_fields as $field) {
    ${$field} = checkError($field, $_POST[$field], $field, 'register');

    ${$field} ? '' : throwException("App has Error");
  }

  passEqualRepass($password, $rePassword) ? '' : throwException("App has Error");

  // insert data in to database
  $username = $name . ' ' . $family;
  $password_hash = passwordHash($password, SALT_REGISTER);
  insertData('users', ['name', 'email', 'password'], [$username, $email, $password_hash]);
  
  isset($_SESSION['error']) ? call_user_func(function(){ $_SESSION['error'] = ""; } ) : "";
  redirect(url() . '/public/auth/login.php');
}
catch(Exception $e)
{
  redirect($_SERVER["HTTP_REFERER"]);
}

function passEqualRepass($password, $rePassword, $name='password'){
  try{
    return $password == $rePassword ? true : throwException("تکرار رمز عبور با رمز عبور یکی نمی باشد");
  }
  catch(Exception $e){
    setErrorInSession($name, $e->getMessage());
    return false;
  }
}