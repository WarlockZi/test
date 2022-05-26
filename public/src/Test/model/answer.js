import {$, popup, post} from '../../common'

export let _answer = {

  el: (add_button) => {
    let answers = add_button.parentNode.querySelectorAll('.answer')
    let prev_sort = 0
    if (answers.length) {
      prev_sort = +$(answers[answers.length - 1]).find('.sort').innerText
    }
    let el = $('.answer__create').find('.answer').cloneNode(true)
    el.classList.add('answer')
    el.classList.remove('answer__create')
    return {
      el: el,
      id: 'new',
      q_id: +add_button.closest('.question-edit').id,
      previous_sort: prev_sort,
      answerCnt: answers.length,
      sort: $(el).find('.sort'),
      checked: $(el).find('input'),
      text: $(el).find('.text'),
      delete: $($(el).find('.delete')).on('click', function () {
        _answer.del(this)
      })
    }
  },
  getModelForServer(el) {
    return {
      answer: '',
      parent_question: el.q_id,
      correct_answer: 0,
      pica: ''
    }
  },

  async create(button) {
    // debugger
    let a_id = await createOnServer(button)
    show(a_id)

    async function createOnServer(button) {
      let newEl = _answer.getModelForServer(_answer.el(button))

      let res = await post('/answer/create', newEl)
      res = JSON.parse(res)

      return res.id
    }

    function show(a_id) {
      let el = _answer.el(button)

      el.checked.checked = false
      el.el.dataset['answerId'] = a_id
      el.text.innerText = ''
      el.sort.innerText = el.answerCnt + 1

      el.el.style.display = 'flex'
      button.before(el.el)
      el.el.style.opacity = 1
    }
  },

  async del(target) {
    let del_button = target.closest('.delete')
    if (!del_button) return false
    if (confirm("Удалить этот ответ?")) {
      let res = await deleteFromServer(del_button)
    }

    async function deleteFromServer(del_button) {

      let a_id = +del_button.closest('.answer').dataset['answerId']
      let res = await post('/answer/delete', {a_id})
      res = JSON.parse(res)
      if (res.msg === 'ok') {
        del_button.closest('.answer').remove()
        popup.show('Ответ удален')
      }
    }
  },
}
