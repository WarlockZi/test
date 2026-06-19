import {
  catItemSelector,
  dataPivotSelector,
  dataRelationSelector,
} from "../../constants.js";

export default class FieldDTO {
  constructor(el) {
    if (!el) return false;

    this.el = el;

    this.model = el.closest([catItemSelector]).dataset.model;
    this.id = el.closest([catItemSelector]).dataset.id;
    this.relation = el.closest([dataRelationSelector])?.dataset.relation;
    this.pivot = el.closest([dataPivotSelector])?.dataset.pivot;

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
      [dataset?.field]:
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
