import {$, popup, post} from "../../common"
import {_answer} from "./answer";
// import {_question} from "./question"

export let _question = {

    showFirst: () => {
        let question = _question.cloneEmptyModel()
        if (!question) return

        let model = _question.viewModel(question)
        model.sort.innerText = '1'

        $(question).addClass('question-edit')
        $(question).removeClass('question__create')
        let questionsWrapper = $('.questions').el[0]
        questionsWrapper.prepend(question)

        $(model.save).on('click', _question.save)
        $(model.del).on('click', _question.delete)

    },

    cloneEmptyModel: () => {
        let question = $('.questions .question__create .question-edit').el[0]
        return question.cloneNode(true)
    },

    showAnswers: (e) => {
        let text = e.target
        let parent = text.parentNode.parentNode
        let answers = $(parent).find('.question__answers')
        answers.classList.toggle('height')
        answers.classList.toggle('scale')

        text.classList.toggle('rotate')
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
            addButton: $($('.questions').el[0]).find('.question__create-button'),
        }
    },

    serverModel: () => {
        return {
            question: {
                id: null,
                qustion: '',
                parent: +window.location.href.split('/').pop(),
                sort: _question.questionsCount(),
            }
        }
    },

    questions: () => {
        return $('.questions>.question-edit').el
    },
    questionsCount: () => {
        return $('.questions>.question-edit').el.length
    },
    lastQuestion: () => {
        let questions = _question.questions()
        return questions[questions.length - 1]
    },

    create:
        async (e) => {
            // let add_button = e.target.closest('.')
            // let el = add_button.closest('.question-edit')

            let q_id = await _question.createOnServer(e)
            if (q_id) {
                _question.createOnView(q_id)
            }
        },

    createOnServer:
        async (e) => {
            let self = this

            let add_button = e.target
            // let question_div = add_button.parentNode.parentNode
            let question = _question.serverModel()
            // let t = $(question_div).find('.question__text')
            // question.question.qustion = t.innerText
            // let answers = _question.getAnswers(question_div.parentNode)

            // question.question.sort = question.question.sort
            let res = await post('/question/updateOrCreate', {question: question.question, answers: {}})
            res = await JSON.parse(res)
            return res.id
        },

    createOnView:
        (q_id) => {
            let questions = _question.questions()
            let clone = _question.cloneEmptyModel()
            let model = _question.viewModel(clone)

            $(model.save).on('click', _question.save)
            $(model.del).on('click', _question.delete)

            model.sort.innerText = questions.length + 1
            model.text.innerText = ''

            $(model.createAnswerButton).on('click', _answer.create)
            $(model.text).on('click', _question.showAnswers)

            model.el.id = q_id
            let addButt = model.addButton
            addButt.before(clone)
        },


    save:
        async (e) => {
            let question = e.target.closest('.question-edit')
            let viewModel = _question.viewModel(question)
            if (viewModel.id) {
                let res = await post(
                    '/question/UpdateOrCreate',
                    {
                        question: _question.getModelForServer(question),
                        answers: _question.getAnswers(question),
                    })
                res = await JSON.parse(res)
                popup.show(res.msg)
                return
            } else {
                _question.create(e)
            }
        },

    delete:
        async (e) => {
            if (confirm("Удалить вопрос со всеми его ответами?")) {
                let viewModel = _question.viewModel(e.target.closest('.question-edit'))
                let id = viewModel.id

                let deleted = await _question.deleteFromServer(id)
                if (deleted) {
                    _question.deleteFromView(viewModel)
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
                parent: +$('.test-name').el[0].getAttribute('value'),
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

