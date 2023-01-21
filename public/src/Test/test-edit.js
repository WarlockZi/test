import './test-edit.scss'
import '../components/footer/footer.scss'

import './test-edit-menu.scss'

import './test-update'

import {$, debounce} from '../common'

import {_question} from "./model/question"
import {_test} from "./model/test";


import sortable from "../components/sortable"
import WDSSelect from "../components/select/WDSSelect"
import pagination from "../components/pagination/pagination";
import Answer from "./Mode/Answer";
import Testresult from "./Mode/Testresult";


export default function testEdit() {


  let testEdit = $('.test-edit-wrapper')[0]
  if (testEdit) {

    pagination()
    sortable('.test-edit-wrapper .questions',
      '.questions>.question-edit',
      'question')

    let answer = new Answer()
    let test = new Testresult()

    $(testEdit).on('keyup', debouncedHandleKeyup.bind(this))
    $(testEdit).on('change', handleChange.bind(this))
    $(testEdit).on('click', handleClick.bind(this))
  }
}

function handleClick({target}) {

// debugger
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
  } else if (!!target.closest('.question__show-answers')) {
    _question.showAnswers(target)
  } else if (target.classList.contains('question__create-button')) {
    _question.questionCreate(target)
  } else if (!!target.closest('.question__delete')) {
    _question.del(target)
  } else if (!!target.closest('.delete')) {
    answer.delete(target)
  } else if (target.classList.contains('answer__create-button')) {
    answer.create(target)
  } else if (target.classList.contains('correct')) {
    answer.update(target)
  }
}

let debouncedHandleKeyup = debounce(handleKeyup.bind(this)).bind(this)

async function handleKeyup({target}) {
  if (target.classList.contains('text')) {
    let answerEl = target.closest('.answer')
    if (answerEl) {
      answer.update(target)
    } else {
      _question.saveQuestion(target)
    }
  }
}

async function handleChange({target}) {
  if (!!target.closest('.question-edit__parent-select')) {
    _question.changeParent(target)
  }
}




