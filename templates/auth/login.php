<?php

sessionStart();

// check user is login
if(checkUserLoggedIn()){
  redirect(url() . '/public');
}

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

<div
  class="login-container d-flex justify-content-center align-items-center container">
  <div
    class="form-container mt-5 mb-2 mx-md-5 bg-white rounded text-center shadow-lg w-100">
    <div class="row">
      <div class="col-12 d-none d-lg-block col-lg-6 img-login"></div>

      <div class="col-12 col-lg-6">
        <form method="post" class="p-5"
          action="<?= url() ?>/modules/auth/login.php">
          <h2 class="text-secondary mb-5">ورود به حساب کاربری</h2>

          <div class="mb-4">
            <?= displayError('global') ?>
            <input name="email" type="email"
              class="form-control"
              placeholder="ایمیل">
            <?= displayError('email') ?>
          </div>

          <div class="mb-4">
            <input name="password" type="password"
              class="form-control"
              placeholder="رمز ورود">
            <?= displayError('password') ?>
          </div>

          <div class="form-check ms-1 mb-4 text-start">
            <input name="remember" class="form-check-input"
                type="checkbox"
                id="formCheck">
              <label class="form-check-label"
                for="formCheck">
                مرا به خاطر بسپار
              </label>
          </div>

          <div class="mb-4">
            <input type="submit"
              value="ورود"
              class="btn btn-primary w-100">
          </div>

          <hr class="mb-4 d-none">

          <div class="mb-2 d-none">
            <a href="#"
              class="btn btn-danger w-100">
              <i class="fab fa-google"></i>
              <span>ورود با حساب گوگل</span>
            </a>
          </div>

          <div class="mb-4 d-none">
            <a href="#"
              value=""
              class="btn btn-facebook w-100">
              <i class="fab fa-facebook-f"></i>
              <span>ورود با حساب فیسبوک</span>
            </a>
          </div>

          <hr class="mb-4">

          <footer class="pt-1">
            <div class="mb-3 d-none">
              <a href="#">آیا رمز ورود خود را فراموش کرده اید؟</a>
            </div>

            <div>
              <a href="<?= url() ?>/public/auth/register.php">ساخت حساب کاربری جدید!</a>
            </div>
          </footer>
        </form>
      </div>
    </div>
  </div>
</div>