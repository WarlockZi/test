import './showPassword.scss'
import {$} from "../../common";

export default function showPassword() {
  let showPassword = $('.password-control')
  if (showPassword) {
    $('.password-control').on('click', viewPassword)
  }

  function viewPassword({target}) {
    let input = target.parentNode.querySelector('input')
    if (input.getAttribute('type') === 'password') {
      input.setAttribute('type', 'text');
    } else {
      input.setAttribute('type', 'password');
    }
    target.classList.toggle('view')
  }
}