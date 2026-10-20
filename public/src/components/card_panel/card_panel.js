import { $, popup } from "../../common.js";
import "./card_panel.scss";
import handleShortlink from "@components/card_panel/short_link.js";
import handleLike from "@components/card_panel/like.js";
import handleCompare from "@components/card_panel/compare.js";

export default class CardPanel {
  constructor(element) {
    this.el = element || $(`.card-panel`).first();

    if (!this.el) {
      console.warn("CardPanel: элемент не найден");
    }
    this.el.addEventListener("click", this.handleClick.bind(this));
  }

  handleClick({ target }) {
    if (target.dataset.shortlink) {
      handleShortlink(target);
    } else if (target.dataset.like) {
      handleLike(target);
    } else if (target.dataset.compare) {
      handleCompare(target);
    }
  }
}
