import {$, post, popup} from "../../common";

export const _testResult = {


  delServer: async (id) => {
    let res = await post('/test/resultdelete', {id})
    if (res) {
      popup.show('Удалено')
    }
  },

  delDom: ({target}) => {
    let button = target.closest('.del')
    let id = button.dataset['row'];
    [].map.call($(`[data-row = "${id}"]`), function (i) {
        i.remove()
      }
    )
    return id
  },

  delete: (e) => {
    if (confirm("Удалить результат теста?")) {
      let id = _testResult.delDom(e)
      _testResult.delServer(id)
    }
  },

}