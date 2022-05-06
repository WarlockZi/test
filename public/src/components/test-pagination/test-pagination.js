import './test-pagination.scss'
import {$} from "../../common";


$('.pagination').on('click', handleClick)

function handleClick({target}) {
    // debugger
    if (!target.dataset.pagination) return;

/// get clicked button Return if clicked is active
    if (target.classList.contains('nav-active')) return

    let active_btn = $('.pagination .active')[0]
//// change active button
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
    Array.from(nav_buttons).map((nav)=>{
        nav.classList.remove('nav-active')
    })
    nav_buttons[0].classList.add('nav-active')
}

export { navInit}


