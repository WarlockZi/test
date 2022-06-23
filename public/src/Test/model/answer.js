import {$, post, trimStr, popup} from '../../common'

class answer {
  constructor() {
  }

  async saveAnswer(target) {
    let q_id = target.closest('.question-edit').dataset.id
    let el = target.closest('.answer')
    let answer = this.getAnswerModel(el, q_id)
    let res = await post('/adminsc/answer/updateOrCreate', answer)
  }

  async del(target) {
    let el = target.closest('.answer')

    let id = +target.dataset.id
    if (confirm('Удалить?')) {
      let res = await post(`/adminsc/answer/delete`, {id})
      if (res) {
        el.remove()
      }
    }
  }

  async answerCreate(target) {
    let answer = $('.answer__create .answer')[0]
    let question = target.closest('.question-edit')
    let q_id = +question.id
    let clone = answer.cloneNode(true)
    let answerModel = this.getAnswerModel(clone, q_id)
    let res = await post(`/adminsc/answer/updateOrCreate`, answerModel)
    if (res) {
      if (res.arr.popup) popup.show(res.arr.popup)
      if (res.arr.id ) {
        let sort = question.querySelectorAll('.answer').length + 1
        clone.querySelector('.sort').innerText = sort
        clone.querySelector('.delete').dataset.id =
          clone.dataset.id = res.arr.id
        target.before(clone)
      }

    }
  }

  getAnswerModel(el, q_id) {
    return {
      id: +el.dataset.id,
      answer: trimStr($(el).find('.text').innerText),
      question_id: q_id,
      correct_answer: +$(el).find('input').checked,
      pica: '',
    }
  }
}

export let _answer = new answer()
