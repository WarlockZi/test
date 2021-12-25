import {$} from '../../common'
import './header.scss'

let mobileMenu = $('.gamburger').on('click', mobile)

function mobile(e) {
  let mm = e.target.closest('.utils').querySelector('.mobile-menu')
    mm.classList.toggle('show')
}
