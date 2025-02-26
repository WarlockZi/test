import {fragmentDate} from '../../common'
import './date.scss'
import {ael} from "@src/constants.js";

export default class CustomDate {
   constructor(date) {
      this.date = date;
      this.date[ael]('change', this.onChange.bind(this));
   }

   onChange({target}) {
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
