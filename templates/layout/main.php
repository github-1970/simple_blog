<!-- main container -->
<div class="main-container my-5">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-4 order-2 order-md-0 mt-5 mt-md-0">
        <aside>
          <div class="card bg-light">
            <div class="card-body">
              <h4 class="mb-3">جستجو در مقالات وبلاگ</h4>

              <form action="#" method="get">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control shadow-none"
                    id="searchInput"
                    name="search"
                    placeholder="جستجو..."
                  />
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
              <a href="#" class="d-flex align-items-center justify-content-lg-between">
                <span>طبیعت</span>
                <span class="badge bg-primary rounded-pill bg-light text-dark">14</span>
              </a>
            </div> -->

            <div
              class="list-group-item list-group-item-action<?= $active_category ? ' active' : '' ?>"
            >
              <a
                href="category?category_id=<?= $category->id ?>"
                class="d-flex align-items-center justify-content-lg-between"
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

              <form action="#" method="get">
                <div class="form-floating">
                  <input
                    type="text"
                    class="form-control"
                    id="newslettersText"
                    placeholder="نام خود را وارد کنید..."
                  />
                  <label for="newslettersText">نام خود را وارد کنید...</label>
                </div>

                <div class="form-floating mt-3">
                  <input
                    type="email"
                    class="form-control"
                    id="newslettersEmail"
                    placeholder="ایمیل خود را وارد کنید..."
                  />
                  <label for="newslettersEmail"
                    >ایمیل خود را وارد کنید...</label
                  >
                </div>
                <input
                  type="submit"
                  class="btn btn-outline-primary w-100 mt-3"
                  value="عضویت"
                />
              </form>
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