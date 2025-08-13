export default class CheckboxDTO {
  constructor(target) {
    this.target = target;
    return this.processTarget(target);
  }

  processTarget(target) {
    if (target?.dataset.pivot) {
      return {
        id: target?.closest(".item-wrap")?.dataset?.id ?? "",
        relation: {
          name: target?.closest("[data-relation]")?.dataset?.relation ?? "",
          id: target?.parentNode?.dataset?.id,
          pivot: {
            [target?.dataset?.pivot]: +target?.checked,
          },
        },
      };
    } else if (target?.dataset.field) {
      return {
        model: target?.closest("[data-model]")?.dataset?.model,
        id: target?.parentNode?.dataset?.id,
        fields: {
          [target?.dataset.field]: target?.checked,
        },
      };
    }
  }
}
