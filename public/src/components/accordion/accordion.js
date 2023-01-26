import './accordion.scss'
import {$} from '../../common'

let accordions = $('[accordion]')
if (accordions) {
  $('[accordion]').on('click', handle)
}

function handle({target}) {
  let li = target.closest('li')
  // debugger
  if (!li) return

  let ul = $(li).find('ul')
  if (!ul) {
    li.classList.toggle('rotate')
  } else {
    if (ul.classList.contains('open')) {
      close(ul, li)
    } else {
      if (!ul) return
      let parent = li.closest('ul')
      closeSiblings(parent)
      open(ul, li, parent)
    }
  }
}

function closeSiblings(parent) {
  if (!parent) return
  let open = $(parent).find('li>ul.open')
  if (open) {
    let li = open.closest('li')
    close(open, li)
  }
}

function open(ul, li, parent) {
  if (parent) {
    parent.style.maxHeight = ul.scrollHeight + parent.scrollHeight + "px";
  }
  ul.style.maxHeight = ul.scrollHeight + "px";
  ul.classList.toggle('open')
  li.classList.toggle('rotate')
}

function close(ul, li) {
  ul.style.maxHeight = 0 + "px";
  ul.classList.toggle('open')
  li.classList.toggle('rotate')
}

// let checkboxes = $(`[accordion] [type='checkbox']`)
// if (checkboxes) {
//   [...checkboxes].filter(ch => {
//     ch.checked = false
//   })
// }