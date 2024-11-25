export default class DTO {
   constructor(id = 0, target = null) {
      this.id = id ?? 0
      this.fields = {
         [target?.dataset?.field]: target?.dataset?.value ?? target.innerText ?? target.checked
      }
      const relFields = target?.dataset?.field
      const fields = relFields ? {[relFields]: target?.dataset?.value ?? target.innerText ?? target.checked} : {}
      this.relation = {
         name: target?.dataset?.relation ?? '',
         id: target?.dataset?.value ?? 0,
         fields,
         pivot: {
            field: target?.dataset?.pivotField,
            value: target?.dataset?.pivotValue
         }
      }
   }
}