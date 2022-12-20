import {$, post, objAndData2FormData} from "../../common";
import DragNDrop from "../dnd/DragNDrop";
import DragNDropMany from "../dnd/DragNDropMany";
import DragNDropOne from "../dnd/DragNDropOne";

export default class Morph {

  constructor(morphEl, morphedEl) {
    if (!morphEl) throw new Error('add right element')
    if (!morphedEl) throw new Error('add morphed')

    this.morphEl = morphEl
    this.morphedEl = morphedEl

    this.imagePath = Morph.setImagePath(morphedEl)
    this.appendTo = Morph.setAppendTo(morphedEl)

    let dndContainer = $(`[data-dnd]`)[0]
    if (dndContainer) {
      this.oneOrMany = morphEl.dataset.morph
      // debugger
      let dndCallback = Morph.dndCallback.bind(this)

      if (this.oneOrMany === 'many') {
        new DragNDropMany(dndContainer, dndCallback)
      } else {
        new DragNDropOne(dndContainer, dndCallback)
      }
    }

    $(this.morphEl).on('click', '[data-detach]', function ({target}) {
      let mor = Morph.detach(target)
    })
  }

  static setImagePath(morphedEl){
    let imagePath = $(morphedEl).find('[data-path]')
    if (imagePath) {
      return imagePath.dataset.path
    }
    return ''
  }

  static setAppendTo(morphedEl){
    let appendTo = $(morphedEl).find('[data-appendto]')
    if (appendTo) {
      return '.'+appendTo.dataset.appendto
    }
    return ''
  }

  static prepareData(morphEl, morphedEl) {
    let data = {}
    data.morph = {}
    data.morphed = {}

    data.morphed.type = morphedEl.dataset.model
    data.morphed.id = morphedEl.dataset.id

    data.morph.type = morphEl.dataset.model
    data.morph.slug = morphEl.dataset.slug
    data.morph.path = morphEl.dataset.path

    return data
  }

  static async dndCallback(files) {
    // debugger
    let url = `/adminsc/${this.morphEl.dataset.model}/attach${this.oneOrMany}`

    let data = Morph.prepareData(this.morphEl, this.morphedEl)
    data = objAndData2FormData(data, files)

    let res = await post(url, data)

    Morph.appendTo(this,res.arr)

  }

  static appendTo(self,srcs){

    if (self.appendTo){
      let el = self.morphEl.closest(self.appendTo)
      if (self.oneOrMany==='many'){
        Morph.appendManyImages(el,srcs)
      }else{
        Morph.appendOneImage(el,srcs)
      }
    }
  }

  static async detach(target) {
    let container = target.closest('.wrap')
    let morphedType = target.closest('.item_wrap').dataset.model
    let morphedId = target.closest('.item_wrap').dataset.id
    let slug = target.closest('[data-morph]').dataset.slug
    let morphType = target.closest('[data-morph]').dataset.model
    let morphId = target.dataset.id
    let url = `/adminsc/${morphType}/detach`
    let data = {morphedType, morphedId, morphId, slug}
    let res = await post(url, data)
    if (res.success) {
      container.remove()
    }
  }

  static async attach(oneOrMany, files) {
    let container = target.closest('.wrap')
    let morphedType = target.closest('.item_wrap').dataset.model
    let morphedId = target.closest('.item_wrap').dataset.id
    let slug = target.closest('.morph').dataset.slug
    let morphType = target.closest('.morph').dataset.type
    let morphId = target.dataset.id
    let url = `/adminsc/${morphType}/detach`
    let data = {morphedType, morphedId, morphId, slug}
    let res = await post(url, data)
    if (res.success) {
      container.remove()
    }
  }


  static appendOneImage(appendTo, src) {
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

  static appendManyImages(appendTo, srcArr) {
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
      wrap.appendChild(img)
      holder.appendChild(img)
    }).bind(appendTo)
  }
}