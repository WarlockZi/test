import {$, post} from "../../common";

export default class Morph {
  morph = {};
  data = {};


  constructor(morph, morphed, file) {
    // if (!morph_id) throw new Error('add morph_id')
    if (!morph.type) throw new Error('add morph_type')
    if (!morphed.id) throw new Error('add morphed_id')
    if (!morphed.type) throw new Error('add morphed_type')

    let morph_type = morph.type
    let morphed_type = morphed.type
    let morphed_id = morphed.id

    this.morph = morph
    this.data = {morphed_type, morphed_id, morph_type, file}
  }

  async addMorphed() {
    return await post(this.morph.url, this.data);
  }

  appendOneImage(appendTo) {
    let img = $(appendTo)[0].querySelector('img')
    if (!img) {
      let img = document.createElement('img')
      img.src = '/pic/ava_male.png'
      appendTo.appendChild(img)
    } else {
      img.src = '/pic/ava_male.png'
    }
  }
}