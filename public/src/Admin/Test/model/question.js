import {$, post, trimStr} from "../../../common.js"

class question {

  constructor(el) {
    this.sort = document.querySelectorAll('.questions>.question-edit').length + 1 ?? 0
  }

  async questionCreate(target) {
    let question = $('.empty .question-edit').first()
    let clone = question.cloneNode(true)
    let questionModel = this.getQuestionModel(clone)
    let res = await post(`/adminsc/question/updateOrCreate`, questionModel)
    if (res) {
      clone.querySelector('.sort').innerText = $('.question-edit').length
      clone.querySelector('.question__delete').dataset.id =
        clone.dataset.id = res.arr.id
      target.before(clone)
    }
  }

  getQuestionModel(el) {
    return {
      id: +el.dataset.id,
      qustion: trimStr(el.querySelector('.text').innerText),
      test_id: +window.location.href.split('/').pop(),
      sort: +el.closest('.question-edit').querySelector('.sort').innerText,
    }
  }

  async changeParent(target) {

    let question = target.closest('.question-edit')
    let id = question.dataset.id
    let opt = target.options[target.selectedIndex]
    let test_id = opt.dataset['questionParentId']

    let res = await post('/adminsc/question/changeParent', {id, test_id})
    if (res) {
      question.remove()
    }
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
