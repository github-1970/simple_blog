<!-- home page main -->
<div class="col-12 col-md-8">
  <main class="main" id="homeMain">
    <div class="row">

    <?php
    foreach ($main_posts as $post){
    ?>
    
      <div class="col-12 col-md-6">
        <div class="card">
          <a href="<?= url() ?>/public/post.php?id=<?=$post->id?>">
            <img src="img/posts/<?=$post->image?>" class="card-img-top" alt="<?=$post->title?>">
          </a>

          <div class="card-body">
            <div class="card-title d-flex align-items-center justify-content-between">
              <a href="post.php?id=<?=$post->id?>">
                <h5><?=$post->title?></h5>
              </a>

              <a href="<?= url() ?>/public/category.php?category_id=<?= $post->category_id ?>">
                <span class="badge bg-secondary"><?= $post->category_title ?></span>
              </a>
            </div>

            <p class="card-text my-3">
              <?=textWrapper(html_entity_decode($post->text))?>
            </p>

            <div class="d-flex align-items-center justify-content-between">
              <a href="post.php?id=<?=$post->id?>" class="btn btn-outline-primary">مشاهده</a>

              <div>
                <span class="text-muted">نویسنده: </span>
                <span><?=$post->author_name?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
  </main>
</div>
