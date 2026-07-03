import FieldDTO from "@src/Admin/DTO/FieldDTO.js";

export default class RelationDTO {
  constructor(target, prev) {
    if (!target) return;
    this.target = target;
    const dto = new FieldDTO(target);

    //model
    this.id = target?.closest(".item-wrap")?.dataset?.id;

    this.field = target?.dataset?.field ?? false;

    this.relation =
      target?.dataset?.relation ??
      target?.closest("[data-relation]")?.dataset?.relation ??
      false;

    this.pivot =
      target?.dataset?.pivot ?? target?.parentNode?.dataset?.pivot ?? false;
    this.attach =
      !!this.target?.closest("[custom-table]")?.dataset?.relationtype;

    if (this.field) {
      this.field = {
        [target?.dataset?.field]:
          target?.dataset?.value ?? target?.checked ?? target?.innerText,
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
    if (!this.field) delete this.field;
    if (!this.relation) delete this.relation;
    delete this.attach;
    delete this.pivot;
    delete this.target;
  }
}
