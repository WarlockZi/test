import { getEmailInput, getPasswordInput } from "./renderInputs.js";
import { getLoginButton, getYandexAuthButton } from "./renderButtons.js";
import { createLinks, getLoginWarning } from "./renderLinks.js";

export default class LoginRows {
  constructor() {
    return [
      "Вход",
      getEmailInput(),
      getPasswordInput(),
      getLoginButton(),
      createLinks("login"),
      getYandexAuthButton(),
      getLoginWarning(),
    ];
  }


}
