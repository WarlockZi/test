import {ael} from "@src/constants.js";

export default class Checkbox {
   constructor(checkbox) {
      this.id = checkbox.id;
      this.checkbox = checkbox;
      checkbox[ael]('change', this.changed.bind(this));
   }

   async changed({target}) {
      target.dataset.pivotValue= +target.checked
      this.checkbox.dispatchEvent(
         new CustomEvent('checkbox.changed', {
            bubbles:true,
            detail: target.checked})
      );
   }
}