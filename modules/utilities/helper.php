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

function prepareReceiveError(){
  // destroy session error in start
  // use "if" and "isset" for prevent undefined variable error
  if( isset($_SESSION['error']) ){
    $_SESSION['new_error'] = $_SESSION['error'];
    $_SESSION['error'] = [];
  }
  else{
    $_SESSION['new_error'] = [];
  }
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

function logout($redirect=true, $remove_remember=false){
  // check user is login
  if(isset($_SESSION['user']['login']['status']) && $_SESSION['user']['login']['status'] && $_COOKIE[session_name()] && $redirect){
    unset($_SESSION['user']);
    $remove_remember ? setSessionInCookie( (-ONE_DAY) ) : '';
    redirect(url() . '/public');
  }

  if( isset($_SESSION['user']) ){
    unset($_SESSION['user']);
    $remove_remember ? setSessionInCookie( (-ONE_DAY) ) : '';
  }

  return;
}

function setSessionInCookie($lifetime=ONE_DAY){
  return setcookie(session_name(), session_id(), time() + $lifetime);
}

function checkUserLoggedIn($redirect_url=false, $set_remember=false){
  if( isset($_SESSION['user']['login']['status']) && $_SESSION['user']['login']['status'] ){
    // set session in cookie
    if($_COOKIE[session_name()] && $_SESSION['user']['login']['remember'] && $set_remember){
      setSessionInCookie( (ONE_DAY * 30) );

      $redirect_url ? redirect($redirect_url) : '';
    }

    return true;
  }

  // logout(false);
  return false;
}

function sanitizeString($str){
  $str = trim($str, ' \'\"\\\/');
  $str = htmlentities($str, ENT_QUOTES, 'UTF-8');
  return filter_var($str, FILTER_SANITIZE_STRING);
}

function sanitizeNumber($num){
  $num = sanitizeString($num);
  return (int) filter_var($num, FILTER_SANITIZE_NUMBER_INT);
}

function displaySearch($search){
  return $search ? $search : '';
}

function setReferer($referer){
  $referer = explode('?', $referer)[0];
  
  $_SESSION['last_page_ref'] = isset($_SESSION['last_page_ref']) && is_array($_SESSION['last_page_ref']) ? $_SESSION['last_page_ref'] : [];
  
  $_SESSION['last_page_ref'] = arrayUniquePush($_SESSION['last_page_ref'], $referer);
  
  $last_page_count = count($_SESSION['last_page_ref']);
  if($last_page_count >= 2){
    $_SESSION['last_page_ref'] = array_slice($_SESSION['last_page_ref'], ($last_page_count - 2));
  }
}

function getDoubleReferer(){
  if ( isset($_SESSION['last_page_ref']) && count($_SESSION['last_page_ref']) >= 2 ) {
    return $_SESSION['last_page_ref'][0];
  }
  return '';
}

function arrayUniquePush($array, $value){
  $temp_array = $array;
  foreach ($temp_array as $key => $item) {
    if($item == $value){
      unset($array[$key]);
    }
  }
  array_push($array, $value);
  return $array;
}

function setErrorInSession($name, $message){
  $_SESSION['error'][$name] = $message;
}