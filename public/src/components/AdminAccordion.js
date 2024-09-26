import {$} from '../common'
import {ael, qs} from "../constants";

export default class AdminAccordion {
   constructor() {
      this.burger = document[qs]('svg#burger')
      this.accordion = $('.admin-sidebar [accordion]').first()

      this.burger[ael]('click', this.handleClick.bind(this))
      // this.accordion[ael]('click', this.handleClick.bind(this))
   }

   handleClick({target}) {
      if (target === this.burger) {
         this.accordion.classList.toggle('show')
      }
      // else {
      //    const li = target.closest('li')
      //    li.classList.toggle('open')
      // }


   }
}

