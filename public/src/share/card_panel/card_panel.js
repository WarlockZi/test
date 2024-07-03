import {$, popup} from "../../common";
import './card_panel.scss'

export default class Card_panel {
   constructor() {
      this.el = $(`[data-shortLink]`).first()
      if (this.el) return false

   }

   shortLink(target) {
      navigator.permissions.query({name: "clipboard-write"}).then((result) => {
         if (result.state === "granted" || result.state === "prompt") {
            popup.show('Ссылка скопирована')
            navigator.clipboard.writeText(target.dataset.shortlink)
         }
      });
   }

}