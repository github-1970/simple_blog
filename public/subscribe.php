<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/database/insertData.php';
require_once MODULES . '/utilities/helper.php';
require_once MODULES . '/libs/checkError.php';

sessionStart();
$require_fields = ['name', 'email'];

try
{
  // destroy session error in start
  isset($_SESSION['error']) ? call_user_func(function(){unset($_SESSION['error']);} ) : "";

  foreach ($require_fields as $field) {
    ${$field} = checkError($field, $_POST[$field], $field, 'subscribe');

    ${$field} ? '' : throwException("App has Error");
  }

  // insert data in to database
  insertData('subscribers', ['name', 'email'], [$name, $email]);
  
  setSessionForSubscribe();
  isset($_SESSION['error']) ? call_user_func(function(){ $_SESSION['error'] = ""; } ) : "";
  redirect($_SERVER["HTTP_REFERER"]);
}
catch(Exception $e)
{
  redirect($_SERVER["HTTP_REFERER"]);
}