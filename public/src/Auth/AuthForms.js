import LoginRows from "@src/Auth/authForms/LoginRows.js";
import RegisterRows from "@src/Auth/authForms/RegisterRows.js";
import ForgotRows from "@src/Auth/authForms/ForgotRows.js";

export default class AuthForms {
  constructor() {
    return {
      1: [new LoginRows()],
      2: [new RegisterRows()],
      3: [new ForgotRows()],
    };
  }
}
