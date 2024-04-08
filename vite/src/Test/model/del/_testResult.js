import {$, post} from "../../../common";

export const _testResult = {

  delServer: async (id) => {
    let opentest = $('.opentest')[0]
    if (opentest) {
      let res = await post('/adminsc/opentestresult/delete', {id})
    } else {
      let res = await post('/adminsc/testresult/delete', {id})
    }
  },
  delDom: (id) => {
    [].map.call($(`[data-row = "${id}"]`), function (i) {
        i.remove()
      }
    )
  },
  delete: (id) => {
    if (confirm("Удалить результат теста?")) {
      _testResult.delServer(id)
      _testResult.delDom(id)
    }
  },

}