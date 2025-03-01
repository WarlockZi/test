import {$, objAndFiles2FormData, post} from "../../common";
import Dnd from "../dnd/dnd";
import MorphDTO from "./MorphDTO";

class Morph {
  constructor(el) {
    this.model = el.closest('.item-wrap').dataset.model;
    this.id = +el.closest('.item-wrap').dataset.id;

    el.onclick = this.handleClick.bind(this);
    // debugger
    if (el.querySelector('[dnd]')) {
      new Dnd(el,this.attach.bind(this))
    }
  }

  handleClick({target}) {
    if (target.hasAttribute('data-detach')) {
      this.detach(target, this)
    }
  }


  async attach(files, target) {
    this.dnd = target;
    this.morph = new MorphDTO(target);
    let url = `/adminsc/${this.model}/attach`;
    let param = {model: this.model, id: this.id, morph: this.morph};

    let res = await post(url, objAndFiles2FormData(param, files));
    if (res.arr) {
      Morph.appendTo(this, res.arr)
    }
  }

  async detach(target, self) {
    let url = `/adminsc/${this.model}/detach`;
    let data = self;
    data.morphId = target.dataset.id;
    data.relation = target.closest('[data-morph-relation]').dataset.morphRelation;

    let res = await post(url, data);
    if (res.success) {
      target.closest('.wrap').remove()
    }
  }

  static appendTo(self, images) {
    if (self.dnd) {
      if (self.morph.oneormany === 'many') {
        Morph.appendManyImages(self.dnd.parentNode, images)
      } else {
        Morph.appendOneImage(self.dnd.parentNode, images[0])
      }
    }
  }

  static appendOneImage(appendTo, image) {
    let img = $(appendTo)[0].querySelector('img');
    if (!img) {
      Morph.renderImage(appendTo, image)
    } else {
      img.src = image?.src
    }
  }

  static appendManyImages(appendTo, srcArr) {
    srcArr.forEach((image) => {
      Morph.renderImage(appendTo, image)
    })
  }

  static renderImage(appendTo, image) {
    let holder = $(appendTo)[0];
    let img = document.createElement('img');
    img.src = image.src;
    let del = document.createElement('div');
    del.setAttribute('data-detach', '');
    del.dataset.id = image.id;
    del.innerText = 'x';
    let item = document.createElement('div');
    item.classList.add('item');
    item.appendChild(img);
    let wrap = document.createElement('div');
    wrap.classList.add('wrap');
    wrap.appendChild(item);
    wrap.appendChild(del);
    holder.appendChild(wrap)
  }

}

// export default function morph() {
//   let morphs = $('[data-morph-relation]');
//   // debugger
//   if (morphs) {
//     morphs.forEach((morph) => {
//       new Morph(morph)
//     })
//   }
// }