import BaseValidator from "@src/components/validator/BaseValidator.js";

export default class EmailValidator extends BaseValidator {
  constructor() {
    super();

    this.email = "";
    this.min = 2;
    this.minLengthAfterAt = "(.){2,}@(.){2,}";
    this.dot = ".";
    this.domainLength = "^(.){2,}@(.){2,}\.(.){2,}$";
  }

  validate(mail) {
    this.email = decodeURI(mail); //иначе русские буквы после @ шифруются в url
    const replacePattern = /[a-zA-Z0-9\@\-\_\.]*/;
    if (!this.email.length) {
      this._errors.push("Поле не должно быть пустым");
    }
    if (this.email.replace(replacePattern, "").length) {
      this._errors.push("Разрешены только английские");
    }
    if (this.email.length < this.min) {
      this._errors.push("Длина меньше 2 символов");
    }
    if (!/[\@]/.test(this.email)) {
      this._errors.push("Нет знака @");
    }
    if (!this.email.match(this.minLengthAfterAt)) {
      this._errors.push("Меньше 2 знаков после @");
    }
    if (!this.email.includes(this.dot)) {
      this._errors.push("Нет точки");
    }
    if (!this.email.match(this.domainLength)) {
      this._errors.push("Меньше 2 знаков После точки");
    }
    return this;
  }
}
