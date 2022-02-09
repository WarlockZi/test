import {$} from "../common";

export function accordion_show() {

  let showTestList = $('.test-edit__menu-toggle')[0]

  if (showTestList) {
    $(showTestList).on('click', (e) => {
      let showTestList = e.target
      // let wraper = showTestList.closest('.test-edit-wrapper')
      let menu = $('.test-edit__accordion')[0]
      menu.classList.toggle('open')
    })
  }
}
