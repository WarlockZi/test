import './test-results__table.scss'
import {$} from '../../common'
import {_testResult} from '../model/_testResult'

let testResults = $('.test-results__table')[0]
if (testResults) {
  $(testResults).on('click', handleClick)
}

function handleClick({target}) {
  if (!!target.closest('.del-btn')) {
    let id = target.closest('.del-btn').dataset.row
    _testResult.delete(id)
  }
}


let testResult = $('.testresult')[0]
if (testResult) {
  $('.accordion_wrap')[0].remove()
  $('.page-name')[0].remove()
  $('.test-name')[0].remove()
  $('.test-do__finish-btn')[0].remove()
}