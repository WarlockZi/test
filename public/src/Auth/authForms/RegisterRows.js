import {
  getEmailInput,
  getPasswordInput,
  getPhoneInput,
} from "./renderInputs.js";
import { getRegisterButton } from "./renderButtons.js";
import { createLinks, getLoginWarning } from "./renderLinks.js";

export default class RegisterRows {
  constructor() {
    return [
      "Регистрация",
      getEmailInput(),
      getPasswordInput(),
      getPhoneInput(),
      getRegisterButton(),
      createLinks("register"),
      getLoginWarning(),
    ];
  }
}
