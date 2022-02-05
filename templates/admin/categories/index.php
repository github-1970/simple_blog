<?php
// destroy session error in start
// use "if" and "isset" for prevent undefined variable error
prepareReceiveError();
?>

<!-- main -->
<main class="main p-3 ms-5 me-2 ms-md-0 me-md-0 pb-5">
  <h1 class="border-1 border-bottom pt-2 pb-4">دسته‌بندی‌ها</h1>

  <!-- categories tables -->
  <div class="categories-table border-1 border-bottom py-4">
    <a href="<?= url() ?>/public/admin/categories/operations.php"
      class="btn btn-primary mb-4">ایجاد دسته‌بندی جدید</a>

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
            <a href="<?= url() ?>/public/admin/categories/operations.php?type=edit&id=<?= $category->id ?>" class="btn btn-outline-info mb-2 mb-md-0">ویرایش</a>

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
