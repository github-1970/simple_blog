<?php

namespace Modules\Libs\ImageUpload;

trait ImageTraits{
  public function imageValidation(){
    self::checkRequestHasFile($this->name) ? '' : throwException('این فیلد نمی تواند خالی باشد!');

      $this->checkFileIsImage($this->name) ? '' : throwException('این فایل یک تصویر نمی باشد! لطفا یک تصویر انتخاب کنید و دوباره تلاش کنید.');

      $image_size = $this->checkFileSize($this->name) ? $this->checkFileSize($this->name) : throwException('سایز فایل تصویر مناسب نمی باشد! لطفا یک تصویر با سایز بین 10 کیلوبایت تا 10 مگابایت انتنخاب نمایید.');

      $image_file_type = $this->checkFileType($this->name) ? $this->checkFileType($this->name) : throwException('نوع فایل تصویر مناسب نمی باشد! لطفا از بین انواع: 
      jpg, jpeg, png, gif, webp
      یک تصویر را ارسال نمایید.');

      return [
        'image_file_type' => $image_file_type,
        'image_size' => $image_size
      ];
  }

  public static function checkRequestHasFile($name)
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
    $image_full_name = $this->checkFileNotExist($image_full_name, $name, $image_dir, $type);

    return ['image_full_path' => $image_full_name, 'image_name' => $image_name];
  }

  public function checkFileNotExist($target_path, $name, $image_dir, $type)
  {
    return file_exists($target_path) ? $this->createFileName($name, $image_dir, $type)['image_full_path'] : $target_path;
  }
}