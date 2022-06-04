import './test-edit.scss'
import '../components/footer/footer.scss'

import './test-edit-menu.scss'
import '../components/popup.scss'

import './test-update'
// import './path-create'
import '../Admin/admin'

import {$} from '../common'

import {_question} from "./model/question"
import sortable from "../components/sortable"
import WDSSelect from "../components/select/WDSSelect"
import accordionShow from "../components/accordion-show";

import testEditActions from "./testEditActions";

export default function testEdit() {
  let testEdit = $('.test-edit-wrapper')
  if (testEdit) {

    sortable('.test-edit-wrapper.questions')


    // debugger
    let customSelects = $('[custom-select]');
    [].forEach.call(customSelects, function (select) {
      new WDSSelect(select)
    });

// при создании нового теста показать пустой вопрос
    if (!_question.questions().length
      && /\/adminsc\/test\/edit/.test(window.location.pathname)) {
      _question.showFirst()
    }

    // debugger
    let testEditWrapper = $('.test-edit-wrapper')[0]
    if (testEditWrapper) {
      testEditWrapper.addEventListener('click',
        ({target}) => {
          testEditActions(target, 'click')
        }
      )
      testEditWrapper.addEventListener('change',
        ({target}) => {
          testEditActions(target, 'change')
        }
      )
    }

  }
}




