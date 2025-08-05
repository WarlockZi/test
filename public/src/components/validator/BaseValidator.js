export default class BaseValidator {
  constructor(obj) {
    this._errors = [];
    this.min = obj?.min ?? 0;
    this.max = obj?.max ?? 0;
    this.errorMassage = {
      required: "Поле должно быть заполнено",
      min: `Длина меньше ${this.min} символов`,
      max: `Длина больше ${this.max} символов`,
    };
    if (obj === undefined || obj === null || typeof obj === "undefined") {
      return false;
    }
    if (obj?.required) {
      if (!obj.value.length) {
        this._errors.push(this.errorMassage.required);
      }
    }

    if (obj?.min) {
      if (obj.value.length < obj?.min) {
        this._errors.push(this.errorMassage.min);
      }
    }

    if (obj?.max) {
      if (obj.value.length > obj?.max) {
        this._errors.push(this.errorMassage.max);
      }
    }
  }
  get errors() {
    return this._errors;
  }
  set errors(error) {
    this._errors.push(error);
  }
}
