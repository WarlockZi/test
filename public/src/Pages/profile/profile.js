// import Catalog_item from ;
import { $ } from "@src/common.js";

export default class Profile {
  constructor() {
    this.catalogItem = $(".item-wrap").first();
    if (!this.catalogItem) return false;
    this.init();
  }
  async init() {
    // const { default: CatalogItem } =
    //   // await import("@src/Admin/components/catalog-item/catalog_item.js");
    // if (CatalogItem) new CatalogItem(this.catalogItem);
  }
}
