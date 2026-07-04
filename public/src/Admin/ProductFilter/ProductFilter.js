import "./ProductFilter.scss";
import { ael, qa, qs, searchSelector } from "@src/constants.js";
import { $, post } from "@src/common.js";
import ProductFilterSelects from "@src/Admin/ProductFilter/ProductFilterSelects.js";

export default class ProductFilter {
  constructor() {
    const productsFilter = $(".products-filter").first();
    if (!productsFilter) return false;

    this.wrap = productsFilter;
    this.panel = productsFilter[qs](".list-filter");
    this.url = "/adminsc/report/updateFilter";
    this.selectedOptionSelector = ".fs-options .fs-option[selected]";

    this.wrap[ael]("click", this.handleClick.bind(this));

    new ProductFilterSelects($(".filter-wrap").first());
  }

  async handleClick(e) {
    const target = e.target;
    if (target.classList.contains("filter-button")) {
      e.preventDefault();
      const req = this.getClickedFilters();
      const res = await post(this.url, req);
      this.renderDataFromResponse(res);
    }
  }

  getClickedFilters() {
    const req = {};
    const selects = Array.from(this.wrap[qa]("[" + searchSelector + "]"));
    req.changedFilters = selects
      .filter((select) => select.dataset.value !== "0")
      .reduce((obj, select) => {
        const selectedOption = select[qs](this.selectedOptionSelector);
        const name = select.getAttribute("name");
        const value = selectedOption.dataset.value;
        const checkbox = select.parentNode[qs]('[type="checkbox"]');
        const checked = checkbox.checked;
        obj[name] = {
          value: value,
          checked,
        };
        return obj;
      }, {});

    return req;
  }

  renderDataFromResponse(res) {
    $(".used-filters").first().innerHTML = res?.filterString;
    $(".list-filter").first().innerHTML = res?.filterPanel;
    const table = $("[custom-table]").first();
    table.innerHTML = res?.productsTable;
    this.setSelects();
  }
}
