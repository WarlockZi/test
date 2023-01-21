import {$, post} from "../../common";

export default class Model {

  constructor(props) {
    this.id = 0
  }

  getUrlUpdateOrCreate() {
    return `/adminsc/${this.name}/updateOrCreate`
  }

  updateOrCreate(model) {
    return post(this.getUrlUpdateOrCreate(), model)
  }

  delServer() {
    return post(`/adminsc/${this.name}/delete`, {id: this.id})
  }

  delDom() {
    let selector = this.delDomSelector;
    [].map.call($(selector), function (i) {
        i.remove()
      }
    )
  }

  async delete(target) {
    let id  = target.closest(this.className).dataset.id
    if (!confirm('Удалить?')) return false
    this.id = id
    if (await this.delServer()) {
      this.delDom()
    }

  }

}