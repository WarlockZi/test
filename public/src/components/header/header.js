import {$} from '../../common'
import './header.scss'

debugger
let gumburger = $('.gamburger')[0]
if (gumburger) {
  $('.gamburger').on('click', opentMobilePanel)

}

function opentMobilePanel(e) {
  let mm = e.target.closest('.utils').querySelector('.mobile-menu')
  mm.classList.toggle('show')
}
