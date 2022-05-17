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
  // li.classList.toggle('rotate')

  let accordion = li.closest('[accordion]')
  let ul = $(li).find('ul')
  if (!ul) return;
  if (ul.classList.contains('open')) {
    slideUp(ul,li)
  } else {
    if (!ul) return
    closeSiblings(accordion)
    // accordion.style.height = "auto"
    slideDown(ul,li)
  }
}

function closeSiblings(accordion) {
  let ul = $(accordion).find('.open')
  if (ul) {
  let li = ul.closest('li')
    slideUp(ul,li)
  }
}

function slideDown(ul, li) {
  ul.style.maxHeight = ul.scrollHeight + "px";
  ul.classList.toggle('open')
  li.classList.toggle('rotate')
}

function slideUp(ul,li) {
  ul.style.maxHeight = 0 + "px";
  ul.classList.toggle('open')
  li.classList.toggle('rotate')
}


function increaseParent(parent, ulHeight) {
  if (!parent.classList.contains('accordion')) {
    let parentHeight = parseInt(parent.style.maxHeight) + ulHeight
    parent.style.maxHeight = parentHeight + "px";
  }
}