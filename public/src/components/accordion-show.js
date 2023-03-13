import {$} from "../common";

export default function accordionShow() {

  let currentTestId = $(`[data-testid]`)[0]
  if (currentTestId) {
    currentTestId = +currentTestId.dataset['testid']
    let menuItemCollection = $('.test-edit.accordion a')
    Array.from(menuItemCollection).filter((a) => {
      if (+a.dataset.id === currentTestId) {
        a.classList.add('current')
      }
    })
  }


  let button = $('.accordion-open')[0]
  debugger
  if (button) {
    $(button).on('click', function () {
      let menu = $('.accordion_wrap')[0]
      menu.classList.toggle('open')
    })
  }

  let admin_sidebar_gumburger = $('#burger')[0]
  if (admin_sidebar_gumburger) {
    $(admin_sidebar_gumburger).on('click', function () {
      let admin_sidebar = $('.admin_sidebar')[0]
      admin_sidebar.classList.toggle('open')
    })
  }


}
