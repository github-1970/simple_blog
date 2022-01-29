<?php
$post_id_in_url = isset($_GET['id']) && $_GET['id'] && $_GET['id'] > 0 ? (int)$_GET['id'] : 1;
$post_not_found = false;

try{
  $stmt = $conn->prepare("SELECT p.*, c.title AS category_title, u.name AS author_name FROM posts p INNER JOIN categories c ON p.category_id = c.id INNER JOIN users u ON p.author_id = u.id where p.id = :id");
  $stmt->execute([':id' => $post_id_in_url]);
  $post = $stmt->fetch(PDO::FETCH_OBJ);

  if(!$post){
    throw new PDOException('پست مورد نظر شما یافت نشد!');
  }
}
catch(PDOException $e){
  $post_not_found = true;
  $post_not_found_message = '
  <div class="alert alert-danger">' . 
    '<h4 class="mb-3">' . $e->getMessage() . '</h4>' .
    '<span>از طریق این لینک به صفحه اصلی بروید: </span>' .
    '<a class="text-primary" href="' . url() .'/public">صفحه اصلی</a>' .
  '</div>';
  
  $script = '
  <script defer>
  document.querySelector("aside").style.marginTop = "2.5rem"
  </script>
  ';
}

?>

<div class="col-12 col-md-8">

  <?php if(!$post_not_found){ ?>

  <main class="main" id="psotMain">
    <!-- show post -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <img src="img/<?= $post->image ?>" class="card-img-top" alt="<?= $post->title ?>">

          <div class="card-body">
            <div class="card-title d-flex align-items-center justify-content-between mt-3 mb-4">
              <h1><?= $post->title ?></h1>

              <a href="<?= url() ?>/public/category.php?category_id=<?= $post->category_id ?>">
                <span class="badge bg-secondary"><?= $post->category_title ?></span>
              </a>
            </div>

            <p class="card-text my-3">
              <?= $post->text ?>
            </p>

            <div class="d-flex align-items-center mb-3 mt-4">
              <div>
                <span class="text-muted">نویسنده: </span>
                <span><?= $post->author_name ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- send comment -->
    <div class="row">
      <div class="col-12">
        <form action="#" method="post" class="comment-form border-top border-bottom py-4 my-2">
          <h3 class="mb-4">ارسال نظر در رابطه با مقاله</h3>

          <div class="p-input-group mb-3">
            <label for="nameInput" class="mb-2">نام</label>
            <input type="text" name="name" class="form-control" id="nameInput" placeholder="نام خود را وارد کنید...">
          </div>

          <div class="p-input-group mb-3">
            <label for="nameInput" class="mb-2">متن نظر شما</label>
            <textarea name="name" class="form-control" id="nameInput" placeholder="متن نظر خود را وارد کنید..." rows="6"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">ارسال</button>
        </form>
      </div>
    </div>

    <!-- show comments -->
    <div class="row">
      <div class="col-12">
        <div class="comments-container mt-4">

          <?php
          $comments = $conn->query("SELECT c.*, u.name as author_name FROM comments c INNER JOIN users u ON c.author_id = u.id where post_id={$post->id}");

          $comments = $comments->fetchALl(PDO::FETCH_OBJ);

          // split parent and child comments
          $parent_comments = array_filter($comments, function($_comment){
            return $_comment->parent_id == null;
          });
          $child_comments = array_filter($comments, function($_comment){
            return $_comment->parent_id != null;
          });
          ?>

          <h3 class="mb-3">نظرهای کاربران</h3>
          <span class="">تعداد نظرها: </span>
          <span class="h5 fw-bold"><?= count($comments) ?></span>

          <div class="comments my-4">

          <?php
          $counter = 0;
          foreach ($parent_comments as $parent_comment) {
            $counter++
          ?>

            <div class="comments-item">
              <img src="img/profiles/user-profile-default.png" alt="<?= $parent_comment->author_name ?>" class="img-fluid" />

              <div class="comments-item-content w-100 ms-2">
                <h5 class="mb-4"><?= $parent_comment->author_name ?></h5>

                <p>
                  <?= $parent_comment->text ?>
                </p>

                <div class="responses">
                  <div class="d-flex mt-3 justify-content-end">
                    <div class="btn btn-primary ms-auto" data-bs-toggle="collapse" data-bs-target="#responseForm<?= $counter ?>">پاسخ</div>
                  </div>

                  <div class="collapse" id="responseForm<?= $counter ?>">
                    <div class="row">
                      <div class="col-12">
                        <form action="#" method="post" class="comment-form border-top border-bottom py-4 mb-2 mt-4">
                          <h3 class="mb-4">
                            <span>ارسال پاسخ به نظر</span>
                            <span><?= $parent_comment->author_name ?></span>
                          </h3>

                          <div class="p-input-group mb-3">
                            <label for="nameInput<?= $counter ?>" class="mb-2">نام</label>
                            <input type="text" name="name" class="form-control" id="nameInput<?= $counter ?>" placeholder="نام خود را وارد کنید..." />
                          </div>

                          <div class="p-input-group mb-3">
                            <label for="textInput<?= $counter ?>" class="mb-2">متن پاسخ شما</label>
                            <textarea name="text" class="form-control" id="textInput<?= $counter ?>" placeholder="متن پاسخ خود را وارد کنید..." rows="6"></textarea>
                          </div>

                          <button type="submit" class="btn btn-primary">ارسال</button>

                          <input type="hidden" name="commentId" value="<?= $parent_comment->id ?>">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


          <?php
          $child_comments_item = 
          array_filter($child_comments, 
          function($_child_comment) use ($parent_comment){
            return $_child_comment->parent_id == $parent_comment->id;
          });

          foreach ($child_comments_item as $child_comment_item) {
          ?>

            <div class="comments-item comments-item-child">
              <img src="img/profiles/user-profile-default.png" alt="<?= $child_comment_item->author_name ?>" class="img-fluid" />

              <div class="comments-item-content w-100 ms-2">
                <h5 class="mb-4"><?= $child_comment_item->author_name ?></h5>

                <p>
                  <?= $child_comment_item->text ?>
                </p>

                <div class="responses">
                  <div class="d-flex mt-3 justify-content-end">
                    <div class="btn btn-primary ms-auto" data-bs-toggle="collapse" data-bs-target="#responseForm<?= $counter ?>">پاسخ</div>
                  </div>

                  <div class="collapse" id="responseForm<?= $counter ?>">
                    <div class="row">
                      <div class="col-12">
                        <form action="#" method="post" class="comment-form border-top border-bottom py-4 mb-2 mt-4">
                          <h3 class="mb-4">
                            <span>ارسال پاسخ به نظر</span>
                            <span><?= $child_comment_item->author_name ?></span>
                          </h3>

                          <div class="p-input-group mb-3">
                            <label for="nameInput<?= $counter ?>" class="mb-2">نام</label>
                            <input type="text" name="name" class="form-control" id="nameInput<?= $counter ?>" placeholder="نام خود را وارد کنید..." />
                          </div>

                          <div class="p-input-group mb-3">
                            <label for="textInput<?= $counter ?>" class="mb-2">متن پاسخ شما</label>
                            <textarea name="text" class="form-control" id="textInput<?= $counter ?>" placeholder="متن پاسخ خود را وارد کنید..." rows="6"></textarea>
                          </div>

                          <button type="submit" class="btn btn-primary">ارسال</button>

                          <input type="hidden" name="commentId" value="<?= $child_comment_item->id ?>">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <?php
          /* end first foreach */ }
          /* end last foreach */ }
          ?>
          
          </div>
        </div>
      </div>
    </div>
  </main>
  
  <?php } else{ ?>

  <div class="main" id="psotMain">
    <?= $post_not_found_message ?>
  </div>

  <?php
    echo $script;
    }
  ?>

</div>