<?php
// destroy session error in start
// use "if" and "isset" for prevent undefined variable error
prepareReceiveError();

if( isset($_SESSION['subscribe']['message']) ){
  $_SESSION['subscribe']['new_message'] = $_SESSION['subscribe']['message'];
  $_SESSION['subscribe']['message'] = '';
}
else{
  $_SESSION['subscribe']['new_message'] = '';
}
?>

<!-- main container -->
<div class="main-container my-5">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-4 order-2 order-md-0 mt-5 mt-md-0">
        <aside>
          <div class="card bg-light">
            <div class="card-body">
              <h4 class="mb-3">جستجو در مقالات وبلاگ</h4>

              <form action="<?= url() ?>/public/search.php" method="get">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control shadow-none"
                    id="searchInput"
                    name="search"
                    value="<?= isset($search) ? displaySearch($search) : '' ?>"
                    placeholder="جستجو..."
                  />
                  <?= displayError('search') ?>

                  <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search fa-lg"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="list-group mt-4">
            <div class="list-group-item bg-light">
              <h4>دسته‌بندی‌ها</h4>
            </div>

            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/database/dbConnection.php';

            $categories = $conn->query("SELECT c.*, COUNT(p.category_id) as
            posts_count FROM `categories` c INNER JOIN `posts` p ON c.id =
            p.category_id GROUP BY p.category_id;");
            $categories =
            $categories->fetchAll(PDO::FETCH_OBJ);
            $category_id_in_url =
            isset($_GET['category_id']) ? $_GET['category_id'] : '';

            foreach($categories as $category) {
              $active_category = ($category_id_in_url
            && $category_id_in_url == $category->id); 
            ?>

            <!-- style for active item
            <div class="list-group-item list-group-item-action active">
              <a href="#" class="d-flex align-items-center justify-content-between">
                <span>طبیعت</span>
                <span class="badge bg-primary rounded-pill bg-light text-dark">14</span>
              </a>
            </div> -->

            <div
              class="list-group-item list-group-item-action<?= $active_category ? ' active' : '' ?>"
            >
              <a
                href="category.php?category_id=<?= $category->id ?>"
                class="d-flex align-items-center justify-content-between"
              >
                <span><?= $category->title ?></span>

                <span class="badge bg-primary rounded-pill<?= $active_category ? ' bg-light text-dark' : '' ?>">
                    <?= $category->posts_count ?>
                </span>
              </a>
            </div>

            <?php } ?>
          </div>

          <div class="card bg-light mt-4">
            <div class="card-body">
              <h4 class="mb-3">عضویت در خبرنامه</h4>

              <form action="<?= url() ?>/public/subscribe.php" method="post">
                <div class="form-floating">
                  <input
                    name="name"
                    type="text"
                    class="form-control"
                    id="newslettersText"
                    placeholder="نام خود را وارد کنید..."
                  />
                  <label for="newslettersText">نام خود را وارد کنید...</label>

                  <?= displayError('name') ?>

                </div>

                <div class="form-floating mt-3">
                  <input
                    name="email"
                    type="email"
                    class="form-control"
                    id="newslettersEmail"
                    placeholder="ایمیل خود را وارد کنید..."
                  />
                  <label for="newslettersEmail"
                    >ایمیل خود را وارد کنید...</label
                  >

                  <?= displayError('email') ?>

                </div>
                <input
                  type="submit"
                  class="btn btn-outline-primary w-100 mt-3"
                  value="عضویت"
                />

                <input class="border-0" type="text"  style="width: 0; height: 0;"
                <?= hasError() ? 'autofocus' : '' ?>
                >
              </form>
              
              <!-- alert -->
              <?php if(subscribeIsSuccuss()){ ?>

              <div class="alert alert-success p-alert mt-3">
                <p class="h4 mb-3">عضویت شما در خبرنامه با موفقیت ثبت شد</p>
                <p class="text-danger">
                  <span class="fw-bolder">نکته: </span>
                  <span>عضویت در خبرنامه به معنای ثبت نام در سایت نیست!</span>
                </p>
                <input type="button" autofocus class="btn btn-primary w-100 mt-3" value="باشه" data-bs-dismiss="alert"></input>
              </div>

              <!-- <script defer>
                let pAlert = document.querySelector('.p-alert')
                setTimeout(() => {
                  pAlert.classList.add('d-none')
                }, 5000);
              </script> -->

              <?php } ?>
              <!-- end alert -->

            </div>
          </div>

          <div class="card bg-light mt-4">
            <div class="card-header">
              <h4>درباره ما</h4>
            </div>

            <div class="card-body">
              <p>
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
                استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله
                در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد
                نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد،
                کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان
                جامعه و متخصصان را می طلبد.
              </p>
            </div>
          </div>
        </aside>
      </div>