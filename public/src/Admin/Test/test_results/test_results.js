import './test-results.scss'
import {$} from '../../../common.js'
import Testresult from "../Mode/Testresult.js";

let testResults = $('.test-results__table')[0]
if (testResults) {
  $(testResults).on('click', handleClick)
}

function handleClick({target}) {
  if (target.closest('.del-btn')) {
    let testresult = new Testresult()
    let id = target.closest('.del-btn').dataset.row
    testresult.delete(id)
  }
}
