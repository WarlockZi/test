import {$, post} from "../../common";

export default class Model {

  constructor(props) {
    this.id = 0
  }

  get empty() {
    return $(this.emptySelector)[0].cloneNode(true)
  }

  getElById(id) {
    if (!id) return false
    return $(this.className).filter(
      (el) => {
        return el.dataset.id === id
      })[0];
  }

  getEl() {
    return this.target.closest(this.className)
  }

  getId() {
    return this.getEl().dataset.id
  }

  getUrlUpdateOrCreate() {
    return `/adminsc/${this.name}/updateOrCreate`
  }

  updateOrCreate() {
    return post(this.getUrlUpdateOrCreate(), this.model)
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

  async delete() {
    if (!confirm('Удалить?')) return false
    this.id = this.getId()
    if (await this.delServer()) {
      this.delDom()
    }

  }

}