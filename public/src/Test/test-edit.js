import './test-edit.scss'
import '../components/footer/footer.scss'

import './test-edit-menu.scss'
import '../components/popup.scss'

// import './test'
import './test-update'
import './path-create'
import '../Admin/admin'

import {$, addTooltip} from '../common'

import {_test} from "./model/test"
import {_question} from "./model/question"
import {_answer} from "./model/answer"
import {sortable} from "../components/sortable"
import WDSSelect from "../components/select/WDSSelect"
import accordionShow from "./accordion-show";

import testEditActions from "./testEditActions";

export default function testEdit() {

  accordionShow()
// debugger
  let customSelects = $('[custom-select]');
  [].forEach.call(customSelects, function (select) {
    new WDSSelect(select)
  });

  // let parentSelect = new WDSSelect({
  //   element: $("[data-custom-parent]")[0],
  //   title: 'Папка',
  //   class: 'parent'
  // })
  //
  //
  // let enableSelect = new WDSSelect({
  //   element: $("[data-custom-enable]")[0],
  //   title: 'Показывать пользователям',
  //   class: 'enable'
  // })


  if ($("[data-question-parent-id]")) {
    $(".question-edit__parent-select select").on('change', _question.changeParent)
  }


  sortable.connect('.questions')


// при создании нового теста показать пустой вопрос
  if (!_question.questions().length
    && /\/adminsc\/test\/edit/.test(window.location.pathname)) {
    _question.showFirst()
  }

  debugger
  let testEditWrapper = $('.test-edit-wrapper')[0]
  if (testEditWrapper) {
    $(testEditWrapper).on('click', function ({target}) {
      testEditActions(target)
    })
  }
//   $('.test-path__update').on('click',)
// // $('.question__sort').on('change', validate.sort)
//   $('.question__save').on('click', _question.save)
//   $('.question__show-answers').on('click', _question.showAnswers)
//   $('.question__delete').on('click', _question.delete)
//   $('.question__create-button').on('click', _question.create)
  // $('.answer__delete').on('click', _answer.del)
  // $('.answer__create-button').on('click', _answer.create)


  addTooltip({
    els: $('.question__save'),
    message: 'Сохранить вопросы и ответы'
  })

  addTooltip({
    els: $('.question__menu'),
    message: 'Переложить в другой тест'
  })
  addTooltip({
    els: $('.question__delete'),
    message: 'Удалить вопросы и ответы'
  })

  addTooltip({
    els: $('.question__show-answers'),
    message: 'Показать ответы'
  })

  addTooltip({
    els: $('.test-edit-menu__params'),
    message: 'Редактировать'
  })

  addTooltip({
    els: $('.question__menu'),
    message: 'Перенести в другой тест'
  })

}


