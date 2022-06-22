import './test-edit.scss'
import '../components/footer/footer.scss'

import './test-edit-menu.scss'
import '../components/popup.scss'

import './test-update'

import '../Admin/admin'

import {$, debounce, popup, post, trimStr} from '../common'

import {_question} from "./model/question"
import {_test} from "./model/test";
import {_answer} from "./model/answer";

import sortable from "../components/sortable"
import WDSSelect from "../components/select/WDSSelect"


export default function testEdit() {

  let testEdit = $('.questions')[0]
  if (testEdit) {

    sortable('.test-edit-wrapper .questions',
      '.questions>.question-edit',
      'question')
    // customSelect()

    $(testEdit).on('keyup', handleKeyup)
    $(testEdit).on('click', handleClick)
  }
}

function handleClick({target}) {

  if (target.classList.contains('test-path__update')) {
    _test.update()
  } else if (target.classList.contains('test__update')) {
    _test.update()
  } else if (target.classList.contains('test__save')) {
    _test.update()
  } else if (target.classList.contains('test__delete')) {
    _test.delete()
  } else if (target.classList.contains('test-path__create')) {
    _test.path_create()
  } else if (target.classList.contains('test__create')) {
    _test.create()
  } else if (!!target.closest('.question__save')) {
    _question.save(target)
  } else if (!!target.closest('.question__show-answers')) {
    _question.showAnswers(target)
  } else if (target.classList.contains('question__create-button')) {
    _question.questionCreate(target)
  } else if (!!target.closest('.question__delete')) {
    _question.del(target)
  } else if (!!target.closest('.delete')) {
    _answer.del(target)
  } else if (target.classList.contains('answer__create-button')) {
    _answer.answerCreate(target)
  }
}

async function handleKeyup({target}) {

  if (target.classList.contains('text')) {
    let answer = target.closest('.answer')
    if (answer) {
      let debounced = debounce(_answer.saveAnswer)
      debounced(answer)
    } else {
      let debounced = debounce(_question.saveQuestion)
      let id = target.closest('.question-edit').id
      let question = target.innerText
      // let res = await post('/adminsc/openquestion/updateOrCreate',
      //   {id, question})
      debounced(target)

    }
  }

  if (!!target.closest('.question-edit__parent-select')) {
    _question.changeParent(target)
  }
}


// function customSelect() {
//   let customSelects = $('[custom-select]');
//   [].forEach.call(customSelects, function (select) {
//     new WDSSelect(select)
//   });
// }



