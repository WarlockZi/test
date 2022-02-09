import './accordion.scss'
import {$} from '../../common'


$('.accordion label').on('click', handleToggle)

window.onload = function () {
// debugger
let checkboxes = $('.admin-layout__sidebar.accordion input[type=checkbox]').el
  if (checkboxes){
    [...checkboxes].filter(ch=>{
      ch.checked = false
    })
  }
}

function handleToggle(e) {

  let checkbox = e.target.previousElementSibling
  let parent = checkbox.closest('ul')
  let ul = $(checkbox.parentNode).find('ul')


  if (checkbox.checked) {
    slideUp(ul, 0,)
  } else {
    parent.style.height = "auto"
    slideDown(ul)
    let ulHeight = ul.scrollHeight
    increaseParent(parent, ulHeight)
    // debugger
    closeSiblings(parent)
  }
}

function increaseParent(parent, ulHeight) {
  if (!parent.classList.contains('accordion')) {
    let parentHeight = parseInt(parent.style.maxHeight) + ulHeight
    parent.style.maxHeight = parentHeight + "px";
  }
}



function slideDown(ul, callback) {
  ul.style.maxHeight = ul.scrollHeight + "px";
  if (callback) {
    callback()
  }
}

function closeSiblings(parent) {
  Array.from(parent.children).map((el) => {
      let elArr = Array.from(el.children)
      elArr.map((ch) => {
        if (ch.type && ch.type === 'checkbox' && ch.checked) {
          let ul = $(ch.parentNode).find('ul')
          slideUp(ul, 0, function () {
            ch.checked = false
          })
        }
      })
    }
  )
}

function slideUp(ul, interval, callback) {
  ul.style.maxHeight = 0 + "px";
  if (callback) {
    callback()
  }
}





