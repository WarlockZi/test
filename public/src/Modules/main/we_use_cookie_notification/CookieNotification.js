import "./cookie.scss";
import { $, createElement } from "../../../common.js";
import { ael, localStorageWeUseCookies } from "../../../constants.js";

export default class CookieNotification {
  constructor() {
    this.render();
    setTimeout(this.slideUp.bind(this), 200);
    this.button[ael]("click", this.accept.bind(this));
  }

  async accept() {
    localStorage.setItem(localStorageWeUseCookies, "accepted");
    this.notice.classList.add("slide-down");
  }
  render() {
    this.notice = new createElement()
      .tag("div")
      .attr("id", "cookie-notice")
      .attr("role", "banner")
      .text(this.getText())
      .get();

    this.button = new createElement()
      .tag("button")
      .attr("id", "cn-accept-cookie")
      .text("Соглашаюсь")
      .get();

    this.notice.append(this.button);
    $("footer").first().append(this.notice);
  }

  slideUp() {
    this.notice.classList.add("slide-up");
  }
  getText() {
    return "Продолжая использовать сайт, вы даете согласие на обработку файлов cookie, пользовательских данных (сведения о местоположении; тип и версия ОС; тип и версия Браузера; тип устройства и разрешение его экрана; источник откуда пришел на сайт пользователь; с какого сайта или по какой рекламе; язык ОС и Браузера; какие страницы открывает и на какие кнопки нажимает пользователь; ip-адрес) в целях функционирования сайта, проведения ретаргетинга и проведения статистических исследований и обзоров. Если вы не хотите, чтобы ваши данные обрабатывались, покиньте сайт.";
  }
}
