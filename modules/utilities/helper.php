<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';

sessionStart();

function textWrapper($text, $count=300){
  return strlen($text) - 3 > $count ? mb_substr($text, 0, $count, 'utf-8') . ' ...' : $text;
}

function url(){
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
  return $protocol . "://$_SERVER[HTTP_HOST]";
}

function redirect($path){
  header('Location: '. $path);
  exit();
}

function throwException($message) {
  throw new Exception($message);
}

function notEmpty($value){
  $value = trim($value, ' \'\"\\\/');
  return (isset($value) && !empty($value)) ? $value : false;
}

function displayError($name){
  if( !isset($_SESSION['new_error']) ){
    return '';
  }
  
  if( isset($_SESSION['new_error'][$name]) ){
    return notEmpty($_SESSION['new_error'][$name]) ? "<p class='text-danger my-1'>{$_SESSION['new_error'][$name]}</p>" : "";
  }
  return '';
}

function hasError(){
  if( isset($_SESSION['new_error']) && is_array($_SESSION['new_error']) ){
    return (count($_SESSION['new_error']) > 0);
  }
  return '';
}

function subscribeIsSuccuss($name='subscribe'){
  if( !$_SESSION[$name] ){
    return false;
  }
  
  if( isset($_SESSION[$name]['new_message']) ){
    return $_SESSION[$name]['new_message'];
  }
  return false;
}

function passwordHash($pass, $salt){
  return password_hash(($pass . $salt), PASSWORD_DEFAULT);
}

function passwordVerify($pass, $salt, $hash){
  return password_verify(($pass . $salt), $hash);
}

function sessionStart(){
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
}

function logout($redirect = true){
  // check user is login
  if(isset($_SESSION['user']['login']['status']) && $_SESSION['user']['login']['status'] && $_COOKIE[session_name()] && $redirect){
    unset($_SESSION['user']);
    setSessionInCookie( (-ONE_DAY) );
    redirect(url() . '/public');
    return;
  }

  unset($_SESSION['user']);
  setSessionInCookie( (-ONE_DAY) );
}

function setSessionInCookie($lifetime=ONE_DAY){
  return setcookie(session_name(), session_id(), time() + $lifetime);
}

function checkUserLoggedIn(){
  if( isset($_SESSION['user']['login']['status']) && $_SESSION['user']['login']['status'] ){
    // set session in cookie
    if($_COOKIE[session_name()] && $_SESSION['user']['login']['remember']){
      setSessionInCookie( (ONE_DAY * 30) );
    }

    return true;
  }

  logout(false);
  return false;
}

function sanitizeString($str){
  $str = trim($str, ' \'\"\\\/');
  return filter_var($str, FILTER_SANITIZE_STRING);
}

function displaySearch($search){
  return $search ? $search : '';
}