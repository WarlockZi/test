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


