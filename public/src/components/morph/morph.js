import {post} from "../../common";

export default class Morph {
  url = '';
  data = {};

  constructor(morphed_type, morphed_id, morph_model, morph_id,) {
    if (!morphed_type) throw new Error('add morphed_type')
    if (!morphed_id) throw new Error('add morphed_id')
    if (!morph_model) throw new Error('add morph_model')
    if (!morph_id) throw new Error('add morph_id')
    this.url = `adminsc/${morph_model}/addMorph`
    this.data = {morphed_type, morphed_id, morph_id}
  }

  async addMorphed() {
    return await post(this.url, this.data);
  }

}