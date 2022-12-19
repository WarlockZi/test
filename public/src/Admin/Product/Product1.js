export default class Product {

  imagePath = 'catalog';

  constructor(id, slugNameId) {
    this.id = id
    this.slugName = this.slugNames.get(slugNameId)
  }
}