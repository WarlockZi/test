import {$, popup} from "../../common";
import './card_panel.scss'

export const card_panel=()=>{

  const shortLink = $(`[data-shortLink]`).first()
  if (shortLink) {

    shortLink.addEventListener('click', async (e) => {
      navigator.permissions.query({name: "clipboard-write"}).then((result) => {
        if (result.state === "granted" || result.state === "prompt") {
          popup.show('Ссылка скопирована')
          navigator.clipboard.writeText(e.target.dataset.shortlink)
        }
      });
    })
  }
}