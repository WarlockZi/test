import {_test} from "./model/test";
import {_question} from "./model/question";
import {_answer} from "./model/answer";

export default function testEditActions(target, type) {

  if (type === 'click') {
    switch (true) {
      case target.classList.contains('test-path__update'): {
        _test.update()
        break;
      }
      case target.classList.contains('test__update'): {
        _test.update()
        break;
      }
      case target.classList.contains('test__save'): {
        _test.update()
        break;
      }
      case target.classList.contains('test__delete'): {
        _test.delete()
        break;
      }
      case target.classList.contains('test-path__create'): {
        _test.path_create()
        break;
      }
      case target.classList.contains('test__create'): {
        _test.create()
        break;
      }

      case !!target.closest('.question__save'): {
        _question.save(target)
        break;
      }
      case !!target.closest('.question__show-answers'): {
        _question.showAnswers(target)
        break;
      }
      case !!target.closest('.question__delete'): {
        _question.delete(target)
        break;
      }
      case target.classList.contains('question__create-button'): {
        _question.create()
        break;
      }
      case target.classList.contains('answer__delete'): {
        _answer.del()
        break;
      }
      case target.classList.contains('answer__create-button'): {
        _answer.create(target)
        break;
      }
    }
  }

  if (type === 'change') {
      // debugger
    switch (true) {
      case !!target.closest('.question-edit__parent-select'): {
        _question.changeParent(target)
        break;
      }
    }
  }
}
