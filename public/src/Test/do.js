import './do.scss'
import './test-pagination/test-pagination'

import {post, $, cachePage} from '../common'

let testDo = $('.test-do')
if (testDo) {
  showFirstQuest()
  finishBtnInit()
  $('.test-do').on('click', handleClick)
}

function finishBtnInit() {
  let button = $('.test-do__finish-btn')[0]
  if (button) {
    if (window.location.pathname.match('^/test/result/.?')) {
      button.classList.add('inactive')
    }
  }
}

function handleClick({target}) {
  if (target.classList.contains('accordion-open')) return
  let currQuest = $('.question.show')[0]??''
  let id = +currQuest?.dataset.id??''
  let navs = $('[data-pagination]')??''
  let navIndex = navs.findIndex(el=>el.classList.contains('active'))??''

  if (target.type === "checkbox") {
    let a = target.labels[0]
    a.classList.toggle('pushed')
  } else if (target.id === 'prev') {
    prevQ()
  } else if (target.id === 'next') {
    nextQ()
  }

  function prevQ() {
    if (navIndex < 1) return false
    let aimId = +navs[navIndex - 1].dataset.pagination
    pushNav(id, aimId)
    pushQ(aimId)
  }

  function nextQ() {
    if (navIndex === navs.length-1) return false
    let aimId = +navs[navIndex + 1].dataset.pagination

    pushNav(id, aimId)
    pushQ(aimId)
  }

  function pushNav(currentId, aimNavId) {
    let currNavEl = $(`[data-pagination="${currentId}"]`)[0]
    currNavEl.classList.toggle('active')

    let NavEl = $(`[data-pagination="${aimNavId}"]`)[0]
    NavEl.classList.toggle('active')
  }

  function pushQ(aimId) {
    currQuest.classList.toggle('show')
    let aimQuestion = $(`.question[data-id="${aimId}"]`)[0]
    aimQuestion.classList.toggle('show')
  }
}

function showFirstQuest() {
  $('.question').removeClass("show")
  $('.question:first-child').addClass("show")
}

$('.test-do__finish-btn').on('click', async function (e) {

  let button = e.target;
  if (button.id !== 'btnn') return false

  if (button.text === "ПРОЙТИ ТЕСТ ЗАНОВО") {
    location.reload();
    return;
  }
  button.text = "ПРОЙТИ ТЕСТ ЗАНОВО"

  button.classList.add('inactive')

  let corrAnswers = await post('/test/getCorrectAnswers', {})
  corrAnswers = corrAnswers['arr']
  let errorCnt = colorView(corrAnswers)

  let data = objToServer(errorCnt)
  let res = await post('/adminsc/testresult/cachePageSendEmail', {...data})
  if (res === 'ok') {
    $("#btnn")[0].href = location.href
    $("#btnn")[0].text = "ПРОЙТИ ТЕСТ ЗАНОВО"
  }
})


function objToServer(errorCnt) {
  return {
    questionCnt: $('.question').length,
    errorCnt: errorCnt,
    html: cachePage('.test-do'),
    testid: $('[data-test-id]')[0].dataset.testId,
    testname: $('.test-name')[0].innerText,
    user: $('.user-menu__fio')[0].innerText,
  }
}


function colorView(correctAnswers) {
  let q = $('.question');
  [].map.call(q, function (question) {
    let answers = question.querySelectorAll('.a')
    let errors = [];
    [].map.call(answers, function (answer) {
      let input = $(answer).find('input')
      let id = answer.dataset.id
      checkCorrectAnswers(errors, id, correctAnswers, input, answer)
    })

    let id = question.dataset['id'] // id question
    let paginItem = $(`.pagination [data-pagination='${+id}']`)[0]
    if (errors.length) {
      $(paginItem).addClass('redShadow')
    } else {
      $(paginItem).addClass('greenShadow')
    }
  })
  return $('.redShadow').length
}

function checkCorrectAnswers(errors, id, correctAnswers, input, answer) {
  let correctAnser = correctAnswers.indexOf(id) !== -1
  let checked = input.checked

  if (checked && correctAnser) {// checkbox нажат. а в correct answer нету. в correct_answers есть, его всегда подсвечиваем зеленым
    answer.classList.add('done'); //green check зеленый значек
  } else if (checked && !correctAnser) {// checkbox нажат,и есть в correct answer. в correct_answers нет, кнопка не нажата
    errors.push(true)
  } else if (!checked && correctAnser) {// кнопка не нажата, в correct_answers есть
    answer.classList.add('done'); //green check зеленый значек
    errors.push(true)
  } else if (!checked && !correctAnser) {// кнопка не нажата, в correct_answers нет
  }
}




