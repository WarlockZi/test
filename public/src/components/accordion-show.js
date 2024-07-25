import {$} from "../common";
import {document} from "postcss";
import {ael, qa, qs} from '../constants'

export default class adminAccordion {
   constructor() {
      let currentTestId = +document['qs'](`[data-testid]`).dataset['testid']
      let menuItemCollection = document[qa]('.test-edit.accordion a')
      Array.from(menuItemCollection).filter((a) => {
         if (+a.dataset.id === currentTestId) {
            a.classList.add('current')
         }
      })

      document[qs]('.accordion-open')[ael]('click', function () {
         let menu = $('.accordion_wrap')[0]
         menu.classList.toggle('open')
      })

      document[qs]('#burger')[ael]('click', function () {
         let admin_sidebar = $('.admin_sidebar')[0]
         admin_sidebar.classList.toggle('open')
      })
   }
}
