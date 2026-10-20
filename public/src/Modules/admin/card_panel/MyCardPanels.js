import CardPanel from "@components/card_panel/card_panel.js";
import { $ } from "@src/common.js";

export default class MyCardPanels {
  constructor() {
    this.cardPanels = $(`.card-panel`);
    if (!this.cardPanels) return;

    [].forEach.call(this.cardPanels, (panel) => {
      new CardPanel(panel);
    });
  }
}
