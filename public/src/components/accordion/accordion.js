import './accordion.scss'
import {$} from '../../common'
import showCustomMenu from "./customMenu/customMenu";

$('label').on('click', handle)

// window.oncontextmenu = showCustomMenu


function handle(e) {

  let checkbox = e.target.previousSibling
  let parent = checkbox.closest('ul')
  let ul = checkbox.nextSibling.nextSibling


  if (checkbox.checked) {
    slideUp(ul, 0,)
  } else {
    parent.style.height = "auto"
    let height = slideDown(ul, 0)
    increaseParent(parent, height)
    closeSiblings(parent)
  }
}

function increaseParent(parent, height) {
  if (!parent.classList.contains('accordion')) {
    let final = height + parseInt(parent.style.maxHeight)
    parent.style.maxHeight = final + "px";
  }
}

function slideDown(ul, interval, callback) {
  ul.style.maxHeight = ul.scrollHeight + "px";
  if (callback) {
    callback()
  }
  return ul.scrollHeight
}

function closeSiblings(parent) {
  Array.from(parent.children).map((el) => {
      let elArr = Array.from(el.children)
      elArr.map((ch) => {
        if (ch.type && ch.type === 'checkbox' && ch.checked) {
          let ul = ch.nextSibling.nextSibling
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





