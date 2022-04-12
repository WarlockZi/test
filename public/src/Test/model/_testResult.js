import {$, post, popup} from "../../common";

export const _testResult = {


  delServer: async (id) => {
    let res = await post('/adminsc/testresult/delete', {id})
    if (res) {
      popup.show('Удалено')
    }
  },

  delDom: ({target}) => {
    let id = target.closest('.del').dataset['row'];
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