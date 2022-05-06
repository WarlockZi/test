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


  let button = $('.test-edit__menu-toggle')[0]
  if (button) {
    $(button).on('click', function () {
      let menu = $('.accordion_wrap')[0]
      menu.classList.toggle('open')
    })
  }

}
