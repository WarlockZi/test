import {$} from "../common";

export function accordion_show() {

  $('.test-edit__menu-toggle').on('click', (e) => {
      let menu = $('.test-edit__accordion')[0]
      menu.classList.toggle('open')
    })

}
