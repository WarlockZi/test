import './show.scss'
import {$} from '../common'
import {_test} from './model/test'


$(".test__save").on('click', _test.update)
$(".test__delete").on('click', _test.delete)
$(".test-path__create").on('click', _test.path_create)
$(".test__create").on('click', _test.create)