import './test-results.scss'
import {$} from '../../common'
import {_testResult} from '../model/_testResult'
import Testresult from "../Mode/Testresult";

let testResults = $('.test-results__table')[0]
if (testResults) {
  $(testResults).on('click', handleClick)
}

function handleClick({target}) {
  debugger
  let tr = new Testresult()

  if (!!target.closest('.del-btn')) {
    let id = target.closest('.del-btn').dataset.row
    tr.delete(id)
    // _testResult.delete(id)
  }
}
