import './vendor/bootstrap.bundle.min.js'
import './vendor/fontawesome.min.js'

// scroll indicator
window.onscroll = function() {myFunction()};

function myFunction() {
  let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  let scrolled = (winScroll / height) * 100;
  document.querySelector(".p-progress-bar").style.width = scrolled + "%";
}
// end scroll indicator

let domain = new URL(window.location.href);
if(domain.hostname.search('register') || domain.hostname.search('login')){
  document.body.classList.add('bg-light')
  document.body.classList.add('d-flex')
  document.body.classList.add('flex-column')
  document.body.classList.add('justify-content-center')
}

