<?php
sessionStart();

// destroy session error in start
// use "if" and "isset" for prevent undefined variable error
prepareReceiveError();
?>

<!-- main -->
<main class="main p-3 ms-5 me-2 ms-md-0 me-md-0 pb-4">
  <h1 class="border-1 border-bottom pt-2 pb-4">مقالات</h1>

  <!-- articles table -->
  <div class="articles-table border-1 border-bottom py-4">
    <a href="<?= url() ?>/public/admin/articles/operations.php"
      class="btn btn-primary mb-4">ایجاد مقاله جدید</a>

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
</main>
<!-- end main -->
