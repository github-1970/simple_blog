<?php

sessionStart();

// destroy session error in start
// use "if" and "isset" for prevent undefined variable error
prepareReceiveError();

$id = isset($category) && $category->id ? $category->id : '';
$title = isset($category) && $category->title ? $category->title : '';
$action = isset($category) && $category->id ? 'edit' : 'create';
$target_url = url() . '/public/admin/categories/operations.php?action=' . $action . ($id ? '&id=' . $id : '');
?>

<!-- main -->
<main class="main p-3 ms-5 me-2 ms-md-0 me-md-0 pb-5">
  <h1 class="border-1 border-bottom pt-2 pb-4">ایجاد دسته‌بندی جدید</h1>

  <!-- create category -->
  <div class="create-category border-1 border-bottom py-4">
    <form action="<?= $target_url ?>"
      method="post">
      <div class="row justify-content-center">
        <div class="col-12 col-md-9">
          <div class="mb-3">
            <label class="form-label"
              for="title">عنوان:</label>
            <input class="form-control"
              type="text"
              name="title"
              id="title"
              value="<?= $title ?>"
              placeholder="عنوان دسته جدید را وارد کنید">

              <?= displayError('title') ?>

            <?php if($id){ ?>

              <input type="hidden" name="edit_input" value="<?= $id ?>">

            <?php } ?>
          </div>
        </div>

        <div class="col-12 col-md-9">
          <button type="submit" class="btn btn-primary">ایجاد دسته جدید</button>
        </div>
      </div>
    </form>
  </div>
  <!-- end create category -->
</main>
<!-- end main -->
