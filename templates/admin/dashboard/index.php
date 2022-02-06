<?php
// destroy session error in start
// use "if" and "isset" for prevent undefined variable error
prepareReceiveError();
?>

<!-- main -->
<main class="main p-3 ms-5 me-2 ms-md-0 me-md-0 pb-5">
  <h1 class="border-1 border-bottom pt-2 pb-4">داشبورد</h1>

  <!-- articles table -->
  <div class="articles-table border-1 border-bottom py-4">
    <h3>مقالات اخیر</h3>

    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>عنوان</th>
          <th>نویسنده</th>
          <th>دسته‌بندی</th>
          <th>تنظیمات</th>
        </tr>
      </thead>
      <tbody>
        
      <?php
      $counter = 1;
      foreach ($posts as $post) {
      ?>

        <tr>
          <th><?= $counter++ ?></th>
          <td><?= $post->title ?></td>
          <td><?= $post->author_name ?></td>
          <td><?= $post->category_title ?></td>
          <td>
            <a href="<?= url() ?>/public/admin/articles/operations.php?type=edit&id=<?= $post->id ?>"
              class="btn btn-outline-info mb-2 mb-md-0">ویرایش</a>
            <a href="<?= url() ?>/public/admin/articles?delete=true&id=<?= $post->id ?>"
              class="btn btn-outline-danger mb-2 mb-md-0">حدف</a>
          </td>
        </tr>

      <?php } ?>

      </tbody>
    </table>
  </div>
  <!-- end articles table -->

  <!-- comments tables -->
  <div class="comments-table border-1 border-bottom py-4">
    <h3>نظر‌های اخیر</h3>

    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>نام</th>
          <th>نظر</th>
          <th>تنظیمات</th>
        </tr>
      </thead>
      <tbody>

      <?php
      $counter = 1;
      foreach ($comments as $comment) {
      ?>

        <tr>
          <th><?= $counter++ ?></th>
          <td><?= $comment->author_name ?></td>
          <td><?= textWrapper($comment->text, 50) ?></td>
          <td>

          <?php if($comment->status == 1){ ?>

            <a href="<?= url() ?>/public/admin/comments/index.php?edit=true&id=<?= $comment->id ?>" class="btn btn-outline-success mb-2 mb-md-0">تایید شده</a>

          <?php }elseif($comment->status == 0){ ?>

            <a href="<?= url() ?>/public/admin/comments/index.php?edit=true&id=<?= $comment->id ?>" class="btn btn-outline-info mb-2 mb-md-0">در انتظار تایید</a>

          <?php } ?>

            <a href="<?= url() ?>/public/admin/comments/index.php?delete=true&id=<?= $comment->id ?>" class="btn btn-outline-danger">حدف</a>
          </td>
        </tr>

      <?php } ?>

      </tbody>
    </table>
  </div>
  <!-- end comments tables -->

  <!-- categories tables -->
  <div class="categories-table border-1 border-bottom py-4">
    <h3>دسته‌بندی‌ها</h3>

    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>عنوان</th>
          <th>تنظیمات</th>
        </tr>
      </thead>
      <tbody>

      <?php
      $counter = 1;
      foreach ($categories as $category) {
      ?>

        <tr>
          <th><?= $counter++ ?></th>
          <td><?= $category->title ?></td>
          <td>
            <a href="<?= url() ?>/public/admin/categories/operations.php?type=edit&id=<?= $category->id ?>" class="btn btn-outline-info mb-2 mb-md-0 d-block d-md-inline-block">ویرایش</a>

            <a href="<?= url() ?>/public/admin/categories/index.php?delete=true&id=<?= $category->id ?>" class="btn btn-outline-danger">حدف</a>
          </td>
        </tr>

      <?php } ?>

      </tbody>
    </table>
  </div>
  <!-- end categories tables -->
</main>
<!-- end main -->
