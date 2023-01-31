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
      // li.querySelector('.arrow').classList.toggle('rotate')

      let parent = li.closest('.open')
      if (parent)
        if (parent.closest('li')) {
          parent = parent.closest('li').closest('ul')
        }
      // let parent2 = li.closest('.open').closest('ul')
      // let parent = parent1??parent2
      closeSiblings(parent)
      // let parentli = li.closest('ul')
      // open(ul, li, parentli)
      // let parentUl = li.closest('ul').closest('li')
      open(ul, li, parent)
    }
  }
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
  li.querySelector('.arrow').classList.toggle('rotate')
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