import {
  catItemSelector,
  dataPivotSelector,
  dataRelationSelector,
  tableSelector,
} from "../../constants.js";

export default class FieldDTO {
  constructor(el) {
    if (!el) return false;

    this.el = el;

    this.model =
      el.closest([catItemSelector])?.dataset?.model ?? //catitem
      el.closest("[" + [tableSelector] + "]").dataset.model; //table
    this.id =
      el.closest([catItemSelector])?.dataset?.id ?? //catitem
      el.closest("[data-id]").dataset.id; //table

    this.pivot = el.closest([dataPivotSelector])?.dataset.pivot;
    if (!this.pivot) {
      this.relation = el.closest([dataRelationSelector])?.dataset.relation;
    }
    // this.field = el.closest([dataPivotSelector])?.dataset.field;

    const dataset = this.el?.dataset;

    if (this?.relation) {
      this.relation = this.getRelationOrPivot("relation", dataset);
      this.exit();
    } else if (this?.pivot) {
      this.pivot = this.getRelationOrPivot("pivot", dataset);
      this.exit();
    } else if (dataset?.field) {
      this.field = this.getField(dataset);
      this.exit();
    }
  }

  getRelationOrPivot(type, dataset) {
    return {
      name: this[type],
      id: dataset?.id,
      field: this.getField(dataset),
    };
  }
  getField(dataset) {
    return {
      [this.el.closest("[data-field]")?.dataset?.field]:
        dataset?.value ?? this.el?.checked ?? this.el?.innerText,
    };
  }

  exit() {
    delete this.el;
    if (!this.relation) delete this.relation;
    if (!this.pivot) delete this.pivot;
    return this;
  }
}
