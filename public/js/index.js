import './vendor/bootstrap.bundle.min.js'
import './vendor/fontawesome.min.js'

// import "text" if require element is exists
if(document.querySelector('#text')){
  import('./vendor/textEditor.js')
}
// import "sidebar" if require element is exists
if (document.querySelector('#aside-checkbox')) {
  import('./sidebar.js')
}

// scroll indicator
if(document.querySelector(".p-progress-bar")){
  window.onscroll = function() {myFunction()}
}

function myFunction() {
  let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  let scrolled = (winScroll / height) * 100;
  document.querySelector(".p-progress-bar").style.width = scrolled + "%";
}
// end scroll indicator

let domain = new URL(window.location.href);
if(domain.pathname.search('register') > 0 || domain.pathname.search('login')  > 0){
  document.body.classList.add('bg-light')
  document.body.classList.add('d-flex')
  document.body.classList.add('flex-column')
  document.body.classList.add('justify-content-center')
}

function preservePlace(id, targetId, height=true, width=true){
  let elem = document.querySelector('#'+id)
  let targetElem = document.querySelector('#'+targetId)
  let elemWidth = elem.clientWidth
  let elemHeight = elem.clientHeight

  targetElem.style.width = elemWidth + 'px'
  targetElem.style.height = elemHeight + 'px'
}
