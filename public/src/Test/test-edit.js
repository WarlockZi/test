import './test-edit.scss'
import '../components/footer/footer.scss'

import './test-edit-menu.scss'
import './test-update'

import {$, debounce} from '../common'

import {_test} from "./model/test";

import sortable from "../components/sortable"
import pagination from "../components/pagination/pagination";

import Answer from "./Mode/Answer";
import Question from "./Mode/Question";


export default function testEdit() {

  let testEdit = $('.test-edit-wrapper')[0]
  if (testEdit) {

    pagination()
    sortable('.test-edit-wrapper .questions',
      '.questions>.question-edit',
      'question')

    $(testEdit).on('keyup', debouncedHandleKeyup)
    $(testEdit).on('change', handleChange)
    $(testEdit).on('click', handleClick)
  }
}

function handleClick({target}) {
  let answer = new Answer()
  let question = new Question(target)
// debugger
  if (['test-path__update', 'test__update', 'test__save'].includes(target.classList)) {
    _test.update()
  } else if (target.classList.contains('test__delete')) {
    _test.delete()
  } else if (target.classList.contains('test-path__create')) {
    _test.path_create()
  } else if (target.classList.contains('test__create')) {
    _test.create()
  } else if (!!target.closest('.question__show-answers')) {
    question.showAnswers()
  } else if (target.classList.contains('question__create-button')) {
    // question.updateOrCreate()
    question.create()
  } else if (!!target.closest('.question__delete')) {
    question.delete()
  } else if (!!target.closest('.delete')) {
    answer.delete(target)
  } else if (target.classList.contains('answer__create-button')) {
    answer.create(target)
  } else if (target.classList.contains('correct')) {
    answer.update(target)
  }
}

let debouncedHandleKeyup = debounce(handleKeyup)

async function handleKeyup({target}) {
  if (target.classList.contains('text')) {
    let answerEl = target.closest('.answer')
    if (answerEl) {
      let answer = new Answer()
      answer.update(target)
    } else {
      let question = new Question(target)
      question.update()
    }
  }
}

async function handleChange({target}) {
  if (!!target.closest('.question-edit__parent-select')) {
    let question = new Question(target)
    question.changeParent(target)
  }
}




