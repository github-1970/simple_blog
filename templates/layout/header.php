<!DOCTYPE html>
<html lang="en"
  dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible"
    content="IE=edge">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">
  <title>Simple Blog</title>
  <link rel="stylesheet"
    href="css/styles.css">
  <script defer
    type="module"
    src="js/index.js"></script>
</head>

<body class="position-relative">

  <!-- navbar -->
  <div class="navbar-container fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div
        class="container py-2 d-flex justify-content-between flex-row-reverse">
        <a class="navbar-brand"
          href="/public"><span
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
                href="#">خانه</a>
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

              $categories = $conn->query("SELECT * FROM categories");
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
            <li class="nav-item">
              <a href="/public/login.php" class="nav-link d-flex align-items-center justify-content-center">
                <span class="me-2">ورود</span>
                <i class="fas fa-user fa-lg"></i>
              </a>
            </li>

            <li class="nav-item signup">
              <a href="/public/register.php" class="nav-link d-flex align-items-center justify-content-center">
                <span class="me-2">ثبت نام</span>
                <i class="fas fa-user-plus fa-lg"></i>
              </a>
            </li>

            <!-- for sign out, when logged in -->
            <li class="nav-item d-none">
              <a href="#" class="nav-link d-flex align-items-center">
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

