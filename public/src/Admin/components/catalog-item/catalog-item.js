import "./catalog-item.scss";
import { $, debounce, post } from "@src/common.js";
import { ael, searchSelector } from "@src/constants.js";
import Checkbox from "../../../components/checkbox/checkbox.js";
import CustomDate from "../../../components/date/date.js";
import SearchableSelect from "@components/select/Factory/SearchableSelect.js";
import FieldDTO from "@src/Admin/DTO/FieldDTO.js";

export default class CatalogItem {
  constructor(catalogItem) {
    if (!catalogItem) return false;

    // debugger;
    this.model = catalogItem.dataset.model;
    this.id = +catalogItem.dataset.id;
    this.setCheckboxes();
    this.setSelects();
    this.setDates();

    catalogItem[ael]("click", this.handleClick.bind(this));
    catalogItem[ael]("keyup", debounce(this.handleKeyup.bind(this)));

    catalogItem[ael]("date.changed", this.handleDateChange.bind(this));
    catalogItem[ael](
      "searchableSelect.changed",
      this.handleSelectChange.bind(this),
    );
    if (this.model) {
      catalogItem[ael]("checkbox.changed", this.handleChexboxChange.bind(this));
    }
  }
  setSelects() {
    const selects = $(`[` + searchSelector + `]:has(option)`);

    [].forEach.call(selects, function (select) {
      if (!select.parentNode.hasAttribute("hidden"))
        new SearchableSelect(select);
    });
  }

  setCheckboxes() {
    const checks = $("[my-checkbox]");
    [].forEach.call(checks, function (check) {
      new Checkbox(check);
    });
  }

  setDates() {
    const dates = $("[custom-date]");
    [].forEach.call(dates, function (date) {
      new CustomDate(date);
    });
  }

  handleChexboxChange({ target }) {
    if (target.closest("[custom-table]")) return;
    this.update(target);
  }

  async handleSelectChange(target) {
    // if (target.closest("[custom-table]")) return;
    this.update(target.detail.el);
  }

  async handleDateChange({ target }) {
    this.update(target);
  }

  async handleKeyup({ target }) {
    if (target.closest(".custom-table")) return false;
    if (!target.hasAttribute("contenteditable") || !target.dataset.field)
      return false;

    const res = this.update(target);
    if (res) {
      target.dispatchEvent(
        new CustomEvent("catalogItem.changed", {
          bubbles: true,
          detail: { res },
        }),
      );
    }
  }

  async handleClick({ target }) {
    if (target.classList.contains("tab")) {
      this.handleTabClick(target);
    }
  }

  handleTabClick(target) {
    $(`[data-tab].show`).first().classList.toggle("show");
    $(`[data-tab='${target.dataset.tabId}']`).first().classList.toggle("show");
    $(`.tab.active`).first().classList.toggle("active");
    target.classList.toggle("active");
  }

  async update(target) {
    // const dto = new CatalogItemDTO(target);
    const dto = new FieldDTO(target);
    return await post(`/adminsc/${this.model}/updateorcreate`, dto);
  }
}
