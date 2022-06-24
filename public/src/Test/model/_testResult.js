import {$, post} from "../../common";

export const _testResult = {


  delServer: async (id) => {
    if ($('.opentest')) {
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
      _testResult.delDom(id)
      _testResult.delServer(id)
    }
  },

}