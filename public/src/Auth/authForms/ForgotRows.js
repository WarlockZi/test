import { getEmailInput } from "./renderInputs.js";
import { getForgotButton } from "./renderButtons.js";
import { createLinks, getLoginWarning } from "./renderLinks.js";

export default class ForgotRows {
  constructor() {
    return [
      "Восстановление пароля",
      getEmailInput(),
      getForgotButton(),
      createLinks("forgot"),
      getLoginWarning(),
    ];
  }
}
