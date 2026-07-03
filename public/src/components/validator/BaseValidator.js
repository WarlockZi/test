export default class BaseValidator {
  constructor(rules) {
    this.rules = rules;
    this.parseRules();
    this._errors = [];

    this.errorMassages = {
      required: "Поле должно быть заполнено",
      min: `Длина меньше ${this.min} символов`,
      max: `Длина больше ${this.max} символов`,
      regex: "",
    };
  }

  parseRules() {
    this.rules = this.rules.split("|");
    this.rules = [].map.call(this.rules, (rule) => rule.split(":"));
  }
  validate(str) {
    this.rules.map((rule) => {
      if (this[rule[0]]) {
        this[rule[0]](str, rule[0], rule[1]);
      }
    });
  }
  required(str, ruleName) {
    if (str === "undefined" || str === "") {
      this._errors.push(this.errorMassages[ruleName]);
    }
  }
  min(str, ruleName, ruleValue) {
    if (str.length < ruleValue) {
      this._errors.push(this.errorMassages[ruleName]);
    }
  }
  max(str, ruleName, ruleValue) {
    if (str.length > ruleValue) {
      this._errors.push(this.errorMassages[ruleName]);
    }
  }
  regex(str, ruleName, ruleValue) {
    if (str.length > ruleValue) {
      this._errors.push(this.errorMassages[ruleName]);
    }
  }
  get errors() {
    return this._errors;
  }
  set errors(error) {
    this._errors.push(error);
  }
}
