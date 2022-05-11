import Sortable from 'sortablejs'
import {$, popup, post} from '../common'

export default function sortable(containerSelector,elSelector, model) {

  let container = $(containerSelector)[0];
  let els = $(elSelector);
  // debugger
  if (container) {
    let sortable = Sortable.create(container, {
      animation: 150,
      onEnd: function (evt) {
        let oldI = evt.oldIndex
        let newI = evt.newIndex
        // let questions = _question.questions()
        if (oldI > newI) {
          sort(oldI)
        } else {
          sort(newI)
        }

        async function sort(upToQestionNumber) {
          let questionsEls = els.filter(function (el, i) {
              if (i + 1 < upToQestionNumber) return el
            }
          )
          let toChange = questionsEls.map((el) => {
            return el.id
          })
          let res = await post(`/adminsc/${model}/sort`, {toChange})
          res = JSON.parse(res)
          if (res.msg) {
            popup.show(res.msg)
          }
          questionsEls.map((el, i) => {
            $(el).find('.question__sort').innerText = i + 1
          })
        }
      },
    })
  }

}