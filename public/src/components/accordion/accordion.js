import './accordion.scss'
import {$} from '../../common'

let accordions = $('[accordion]')
if (accordions) {

  let checkboxes = $(`[accordion] [type='checkbox']`)
  if (checkboxes) {
    [...checkboxes].filter(ch => {
      ch.checked = false
    })
  }

  [].forEach.call(accordions, function (acc) {
  // debugger
    $(acc).on('click', handleToggle)
  })
}


function handleToggle({target}) {

  let accordion = target.closest('[accordion]')
  let li = target.closest('li')
  let checkbox = $(li).find(`[type='checkbox']`)
  let ul = $(li).find('ul')


  if (checkbox.checked) {
    slideUp(ul, 0,)
  } else {
    accordion.style.height = "auto"
    slideDown(ul)
    let ulHeight = ul.scrollHeight
    increaseParent(accordion, ulHeight)
    // debugger
    closeSiblings(accordion)
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





