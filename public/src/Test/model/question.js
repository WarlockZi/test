import {$, popup, post, addTooltip} from "../../common"
import {_answer} from "./answer";

export let _question = {

  sort: async function (upToQestionNumber) {
    let questions = [..._question.questions()]
    let questionsEls = questions.filter(function (el, i) {
        if (i + 1 < upToQestionNumber) return el
      }
    )
    let toChange = questionsEls.map((el) => {
      return el.id
    })
    let res = await post('/question/sort', {toChange})
    res = JSON.parse(res)
    if (res.msg) {
      popup.show(res.msg)
    }
    questionsEls.map((el, i) => {
      $(el).find('.question__sort').innerText = i + 1

    })
  },


  changeParent: async function ({target}) {
    debugger
     let opt = target.options[target.selectedIndex]
    let id = target.closest('.question-edit').id
    let test_id = opt.dataset['questionParentId']
    let test_name = opt.value
    let res = await post('/adminsc/question/changeParent',{id, test_id})
    res = JSON.parse(res)
    if (res.msg !=='ok') throw (e);
    let question = target.closest('.question-edit')
    question.remove()
    popup.show('Перемещен в '+test_name)
    // debugger
  },


  showTip: (action, event) => {
    let el = event.target
    let tip = document.createElement("div")

    if (action === 'save.svg') {
      addTooltip(el, 'сохранить')
    }
  },

  showFirst: () => {
    let question = _question.cloneEmptyModel()
    if (!question) return

    let model = _question.viewModel(question)
    model.sort.innerText = '1'
    $(model.save).on('click', _question.save)
    $(model.del).on('click', _question.delete)

    $(question).addClass('question-edit')
    $(question).removeClass('question__create')

    let questions = $('.questions')[0]
    questions.prepend(question)
  },

  cloneEmptyModel: () => {
    let question = $('.questions .question__create .question-edit')[0]
    if (question) return question.cloneNode(true)
  },

  showAnswers: (target) => {
    let parent = target.parentNode.parentNode
    let answers = $(parent).find('.question__answers')
    answers.classList.toggle('height')
    answers.classList.toggle('scale')
    target.classList.toggle('rotate')
  },

  viewModel: (el) => {
    return {
      id: +el.id,
      el: el,
      sort: el.querySelector('.question__sort'),
      save: el.querySelector('.question__save'),
      text: el.querySelector('.question__text'),
      del: el.querySelector('.question__delete'),
      createAnswerButton: el.querySelector('.answer__create-button'),
      addButton: $($('.questions')[0]).find('.question__create-button'),
    }
  },

  serverModel: () => {
    return {
      question: {
        id: null,
        qustion: '',
        parent: +window.location.href.split('/').pop(),
        sort: _question.lastSort(),
      }
    }
  },

  questions: () => {
    let qs = $('.questions>.question-edit')
    // debugger
    return $('.questions>.question-edit')
    // return $('.questions>.question-edit').el
  },

  questionsCount: () => {
    return $('.questions>.question-edit').el.length
  },

  lastSort: () => {
    let qs = _question.questions()
    let length = qs.length-1
    let last =  +_question.viewModel(qs[length]).sort.innerText
    return last+1
  },

  create:
    async (e) => {
      let q_id = await _question.createOnServer(e)
      if (q_id) {
        _question.createOnView(q_id)
      }
    },

  createOnServer:
    async () => {
      let question = _question.serverModel()
      let res = await post('/question/updateOrCreate', {question: question.question, answers: {}})
      res = await JSON.parse(res)

      return res.id
    },

  createOnView:
    (q_id) => {
      let clone = _question.cloneEmptyModel()

      let model = _question.viewModel(clone)
      $(model.save).on('click', _question.save)
      $(model.del).on('click', _question.delete)
      $(model.text).on('click', _question.showAnswers)
      $(model.createAnswerButton).on('click', _answer.create)

      model.sort.innerText = _question.lastSort()
      model.text.innerText = ''
      model.el.id = q_id

      model.addButton.before(clone)
    },


  save:
    async (target) => {
      let question = target.closest('.question-edit')
      let res = await post(
        '/question/UpdateOrCreate',
        {
          question: _question.getModelForServer(question),
          answers: _question.getAnswers(question),
        })
      res = await JSON.parse(res)
      popup.show(res.msg)
    },

  delete:
    async (target) => {
      if (confirm("Удалить вопрос со всеми его ответами?")) {
        let viewModel = _question.viewModel(target.closest('.question-edit'))
        let id = viewModel.id

        let deleted = await _question.deleteFromServer(id)
        if (deleted) {
          _question.deleteFromView(viewModel)
          popup.show(deleted.msg)
        }
      }
    },

  deleteFromView:
    async (viewModel) => {
      viewModel.el.remove()
    },

  deleteFromServer:
    async (q_id) => {
      let res = await post('/question/delete', {q_id})
      return JSON.parse(res)
    },

  getModelForServer:
    (question) => {
      return {
        id: +question.id,
        parent: +$('.test-name')[0].getAttribute('value'),
        picq: '',
        qustion: $(question).find('.question__text').innerText,
        sort: +$(question).find('.question__sort').innerText,
      }
    },
  getAnswers:
    (question) => {
      let answerBlocks = question.querySelectorAll('.answer')
      return [...answerBlocks].map((a) => {
        return {
          id: +a.dataset['answerId'],
          answer: a.querySelector('.answer__text').innerText,
          correct_answer: +a.querySelector('[type="checkbox"]').checked,
          parent_question: +question.id,
          pica: '',
        }
      }, question)
    },
}

