import './test-pagination.scss'
import {$, popup, post} from "../../common";
import {_question} from "../../Test/model/question";
import {_answer} from "../../Test/model/answer";

// Показать первую кнопку
$('[data-pagination]:first-child').addClass('nav-active')
$('.test-edit__content').addClass('flex1')

//// add question
$('.pagination').on('click', function (e) {
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
    let testid = +$('.test-name').value()
    let questCount = $("[data-pagination]").count()

    let res = await post(
        '/question/show',
        {testid, questCount})
    res = JSON.parse(res)
    let Block = res.block
    let blocks = $('.blocks').el[0]
    blocks.insertAdjacentHTML('afterBegin', Block)
    let newBlock = $('.blocks .block:first-child').el[0]
    document.querySelector('.flex1').classList.remove('flex1')
    $(newBlock).addClass('flex1')
    let save_button = $(newBlock).find('.question__save')
        $(save_button).on('click', _question().save)
}

function showHidePaginBtn(pagItem) {
    let activePaginBtn = $('.pagination .nav-active').el[0]
    if (activePaginBtn) {
        activePaginBtn.classList.remove('nav-active')
    }
    $('.add-question').el[0].insertAdjacentHTML('beforeBegin', pagItem)
}

function appendBlock() {
    let block = $('.overlay').find('.block')
    $('.blocks').append(block)
    $(block).addClass('flex1')
    $('.a-add').on('click', _answer.create)
    $('.q-delete').on('click', _question().delete())
    $('.a-del').on('click', _answer.delete())
}

function navInit() {
    let nav_buttons = $('[data-pagination]').el
    if (!nav_buttons[0]) return false
    Array.from(nav_buttons).map((el)=>{
        el.classList.remove('nav-active')
    })
    nav_buttons[0].classList.add('nav-active')

}
// function hideVisibleBlock() {
//     $('.block.flex1').removeClass('flex1')
// }

export {showHidePaginBtn, appendBlock, navInit}


