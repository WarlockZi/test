import "./product.scss";
import { $ } from "../../common.js";
import shippableTable from "@components/shippable/shippableTable.js";
import MyQuill from "@components/quill/MyQuill.js";
import MyCardPanels from "@src/Modules/admin/card_panel/MyCardPanels.js";

export default class Product {
  constructor() {
    new MyCardPanels();

    const product = $(".product-card").first();
    if (!product) return false;

    const table = $(".shippable-table").first();

    new shippableTable(table);
    new MyQuill("#detail-text");
    new MyQuill("#seo-article");
  }
}
