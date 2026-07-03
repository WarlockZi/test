import "./feedback.scss";
import { ael, qa, qs } from "@src/constants.js";
import filterXSS from "xss";
import { createElement, debounce, getPhpSession, post } from "@src/common.js"; // import PhoneValidator from "../components/validator/PhoneValidator.js";
// import PhoneValidator from "../components/validator/PhoneValidator.js";

export default class Feedback {
  constructor(button) {
    if (!button) return false;

    this.button = button;
    this.button.disabled = true;

    this.formWrapper = button.closest(".feedback");
    this.form = this.formWrapper[qs]("form");
    this.title = this.formWrapper[qs](".feedback-title");
    this.checkmark = this.formWrapper[qs](".check-icon");
    this.inputs = this.formWrapper[qa](".input-container input");
    this.email = this.formWrapper[qs]("input#email");
    this.phone = this.formWrapper[qs]("input#phone");
    this.name = this.formWrapper[qs]("input#name");

    this.setInputs();
    this.setErrorTags();

    this.formWrapper[ael]("submit", this.handleSubmit.bind(this));
    this.formWrapper[ael]("keyup", debounce(this.handelKeyup.bind(this), 1000));
  }

  toggleSubmitButton() {
    if (!this.name.value) {
      const formError = this.formWrapper.querySelector("#formError");
      if (!formError) {
        const error = new createElement()
          .tag("div")
          .attr("id", "formError")
          .attr("calss", "form-error")
          // .attr("style", "color:brown;padding-left:15px;padding-top:10px;")
          .text("Заполните пожалуйста Ваше имя")
          .get();
        this.button.before(error);
      }
    }

    this.button.disabled =
      !(this.email.value || this.phone.value) || !this.name.value;
  }

  async handelKeyup({ target }) {
    this.toggleSubmitButton();

    if (target.tagName === "INPUT") {
      const { emailValidator } = await import("@src/common.js");
      const { default: PhoneValidator } = await import(
        "@src/components/validator/PhoneValidator.js"
      );
      if (target.id === "name") {
        const nameErr = filterXSS(target.value, {
          whiteList: {
            a: ["href", "title"],
          },
        });
        // const nameErr = stripjs(target.value);
      } else if (target.id === "email") {
        this.emailError.innerText = emailValidator(target.value)[0] ?? "";
      } else if (target.id === "phone") {
        const phoneErr = new PhoneValidator();
        phoneErr.validate(target.value);
        this.phoneError.innerText = phoneErr.errors[0] ?? "";
      } else if (target.id === "message") {
        const messageErr = filterXSS(target.value, {
          whiteList: {
            a: ["href", "title"],
          },
        });
        // const messageErr = stripjs(target.value);
      }
    }
  }

  async validateInputs() {
    const { default: EmailValidator } = await import(
      "@components/validator/EmailValidator.js"
    );
    const { default: PhoneValidator } = await import(
      "@components/validator/PhoneValidator.js"
    );

    const phoneV = new PhoneValidator(
      "required|min:2|max:15|regex:/^([0-9\\s\\-\\+\\(\\)]*)$/",
    ).validate(this.phone.value);
    const emailV = new EmailValidator(
      "required|min:2|max:15|regex:/^([0-9\\s\\-\\+\\(\\)]*)$/",
    ).validate(this.email.value);
    return [...emailV.errors, ...phoneV.errors];
  }

  buttonVisibility(boolean) {
    this.button.disabled = boolean;
  }

  async handleSubmit(e) {
    e.preventDefault();

    this.buttonVisibility(!this.name || !(this.email || this.phone));

    const errors = this.validateInputs();
    this.buttonVisibility(!!errors.length);

    const res = await post("/feedback/updateOrCreate", this.dto());
    if (res?.id) {
      this.title.innerText = "Сообщение отправлено";
      this.title.classList.add("sent");
      this.checkmark.classList.remove("none");
      setTimeout(
        function () {
          this.form.reset();
          this.checkmark.classList.add("none");
          this.title.classList.remove("sent");
          this.title.innerText = "Напишите свой вопрос";
        }.bind(this),
        2_000,
      );
    }
  }

  dto() {
    const message = this.message.value.replace(/[^a-z\u0400-\u04FF]/gi, " ");
    const name = this.name.value.replace(/[^a-z\u0400-\u04FF]/gi, " ");
    return {
      id: 0,
      fields: {
        name: name,
        email: filterXSS(this.email.value, {
          whiteList: {
            a: ["href", "title"],
          },
        }),
        // email: stripjs(this.email.value),
        // phone: stripjs(this.phone.value),
        phone: filterXSS(this.phone.value, {
          whiteList: {
            a: ["href", "title"],
          },
        }),
        message: message,
      },
      phpSession: getPhpSession(),
    };
  }

  setInputs() {
    this.name = this.formWrapper[qs]("#name");
    this.email = this.formWrapper[qs]("#email");
    this.phone = this.formWrapper[qs]("#phone");
    this.message = this.formWrapper[qs]("#message");
  }

  setErrorTags() {
    this.nameError = this.formWrapper[qs]("#nameError");
    this.emailError = this.formWrapper[qs]("#emailError");
    this.phoneError = this.formWrapper[qs]("#phoneError");
    this.messageError = this.formWrapper[qs]("#messageError");
  }
}
