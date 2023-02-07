import {$, post} from '../../common'

class Checkbox {
  constructor(context, e) {
    $('[my-checkbox]').on('change', this.changeHandle.bind(context))
  }

  async changeHandle({target}) {
    let field = target?.dataset.field

    let data = {
      id:this.id,
      [field]:+target.checked
    }
    let res = await post(`/adminsc/${this.model}/updateOrCreate`,data)
  }
}

export default function checkbox() {
  return new Checkbox(...arguments)
}