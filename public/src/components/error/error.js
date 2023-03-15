import './error.scss'
import {$} from '../../common'

export default function error(message) {
  // debugger
  let adm_content = $('.adm-content')[0]
  if (!adm_content) return

  let div = document.createElement('div')
  div.classList.add('message')
  div.classList.add('error')
  div.innerText = message
  adm_content.prepend(div)
  setTimeout(errorHide.bind(this), 3000)

  function errorHide() {
    function errorRemove() {
      div.remove()
    }

    div.style.scale = 0
    setTimeout(errorRemove.bind(this), 500)
  }
}


