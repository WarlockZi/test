import "../../../Auth/auth.scss";
import { $ } from "@src/common.js";
import { ael } from "@src/constants.js";

export default class Login {
  constructor() {
    this.modalForm = $(".modal").first();
    this.loginButton = $("#login").first();
    this.cartLoginButton = $("#cartLogin").first();
    if (!this.modalForm || !this.loginButton) return false;

    if (this.loginButton) {
      this.loginButton[ael]("click", this.loadModules.bind(this));
    }
    if (this.cartLoginButton) {
      this.cartLoginButton[ael]("click", this.loadModules.bind(this));
    }
  }

  async loadModules() {
    const [ModalModule, AuthFormsModule] = await Promise.all([
      import("@components/Modal/modal.js"),
      import("@src/Auth/AuthForms.js"),
    ]);
    const Modal = ModalModule.default;
    const AuthForms = AuthFormsModule.default;

    const modalsGroup = new Modal({
      triggers: [".guest-menu", "#cartLogin"],
      boxes: new AuthForms(),
    });
    modalsGroup.show();
  }
}
