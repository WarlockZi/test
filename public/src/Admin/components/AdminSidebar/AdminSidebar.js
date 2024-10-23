import './adminSidebar.scss'
import {$} from '../../../common'
import {ael, qs} from "../../../constants.js";

export default class AdminSidebar {
   constructor(sidebar) {
      if (!sidebar) return false

      this.sidebar = sidebar
      this.burger = sidebar[qs]('#burger')
      sidebar[ael]('click', this.handleClick.bind(this));

   }

   handleClick({target}) {
      if (target === this.burger) {
         this.sidebar[qs]('.wrap').classList.toggle('show')
      } else {
         this.openUl(target)
      }
   }

   openUl(target) {
      const li = target.closest('li')
      if (!li.classList.contains('open')) {
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