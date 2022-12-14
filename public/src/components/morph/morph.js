import {$, post} from "../../common";

export default class Morph {

  constructor(morph, morphed, files) {

    if (!morph) throw new Error('add morph')
    if (!morphed) throw new Error('add morphed')

    this.data = {}
    this.data.morph = morph
    this.data.morphed = morphed
    this.data = this.addMultipleFiles(files, this.data)
  }

   static async detach(target){
    let container = target.closest('.wrap')
    let morphedType = target.closest('.item_wrap').dataset.model
    let morphedId = target.closest('.item_wrap').dataset.id
    let slug = target.closest('.morph').dataset.slug
    let morphType = target.closest('.morph').dataset.type
    let morphId = target.dataset.id
    let url = `/adminsc/${morphType}/detach`
    let data = {morphedType,morphedId,morphId,slug}
    let res = await post(url,data)
    if (res.success){
      container.remove()
    }
  }


  addMultipleFiles(files, data) {
    let formData = new FormData
    for (let i = 0; i < files.length; i++) {
      formData.append(i, files[i])
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

  appendManyImages(appendTo, srcArr) {
    let img = $(appendTo)[0].querySelector('img')
    srcArr.forEach((image) => {
      let holder = $(appendTo)[0]

      let img = document.createElement('img')
      img.src = image.src
      img.onleave = false
      img.onenter = false
      img.ondrop = false

      let del = document.createElement('div')
      del.classList.add('detach')
      del.dataset.id = image.id
      // del.dataset.tag = tag
      del.innerText = 'x'

      let item = document.createElement('div')
      item.classList.add('item')
      item.appendChild(img)
      item.appendChild(del)

      let wrap = document.createElement('div')
      wrap.classList.add('wrap')

      wrap.appendChild(im)

      holder.appendChild(im)


    }).bind(appendTo)
  }
}