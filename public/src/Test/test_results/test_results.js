import './test-results__table.scss'
import {$} from '../../common'
import {_testResult} from '../model/_testResult'

export default function testResults() {
  $('.test-results__table').on('click',handleClick)

  function handleClick({target}) {
    if (!!target.closest('.del-btn')){
      let id = target.closest('.del-btn').dataset.row
      _testResult.delete(id)
    }

  }
}

