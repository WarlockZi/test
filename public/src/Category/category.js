import { ael, qa, qs } from "../constants";
import shippableTable from "@components/shippable/shippableUnitsTable";
import MyQuill from "../components/quill/MyQuill.js";
import { getCookie, newObjAndFiles2FormData, post } from "@src/common.js";
import DTO from "@src/Admin/DTO.js";
import Dnd from "@components/dnd/dnd.js";

export default class Category {
  constructor() {
    this.category = document[qs](".category");
    if (!this.category) return false;

    this.products = this.category[qa](".column");

    this.setCardPanel().then();
    this.mapShippableTables();
    this.setMyQuill();
    this.setDnds();
  }

  setDnds() {
    this.products.forEach((product) => {
      new Dnd(product, this.saveMainImage.bind(this));
    });
  }

  async saveMainImage(files, target) {
    const authed = getCookie("loc_storage_cart_id");
    if (!authed) return false;

    const obj = { productSId: target.closest("[data-1sid]").dataset["1sid"] };
    const data = newObjAndFiles2FormData(obj, files[0]);

    const res = await post("/adminsc/product/saveMainImage", data);
    const src = res?.mainImage;
    if (src) {
      const timestamp = new Date().getTime();
      target.src = `${src}?=${timestamp}`;
    }
  }

  setMyQuill() {
    new MyQuill("#seo_article");
    this.category[ael]("click", this.handleClick.bind(this));
  }

  async setCardPanel() {
    const cardPanel = document[qs](`.card-panel`);
    if (cardPanel) {
      const { default: Card_panel } = await import(
        "@components/card_panel/card_panel"
      );
      this.cardPanel = new Card_panel();
    }
  }

  handleClick({ target }) {
    if (target.hasAttribute("data-like")) {
      this.handleLike(target);
    } else if (target.hasAttribute("data-compare")) {
      this.handleCompare(target);
    } else if (target.hasAttribute("data-shortLink")) {
      this.cardPanel.shortLink(target);
    }
  }

  async handleCompare(target) {
    if (!target.dataset.compare) {
      target.dataset.compare = false;
      const res = await post("/compare/del", this.productDTO(target));
      if (res?.arr?.discompared) target.classList.toggle("green");
    } else {
      target.dataset.compare = true;
      const res = await post(
        "/compare/updateOrCreateCustom",
        this.productDTO(target),
      );
      if (res?.compared) target.classList.toggle("green");
    }
  }

  async handleLike(target) {
    if (!target.dataset.like) {
      target.dataset.like = false;
      const res = await post("/like/del", this.productDTO(target));
      if (res?.arr?.disliked) target.classList.toggle("red");
    } else {
      target.dataset.like = true;
      const res = await post(
        "/like/updateOrCreateCustom",
        this.productDTO(target),
      );
      if (res?.liked) target.classList.toggle("red");
    }
  }

  productDTO(target) {
    const dto = new DTO(target);
    dto.fields = {
      product_id: target.closest(`[data-1sid]`).dataset["1sid"],
    };
    return dto;
  }

  mapShippableTables() {
    [...this.category[qa](".shippable-table")].forEach((table) => {
      new shippableTable(table);
    });
  }
}
