import "./ProductFilter.scss";
import { ael, qa, qs } from "@src/constants.js";
import { $, post } from "@src/common.js";
import SelectNew from "@src/components/select/SelectNew.js";

export default class ProductFilter {
  constructor(productsFilter) {
    if (!productsFilter) return;
    this.wrap = productsFilter;
    this.panel = productsFilter[qs](".list-filter");
    this.url = "/adminsc/report/updateFilter";
    this.wrap[ael]("click", this.handleClick.bind(this));
    this.checkboxes = Array.from(this.panel[qa](`[type='checkbox']`));
    this.selects = Array.from(this.wrap[qa](`[select-new]`));

    this.setSelects();
  }

  setSelects() {
    [].map.call(this.selects, (select) => {
      new SelectNew(select);
    });
  }

  async handleClick(e) {
    const target = e.target;
    if (target.classList.contains("filter-button")) {
      e.preventDefault();
      const req = this.getClickedFilters();
      const res = await post(this.url, req);
      this.renderDataFromResponce(res);
    }
  }

  getClickedFilters() {
    const req = {};

    req.toSelect = this.selects
      .filter((select) => select.dataset.value !== "0")
      .reduce((obj, select) => {
        obj[select.getAttribute("name")] = select.dataset.value;
        return obj;
      }, {});

    req.toSave = this.checkboxes
      .filter((check) => check.checked === true)
      .map((check) => check.name);

    return req;
  }

  renderDataFromResponce(res) {
    $(".used-filters").first().innerHTML = res?.arr?.filterString;
    $(".list-filter").first().innerHTML = res?.arr?.filterPanel;
    const table = $("[custom-table]").first();
    table.innerHTML = res?.arr?.productsTable;
    this.setSelects();
  }
}
