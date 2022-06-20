import './test-edit.scss'
import '../components/footer/footer.scss'

import './test-edit-menu.scss'
import '../components/popup.scss'

import './test-update'

import '../Admin/admin'

import {$} from '../common'

import {_question} from "./model/question"
import sortable from "../components/sortable"
import WDSSelect from "../components/select/WDSSelect"

import {_test} from "./model/test";
import {_answer} from "./model/answer";

export default function testEdit() {

  let testEdit = $('.test-edit-wrapper')[0]

  if (testEdit) {

    sortable('.test-edit-wrapper.questions')

    customSelect()

    $(testEdit).on('change', handleKeyup)
    $(testEdit).on('click', handleClick)

  }
}

function customSelect() {
  let customSelects = $('[custom-select]');
  [].forEach.call(customSelects, function (select) {
    new WDSSelect(select)
  });
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
  } else if (!!target.closest('.question__delete')) {
    _question.delete(target)
  } else if (target.classList.contains('question__create-button')) {
    _question.create()
  } else if (!!target.closest('.delete')) {
    del()
  } else if (target.classList.contains('answer__create-button')) {
    _answer.create(target)
  }
}

async function del(target,callback='') {
  let model = target.dataset.model
  let id = target.dataset.id

  if (confirm('Удалить?')){
    let res = await post(`/adminsc/${model}/delete`,{id})
    if (res && callback){
      callback()
    }
  }

}

function handleKeyup({target}) {
  if (!!target.closest('.question-edit__parent-select')) {
    _question.changeParent(target)
  }
}




