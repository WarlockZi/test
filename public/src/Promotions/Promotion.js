import './promotion.scss'
import {$, post} from '../common'

export default class Promotion {
  constructor() {
    this.$promotion = $('.promotion-edit').first();
    if (!this.$promotion) return;

    this.id = $(this.$promotion).find(`[data-field='id']`).innerText;

    this.$activeTill = $(`[data-field='active-till']`).first();
    this.$activeTill.onchange = this.handleChange.bind(this)

  }

  handleChange({target}){

    let data = this.dto(this);
    data.active_till = target.value;
    let res = post('/adminsc/promotion/updateOrCreate', data);
    if (res){

    }

  }

  dto(self){
    return {
      id: self.id
    }
  }


}