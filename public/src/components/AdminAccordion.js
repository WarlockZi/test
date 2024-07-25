import {$} from '../common'
import {ael, qs} from "../constants";

export default class AdminAccordion {
 constructor() {
   document[qs]('svg#burger')[ael]('click', function () {
     let accordion = $('.admin_sidebar [accordion]')[0]
     accordion.classList.toggle('show')
   })

 }

}

