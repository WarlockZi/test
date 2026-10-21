import { $, newObjAndFiles2FormData, post, time } from "../../../common.js";
import Dnd from "../../../components/dnd/dnd.js";
import Catalog_item from "@src/Modules/admin/catalog_item/catalog_item.js";
import MyQuills from "@src/components/quill/MyQuills.js";

export default class product {
  constructor() {
    new Dnd($("[dnd]").first(), this.addMainImage.bind(this));
    // debugger;
    new MyQuills();

    // const el = $(".item-wrap").first();
    // const c = new Catalog_item(el);
  }
  async addMainImage(files, target) {
    const url = "/adminsc/product/saveMainImage";
    const data = newObjAndFiles2FormData(this.DTO(), files[0]);
    const imageContainer = $("img.main-image").first();

    const res = await post(url, data);
    if (res?.mainImage) {
      imageContainer.src = res?.mainImage + "?" + Date.now();
    }
  }
  DTO() {
    return {
      productSId: $("[data-sid]").first()?.dataset.sid,
    };
  }
}
