<?php

sessionStart();

// check user is login
if(!checkUserLoggedIn()){
  redirect(url() . '/public/admin/login/index.php');
}

?>

<!DOCTYPE html>
<html dir="rtl" lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible"
    content="IE=edge" />
  <title>Dashboard | Admin</title>
  <meta name="viewport"
    content="width=device-width, initial-scale=1" />
  <link rel="stylesheet"
    href="<?= url() ?>/public/css/styles.css" />
  <script type="module"
    defer
    src="<?= url() ?>/public/js/index.js"></script>
</head>

<body class="position-relative">
  <!-- header -->
  <header class="header sticky-top">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand"
          href="<?= url() ?>/public">
          <span class="text-primary">RasoolBlog</span><span>.ir</span>
        </a>
        <button class="navbar-toggler"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"
          id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item mb-1">
              <a
                class="nav-link d-flex align-items-center justify-content-center admin-name">
                <span class="me-2">
                  <?= isset($_SESSION['user']['login']['name']) && $_SESSION['user']['login']['name'] ? $_SESSION['user']['login']['name'] : 'نام کاربری' ?>
                </span>
                <i class="fas fa-user-alt fa-lg"></i>
              </a>
            </li>

            <li class="nav-item border-right mb-1">
              <a href="<?= url() ?>/public/auth/logout.php"
                class="nav-link d-flex align-items-center justify-content-center">
                <span class="me-2">خروج</span>
                <i class="fas fa-sign-out-alt fa-lg"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <!-- end header -->

  <div class="wrapper">
    <!-- aside -->
    <aside class="aside bg-light">
      <div class="sticky-top">
        <div class="aside-container">
          <div class="aside-toggle py-3 d-flex justify-content-end">
            <label class="switch mx-1">
              <input id="aside-checkbox"
                type="checkbox"
                checked>
              <span class="slider round"></span>
            </label>
          </div>
          <div class="aside-dialog">
            <a href="<?= url() ?>/public/admin/dashboard"
              class="aside-item <?= isset($active_category['dashboard']) && $active_category['dashboard'] ? 'active' : '' ?>">
              <div class="aside-icon px-1">
                <i class="fas fa-home fa-lg"></i>
              </div>

              <div class="aside-content">داشبورد</div>
            </a>

            <a href="<?= url() ?>/public/admin/articles"
              class="aside-item <?= isset($active_category['articles']) && $active_category['articles'] ? 'active' : '' ?>">
              <div class="aside-icon px-2">
                <i class="fas fa-file-alt fa-lg"></i>
              </div>

              <div class="aside-content">مقالات</div>
            </a>

            <a href="<?= url() ?>/public/admin/comments"
              class="aside-item <?= isset($active_category['comments']) && $active_category['comments'] ? 'active' : '' ?>">
              <div class="aside-icon px-1">
                <i class="fas fa-comments fa-lg"></i>
              </div>

              <div class="aside-content">نظر‌ها</div>
            </a>

            <a href="<?= url() ?>/public/admin/categories"
              class="aside-item <?= isset($active_category['categories']) && $active_category['categories'] ? 'active' : '' ?>">
              <div class="aside-icon px-1">
                <i class="fas fa-folder-open fa-lg"></i>
              </div>

              <div class="aside-content">دسته‌بندی‌ها</div>
            </a>
          </div>
        </div>
      </div>
    </aside>
    <!-- end aside -->