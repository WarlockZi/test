import './test-pagination.scss'
import {$, post} from "../../common";
import {getAnswers, getQuestion, aAdd, aDelete, qDelete} from '../../Test/edit'

//Скрыть все кнопки
$('[data-pagination]').removeClass('nav-active')
// Показать первую кнопку
$('[data-pagination]:first-child').addClass('nav-active')

//// Пагинация
$('.pagination').on('click', function (e) {
//// add question
    if (e.target.classList.contains('add-question')) {
        show()
        return
    }
//// paginate
    if (e.target.getAttribute('data-pagination')) {
        paginate(e.target)
        return
    }
})

function paginate(self) {
/// get clicked button Return if clicked is active
    if (self.classList.contains('nav-active')) return
    let active_btn = $('.pagination .nav-active').el[0]
//// change active button
    active_btn.classList.remove('nav-active')
    self.classList.add('nav-active')
//// hide the card
    let id_to_hide = active_btn.dataset['pagination']
    $(`#question-${id_to_hide}`).removeClass('flex1')
//// show the card
    let id_to_show = self.dataset['pagination']
    $(`#question-${id_to_show}`).addClass('flex1')
}

//// добавление вопроса
async function show(e) {
    let testId = +$('.test-name').value()
    let questCount = $("[data-pagination]").count()

    let res = await post(
        '/question/show',
        {
            testid: testId,
            questQnt: questCount
        })
    res = JSON.parse(res)
    let Block = res.block
    let blocks = $('.blocks').el[0]
    blocks.insertAdjacentHTML('afterBegin', Block)
    let newBlock = $('.blocks .block:last-child').el[0]
    $(newBlock).addClass('flex1')
    $(newBlock).find('.question__save').on('click', questionSave(e))
    // $('.overlay').on('click', clickOverlay)
}

function showHidePaginBtn(e, pagItem) {
    if ($('.pagination .nav-active').el[0]) {
        $('.pagination .nav-active').el[0].classList.remove('nav-active')
    }
    $('.add-question').el[0]
        .insertAdjacentHTML('beforeBegin', pagItem)
}

function appendBlock() {
    let block = $('.overlay').find('.block')
    $('.blocks').append(block)
    $(block).addClass('flex1')
    $('.a-add').on('click', aAdd)
    $('.q-delete').on('click', qDelete)
    $('.a-del').on('click', aDelete)
}

// function clickOverlay(e) {
//     if (e.target.classList.contains('question__save')) {
//         questionSave(e);
//         return
//     }
//     if (e.target.classList.contains('question__cansel')) {
//         closeOverlay();
//         return
//     }
//     if (e.target.classList.contains('overlay')) {
//         closeOverlay();
//         return
//     }
// }

function hideVisibleBlock() {
    $('.block.flex1').removeClass('flex1')
}

// function closeOverlay() {
//     document.body.removeChild($('.overlay').el[0])
// }

async function questionSave(e) {

    let block = $('.overlay').find('.block')
    let res = await post(
        '/question/UpdateOrCreate',
        {
            question: getQuestion(e, block),
            answers: getAnswers(e, block, $(block).find('textarea').value),
        })
    res = JSON.parse(res)

    if (res) {
        showHidePaginBtn(e, res.paginationButton)
        hideVisibleBlock()
        appendBlock(e)
        closeOverlay()
    }
}
