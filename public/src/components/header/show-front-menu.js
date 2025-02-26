import {$} from '../../common.js'

export default function headerMenu() {

   const menu = $('.header-catalog-menu__wrap').first()
   if (!menu) return false

   $(menu).on('click', '.arrow', ({target}) => {
      const ul = $(target.closest('li')).find('ul')
      ul.classList.toggle('visible')
   })
}

