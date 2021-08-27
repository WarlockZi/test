import './show.scss'
import {$} from '../common'
import {_test} from './model/test'

$(".test-show__save").on('click', _test.create)
$(".test-update__save").on('click', _test.update)