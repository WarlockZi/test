import {$, popup, post} from "../common";
import {getAnswers, getQuestion} from "./edit";
import {showHidePaginBtn, appendBlock} from "../components/test-pagination/test-pagination";

function _question() {
    let q = $('.block.flex1 .e-block-q').el[0]
    return new question(q)
}

function question(q) {
    this.q = q
    this.add = function () {

    }
    this.save = async function () {
        let res = await post(
            '/question/UpdateOrCreate',
            {
                // question: getQuestion(e, q),
                question: this.get(),
                answers: this.getAnswers(),
            })
        res = JSON.parse(res)

        if (res) {
            showHidePaginBtn(res.paginationButton)
            appendBlock()
            popup.show(res.msg)
        }
    }
    this.getAnswers = function () {

        let answerBlocks = $('.block.flex1 .e-block-a').el
        // let answers = []
        return Array.from(answerBlocks).map((a) => {
            return {
                id: +a.querySelector('.checkbox').dataset['answer'],
                answer: a.querySelector('textarea').value,
                correct_answer: +a.querySelector('.checkbox').checked,
                parent_question: +this.q.id,
                pica: '',
            }
        }, this.q)

        // answerBlocks.forEach((a) => {
        //     answers.push({
        //         id: +a.querySelector('.checkbox').dataset['answer'],
        //         answer: a.querySelector('textarea').value,
        //         correct_answer: +a.querySelector('.checkbox').checked,
        //         parent_question: +this.q.id,
        //         pica: '',
        //     })
        // }, this.q)
        // return answers
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


async function questionSave(e) {
}

export {questionSave, _question}