import { localStorageWeUseCookies } from "@src/constants.js";

export default class We_use_cookie_notification {
  static async show_use_cookie_notification() {
    const we_use_cookie_notification = localStorage.getItem(
      localStorageWeUseCookies,
    );
    if (!we_use_cookie_notification) {
      const { default: CookieNotification } =
        await import("./CookieNotification.js");
      new CookieNotification();
    }
  }
}
