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
  $('[accordion]').on('click', handle)
}

function handle({target}) {
  let li = target.closest('li')
  if (!li) return

  let accordion = li.closest('[accordion]')
  let ul = $(li).find('ul')
  if (!ul) {
    rotateArrow(li)
  } else {
    if (ul.classList.contains('open')) {
      slideUp(ul, li)
    } else {
      // accordion.style.height = "auto"
      if (!ul) return
      let parent = li.closest('ul')
      closeSiblings(parent)
      slideDown(ul, li, parent)
    }
  }
}

function closeSiblings(parent) {
  if (!parent) return
  let open = $(parent).find('li>ul.open')
  if (open) {
    let li = open.closest('li')
    slideUp(open, li)
  }
}

function slideDown(ul, li, parent) {
  if (parent) {
    parent.style.maxHeight = ul.scrollHeight + parent.scrollHeight + "px";
  }
  ul.style.maxHeight = ul.scrollHeight + "px";
  ul.classList.toggle('open')
  li.classList.toggle('rotate')
}

function slideUp(ul, li) {
  ul.style.maxHeight = 0 + "px";
  ul.classList.toggle('open')
  li.classList.toggle('rotate')
}

function rotateArrow(li) {
  li.classList.toggle('rotate')
}

function increaseParent(parent, ulHeight) {
  if (!parent.classList.contains('accordion')) {
    let parentHeight = parseInt(parent.style.maxHeight) + ulHeight
    parent.style.maxHeight = parentHeight + "px";
  }
}