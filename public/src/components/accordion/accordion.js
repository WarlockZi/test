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

  $('[accordion]').on('click', dd)
}

function cc({target}) {
  alert('dd')
}

function dd({target}) {
  if (!target.closest('li')) return
  let accordion = target.closest('[accordion]')
  let li = target.closest('li')
  li.classList.toggle('rotate')
  // let checkbox = $(li).find(`[type='checkbox']`)
  let ul = $(li).find('ul')
  if (!ul) return;
  // let arrow = $(li).find('.arrow')

  ul.classList.toggle('open')
  if (!ul.classList.contains('open')) {
    // arrow.style.transform = 'rotate(270deg)'
    slideUp(ul, 0,)
  } else {
    if (!ul)return
    // arrow.style.transform = 'rotate(0deg)'
    accordion.style.height = "auto"
    slideDown(ul)
    // let ulHeight = ul.scrollHeight
    // increaseParent(accordion, ulHeight)
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

function closeSiblings(parent) {
  Array.from(parent.children).map((el) => {

      [].map.call(el.children,(ch) => {
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

function slideDown(ul, callback) {
  ul.style.maxHeight = ul.scrollHeight + "px";
  if (callback) {
    callback()
  }
}

function slideUp(ul, interval, callback) {
  ul.style.maxHeight = 0 + "px";
  if (callback) {
    callback()
  }
}

