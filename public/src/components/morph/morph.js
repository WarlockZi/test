import {$, objAndData2FormData, post} from "../../common";
import {Dnd} from "../dnd/dnd";
import MorphDTO from "./MorphDTO";

class Morph {
  constructor(morphEl) {
    this.model = morphEl.closest('.item_wrap').dataset.model
    this.id = morphEl.closest('.item_wrap').dataset.id

    this.slug = morphEl.dataset.morphSlug
    this.oneOrMany = morphEl.dataset.morphOneormany
    this.relation = morphEl.dataset.morphRelation

    let detaches = $(morphEl)[0].querySelectorAll('[data-detach]');
    [].forEach.call(detaches, (detach) => {
      detach.onclick = this.detach.bind(this)
    })
    // debugger
    let holder = $(morphEl)[0].querySelectorAll('.holder')
    if(holder) new Dnd(this.attach.bind(this))
    // let dndCallback = Morph.dndCallback.bind(this)
  }

  async attach(files, target) {
    let morph = new MorphDTO(target.parentNode)

    if (target.parentNode.dataset.morphOneormany === 'one') {
      let fr = Array.prototype.slice.call(files, 0, 1);
    }
    debugger
    let url = `/adminsc/${this.model}/attach`
    let param = {model:this.model, id:this.id, morph}
    param = objAndData2FormData(param, files)
    let res = await post(url, param)
  }

  async detach({target}) {
    debugger
    let url = `/adminsc/${this.model}/detach`
    let data = this
    data.morphId = target.dataset.id

    let res = await post(url, data)
    if (res.success) {
      container.remove()
    }
  }

  static async dndCallback(files) {

// debugger
    let data = Morph.prepareData(this)
    data = objAndData2FormData(data, files)

    let res = await post(this.url, data)
    if (res.arr) {
      Morph.appendTo(this, res.arr)
    }

  }

  static appendTo(self, srcs) {

    if (self.append) {
      let el = self.append
      // debugger
      if (self.oneOrMany === 'many') {
        Morph.appendManyImages(el, srcs)
      } else {
        Morph.appendOneImage(el, srcs)
      }
    }
  }



  static appendOneImage(appendTo, image) {
    let img = $(appendTo)[0].querySelector('img')
    if (!img) {
      Morph.renderImage(appendTo, image)
    } else {
      img.src = image?.src
    }
  }

  static setImagePath(morphedEl) {
    let imagePath = $(morphedEl).find('[data-path]')
    if (imagePath) {
      return imagePath.dataset.path
    }
    return ''
  }

  static appendManyImages(appendTo, srcArr) {
    srcArr.forEach((image) => {
      Morph.renderImage(appendTo, image)
    })
  }

  static renderImage(appendTo, image) {
    let holder = $(appendTo)[0]
    let img = document.createElement('img')
    img.src = image.src
    let del = document.createElement('div')
    del.setAttribute('data-detach', '')
    del.classList.add('detach')
    del.dataset.id = image.id
    del.innerText = 'x'
    let item = document.createElement('div')
    item.classList.add('item')
    item.appendChild(img)
    let wrap = document.createElement('div')
    wrap.classList.add('wrap')
    wrap.appendChild(item)
    wrap.appendChild(del)
    holder.appendChild(wrap)
  }
}

export default function morph() {
  let morphs = $('[data-morph-relation]')
  if (morphs) {
    // debugger
    morphs.forEach((morph) => {
      new Morph(morph)
    })
  }
}