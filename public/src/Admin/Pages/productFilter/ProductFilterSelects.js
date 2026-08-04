import { $ } from "../../../common.js";
import SearchableSelect from "@components/select/Factory/SearchableSelect.js";
import { catItemSelector, qa, searchSelector } from "../../../constants.js";
import { Select } from "@components/select/Factory/Select.js";

export default class ProductFilterSelects {
  constructor(container) {
    if (!container) {
      console.log();
      return false;
    }
    this.container = container;
    this.createSelects();
  }
  createSelects() {
    // const selects = $(this.container).findAll("[select-new]");
    const selects = $(this.container).findAll("[" + searchSelector + "]");
    [].forEach.call(selects, (select) => {
      const optionsCount = select[qa]("option").length;
      if (optionsCount > 5) {
        new SearchableSelect(select, {});
      } else {
        new Select(select, {});
      }
    });
  }
}
