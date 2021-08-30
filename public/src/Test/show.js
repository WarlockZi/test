import './show.scss'
import {$} from '../common'
import {_test} from './model/test'
// let show  = $(".test-show__save")
// if (show){
// $(show).on('click', _test.create)
// }
$(".test-update__save").on('click', _test.update)