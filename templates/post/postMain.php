<?php
sessionStart();

// prepareReceiveError();
?>

<div class="col-12 col-md-8">

  <?php if(!$post_not_found){ ?>

  <main class="main" id="psotMain">
    <!-- show post -->
    <div class="row">
      <div class="col-12 mb-3">
        <div class="card">
          <img src="img/posts/<?= $post->image ?>" class="card-img-top" alt="<?= $post->title ?>">

          <div class="card-body">
            <div class="card-title d-flex align-items-center justify-content-between my-3">
              <h1><?= $post->title ?></h1>

              <a href="<?= url() ?>/public/category.php?category_id=<?= $post->category_id ?>">
                <span class="badge bg-secondary"><?= $post->category_title ?></span>
              </a>
            </div>

            <p class="card-text my-3">
              <?= html_entity_decode($post->text) ?>
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
    <?php if(checkUserLoggedIn()){ ?>

      <div class="row">
      <div class="col-12">
        <form action="<?= url() ?>/modules/libs/insertComment.php?post_id=<?= $post->id ?>" method="post" class="comment-form border-top border-bottom py-4 my-2">
          <h3 class="mb-4">ارسال نظر در رابطه با مقاله</h3>

          <!-- <div class="p-input-group mb-3">
            <label for="nameInput" class="mb-2">نام</label>
            <input type="text" name="name" class="form-control" id="nameInput" placeholder="نام خود را وارد کنید...">
          </div> -->

          <div class="p-input-group mb-3">
            <label for="textInput" class="mb-2">متن نظر شما</label>
            <textarea name="text" class="form-control" id="textInput" placeholder="متن نظر خود را وارد کنید..." rows="6"></textarea>

            <?= displayError('text') ?>

            <input class="border-0" type="text"  style="width: 0; height: 0;"
            <?= hasError('text') ? 'autofocus' : '' ?> />
          </div>

          <button type="submit" class="btn btn-primary">ارسال</button>
        </form>
      </div>
    </div>

    <?php } ?>

    <!-- show comments -->
    <div class="row">
      <div class="col-12">
        <div class="comments-container mt-4">

        <?php if(hasError('responseText')){ ?>
          <h4 class="alert alert-danger py-3 my-3 text-center">

            فیلد پاسخ: <?= displayError('responseText') ?>

          </h4>
          <input class="border-0" type="text"  style="width: 0; height: 0;"
          <?= hasError('responseText') ? 'autofocus' : '' ?> />
        <?php } ?>

          <h3 class="mb-3">نظرهای کاربران</h3>
          <span class="">تعداد نظرها: </span>
          <span class="h5 fw-bold"><?= count($comments) ?></span>

          <div class="comments my-4">

          <?php
          $counter = 0;
          foreach ($parent_comments as $parent_comment) {
            $counter++;
          ?>

            <div class="comments-item">
              <img src="img/profiles/<?= $parent_comment->author_role == 'admin' ? 'admin-profile-default.jpg' : 'user-profile-default.png' ?>" alt="<?= $parent_comment->author_name ?>" class="img-fluid" />

              <div class="comments-item-content w-100 ms-2">
                <h5 class="mb-4"><?= $parent_comment->author_name ?></h5>

                <p>
                  <?= $parent_comment->text ?>
                </p>

                <div class="responses">
                  <div class="d-flex mt-3 justify-content-end">
                    <div class="btn btn-primary ms-auto <?= checkUserLoggedIn() ? '' : 'd-none' ?>" data-bs-toggle="collapse" data-bs-target="#responseForm<?= $counter ?>">پاسخ</div>
                  </div>
                  
                  <div class="collapse" id="responseForm<?= $counter ?>">
                    <div class="row">
                      <div class="col-12">
                        <form action="<?= url() ?>/modules/libs/insertComment.php?post_id=<?= $post->id ?>" method="post" class="comment-form border-top border-bottom py-4 mb-2 mt-4">
                          <h3 class="mb-4">
                            <span>ارسال پاسخ به نظر</span>
                            <span><?= $parent_comment->author_name ?></span>
                          </h3>

                          <!-- <div class="p-input-group mb-3">
                            <label for="nameInput<?php //echo $counter ?>" class="mb-2">نام</label>
                            <input type="text" name="name" class="form-control" id="nameInput<?php //echo $counter ?>" placeholder="نام خود را وارد کنید..." />
                          </div> -->

                          <div class="p-input-group mb-3">
                            <label for="textInput<?= $counter ?>" class="mb-2">متن پاسخ شما</label>
                            <textarea name="responseText" class="form-control" id="textInput<?= $counter ?>" placeholder="متن پاسخ خود را وارد کنید..." rows="6"></textarea>
                          </div>

                          <button type="submit" class="btn btn-primary">ارسال</button>

                          <input type="hidden" name="parent_id" value="<?= $parent_comment->id ?>">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


          <?php
          // select child comments
          $child_comments_item = 
          array_filter($child_comments, 
          function($_child_comment) use ($parent_comment){
            return $_child_comment->parent_id == $parent_comment->id;
          });

          $child_comments_item = array_reverse($child_comments_item);

          foreach ($child_comments_item as $child_comment_item) {
            $counter++;
          ?>

            <div class="comments-item comments-item-child">
              <img src="img/profiles/<?= $child_comment_item->author_role == 'admin' ? 'admin-profile-default.jpg' : 'user-profile-default.png' ?>" alt="<?= $child_comment_item->author_name ?>" class="img-fluid" />

              <div class="comments-item-content w-100 ms-2">
                <h5 class="mb-4"><?= $child_comment_item->author_name ?></h5>

                <p>
                  <?= $child_comment_item->text ?>
                </p>

                <div class="responses">
                  <div class="d-flex mt-3 justify-content-end">
                    <div class="btn btn-primary ms-auto <?= checkUserLoggedIn() ? '' : 'd-none' ?>" data-bs-toggle="collapse" data-bs-target="#responseForm<?= $counter ?>">پاسخ</div>
                  </div>

                  <div class="collapse" id="responseForm<?= $counter ?>">
                    <div class="row">
                      <div class="col-12">
                        <form action="<?= url() ?>/modules/libs/insertComment.php?post_id=<?= $post->id ?>" method="post" class="comment-form border-top border-bottom py-4 mb-2 mt-4">
                          <h3 class="mb-4">
                            <span>ارسال پاسخ به نظر</span>
                            <span><?= $child_comment_item->author_name ?></span>
                          </h3>

                          <div class="p-input-group mb-3">
                            <label for="textInput<?= $counter ?>" class="mb-2">متن پاسخ شما</label>
                            <textarea name="responseText" class="form-control" id="textInput<?= $counter ?>" placeholder="متن پاسخ خود را وارد کنید..." rows="6"></textarea>
                          </div>

                          <button type="submit" class="btn btn-primary">ارسال</button>

                          <input type="hidden" name="parent_id" value="<?= $parent_comment->id ?>"/>
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