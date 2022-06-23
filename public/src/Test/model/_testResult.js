import {$, post, popup} from "../../common";

export const _testResult = {


  delServer: async (id) => {
    let res = await post('/adminsc/testresult/delete', {id})
  },

  delDom: (id) => {
    [].map.call($(`[data-row = "${id}"]`), function (i) {
        i.remove()
      }
    )
  },

  delete: (id) => {
    if (confirm("Удалить результат теста?")) {
      _testResult.delDom(id)
      _testResult.delServer(id)
    }
  },

}