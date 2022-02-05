<?php
  $header_posts = $conn->query("SELECT s.active, p.* FROM `posts_slider` s INNER JOIN `posts` p ON s.post_id = p.id ORDER BY s.active DESC, COALESCE(p.updated_at, p.created_at) DESC;");
  $header_posts = $header_posts->fetchAll(PDO::FETCH_OBJ);
  $counter = 0;
?>

<!-- header -->
<header id="header">
  <div id="carousel" class="carousel carousel-light slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
    <?php foreach ($header_posts as $post){ ?>
      <button data-bs-target="#carousel" data-bs-slide-to="<?= $counter++ ?>" class="<?= $post->active ? 'active' : ''; ?>"></button>
    <?php } ?>
    </div>

    <div class="carousel-inner">
    <?php foreach ($header_posts as $post){ ?>
      <div class="carousel-item <?= $post->active ? 'active' : ''; ?>">
        <img src="img/posts/<?= $post->image ?>" class="d-block w-100" alt="<?= $post->title ?>">
        <div class="carousel-caption">
          <h2>
            <a href="post.php?id=<?= $post->id ?>"><?= $post->title ?></a>
          </h2>
          <p class="my-3">
            <?= textWrapper(html_entity_decode($post->text), 150) ?>
          </p>
          <a href="post.php?id=<?= $post->id ?>" class="btn btn-primary">مشاهده</a>
        </div>
      </div>
    <?php } ?>
    </div>

    <button class="carousel-control-prev" data-bs-target="#carousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" data-bs-target="#carousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</header>
<!-- end header -->