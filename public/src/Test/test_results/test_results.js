import {$} from '../../common'
import {_testResult} from '../model/_testResult'
import './test-results__table.scss'

export default function testResults() {
  $('.test-results__table .del').on('click', _testResult.delete)
}

