import {$, popup, post} from "../../common"
// import {_question} from "./question"

export let _question = {

    showFirst:
        () => {
            let question = _question.cloneEmptyModel()
            if (!question) return

            let model = _question.viewModel(question)
            model.sort.innerText = '1'

            $(question).addClass('question-edit')
            $(question).removeClass('question__create')
            let questionsWrapper = $('.questions').el[0]
            questionsWrapper.prepend(question)

            $(model.save).on('click', _question.createOnServer)
            $(model.del).on('click', _question.delete)

        },

    cloneEmptyModel: () => {
        let question = $('.questions .question__create .question-edit').el[0]
        return question.cloneNode(true)
    },

    viewModel: (el) => {
        return {
            id: +el.id,
            el: el,
            sort: el.querySelector('.question__sort'),
            save: el.querySelector('.question__save'),
            text: el.querySelector('.question__text'),
            del: el.querySelector('.question__delete'),
        }
    },

    serverModel: () => {
        return {
            question: {
                id: null,
                qustion: '',
                parent: +window.location.href.split('/').pop(),
                sort: _question.questionsCount()+1,
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
        async (add_button) => {
            let el = add_button.closest('.question-edit')
            let q_id = await _question.createOnServer()
            if (q_id) {
                _question.createOnView(add_button, q_id)
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
        (add_button, q_id) => {
            let questions = _question.questions()
            let lastQuestion = _question.lastQuestion()
            let clone = lastQuestion.cloneNode(true)
            let model = _question.viewModel(clone)

            $(model.save).on('click', _question.createOnServer)
            $(model.del).on('click', _question.delete)

            model.sort.innerText = questions.length + 1
            model.text.innerText = ''
            model.el.id = q_id
            add_button.before(clone)
        },



    save:
        async (save_button) => {
            let question = save_button.closest('.question-edit')
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

