import {$, post, popup} from "../../common";

export const _testResult = {

  delServer: async (id) => {
    let res = await post('/test/resultdelete', {id})
    if (res) {
      popup.show('Удалено')

    }
  },

  delDom: (e) => {
    let id = e.target.dataset.row
    Array
      .from($(`[data-row = "${id}"]`).el)
      .map((i) => {
        i.remove()
      })
    return id

  },

  delete: (e) => {

    if (confirm("Удалить результат теста?")) {
      let id = _testResult.delDom(e)
      _testResult.delServer(id)
    }
  },


}