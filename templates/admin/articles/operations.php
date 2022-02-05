<?php

sessionStart();

// destroy session error in start
// use "if" and "isset" for prevent undefined variable error
prepareReceiveError();

$id = '';
$category_id = '';
$author_id = '';
$title = '';
$author_name = '';
$text = '';

$action = isset($article) && $article->id ? 'edit' : 'create';

if($action == 'edit'){
  $id = $article->id;
  $category_id = $article->category_id;
  $author_id = $article->author_id;
  $title = $article->title;
  $author_name = $article->author_name;
  $text = $article->text;
}

$target_url = url() . '/public/admin/articles/operations.php?action=' . $action . ($id ? '&id=' . $id : '');
$current_user_id = isset($_SESSION['user']['login']['id']) ? $_SESSION['user']['login']['id'] : false;
?>

<!-- main -->
<main class="main p-3 ms-5 me-2 ms-md-0 me-md-0 pb-5">
  <h1 class="border-1 border-bottom pt-2 pb-4">
    <?= $id ? 'ویرایش' :
    'ایجاد';?>
    مقاله
    <?= $id ? $title :
    'جدید';?>
  </h1>

  <!-- create article -->
  <div class="create-article border-1 border-bottom py-4">

    <?php
    $errorMessage = displayError('global');
    if($errorMessage){
    ?>

    <h4 class="error-message text-center mb-4"><?= $errorMessage ?></h4>

    <?php } ?>

    <form action="<?= $target_url ?>"
      method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label"
              for="title">عنوان:</label>
            <input class="form-control"
              type="text"
              name="title"
              id="title"
              value="<?= $title ?>"
              placeholder="عنوان مقاله را وارد کنید">
              <?= displayError('title') ?>
          </div>
        </div>

        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label"
              for="author">نویسنده:</label>
            <select class="form-select"
              name="author"
              id="author">
              <option disabled <?= $author_id ? '' : 'selected' ?>>برای مقاله خود یک نویسنده انتخاب نمایید.
              </option>

              <?php
              foreach($users as $user){
              ?>

              <option value="<?= $user->id ?>" 
              <?= // if not edit, use current user 
              $author_id == $user->id ? 'selected' : 
              (!$author_id && $current_user_id == $user->id ? 'selected' : '')
              ?>
              ><?= $user->name ?></option>

              <?php } ?>

            </select>

            <?= displayError('author') ?>

          </div>
        </div>

        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label"
              for="category">دسته‌بندی:</label>
            <select class="form-select"
              name="category"
              id="category">
              <option disabled <?= $category_id ? '' : 'selected' ?>>برای مقاله خود یک دسته‌بندی انتخاب نمایید.
              </option>
              
              <?php foreach($categories as $category){ ?>

              <option value="<?= $category->id ?>" <?= $category_id == $category->id ? 'selected' : '' ?>><?= $category->title ?></option>

              <?php } ?>

            </select>

            <?= displayError('category') ?>

          </div>
        </div>

        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label"
              for="image">تصویر:</label>
            <input class="form-control"
              type="file"
              name="image"
              id="image">

            <?= displayError('image') ?>

            <h6 class="text-secondary my-2">برای مقاله خود یک تصویر انتخاب
              نمایید</h6>
          </div>
        </div>

        <div class="col-12">
          <div class="mb-3">
            <label class="form-label"
              for="text">متن مقاله:</label>
            <textarea class="form-control"
              name="text"
              id="text"
              placeholder="متن مقاله را وارد کنید"
              rows="10"><?= $text ?></textarea>

            <?= displayError('text') ?>

          </div>
        </div>

        <div class="col-12">
          <button type="submit"
            class="btn btn-primary">
            <?= $id ? 'ویرایش' :
            'ایجاد';?>
            مقاله
            <?= $id ? $title :
            'جدید';?>
          </button>
        </div>
      </div>
    </form>
  </div>
  <!-- end create article -->
</main>
<!-- end main -->
