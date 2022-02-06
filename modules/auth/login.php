<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/dbConnection.php';
require_once MODULES . '/database/insertData.php';
require_once MODULES . '/utilities/helper.php';
require_once MODULES . '/libs/checkError.php';

sessionStart();
$require_fields = ['email', 'password'];

try
{
  // destroy session error in start
  isset($_SESSION['error']) ? call_user_func(function(){ unset($_SESSION['error']); } ) : "";

  foreach ($require_fields as $field) {
    $field_value = isset($_POST[$field]) && $_POST[$field] ? $_POST[$field] : '';
    ${$field} = checkError($field, $field_value, $field, 'login');

    ${$field} ? '' : throwException("App has Error");
  }

  // check login
  $user = checkLogin($email, $password);
  if(!$user){
    throwException("App has Error");
  }

  // check remember
  $remember = isset($_POST['remember']) ? trim($_POST['remember'], ' \'\"\\\/') : false;
  if($remember){
    setSessionInCookie( (ONE_DAY * 30) );
    $_SESSION['user']['login']['remember'] = true;
  }
  else{
    $_SESSION['user']['login']['remember'] = false;
  }

  setSessionForUserIsLogin($user->name, $user->id, $user->role);
  isset($_SESSION['error']) ? call_user_func(function(){ $_SESSION['error'] = ""; } ) : "";
  $target_url = isset($_SESSION['auth']['target_url']) ? $_SESSION['auth']['target_url'] : '/public';
  redirect($target_url);
}
catch(Exception $e)
{
  redirect($_SERVER["HTTP_REFERER"]);
}

function checkLogin($email, $password){
  global $conn;

  try{
    $password_hash = passwordHash($password, SALT_REGISTER);
    $query = 'SELECT * FROM users WHERE email = ?';
    $stmt = $conn->prepare($query);
    $stmt->execute( [$email] );
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    count($results) > 0 ? '' : throwException('ایمیل صحیح نمی باشد');

    // check hash password
    $results = array_filter($results, function($result) use ($password) {
      return passwordVerify($password, SALT_REGISTER, $result->password);
    });

    count($results) > 0 ? '' : throwException('رمز عبور صحیح نمی باشد');

    return $results[0];
  }
  catch(Exception $e){
    setErrorInSession('global', $e->getMessage());
    return false;
  }
}

function setSessionForUserIsLogin($name, $id, $role){
  $_SESSION['user']['login']['status'] = true;
  $_SESSION['user']['login']['name'] = $name;
  $_SESSION['user']['login']['id'] = $id;
  $_SESSION['user']['login']['role'] = $role;
}