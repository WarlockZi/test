export default class Product {
  id = 0;
  imagePath = 'catalog';
  type = 'product';
  slugName;
  slugNames = new Map([
    [1,"Detail"],
    [2,"Custom"]
  ])

  constructor(id, slugNameId) {
    this.id = id
    this.slugName = this.slugNames.get(slugNameId)
  }
}