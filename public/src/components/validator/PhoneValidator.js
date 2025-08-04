import BaseValidator from "@src/components/validator/BaseValidator.js";

export default class PhoneValidator extends BaseValidator {
  constructor() {
    super();
  }

  validate(phone) {
    const replacePattern = /[0-9\(\)\s\+-]*/g;

    if (phone.replace(replacePattern, "").length) {
      this._errors.push("Разрешены цифры, пробел, скобки, знак +, знак -");
    }
    // return this;
  }
}
