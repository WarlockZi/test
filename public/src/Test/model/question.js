import {$, popup, post} from "../../common";

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



export let _question = {

    getEl:(save_button)=>{
        save_button.closest('.question-edit')
    },

    create:(add_button)=>{
        _question.createOnServer(add_button)
        _question.createOnView()
   },

    createOnServer:async (add_button)=>{
       let res = await post('/question/updateOrCreate')
        return JSON.parse(res)
    },

    createOnView:(save_button)=>{
        save_button.closest('.question-edit')
    },

    showFirst:()=>{
        let questions = $('.questions .question-edit')
        if (!questions.length) {
            let question = $('.questions .question__create .question-edit').el[0].cloneNode(true)
            $(question).addClass('question-edit')
            $(question).removeClass('question__create')
            let questionsWrapper = $('.questions').el[0]
            questionsWrapper.prepend(question)
        }
    },

    save: async (save_button) => {
        let question = save_button.closest('.question-edit')
        let res = await post(
            '/question/UpdateOrCreate',
            {
                question: _question2.getModelForServer(question),
                answers: _question2.getAnswers(question),
            })
        res = await JSON.parse(res)
        popup.show(res.msg)
    },

    delete: async (del_button) => {
        if (confirm("Удалить вопрос со всеми его ответами?")) {
            let q_id = +this.q.id
            let deleted = await _question2.deleteFromServer(q_id)
            if (deleted) {
                _question2.deleteFromView()
            }
        }
    },

    deleteFromView: async (del_button) => {
        del_button.closest('.question-edit').remove()
    },

    deleteFromServer: async (q_id) => {
        let res = await post('/question/delete', {q_id})
        return JSON.parse(res)
    },
    getModelForServer: (question) => {
        return {
            id: +question.id,
            parent: +$('.test-name').el[0].getAttribute('value'),
            picq: '',
            qustion: $(question).find('.question__text').innerText,
            sort: +$(question).find('.question__sort').innerText,
        }
    },
    getAnswers: (question) => {
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