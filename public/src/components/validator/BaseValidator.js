export default class BaseValidator {
   constructor(obj) {
      this.errors = []
      this.min = obj?.min ?? 0
      this.max = obj?.max ?? 0
      this.errorMassage = {
         required: "Поле должно быть заполнено",
         min: `Длина меньше ${this.min} символов`,
         max: `Длина больше ${this.max} символов`,
      }
      if (obj === undefined
         || obj === null
         || typeof obj === 'undefined'
       ) {
         return false
      }
      if (obj?.required) {
         if (!obj.value.length) {
            this.errors.push(this.errorMassage.required)
         }
      }

      if (obj?.min) {
         if (obj.value.length < obj?.min) {
            this.errors.push(this.errorMassage.min)
         }
      }

      if (obj?.max) {
         if (obj.value.length > obj?.max) {
            this.errors.push(this.errorMassage.max)
         }
      }


   }
}