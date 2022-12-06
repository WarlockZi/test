import {$} from "../../common";

export default class Morph {


  constructor(morph, morphed, files) {

    if (!morph.type) throw new Error('add morph_type')
    if (!morphed.id) throw new Error('add morphed_id')
    if (!morphed.type) throw new Error('add morphed_type')

    this.data = {}
    this.data.morph = morph
    this.data.morphed = morphed
    this.data = this.addMultipleFiles(files, this.data)
  }

  addMultipleFiles(files, data) {
    let formData = new FormData
    for (let i = 0; i < files.length; i++) {
      formData.append(files[i].name, files[i])
    }
    return this.obj2FormData(data, formData)
  }

  obj2FormData(obj, formData = new FormData()) {
    this.formData = formData;
    this.createFormData = function (obj, subKeyStr = '') {
      for (let i in obj) {
        let value = obj[i];
        let subKeyStrTrans = subKeyStr ? subKeyStr + '[' + i + ']' : i;

        if (typeof (value) === 'string' || typeof (value) === 'number') {

          this.formData.append(subKeyStrTrans, value);
        } else if (typeof (value) === 'object') {
          this.createFormData(value, subKeyStrTrans);
        }
      }
    }
    this.createFormData(obj);
    return this.formData;
  }

  async appendManyImages(appendTo) {
    //TODO
  }

  appendOneImage(appendTo, src) {
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
      img.src = src ?? '/pic/ava_male.png'
    }
  }
}