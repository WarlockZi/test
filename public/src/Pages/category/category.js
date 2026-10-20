import "./category.scss";
import { ael, qa, qs } from "../../constants.js";
import shippableTable from "@components/shippable/shippableTable.js";
import { $, newObjAndFiles2FormData, post } from "@src/common.js";
import Dnd from "@components/dnd/dnd.js";
import MyCardPanels from "@src/Modules/admin/card_panel/MyCardPanels.js";

export default class Category {
  constructor() {
    this.category = document[qs](".category");
    if (!this.category) return false;

    this.products = this.category[qa](".column");

    new MyCardPanels();
    this.mapShippableTables();
    this.setMyQuill();
    this.setDnds();

    this.category[ael]("click", this.handleClick.bind(this));
  }

  setDnds() {
    this.products.forEach((product) => {
      new Dnd(product, this.saveMainImage.bind(this));
    });
  }

  async saveMainImage(files, target) {
    // const authed = localStorage.getItem("vitex_guest_id");
    // if (!authed) return false;

    const obj = {
      productSId: target.closest("[data-product_1s_id]").dataset[
        "product_1s_id"
      ],
    };
    const data = newObjAndFiles2FormData(obj, files[0]);

    const res = await post("/adminsc/product/saveMainImage", data);
    const src = res?.mainImage;
    if (src) {
      const timestamp = new Date().getTime();
      target.src = `${src}?=${timestamp}`;
    }
  }

  async setMyQuill() {
    const seo_article = $("#seo_article").first();
    if (seo_article && seo_article.innerText !== "") {
      const { default: MyQuill } = await import("@components/quill/MyQuill.js");
      new MyQuill(seo_article);
    }
  }

  handleClick({ target }) {
    if (target.hasAttribute("data-like")) {
      // this.handleLike(target);
    } else if (target.hasAttribute("data-compare")) {
      // this.handleCompare(target);
    } else if (target.hasAttribute("data-shortLink")) {
      return; // initialized in MyCardPanels
      //
      // this.cardPanel.shortLink(target);
    }
  }

  async handleCompare(target) {
    if (target.dataset.compare === "true") {
      const res = await post("/compare/del", this.productDTO(target));
      target.dataset.compare = false;
      if (res?.discompared) target.classList.toggle("green");
    } else {
      const res = await post(
        "/compare/updateOrCreateCustom",
        this.productDTO(target),
      );
      target.dataset.compare = true;
      if (res?.compared) target.classList.toggle("green");
    }
  }

  async handleLike(target) {}

  productDTO(target) {
    return {
      fields: {
        product_id: target.closest(`[data-1sid]`).dataset["1sid"],
      },
    };
  }

  mapShippableTables() {
    [...this.category[qa](".shippable-table")].forEach((table) => {
      new shippableTable(table);
    });
  }
}
