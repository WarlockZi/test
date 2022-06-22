import {$, popup, post, addTooltip} from "../../common"
import {_answer} from "./answer";

class question {
  constructor() {
    this.sort = document.querySelectorAll('.questions>.question-edit').length + 1 ?? 0
  }

  async questionCreate(target) {
    let question = $('.question__create .question-edit')[0]
    let clone = question.cloneNode(true)
    let questionModel = this.getQuestionModel(clone)
    let res = await post(`/adminsc/question/updateOrCreate`, questionModel)
    if (res) {
      if (res.arr.popup) popup.show(res.arr.popup)
      clone.querySelector('.sort').innerText = this.sort
      clone.querySelector('.question__delete').dataset.id =
        clone.dataset.id = res.arr.id
      target.before(clone)
    }
  }

  getQuestionModel(el) {
    return {
      question: {
        id: el.dataset.id,
        qustion: el.querySelector('text'),
        parent: +window.location.href.split('/').pop(),
        sort: this.sort,
      }
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

  cloneEmptyModel() {
    let question = $('.questions .question__create .question-edit')[0]
    if (question) return question.cloneNode(true)
  }

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
    let question = target.closest('.question-edit')
    let res = await post(
      '/adminsc/question/UpdateOrCreate',
      {
        question: this.getModelForServer(question),
        answers: this.getAnswers(question),
      })
  }

  getAnswers(question) {
    let answerBlocks = question.querySelectorAll('.answer')
    return [...answerBlocks].map((a) => {
      return {
        id: +a.dataset['answerId'],
        answer: a.querySelector('.text').innerText,
        correct_answer: +a.querySelector('[type="checkbox"]').checked,
        question_id: +question.id,
        pica: '',
      }
    }, question)
  }
}

export let _question = new question()
