<!-- home page main -->
<div class="col-12 col-md-8">
  <main class="main" id="homeMain">
    <div class="row">
    <?php
    $posts = $conn->query("SELECT p.*, c.title AS category_title, u.name AS author_name FROM posts p INNER JOIN categories c ON p.category_id = c.id INNER JOIN users u ON p.author_id = u.id;");
    
    foreach ($posts->fetchAll(PDO::FETCH_OBJ) as $post){
    ?>
      <div class="col-12 col-md-6">
        <div class="card">
          <a href="post.php?id=<?=$post->id?>">
            <img src="img/<?=$post->image?>" class="card-img-top" alt="<?=$post->title?>">
          </a>

          <div class="card-body">
            <div class="card-title d-flex align-items-center justify-content-between">
              <a href="post.php?id=<?=$post->id?>">
                <h5><?=$post->title?></h5>
              </a>

              <a href="#">
                <span class="badge bg-secondary"><?=$post->category_title?></span>
              </a>
            </div>

            <p class="card-text my-3">
              <?=textWrapper($post->text)?>
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
