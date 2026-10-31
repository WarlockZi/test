import "./product.scss";
import { $ } from "../../common.js";
import shippableTable from "@components/shippable/shippableTable.js";
import MyQuill from "@components/quill/MyQuill.js";
import MyCardPanels from "@src/Modules/admin/card_panel/MyCardPanels.js";

export default class Product {
  constructor() {
    this.main_image = $(".zoom").first();
    new MyCardPanels();

    const product = $(".product-card").first();
    if (!product) return false;

    const table = $(".shippable-table").first();

    new shippableTable(table);
    new MyQuill("#detail-text");
    new MyQuill("#seo-article");
    this.main_image.addEventListener("mousemove", this.zoom.bind(this));
  }
  zoom(e) {
    // debugger;
    let offsetX, offsetY, x, y;
    var zoomer = e.currentTarget;
    e.offsetX ? (offsetX = e.offsetX) : (offsetX = e.touches[0].pageX);
    e.offsetY ? (offsetY = e.offsetY) : (offsetX = e.touches[0].pageX);
    x = (offsetX / zoomer.offsetWidth) * 100;
    y = (offsetY / zoomer.offsetHeight) * 100;
    zoomer.style.backgroundPosition = x + "% " + y + "%";
  }
}
