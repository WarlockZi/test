import "./product.scss";
import "./units.scss";
import { $, newObjAndFiles2FormData, post } from "../../common.js";
import "./Props.js";
import { qs } from "../../constants";
// import QuillFactory from "@src/components/quill/QuillFactory.js";
// import { QuillConst } from "@src/components/quill/QuillConstans.js";
// import MyQuill from "@components/quill/MyQuill.js";

export default class Product {
  constructor() {
    const product = document[qs](`.item-wrap[data-model='product']`);
    if (!product) return false;
    this.product = product;
    this.model = "product";
    this.id = this.product.dataset.id;
    // this.id = $(this.product).find(`[data-field='id']`).innerText;

    this.setProps().then();

    this.setDragNDrop().then();
    this.setCardPanel().then();

    // QuillFactory.create(".txt", QuillConst.ADMIN_PRODUCT_DESCRIPTION);
    // QuillFactory.create(
    //   "[data-id='seo-article']",
    //   QuillConst.ADMIN_CATEGORY_SEO_ARTICLE,
    // );
  }

  async setDragNDrop() {
    const dragNdrop = document[qs]("[dnd]");
    if (dragNdrop) {
      const { default: Dnd } = await import("../../components/dnd/dnd");
      await new Dnd(dragNdrop, this.addMainImage);
    }
  }

  async setFields() {
    const { default: Fields } = await import("./Fields.js");
    new Fields(this.product);
  }

  async setProps() {
    const { default: Props } = await import("./Props.js");
    new Props(this.product);
  }

  async setCardPanel() {
    const cardPanel = document[qs](`.cardPanel`);
    if (cardPanel) {
      const { default: cardPanel } = await import(
        "@components/card_panel/card_panel"
      );
      new cardPanel();
    }
  }

  async addMainImage(files, target) {
    const obj = {
      productSId: target
        .closest(".item-wrap")
        [qs](`[data-field="1s_id"]`)
        .innerText.trim(),
    };
    const data = newObjAndFiles2FormData(obj, files[0]);

    const res = await post("/adminsc/product/saveMainImage", data);
    const src = res?.mainImage;
    if (src) {
      const timestamp = new Date().getTime();
      const mainImage = target.closest(".dnd-container").querySelector("img");
      mainImage.src = `${src}?=${timestamp}`;
    }
  }
}
