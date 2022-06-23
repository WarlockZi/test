import {$, popup, post, trimStr} from "../../common"
import {_answer} from "./answer";

class question {

  constructor(el) {
    this.sort = document.querySelectorAll('.questions>.question-edit').length + 1 ?? 0
  }

  async questionCreate(target) {
    let question = $('.question__create .question-edit')[0]
    let clone = question.cloneNode(true)
    let questionModel = this.getQuestionModel(clone)
    let res = await post(`/adminsc/question/updateOrCreate`, questionModel)
    if (res) {
      clone.querySelector('.sort').innerText = this.sort
      clone.querySelector('.question__delete').dataset.id =
        clone.dataset.id = res.arr.id
      target.before(clone)
    }
  }

  getQuestionModel(el) {
    return {
      id: el.id,
      qustion: trimStr(el.querySelector('.text').innerText),
      parent: +window.location.href.split('/').pop(),
      sort: el.querySelector('.sort').innerText,
    }
  }

  async changeParent(target) {
    debugger
    let opt = target.options[target.selectedIndex]
    let id = target.closest('.question-edit').id
    let test_id = opt.dataset['questionParentId']
    let test_name = opt.value
    let res = await post('/adminsc/question/changeParent', {id, test_id})
    let question = target.closest('.question-edit')
    question.remove()
  }

  // cloneEmptyModel() {
  //   let question = $('.questions .question__create .question-edit')[0]
  //   if (question) return question.cloneNode(true)
  // }

  showAnswers(target) {
    let row = target.closest('.question-edit')
    let answers = $(row).find('.question__answers')
    answers.classList.toggle('height')
    answers.classList.toggle('scale')
    target.classList.toggle('rotate')
  }

  async del(target) {
    let model = target.dataset.model
    let el = null
    if (model === 'answer') {
      el = target.closest('.answer')
    } else if (model === 'question') {
      el = target.closest('.question-edit')
    }
    let id = +target.dataset.id
    if (confirm('Удалить?')) {
      let res = await post(`/adminsc/${model}/delete`, {id})
      if (res) {
        el.remove()
      }
    }
  }

  async saveQuestion(target) {
    let el = target.closest('.question-edit')
    let question = _question.getQuestionModel(el)
    let res = await post('/adminsc/question/UpdateOrCreate', question)
  }

  // getAnswers(question) {
  //   let answers = question.querySelectorAll('.answer')
  //   return [...answers].map((a) => {
  //     return {
  //       id: +a.dataset['answerId'],
  //       answer: a.querySelector('.text').innerText,
  //       correct_answer: +a.querySelector('[type="checkbox"]').checked,
  //       question_id: +question.id,
  //       pica: '',
  //     }
  //   }, question)
  // }
}

export let _question = new question
