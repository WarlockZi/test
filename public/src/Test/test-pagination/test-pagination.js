import './test-pagination.scss'
import {$} from "../../common";

let pagination = $('.pagination')[0]

if (pagination) {
  navInit()
  $(pagination).on('click', handleClick)
}

function handleClick({target}) {

  if (!target.dataset.pagination) return;

  if (target.classList.contains('active')) return

  let active_btn = $('.pagination .active')[0]
  active_btn.classList.remove('active')
  target.classList.add('active')

  let id_to_hide = active_btn.dataset['pagination']
  $(`.question[data-id="${id_to_hide}"]`).removeClass('show')

  let id_to_show = target.dataset['pagination']
  $(`.question[data-id="${id_to_show}"]`).addClass('show')
}

function navInit() {
  let nav_buttons = $('[data-pagination]')
  if (!nav_buttons[0]) return false
  Array.from(nav_buttons).map((nav) => {
    nav.classList.remove('active')
  })
  nav_buttons[0].classList.add('active')
}

// export {navInit}


