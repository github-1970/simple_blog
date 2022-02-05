<?php

sessionStart();

// destroy session error in start
// use "if" and "isset" for prevent undefined variable error
if( isset($_SESSION['error']) ){
  $_SESSION['new_error'] = $_SESSION['error'];
  $_SESSION['error'] = '';
}
else{
  $_SESSION['new_error'] = '';
}

?>

<div class="register-container d-flex justify-content-center align-items-center container">
  <div class="form-container mt-5 mb-2 mx-md-5 bg-white rounded text-center shadow-lg w-100">
    <div class="row">
      <div class="col-12 d-none d-lg-block col-lg-5 img-register"></div>

      <div class="col-12 col-lg-7">
        <form class="p-5" action="<?= url() ?>/modules/auth/register.php" method="post">
          <h2 class="text-secondary mb-5">ساخت حساب کاربری</h2>

          <div class="row">
            <div class="col-12 col-md-6">
              <div class="mb-4">
                <input name="name" type="text" class="form-control" placeholder="نام">
                <?= displayError('name') ?>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="mb-4">
                <input name="family" type="text" class="form-control" placeholder="نام خانوادگی">
                <?= displayError('family') ?>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <input name="email" type="email" class="form-control" placeholder="ایمیل">
            <?= displayError('email') ?>
          </div>

          <div class="row">
            <div class="col-12 col-md-6">
              <div class="mb-4">
                <input name="password" type="password" class="form-control" placeholder="رمز ورود">
                <?= displayError('password') ?>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="mb-4">
                <input name="rePassword" type="password" class="form-control" placeholder="تکرار رمز ورود">
                <?= displayError('rePassword') ?>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <input type="submit" value="ساخت حساب کاربری" class="btn btn-primary w-100">
          </div>

          <hr class="mb-4 d-none">

          <div class="mb-2 d-none">
            <a href="#" class="btn btn-danger w-100">
              <i class="fab fa-google"></i>
              <span>ساخت حساب کاربری با گوگل</span>
            </a>
          </div>

          <div class="mb-4 d-none">
            <a href="#" value="" class="btn btn-facebook w-100">
              <i class="fab fa-facebook-f"></i>
              <span>ساخت حساب کاربری با فیسبوک</span>
            </a>
          </div>

          <hr class="mb-4">

          <footer class="pt-1">
            <div class="mb-3 d-none">
              <a href="#">آیا رمز ورود خود را فراموش کرده اید؟</a>
            </div>

            <div>
              <a href="<?= url() ?>/public/auth/login.php">آیا از قبل حساب کاربری دارید؟ (login)</a>
            </div>
          </footer>
        </form>
      </div>
    </div>
  </div>
</div>