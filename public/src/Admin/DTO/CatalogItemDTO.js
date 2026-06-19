import { catItemSelector, qa } from "../../constants.js";
import FieldDTO from "@src/Admin/DTO/FieldDTO.js";

export default class CatalogItemDTO {
  constructor(target) {

    const dto = new FieldDTO(target);
    this.target = target;
    const dataset = this.target?.dataset;

    this.model = target.closest([catItemSelector]).dataset.model;
    this.id = target.closest([catItemSelector]).dataset.id;

    this.field = this.target.dataset.field ?? null;

    if (this.field) {
      this.field = {
        [dataset?.field]:
          dataset?.value ?? target?.checked ?? target?.innerText,
      };
      this.exit();
    }

    if (dataset?.relation) {
      this.relation = {
        [dataset.relation]: dataset?.id,
        field: {
          [dataset?.field]: dataset?.value,
        },
      };
      this.exit();
    }

    if (dataset?.pivot) {
      this.pivot = {
        [dataset?.pivot]: dataset?.id,
        field: {
          [dataset?.field]: dataset?.value,
        },
      };
      this.exit();
    }
  }

  exit() {
    delete this.target;
    return this;
  }
}
