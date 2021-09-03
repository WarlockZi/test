import {$, popup, post} from "../../common"
// import {_question} from "./question"

export let _question = {

    getEl: (el) => {
        return {
            el: el,
            sort: el.querySelector('.question__sort'),
            save: el.querySelector('.question__save'),
            text: el.querySelector('.question__text'),
            del: el.querySelector('.question__delete'),
        }
    },

    elForServer: (el) => {
        return {
            question: {
                id: null,
                qustion: '',
                parent: $('.test-name').value(),
                sort: _question.questionsCount,
            }
        }
    },

    qestions: () => {
        return $('.questions>.question-edit').el
    },
    questionsCount: () => {
        return $('.questions>.question-edit').el.length
    },
    lastQuestion:
        () => {
            let questions = _question.qestions
            return questions[questions.length - 1]
        },

    create:
        async (add_button) => {
            let el = add_button.closest('.question-edit')
            let model = _question.elForServer(el)
            let q_id = await _question.createOnServer(model)
            if (q_id) {
                _question.createOnView(add_button, q_id)
            }
        },

    createOnServer:
        async (question) => {
            question.question.parent = +$('.test-name').value()
            question.question.sort = +_question.questionsCount

            let res = await post('/question/updateOrCreate', {question: question.question, answers: {}})
            res = await JSON.parse(res)
            return res.id
        },

    createOnView:
        (add_button, q_id) => {
            let questions = _question.qestions
            let lastQuestion = _question.lastQuestion()
            let clone = lastQuestion.cloneNode(true)
            let model = _question.getEl(clone)
            model.sort.innerText = questions.length
            model.text.innerText = ''
            model.text.innerText = ''
            model.el.id = q_id
            add_button.before(clone)
        },

    showFirst:
        () => {
            let question = $('.questions .question__create .question-edit').el[0]
            if (!question) return
            question = question.cloneNode(true)
            let model = _question.getEl(question)
            model.sort.innerText = '1'

            $(question).addClass('question-edit')
            $(question).removeClass('question__create')
            let questionsWrapper = $('.questions').el[0]
            questionsWrapper.prepend(question)
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
        async (del_button) => {
            if (confirm("Удалить вопрос со всеми его ответами?")) {
                let q_id = +this.q.id
                let deleted = await _question2.deleteFromServer(q_id)
                if (deleted) {
                    _question.deleteFromView()
                }
            }
        },

    deleteFromView:
        async (del_button) => {
            del_button.closest('.question-edit').remove()
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


// let _question1 = {
//     get:()=>{
//         return {
//             id: +this.q.id,
//             parent: +$('.test-name').el[0].getAttribute('value'),
//             picq: '',
//             qustion: $(this.q).find('.question__text').innerText,
//             sort: +$(this.q).find('.question__sort').innerText,
//         }
//     },
//     delete:async()=>{
//         if (confirm("Удалить вопрос со всеми его ответами?")) {
//             let q_id = +this.q.id
//             let res = await post('/question/delete', {q_id})
//             return JSON.parse(res)
//         }
//     },
//     save:async()=>{
//         let res = await post(
//             '/question/UpdateOrCreate',
//             {
//                 question: this.get(),
//                 answers: this.getAnswers(),
//             })
//         return await JSON.parse(res)
//     },
//     getAnswers:()=>{
//         let answerBlocks = this.q.querySelectorAll('.answer')
//         return [...answerBlocks].map((a) => {
//             return {
//                 id: +a.dataset['answerId'],
//                 answer: a.querySelector('.answer__text').innerText,
//                 correct_answer: +a.querySelector('[type="checkbox"]').checked,
//                 parent_question: +this.q.id,
//                 pica: '',
//             }
//         }, this.q)
//     },
// }

//
// function _question(id) {
//     let q = id ?
//         $(`.e-block-q#{id}`).el[0] :
//         $('.block.flex1 .e-block-q').el[0]
//
//     return new question(q)
// }
//
// function question(q) {
//     this.q = q
//     this.add = function () {
//     }
//     this.showFirst =() => {
//         $('.block:first-child').addClass('flex1')
//     }
//
//     this.delete = async function () {
//         if (confirm("Удалить вопрос со всеми его ответами?")) {
//             let q_id = +this.q.id
//             let res = await post('/question/delete', {q_id})
//             return JSON.parse(res)
//         }
//     }
//
//     this.save = async function () {
//         let res = await post(
//             '/question/UpdateOrCreate',
//             {
//                 question: this.get(),
//                 answers: this.getAnswers(),
//             })
//         return await JSON.parse(res)
//     }
//
//     this.getAnswers = function () {
//
//         let answerBlocks = $('.block.flex1 .e-block-a').el
//         return [...answerBlocks].map((a) => {
//             return {
//                 id: +a.querySelector('.checkbox').dataset['answer'],
//                 answer: a.querySelector('textarea').value,
//                 correct_answer: +a.querySelector('.checkbox').checked,
//                 parent_question: +this.q.id,
//                 pica: '',
//             }
//         }, this.q)
//
//     }
//     this.get = function () {
//         return {
//             id: +this.q.id,
//             parent: +$('.test-name').el[0].getAttribute('value'),
//             picq: '',
//             qustion: $(this.q).find('textarea').value,
//             sort: +$(this.q).find('.question__sort').value,
//         }
//     }
// }