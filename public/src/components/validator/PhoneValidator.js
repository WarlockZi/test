import BaseValidator from "@src/components/validator/BaseValidator.js";

export default class PhoneValidator extends BaseValidator {
   constructor(obj) {
      super(obj);

      const replacePattern = /[0-9\(\)\s\+-]*/g

      if (obj.value.replace(replacePattern, '').length) {
         this.errors.push("Разрешены цифры, пробел, скобки, знак +, знак -")
      }
      return this.errors
   }

}