import "../Product/product.scss";
import "./category.scss";
import PropertyTable from "./PropertyTable";
import { $, post } from "../../common.js";
// import SelectNew from "@components/select/del/SelectNew.js";
// import QuillFactory from "@src/components/quill/QuillFactory.js";
import SearchableSelect from "@components/select/Factory/SearchableSelect.js";
// import { QuillConst } from "@src/components/quill/QuillConstans.js";

export default class Category {
  constructor(el) {
    this.el = el;
    this.id = el.dataset.id;
    this.setSelects();
    this.setProperties();
  }

  setSelects() {
    const el = $(`[data-field='category_id']`).first();
    if (el) new SearchableSelect(el);
  }

  setProperties() {
    new PropertyTable(this.el.querySelector(`[data-relation="properties"]`));
  }

  dto(change) {
    return {
      id: this.id,
      relation: "ownProperties",
      fields: {
        seo_article: change,
      },
    };
  }

  attachCategory({ detail }) {
    const data = {
      id: this.id,
      relation: detail.target.dataset.relationmodel,
      fields: {
        category_id: +detail.next.value,
      },
    };
    post(`/adminsc/category/updateOrCreate`, data);
  }
}
