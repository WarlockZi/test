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


  if ($("[data-question-parent-id]")) {
    $(".select__wrap select").on('change', _question.changeParent)
  }


// подсветка текущего теста
  _test.markCurrentInMenu()


  sortable.connect('.questions')


// при создании нового теста показать пустой вопрос
  if (!_question.questions().length
    && /\/adminsc\/test\/edit/.test(window.location.pathname)) {
    _question.showFirst()
  }

  let testEditWrapper = $('.test-edit-wrapper')[0]
  if (testEditWrapper) {
    $(testEditWrapper).on('click', function ({target}) {
  debugger
      switch (true) {
        case [target.classList].includes('test-path__update'): {
          _test.update()
          break;
        }
        case [target.classList].includes('question__save'): {
          _question.save()
          break;
        }
        case [target.classList].includes('question__show-answers'): {
          _question.showAnswers()
          break;
        }
        case [target.classList].includes('question__delete'): {
          _question.delete()
          break;
        }
        case [target.classList].includes('question__create-button'): {
          _question.create()
          break;
        }
        case [target.classList].includes('answer__delete'): {
          _answer.del()
          break;
        }
        case [target.classList].includes('answer__create-button'): {
          _answer.create()
          break;
        }
      }

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


