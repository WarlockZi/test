import Sortable from 'sortablejs'
import {$, popup, post} from '../common'

export default function sortable(containerSelector, elSelector, model) {

  let container = $(containerSelector)[0];
  if (container) {

    let sortable = Sortable.create(container, {
      animation: 150,
      onEnd: function (evt) {
        let oldI = evt.oldIndex
        let newI = evt.newIndex
        if (oldI > newI) {
          sort(oldI)
        } else {
          sort(newI)
        }

        async function sort(upToQestionNumber) {
          let els = $(elSelector);
          let questionsEls = [].map.call(els, function (el, i) {
              if (i - 1 < upToQestionNumber) return el
            }
          )

          let toChange = questionsEls.map((el) => {
            return el.dataset.id
          })
          let res = await post(`/adminsc/${model}/sort`, {toChange})
          questionsEls.map((el, i) => {
            $(el).find('.sort').innerText = i + 1
          })
        }
      },
    })

  }
}