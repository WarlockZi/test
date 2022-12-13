export default class Product {

  type = 'product';

  constructor(id, slugNameId) {
    this.id = id
    this.slugName = this.slugNames.get(slugNameId)
  }
}