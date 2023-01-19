import {$, post} from "../../common";

export default class Model {

  constructor(props) {
  }

  updateOrCreate() {

  }

  async delServer(id) {
    let res = await post(`/adminsc/${this.name}/delete`, {id})
  }

  delDom(id){
    this.id = id
    let selector = this.delDomSelector;

    [].map.call($(selector), function (i) {
        i.remove()
      }
    )
  }

  delete(id){
    if (confirm('Удалить?')){
      if ( this.delServer(id)){
        this.delDom(id)
      }
    }
  }

}