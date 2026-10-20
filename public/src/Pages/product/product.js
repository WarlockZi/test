import "./product.scss";
import Card_panel from "@components/card_panel/card_panel.js";
import { $ } from "../../common.js";
import shippableTable from "@components/shippable/shippableTable.js";
import MyQuill from "@components/quill/MyQuill.js";
import { ael } from "@src/constants.js";
import MyCardPanels from "@src/Modules/admin/card_panel/MyCardPanels.js";

export default class Product {
  constructor() {
    const panel = new MyCardPanels();
    const product = $(".product-card").first();
    if (!product) return false;

    // this.products = $(".product-wrap").first();
    // if (this.products) {
    //   this.products[ael]("click", this.handleClick.bind(this));
    // }

    const table = $(".shippable-table").first();

    new shippableTable(table);

    // const short_link = $(".short-link").first();
    // if (short_link) {
    //   short_link.addEventListener("click", function ({ target }) {
    //     const cardPanel = new Card_panel();
    //     cardPanel.shortLink(target);
    //   });
    // }

    new MyQuill("#detail-text");
    new MyQuill("#seo-article");
  }
}
