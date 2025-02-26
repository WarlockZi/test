import './test-edit.scss'
import '../../../components/footer/footer.scss'

import './test-edit-menu.scss'
import '../test-update.js'

import {$, debounce} from '../../../common.js'

import {_test} from "../model/test.js";

import sortable from "../../../components/sortable.js"
import pagination from "../../../components/pagination/pagination.js";

import answer from "../Mode/Answer.js";
import question from "../Mode/Question.js";


export default function testEdit() {

  // debugger
  let testEdit = $('.test-edit__cont')[0]
  if (testEdit) {

    pagination()
    sortable('.test-edit__cont .questions',
      '.questions>.question-edit',
      'question')

    $(testEdit).on('keyup', debouncedHandleKeyup)
    $(testEdit).on('change', handleChange)
    $(testEdit).on('click', handleClick)
  }
}

function handleClick({target}) {
  // debugger
  if (['test-path__update', 'test__update', 'test__save'].includes(target.classList)) {
    _test.update()
  } else if (target.classList.contains('test__delete')) {
    _test.delete()
  } else if (target.classList.contains('test__create')) {
    _test.create()
  } else if (target.classList.contains('test-path__create')) {
    _test.path_create()

  } else if (!!target.closest('.question__delete')) {
    question(target).delete()
  } else if (target.classList.contains('question__create-button')) {
    question(target).create()
  } else if (!!target.closest('.question__show-answers')) {
    question(target).showAnswers()

  } else if (!!target.closest('.delete')) {
    answer(target).delete()
  } else if (target.classList.contains('answer__create-button')) {
    answer(target).create()
  } else if (target.classList.contains('correct')) {
    answer(target).update()
  }
}

let debouncedHandleKeyup = debounce(handleKeyup)

async function handleKeyup({target}) {
  if (target.classList.contains('text')) {
    let answerEl = target.closest('.answer')
    if (answerEl) {
      // debugger
      answer(target).update()
    } else {
      question(target).update()
    }
  }
}

async function handleChange({target}) {
  if (!!target.closest('.question-edit__parent-select')) {
   question(target).changeParent()
  }
}




