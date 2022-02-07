<?php

namespace Modules\Libs\ImageUpload;

use Exception;

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/constants.php';
require_once MODULES . '/utilities/helper.php';
include MODULES . '/libs/ImageUpload/ImageTraits.php';

class ImageUpload
{
  use ImageTraits;

  public function __construct( $name = 'image', $image_dir = (PUBLIC_DIR . '/img/posts/') )
  {
    $this->name = $name;
    $this->image_dir = $image_dir;

    sessionStart();
  }

  public function run(){
    try {
      $image_file_type = $this->imageValidation()['image_file_type'];

      $image_path_array = $this->createFileName($this->name, $this->image_dir, $image_file_type);
      $image_full_path = $image_path_array['image_full_path'];
      // $image_name = $image_path_array['image_name'];

      if (move_uploaded_file($_FILES[$this->name]["tmp_name"], $image_full_path)) {
        return $image_path_array;
      }

      throwException('بارگذاری تصیر با مشکل مواجه شد! لطفا دوباره امتحان کنید.');
      return false;
    } catch (Exception $e) {
      setErrorInSession($this->name, $e->getMessage());

      return false;
    }
  }
}
