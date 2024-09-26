import './accordion.scss'
import {$} from '../../common'
import {ael} from "../../constants.js";

export default class Accordion {
   constructor(accordion) {
      if (!accordion) return false
      this.arrowSelector = '.arrow'
      this.rootUl = $(accordion).find('[accordion]')

      accordion[ael]('click', this.handleClick.bind(this));

   }

   handleClick({target}) {
      const li = target.closest('li')
      if (!li) return

      const ul = $(li).find('ul')
      if (!ul) {
         this.rotateArrow(li)
      } else {
         if (ul.classList.contains('open')) {
            this.close(ul, li)
         } else {
            this.closeSiblings(li.closest('ul'))
            const parent = li.closest('.open')
            this.open(ul, li, parent)
         }
      }
   }

   rotateArrow(li) {
      const arrow = $(li).find(this.arrowSelector)
      if (!arrow) return
      arrow.classList.toggle('rotate')
   }


   closeSiblings(parent) {
      if (!parent || parent === this.rootUl) return
      const open = $(parent).find('.open')
      if (open) {
         const li = open.closest('li')
         this.close(open, li)
      }
   }

   close(ul, li) {
      ul.style.maxHeight = 0 + "px";
      ul.classList.toggle('open')
      this.rotateArrow(li)
      this.closeChild(ul)
   }

   closeChild(ul) {
      const openedChild = ul.querySelector('.open')
      if (openedChild) {
         openedChild.style.maxHeight = 0 + "px";
      }
   }

   open(ul, li, parent) {
      if (parent) {
         parent.style.maxHeight = ul.scrollHeight + parent.scrollHeight + "px";
      }
      ul.style.maxHeight = ul.scrollHeight + "px";
      ul.classList.toggle('open')
      li.querySelector(this.arrowSelector).classList.toggle('rotate')
   }

}