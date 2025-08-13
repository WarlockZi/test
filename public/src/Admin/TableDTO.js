import CheckboxDTO from "@src/Admin/CheckboxDTO.js";

export default class TableDTO {
  constructor(target, prev) {
    if (!target) return;

    if (target.hasAttribute("my-checkbox")) {
      return new CheckboxDTO(target);
    }
    this.target = target;
    //model
    this.id =
      target?.closest(".item-wrap")?.dataset?.id ??
      target?.dataset?.id ??
      target?.parentNode?.dataset?.id;

    this.fields = this.filterAttributes(target) ?? false;
    // this.fields = target.querySelectorAll('[data^="field"]') ?? false;

    this.relation =
      target?.dataset?.relation ??
      target?.closest("[data-relation]")?.dataset?.relation ??
      false;

    this.pivot =
      target?.dataset?.pivot ?? target?.parentNode?.dataset?.pivot ?? false;
    this.attach =
      !!this.target?.closest("[custom-table]")?.dataset?.relationtype;

    if (this.fields) {
      this.fields = {
        [target?.dataset?.field]:
          target?.dataset?.value ?? +target?.checked ?? target?.innerText,
      };
    }

    if (this.relation) {
      const name = this.relation;
      this.relation = {};
      this.relation.name = name;
      this.relation.id =
        target?.dataset?.value ??
        target?.dataset?.id ??
        0 ??
        target?.closest("[data-relation]")?.dataset?.relation ??
        0;

      if (this.attach && !this.pivot) {
        this.relation.attach =
          this.target?.dataset?.id ?? this.target?.dataset.value;
        this.relation.detach = prev ?? null;
      } else if (this.pivot) {
        delete this.attach;
        this.relation.pivot = {};
        this.relation.pivot[target?.dataset?.pivot] =
          target?.dataset?.value ?? target?.checked ?? target?.innerText;
      } else {
        this.relation.field = {};
        const fieldName = target?.dataset?.field ?? target?.dataset.pivot;
        this.relation.field[fieldName] =
          target?.dataset?.value ?? target?.checked ?? target?.innerText;
      }
    }
    if (!this.fields) delete this.fields;
    if (!this.relation) delete this.relation;
    delete this.attach;
    delete this.pivot;
    delete this.target;
  }

  filterAttributes(target) {
    const fieldAttrs = [];
    for (const attr of target.attributes) {
      if (attr.name === "data-field") {
        const field = attr.value;
        fieldAttrs.push(field);
      }
    }
    return fieldAttrs;
  }
}
