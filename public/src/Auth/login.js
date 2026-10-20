import { $, popup, post, validate } from "../common";

export default class Login {
  constructor() {
    this.loginForm = $("[data-auth='login']").first();
    if (!this.loginForm) return;

    this.email = $("input[type = email]").first();
    this.pass = $("input[name= password]").first();
    this.msg = $(".message").first();

    if (!this.email || !this.pass || !this.msg) {
      console.error("Не найдены необходимые элементы формы");
      return;
    }

    this.loginForm.addEventListener("click", this.handleSubmit.bind(this));
  }

  async handleSubmit(e) {
    e.preventDefault();

    const submitButton = e.target;
    const isSubmitButton = submitButton.contains("submit__button");
    if (!isSubmitButton) return;

    submitButton.disabled = true;

    try {
      if (this.validateData()) {
        const res = await post("/auth/login", this.loginDto());
        await this.parseLoginResponse(res);
      }
    } catch (error) {
      this.showError("Произошла ошибка при подключении к серверу");
      console.error("Login error:", error);
    } finally {
      submitButton.disabled = false;
      submitButton.textContent = "Войти";
    }
  }

  loginDto() {
    const email = this.email.value.trim();
    const password = this.pass.value;

    if (!email || !password) {
      popup.show("Email и пароль обязательны");
      return false;
    }

    return {
      email,
      password,
    };
  }

  showError(error) {
    this.msg.innerText = "";
    this.msg.innerText = error;
    $(this.msg).addClass("error");
  }

  validateData() {
    let error = validate.email(this.email.value);
    if (error) {
      this.showError(error);
      return false;
    }

    if (env?.EMAIL_VITE_SU !== this.email.value) {
      error = validate.password(this.pass.value);
      if (error) {
        this.showError(error);
        return false;
      }
    }
    return true;
  }

  async parseLoginResponse(res) {
    if (!res || typeof res !== "object" || res?.arr?.error) {
      popup.show("ошибка при входе");
      return;
    }
    if (!res.arr?.id) {
      popup.show("Отсутствует ID пользователя в ответе");
    }

    this.loginRedirect(res?.arr?.role);
  }

  loginRedirect(role) {
    const redirectPaths = {
      employee: "/adminsc",
      user: "/auth/profile",
    };

    const path = redirectPaths[role];

    if (path) {
      window.location.href = path; // используем href вместо location
    } else {
      console.warn(`Неизвестная роль: ${role}`);
      this.showError("Не удалось определить тип пользователя");
    }
  }
}
