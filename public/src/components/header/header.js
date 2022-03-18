import {$} from '../../common'
import './header.scss'

debugger
let gumburger = $('.gamburger')[0]
if (gumburger) {
  let mobileMenu = $('.gamburger').on('click', mobile)

}

function mobile(e) {
  let mm = e.target.closest('.utils').querySelector('.mobile-menu')
  mm.classList.toggle('show')
}
