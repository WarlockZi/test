import './show.scss'
import {$} from '../common'
import {_test} from './model/test'
import WDSSelect from "../components/select/WDSSelect"



let parentSelect = new WDSSelect({
  element: $("[data-custom-parent]")[0],
  title: 'Папка',
  class: 'parent'
})


let enableSelect = new WDSSelect({
  element: $("[data-custom-enable]")[0],
  title: 'Показывать пользователям',
  class: 'enable'
})


$(".test__save").on('click', _test.update)
$(".test__delete").on('click', _test.delete)
$(".test-path__create").on('click', _test.path_create)
$(".test__create").on('click', _test.create)