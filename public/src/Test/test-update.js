import './test-update.scss'
import {$} from '../common'
import {_test} from './model/test'
import WDSSelect from "../components/select/WDSSelect"
import accordionShow from "./accordion-show";

export default function testUpdate() {
  accordionShow()

  // let parentSelect = new WDSSelect({
  //   element: $("[data-custom-parent]")[0],
  //   title: 'Лежит в папке',
  //   class: 'parent'
  // })

  // debugger
  let enableSelect = new WDSSelect({
    title: 'Показывать пользователям',
    class: 'enable',
    field: 'enable',
  })

  let parentsSelect = new WDSSelect({
    title: 'Лежит в папке',
    class: 'parent',
    field: 'parent',
  })
debugger
  $('.test__update').on('click', _test.update.bind(null, parentsSelect.selectedOption, enableSelect.selectedOption))
  $(".test__save").on('click', _test.update)
  $(".test__delete").on('click', _test.delete)
  $(".test-path__create").on('click', _test.path_create)
  $(".test__create").on('click', _test.create)
}
