import {$, post} from "../../common";

export default class Morph {

  data = {};


  constructor(morph, morphed, file) {

    if (!morph.type) throw new Error('add morph_type')
    if (!morphed.id) throw new Error('add morphed_id')
    if (!morphed.type) throw new Error('add morphed_type')

    let morph_type = morph.type
    let morphed_type = morphed.type
    let morphed_id = morphed.id

    // let morph = new morph

    // this.morph = morph
    this.data = {morphed, morph, file}
  }

  async appendManyImages(appendTo) {
    //TODO
  }

  appendOneImage(appendTo) {
    let img = $(appendTo)[0].querySelector('img')
    let holder = $(appendTo)[0]
    if (!img) {
      let img = document.createElement('img')
      img.src = '/pic/ava_male.png'
      img.onleave = false
      img.onenter = false
      img.ondrop = false
      holder.appendChild(img)
    } else {
      img.src = '/pic/ava_male.png'
    }
  }
}