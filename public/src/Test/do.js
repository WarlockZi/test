import {post, $, fetchW} from '../common'
import './do.scss'
import '../components/header/autocomplete'
import '../components/cookie/cookie'

//Скрыть все вопросы
$('.question').removeClass("flex1")
//Показть первый вопрос
$('.question:first-child').addClass("flex1")


$('[type="checkbox"]').on('click', function (e) {
    let a = e.target.labels[0]
    a.classList.toggle('pushed')
})


$('#prev').on('click', prevQ)
$('#next').on('click', nextQ)

function nextQ() {
    let current = currentQ()
    if (current.id > current.navLength-2) return false

    let aimNavId = aimNavIdFunction(current.id, 'next')
    let aimQEl = aimQElFunction(current, 'next')

    pushNav(current.id, aimNavId)
    pushQ(current.QEl, aimQEl)
}

function prevQ() {
    let current = currentQ()
    if (current.id < 1) return false

    let aimNavId = aimNavIdFunction(current.id, 'back')
    let aimQEl = aimQElFunction(current, 'back')

    pushNav(current.id, aimNavId)
    pushQ(current.QEl, aimQEl)
}

function pushNav(currentId, aimNavId) {
    let currNavEl = $('[data-pagination]')
        .el[currentId]
    currNavEl.classList.toggle('nav-active')

    let NavEl = $('[data-pagination]')
        .el[aimNavId]
    NavEl.classList.toggle('nav-active')
}

function pushQ(currentEl, aimQEl) {
    currentEl.classList.toggle('flex1')
    aimQEl.classList.toggle('flex1')
}

function aimNavIdFunction(currentId, direction) {
    let dir = currentId
    switch (true) {
        case direction === 'next':
            return dir += 1
            break
        case direction === 'back':
            return dir -= 1
            break
    }
}

function aimQElFunction(current, direction) {
    switch (true) {
        case direction === 'next':
            return current.QNextEl
            break
        case direction === 'back':
            return current.QPrevc
            break
    }
}

function currentQ() {
    return {
        id: $('.nav-active').el[0].innerText - 1,
        QEl: $('.question.flex1').el[0],
        navLength: $('[data-pagination]').el.length,
        QPrevc: $('.question.flex1').el[0].previousElementSibling,
        QNextEl: $('.question.flex1').el[0].nextElementSibling,
    }
}

/////////////////////////////////////////////////////////////////////////////
///////////  RESULTS  TEST  Закончить тест/////////////////////////////
/////////////////////////////////////////////////////////////////////////////


$('.test-do__finish-btn').on('click', async function (e) {
    let button = e.target;
    if (button.id !== 'btnn') return false

    if (button.text == "ПРОЙТИ ТЕСТ ЗАНОВО") {
        location.reload();
        return;
    }
    let corrAnswers = await post('/test/getCorrectAnswers', {})
    corrAnswers = JSON.parse(corrAnswers)
    let errorCnt = colorView(corrAnswers)
    let data = objToServer(errorCnt)
    let res = await post('/test/cachePageSendEmail', data)
    if (res) {
        $("#btnn").el[0].href = location.href
        $("#btnn").el[0].text = "ПРОЙТИ ТЕСТ ЗАНОВО"
    }

})

function colorView(correctAnswers) {
    let q = $('.question').el
    Array.from(q).map((question, i) => {
        let answers = question.querySelectorAll('.a'),
            errors = []
        Array.from(answers).map((answer) => {
            let input = answer.getElementsByTagName('input')[0],
                answerId = input.id.replace("answer-", ""), // id question
                label = answer.getElementsByTagName('label')[0], // Чтобы прикрепить зеленый значек к этому элементу
                correctAnser = correctAnswers.indexOf(answerId) !== -1
            if (!checkCorrectAnswers(correctAnser, input, label)) {
                errors.push(true)
            }
        })

        let questId = +question.dataset['id'], // id question
            paginItem = $('.pagination [data-pagination="' + questId + '"]').el[0]
        if (errors.length) {
            $(paginItem).addClass('redShadow')
        } else {
            $(paginItem).addClass('greenShadow')
        }
    })
    return $('.redShadow').el.length
}

function checkCorrectAnswers(correctAnser, input, label) {
    if (input.checked && correctAnser) {// checkbox нажат. а в correct answer нету. в correct_answers есть, его всегда подсвечиваем зеленым
        label.classList.add('done'); //green check зеленый значек
        return true
    } else if (input.checked && !correctAnser) {// checkbox нажат,и есть в correct answer. в correct_answers нет, кнопка не нажата
        return false
    } else if (!input.checked && correctAnser) {// кнопка не нажата, в correct_answers есть
        label.classList.add('done'); //green check зеленый значек
        label.classList.add('done');// green check зеленый значек
        return false
    } else if (!input.checked && !correctAnser) {// кнопка не нажата, в correct_answers нет
        return true
    }
}

function objToServer(errorCnt) {
    return ({
        token: document.querySelector('meta[name="token"]').getAttribute('content'),
        questionCnt: $('.question').el.length,
        errorCnt: errorCnt,
        pageCache: `<!DOCTYPE ${document.doctype.name}>` + document.documentElement.outerHTML,
        testId: $('[data-test-id]').el[0].dataset.testId,
        test_name: $('.test-name').el[0].innerText,
        userName: $('.user-menu__FIO').el[0].innerText,
    })
}




