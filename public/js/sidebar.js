let asideContainer = document.querySelector('.aside-container')
let asideCheck = document.querySelector('#aside-checkbox')
let counter = 20

// in start
if (window.matchMedia('(max-width: 768px)').matches) {
  // asideContainer.style.width = '2.5rem'
  asideCheck.checked = false
}

// for window resize
window.addEventListener('resize', function(){
  if(asideCheck.checked){
    asideContainer.style.width = '20rem'
  }
  else{
    asideContainer.style.width = '2.5rem'
  }
})


asideCheck.addEventListener('click', function(){
  let asideChecked = document.querySelector('#aside-checkbox:checked')
  if(!asideChecked)
  {
    counter = 20
    let counterDelay = setInterval(() => {
      counter--
      asideContainer.style.width = counter + 'rem'
      if(counter <= 3){
        asideContainer.style.width = '2.5rem'
        clearInterval(counterDelay)
      }
    }, 0);
  }
  else
  {
    counter = 0
    let counterDelay = setInterval(() => {
      counter++
      asideContainer.style.width = counter + 'rem'
      if(counter >= 20){
        clearInterval(counterDelay)
      }
    }, 0);
  }
})
