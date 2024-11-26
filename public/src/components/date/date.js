import {$, fragmentDate} from '../../common'
import './date.scss'
import {ael} from "@src/constants.js";
// import dispatchEvent from "sortablejs/src/EventDispatcher.js";

const dates = $('[custom-date]')

if (dates) {
   for (let date of dates) {
      date[ael]('change', onChange)
   }

   function onChange({target}) {
      const {yyyy, mm, dd} = fragmentDate(target.value)
      const formated = `${yyyy}-${mm}-${dd}`
      target.setAttribute('data-value', formated)
      const customEvent =
         new CustomEvent('date.changed',
            {bubbles: true, cancelable: true, detail: {value: formated}}
         )
      target.dispatchEvent(customEvent)
   }
}
