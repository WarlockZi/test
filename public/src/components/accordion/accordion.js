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
    rotateArrow(li)
  } else {
    if (ul.classList.contains('open')) {
      close(ul, li)
    } else {
      let parentUl = getParentUl(li)
      closeSiblings(parentUl)
      parent = getParent(li)
      open(ul, li, parent)
    }
  }
}
function rotateArrow(li) {
  let arrow = $(li).find('.arrow')
  if (!arrow) return
  arrow.classList.toggle('rotate')
}

function getParent(li) {
  let parent = li.parentNode.closest('.open')
  if (parent) {
    return parent.closest('ul')
  } else {
    return null
  }
}

function getParentUl(li) {
  let parent = li.closest('.open')
  return parent ?? null
}



function closeSiblings(parent) {
  if (!parent) return
  let open = $(parent).find('.open')
  if (open) {
    let li = open.closest('li')
    close(open, li)
  }
}

function close(ul, li) {
  ul.style.maxHeight = 0 + "px";
  ul.classList.toggle('open')
  rotateArrow(li)
  closeChild(ul)
}

function closeChild(ul) {
  let openedChild = ul.querySelector('.open')
  if (openedChild) {
    openedChild.style.maxHeight = 0 + "px";
  }
}

function open(ul, li, parent) {
  if (parent) {
    parent.style.maxHeight = ul.scrollHeight + parent.scrollHeight + "px";
  }
  ul.style.maxHeight = ul.scrollHeight + "px";
  ul.classList.toggle('open')
  li.querySelector('.arrow').classList.toggle('rotate')
}

// let checkboxes = $(`[accordion] [type='checkbox']`)
// if (checkboxes) {
//   [...checkboxes].filter(ch => {
//     ch.checked = false
//   })
// }