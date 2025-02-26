import './adminSidebar.scss'
import {$} from '@src/common.js'
import {ael, qs} from "@src/constants.js";

export default class AdminSidebar {
   constructor(sidebar) {
      if (!sidebar) return false

      this.sidebar = sidebar
      this.sidebar[ael]('click', this.handleClick.bind(this));


      this.burger = document[qs]('.burger')
      this.burger[ael]('click', this.handleClick.bind(this));

   }

   handleClick({target}) {
      if (target === this.burger) {
         this.sidebar.classList.toggle('show')

      } else {
         this.openUl(target)
      }
   }

   openUl(target) {
      const li = target.closest('li')
      if (!li) return
      if (!li?.classList?.contains('open')) {
         this.closeUls()
      }
      li.classList.toggle('open')
      this.rotateArrow(li)
   }

   closeUls() {
      const opened = $(this.sidebar).find('.open')
      if (opened) {
         const arrow = opened[qs]('.rotate')
         arrow.classList.toggle('rotate')
         opened.classList.toggle('open')
      }
   }

   rotateArrow(li) {
      const arrow = $(li).find('.arrow')
      if (!arrow) return
      arrow.classList.toggle('rotate')
   }

}