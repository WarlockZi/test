import { qs } from "@src/constants.js";

export default class MyCatalogItem {
  constructor() {
    this.catalogItem = document[qs](".item-wrap");
    if (!this.catalogItem) return false;

    this.category = document[qs](`.item-wrap[data-model='category']`);
    this.product = document[qs](`.item-wrap[data-model='product']`);
    this.loadModules();
  }

  async loadModules() {
    const { default: CatalogItem } =
      await import("@modules/admin/catalog_item/catalog_item.js");
    new CatalogItem(this.catalogItem);

    if (this.category) {
      const { default: Category } =
        await import("@src/Pages/category/category.js");
      new Category(this.category);
    }

    if (this.product) {
      const { default: Product } =
        await import("@src/Pages/product/product.js");
      new Product();
    }
  }
}
