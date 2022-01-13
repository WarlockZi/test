import './accordion.scss'
import {$} from '../../common'
import showCustomMenu from "./customContextMenu/customMenu";

$('.accordion label').on('click', handleToggle)

window.onload = function () {
let checkboxes = $('.admin-layout__sidebar.accordion input[type=checkbox]').el
  if (checkboxes){
    [...checkboxes].filter(ch=>{
      ch.checked = false
    })
  }
}




// $('.test-edit__accordion .accordion a').on('mouseenter', showCustomMenu)
// $('.test-edit__accordion .accordion label').on('mouseenter', showCustomMenu)


function handleToggle(e) {

  let checkbox = e.target.previousElementSibling
  let parent = checkbox.closest('ul')
  let ul = $(checkbox.parentNode).find('ul')


  if (checkbox.checked) {
    slideUp(ul, 0,)
  } else {
    parent.style.height = "auto"
    slideDown(ul)
    let ulHeight = getUlHeight(ul)
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

function getUlHeight(ul) {
  return ul.scrollHeight
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





