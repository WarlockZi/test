import {$, popup} from "../common";

export const shortLink=()=>{
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