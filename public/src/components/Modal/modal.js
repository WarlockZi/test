import './modal.scss'
import {$} from '../../common'
import {ael, cqs, qa, qs} from "../../constants.js";

export default class Modal {
   constructor(props) {
      this.modal = $(`[data-modal='default']`).first();

      if (!props?.triggers || !props?.boxes || !this.modal) return;
      this.triggers = props.triggers;
      this.boxes = props.boxes;

      this.overlay = $(this.modal).find('.overlay');
      this.wrap = $(this.modal).find('.wrap');
      this.content = $(this.modal).find('.content');
      this.box = $(this.modal).find('.box');
      this.closeEl = $(this.modal).find('.modal-close');

      this.triggers.forEach((trigger) => {
         if (cqs(trigger)) cqs(trigger)[ael]('click', this.show.bind(this));
      })

      this.overlay[ael]('click', this.close.bind(this));
      this.modal[ael]('modal.switch', this.switch.bind(this));
   }

   switch({target}) {
      const box = target.closest('.box')
      box[ael]('transitionend', this.removeClasses, {once: true})
      box.classList.add('translate-left')
      const targe = target.dataset.target;
      const registerBox = this.wrap[qs](`[id='${targe}']`)
      registerBox.classList.add('transform-in')
   }

   removeClasses({target}) {
      target.classList.remove('transform-in')
      target.classList.remove('translate-left')
   }

   show() {
      this.renderBoxes();
      this.modal.classList.remove('invisible');
      this.overlay.classList.add('blur')
      this.wrap[qs]('.box:nth-child(2)').classList.add('transform-in');
   }

   close({target}) {
      // this.overlay.
      if (!target.classList.contains('modal-close') && !target.classList.contains('overlay')) return
      const openedBox = this.wrap[qs]('.transform-in')
      openedBox[ael]('transitionend', this.transitionHandler.bind(this))
      openedBox?.removeEventListener('transitionend', this.transitionHandler, {once:true})
      openedBox?.classList.remove('transform-in');
      this.overlay.classList.remove('blur')
   }

   transitionHandler() {
      this.modal.classList.add('invisible');
      this.wrap[qa]('.box[id]').forEach(box => box.remove())
   }

   renderBoxes() {
      for (let index in this.boxes) {
         const box = this.boxes[index];
         const boxClone = this.box.cloneNode(true)
         boxClone[ael]('click', this.close.bind(this))
         boxClone.id = index;
         boxClone[qs]('.title').innerText = box[0][0]
         for (let i in box) {
            const row = box[i];
            for (let j in row) {
               if (j > 0) {
                  boxClone[qs]('.content').appendChild(row[j])
               }
            }
         }
         this.wrap.appendChild(boxClone)
      }
   }

}