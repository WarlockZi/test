import {$, post} from "../../common";

export default class Model {

  constructor(props) {
    this.id = 0
  }

  updateOrCreate() {

  }

  getUrlUpdateOrCreate() {
    return `/adminsc/${this.name}/updateOrCreate`
  }

  async create(target) {
    // debugger
    let id = await post(this.getUrlUpdateOrCreate(), {id: 0})
    return id
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
    debugger
    // if (!confirm('Удалить?')) return false
    this.id = id
    if (await this.delServer()) {
      this.delDom()
    }

  }

}