<?php

namespace Modules\Libs;

use Exception;

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/utilities/helper.php';

class ImageUpload
{
  public function __construct( $name = 'image', $image_dir = (PUBLIC_DIR . '/img/posts/') )
  {
    $this->name = $name;
    $this->image_dir = $image_dir;

    sessionStart();
  }

  public function run( $name = 'image', $image_dir = (PUBLIC_DIR . '/img/posts/') ){
    try {
      $this->checkRequestHasFile($name) ? '' : throwException('این فیلد نمی تواند خالی باشد!');

      $this->checkFileIsImage($name) ? '' : throwException('این فایل یک تصویر نمی باشد! لطفا یک تصویر انتخاب کنید و دوباره تلاش کنید.');

      $image_size = $this->checkFileSize($name) ? $this->checkFileSize($name) : throwException('سایز فایل تصویر مناسب نمی باشد! لطفا یک تصویر با سایز بین 10 کیلوبایت تا 10 مگابایت انتنخاب نمایید.');

      $image_file_type = $this->checkFileType($name) ? $this->checkFileType($name) : throwException('نوع فایل تصویر مناسب نمی باشد! لطفا از بین انواع: 
      jpg, jpeg, png, gif, webp
      یک تصویر را ارسال نمایید.');

      $image_path_array = $this->createFileName($name, $image_dir, $image_file_type);
      $image_full_path = $image_path_array['image_full_path'];
      // $image_name = $image_path_array['image_name'];

      if (move_uploaded_file($_FILES[$name]["tmp_name"], $image_full_path)) {
        return $image_path_array;
      }

      throwException('بارگذاری تصیر با مشکل مواجه شد! لطفا دوباره امتحان کنید.');
      return false;
    } catch (Exception $e) {
      setErrorInSession($name, $e->getMessage());

      return false;
    }
  }

  public function checkRequestHasFile($name)
  {
    return (isset($_FILES[$name]) && $_FILES[$name]['name']);
  }

  public function checkFileIsImage($name)
  {
    $image_info = getimagesize($_FILES[$name]["tmp_name"]);
    return $image_info ? $image_info : false;
  }

  public function checkFileSize($name)
  {
    $image_size = filesize($_FILES[$name]["tmp_name"]);
    return ($image_size > 10000 && $image_size < 10000000) ? $image_size : false;
  }

  // JPG, JPEG, PNG & GIF, WEBP
  public function checkFileType($name)
  {
    $image_file_type = strtolower(pathinfo($_FILES[$name]["name"], PATHINFO_EXTENSION));
    $valid_image_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $image_type_is_valid = false;

    foreach ($valid_image_types as $valid_image_type) {
      if ($image_file_type == $valid_image_type) {
        $image_type_is_valid = true;
        break;
      }
    }

    return $image_file_type && $image_type_is_valid ? $image_file_type : false;
  }

  public function createFileName($name, $image_dir, $type)
  {
    $file_name = basename($_FILES[$name]["name"]);
    date_default_timezone_set('Iran');
    $date = date('Y/d/mh:i:s', time()) . microtime(true);
    $rand = rand(100000, 999999);
    $image_name = md5($date . $rand) . '.' . $type;
    $image_full_name = $image_dir . $image_name;
    $image_full_name = checkFileNotExist($image_full_name, $name, $image_dir, $type);

    return ['image_full_path' => $image_full_name, 'image_name' => $image_name];
  }

  public function checkFileNotExist($target_path, $name, $image_dir, $type)
  {
    return file_exists($target_path) ? createFileName($name, $image_dir, $type)['image_full_path'] : $target_path;
  }

}













function imageUpload($name = 'image', $image_dir = (PUBLIC_DIR . '/img/posts/'))
{
  try {
    checkRequestHasFile($name) ? '' : throwException('این فیلد نمی تواند خالی باشد!');
    checkFileIsImage($name) ? '' : throwException('این فایل یک تصویر نمی باشد! لطفا یک تصویر انتخاب کنید و دوباره تلاش کنید.');
    $image_size = checkFileSize($name) ? checkFileSize($name) : throwException('سایز فایل تصویر مناسب نمی باشد! لطفا یک تصویر با سایز بین 10 کیلوبایت تا 10 مگابایت انتنخاب نمایید.');
    $image_file_type = checkFileType($name) ? checkFileType($name) : throwException('نوع فایل تصویر مناسب نمی باشد! لطفا از بین انواع: 
    jpg, jpeg, png, gif, webp
    یک تصویر را ارسال نمایید.');

    $image_path_array = createFileName($name, $image_dir, $image_file_type);
    $image_full_path = $image_path_array['image_full_path'];
    // $image_name = $image_path_array['image_name'];

    die('success');

    if (move_uploaded_file($_FILES[$name]["tmp_name"], $image_full_path)) {
      return $image_path_array;
    }

    throwException('بارگذاری تصیر با مشکل مواجه شد! لطفا دوباره امتحان کنید.');
    return false;
  } catch (Exception $e) {
    setErrorInSession($name, $e->getMessage());

    return false;
  }
}

function checkRequestHasFile($name)
{
  return (isset($_FILES[$name]) && $_FILES[$name]['name']);
}

function checkFileIsImage($name)
{
  $image_info = getimagesize($_FILES[$name]["tmp_name"]);
  return $image_info ? $image_info : false;
}

function checkFileSize($name)
{
  $image_size = filesize($_FILES[$name]["tmp_name"]);
  return ($image_size > 10000 && $image_size < 10000000) ? $image_size : false;
}

// JPG, JPEG, PNG & GIF, WEBP
function checkFileType($name)
{
  $image_file_type = strtolower(pathinfo($_FILES[$name]["name"], PATHINFO_EXTENSION));
  $valid_image_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  $image_type_is_valid = false;

  foreach ($valid_image_types as $valid_image_type) {
    if ($image_file_type == $valid_image_type) {
      $image_type_is_valid = true;
      break;
    }
  }

  return $image_file_type && $image_type_is_valid ? $image_file_type : false;
}

function createFileName($name, $image_dir, $type)
{
  $file_name = basename($_FILES[$name]["name"]);
  date_default_timezone_set('Iran');
  $date = date('Y/d/mh:i:s', time()) . microtime(true);
  $rand = rand(100000, 999999);
  $image_name = md5($date . $rand) . '.' . $type;
  $image_full_name = $image_dir . $image_name;
  $image_full_name = checkFileNotExist($image_full_name, $name, $image_dir, $type);

  return ['image_full_path' => $image_full_name, 'image_name' => $image_name];
}

function checkFileNotExist($target_path, $name, $image_dir, $type)
{
  return file_exists($target_path) ? createFileName($name, $image_dir, $type)['image_full_path'] : $target_path;
}
