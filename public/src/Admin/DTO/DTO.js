export default class DTO {
  constructor(id = 0, target = null) {
    this.id = id ?? target?.parentNode?.dataset?.id ?? 0;

    if (target?.parentNode?.dataset?.attach)
      this.attach = target?.parentNode?.dataset?.attach ?? false;

    this.fields = {
      [target?.dataset?.field]:
        target?.dataset?.value ?? target?.checked ?? target?.innerText,
    };
    const relFields = target?.dataset?.field;
    const fields = relFields
      ? {
          [relFields]:
            target?.dataset?.value ?? target.innerText ?? target.checked,
        }
      : {};

    if (target?.dataset?.relation) {
      this.relation = {
        name:
          target?.dataset?.relation ??
          target?.closest("[data-relation]")?.dataset?.relation ??
          "",
        id: target?.dataset?.value ?? target?.dataset?.id ?? 0,
        fields,
        pivot: {
          field:
            target?.dataset?.pivotField ?? target?.parentNode?.dataset?.pivot,
          value: target?.dataset?.pivotValue ?? target?.innerText,
        },
      };
    }

  }
}
