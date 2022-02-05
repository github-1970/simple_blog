<!-- main -->
<main class="main p-3 ms-5 me-2 ms-md-0 me-md-0 pb-5">
  <h1 class="border-1 border-bottom pt-2 pb-4">نظر‌ها</h1>

  <!-- comments tables -->
  <div class="comments-table border-1 border-bottom py-4">
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
</main>
<!-- end main -->