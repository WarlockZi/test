import {$, popup, post, trimStr} from '../../common'

class answer {
  constructor() {
  }

  async saveAnswer(answerEl) {
    let id = answerEl.dataset.answerId
    let is_correct = +answerEl.querySelector('input').checked
    let openquestion_id = answerEl.closest('.question-edit').id
    let answer = answerEl.querySelector('.text').innerText
    let res = await post('/adminsc/answer/updateOrCreate',
      {id, answer, openquestion_id, is_correct})
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
    let res = await post(`/answer/updateOrCreate`, answerModel)
    if (res) {
      if (res.arr.popup) popup.show(res.arr.popup)
      let sort = question.querySelectorAll('.answer').length + 1
      clone.querySelector('.sort').innerText = sort
      clone.querySelector('.delete').dataset.id =
        clone.dataset.id = res.arr.id
      target.before(clone)
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
//
//   el: (add_button) => {
//     let answers = add_button.parentNode.querySelectorAll('.answer')
//     let prev_sort = 0
//     if (answers.length) {
//       prev_sort = +$(answers[answers.length - 1]).find('.sort').innerText
//     }
//     let el = $('.answer__create').find('.answer').cloneNode(true)
//     el.classList.add('answer')
//     el.classList.remove('answer__create')
//     return {
//       el: el,
//       id: 'new',
//       q_id: +add_button.closest('.question-edit').id,
//       previous_sort: prev_sort,
//       answerCnt: answers.length,
//       sort: $(el).find('.sort'),
//       checked: $(el).find('input'),
//       text: $(el).find('.text'),
//       delete: $($(el).find('.delete')).on('click', function () {
//         _answer.del(this)
//       })
//     }
//   },
//   getModelForServer(el) {
//     return {
//       answer: '',
//       question_id: el.q_id,
//       correct_answer: 0,
//       pica: ''
//     }
//   },
//
//   async create(button) {
//     let a_id = await createOnServer(button)
//     show(a_id)
//
//     async function createOnServer(button) {
//       let newEl = _answer.getModelForServer(_answer.el(button))
//
//       let res = await post('/answer/create', newEl)
//       return res.id
//     }
//
//     function show(a_id) {
//       let el = _answer.el(button)
//
//       el.checked.checked = false
//       el.el.dataset['answerId'] = a_id
//       el.text.innerText = ''
//       el.sort.innerText = el.answerCnt + 1
//
//       el.el.style.display = 'flex'
//       button.before(el.el)
//       el.el.style.opacity = 1
//     }
//   },
//
//   async del(target) {
//     let del_button = target.closest('.delete')
//     if (!del_button) return false
//     if (confirm("Удалить этот ответ?")) {
//       let res = await deleteFromServer(del_button)
//     }
//
//     async function deleteFromServer(del_button) {
//
//       let a_id = +del_button.closest('.answer').dataset['answerId']
//       let res = await post('/answer/delete', {a_id})
//       res = JSON.parse(res)
//       if (res.msg === 'ok') {
//         del_button.closest('.answer').remove()
//         popup.show('Ответ удален')
//       }
//     }
//   },
// }
