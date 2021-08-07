import {$, popup, post} from "../../common";
import {showHidePaginBtn, appendBlock} from "../../components/test-pagination/test-pagination";

function _question(id) {
    let q = id ?
        $(`.e-block-q#{id}`).el[0] :
        $('.block.flex1 .e-block-q').el[0]

    return new question(q)
}

function question(q) {
    this.q = q
    this.add = function () {
    }

    this.delete = async function () {
        if (confirm("Удалить вопрос со всеми его ответами?")) {
            let q_id = +this.q.id
            let res = await post('/question/delete', {q_id})
            return JSON.parse(res)
        }
    }

    this.save = async function () {
        let res = await post(
            '/question/UpdateOrCreate',
            {
                question: this.get(),
                answers: this.getAnswers(),
            })
        return await JSON.parse(res)
    }

    this.getAnswers = function () {

        let answerBlocks = $('.block.flex1 .e-block-a').el
        return [...answerBlocks].map((a) => {
            return {
                id: +a.querySelector('.checkbox').dataset['answer'],
                answer: a.querySelector('textarea').value,
                correct_answer: +a.querySelector('.checkbox').checked,
                parent_question: +this.q.id,
                pica: '',
            }
        }, this.q)

    }
    this.get = function () {
        return {
            id: +this.q.id,
            parent: +$('.test-name').el[0].getAttribute('value'),
            picq: '',
            qustion: $(this.q).find('textarea').value,
            sort: +$(this.q).find('.question__sort').value,
        }
    }
}

export {_question}