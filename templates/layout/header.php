<?php
sessionStart();
?>

<!DOCTYPE html>
<html lang="en"
  dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible"
    content="IE=edge">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link rel="stylesheet"
    href="<?= url() ?>/public/css/styles.css">
  <script defer
    type="module"
    src="<?= url() ?>/public/js/index.js"></script>
</head>

<body class="position-relative bg-light">
  <!-- navbar -->
  <div class="navbar-container fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div
        class="container py-2 d-flex justify-content-between flex-row-reverse">
        <a class="navbar-brand"
          href="<?= url() ?>/public"><span
            class="text-primary">RasoolBlog</span><span>.ir</span>
        </a>
        <button class="navbar-toggler"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-inline-block-i"
          id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center mt-3 mt-md-0">
            <li class="nav-item">
              <a class="nav-link active"
                href="<?= url() ?>/public/">خانه</a>
            </li>

            <li
              class="dropdown d-block d-md-flex align-items-center ms-0 ms-md-3">
              <a href="#"
                class="dropdown-toggle nav-link"
                data-bs-toggle="dropdown">
                دسته‌بندی‌ها
              </a>
              <ul class="dropdown-menu text-center">
              <?php 
              require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/database/dbConnection.php';

              $categories = $conn->query("SELECT c.*, count(c.id) AS posts_count FROM categories c INNER JOIN posts p on c.id = p.category_id GROUP BY c.id;");
              $categories = $categories->fetchAll(PDO::FETCH_OBJ);

              foreach($categories as $category){
              ?>
                <li>
                  <a class="dropdown-item"
                    href="category.php?category_id=<?= $category->id ?>"><?= $category->title ?></a>
                </li>
              <?php } ?>
              </ul>
            </li>
          </ul>

          <ul class="navbar-nav ms-auto me-0 me-md-4">
            <li class="nav-item mb-1 <?= checkUserLoggedIn() ? 'd-none' : '' ?>">
              <a href="<?= url() ?>/public/auth/login.php" class="nav-link d-flex align-items-center justify-content-center">
                <span class="me-2">ورود</span>
                <i class="fas fa-user fa-lg"></i>
              </a>
            </li>

            <li class="nav-item border-right mb-1 <?= checkUserLoggedIn() ? 'd-none' : '' ?>">
              <a href="<?= url() ?>/public/auth/register.php" class="nav-link d-flex align-items-center justify-content-center">
                <span class="me-2">ثبت نام</span>
                <i class="fas fa-user-plus fa-lg"></i>
              </a>
            </li>

            <!-- user -->
            <li class="nav-item mb-1 <?= !checkUserLoggedIn() ? 'd-none' : '' ?>">
              <a href="<?= url() ?>/public/admin/dashboard" class="nav-link d-flex align-items-center justify-content-center">
                <span class="me-2">
                  <?= isset($_SESSION['user']['login']['name']) && $_SESSION['user']['login']['name'] ? $_SESSION['user']['login']['name'] : 'حساب کاربری' ?>
                </span>
                <i class="fas fa-user-cog fa-lg"></i>
              </a>
            </li>

            <!-- for sign out, when logged in -->
            <li class="nav-item border-right mb-1 <?= !checkUserLoggedIn() ? 'd-none' : '' ?>">
              <a href="<?= url() ?>/public/auth/logout.php" class="nav-link d-flex align-items-center justify-content-center">
                <span class="me-2">خروج</span>
                <i class="fas fa-sign-out-alt fa-lg"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="progress-container">
      <div class="p-progress-bar"></div>
    </div>
  </div>
  <!-- end navbar -->

