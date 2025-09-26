import { $, popup } from "../../common.js";
import "./card_panel.scss";

export default class Card_panel {
  constructor() {
    this.el = $(`[data-shortLink]`).first();
    if (this.el) return false;
  }

  async shortLink(target) {
    const permissions = await navigator.permissions.query({
      name: "clipboard-write",
    });
    // .then(async (result) => {
    if (permissions.state === "granted" || permissions.state === "prompt") {
      await navigator.clipboard.writeText(target.dataset.shortlink).then(() => {
        popup.show("Ссылка скопирована");
      });
    }
    // });
  }
}
