import {$} from "../common";

export default function accordionShow() {

  let button = $('.test-edit__menu-toggle')[0]
  if (button){
    $(button).on('click', function(){
      let menu = $('.test-edit__accordion')[0]
      menu.classList.toggle('open')
    })
  }

}
