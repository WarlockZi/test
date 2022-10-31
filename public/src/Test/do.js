import './do.scss'
import {post, $, cachePage} from '../common'
import pagination from "../components/pagination/pagination";

pagination()

let testDo = $('.test-do .content')[0]
if (testDo) {
  showFirstQuest()
  finishBtnInit()
  testDo.addEventListener('click', handleClick)
}

function handleClick({target}) {
  // if (target.classList.contains('accordion-open')) return
  let currQuest = $('.question.show')[0] ?? ''
  if (!currQuest) return
  let id = +currQuest?.dataset.id ?? ''
  let navs = $('[data-pagination]') ?? ''
  let navIndex = navs.findIndex(el => el.classList.contains('active')) ?? ''

  if (target.type === "checkbox") {
    let answer = target.labels[0]
    answer.classList.toggle('pushed')
  } else if (target.id === 'prev') {
    prevQ()
  } else if (target.id === 'next') {
    nextQ()
  } else if (target.classList.contains('test-do__finish-btn')) {
    finishTest(target)
  }

  function prevQ() {
    if (navIndex < 1) return false
    let aimId = +navs[navIndex - 1].dataset.pagination
    pushNav(id, aimId)
    pushQ(aimId)
  }

  function nextQ() {
    if (navIndex === navs.length - 1) return false
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

async function finishTest(target) {

  if (target.innerText === "ПРОЙТИ ТЕСТ ЗАНОВО") {
    location.reload();
    return;
  }
  target.innerText = "ПРОЙТИ ТЕСТ ЗАНОВО"
  target.classList.add('inactive')

  let corrAnswers = await post('/adminsc/test/getCorrectAnswers', {})
  colorView(corrAnswers.arr)
  let errorCnt = $('.redShadow').length

  let data = objToServer(errorCnt)
  let res = await post('/adminsc/testresult/create', data)
  if (res) {
    target.href = location.href
    target.innerText = "ПРОЙТИ ТЕСТ ЗАНОВО"
  }
}

function objToServer(errorCnt) {
  return {
    questionCnt: $('.question').length,
    errorCnt: errorCnt,
    html: cachePage('.test-do'),
    testid: $('[data-test-id]')[0].dataset.testId,
    testname: $('.test-name')[0].innerText,
    user: $('.user-menu .fio')[0].innerText,
  }
}


function colorView(correctAnswers) {
  let questions = $('.question');
  [].map.call(questions, (question)=> {
    let errors = colorQuestions(question, correctAnswers)
    colorPgination(question, errors)
  })
}

function colorPgination(question, errors) {
  let id = question.dataset['id']
  let paginItem = $(`.pagination [data-pagination='${+id}']`)[0]
  if (errors.length) {
    $(paginItem).addClass('redShadow')
  } else {
    $(paginItem).addClass('greenShadow')
  }
}

function colorQuestions(question, correctAnswers) {
  let answers = question.querySelectorAll('.a');
  let errors = [];
  [].map.call(answers, (answer)=> {
    let input = $(answer).find('input')
    let id = answer.dataset.id
    let error = checkCorrectAnswers(id, correctAnswers, input, answer)
    if (error)errors.push(true)
  })
  return errors
}

function checkCorrectAnswers(id, correctAnswers, input, answer) {
  let correctAnser = correctAnswers.indexOf(id) !== -1
  let checked = input.checked
  let error = false

  if (checked && correctAnser) {// checkbox нажат. а в correct answer нету. в correct_answers есть, его всегда подсвечиваем зеленым
    answer.classList.add('done'); //green check зеленый значек
  } else if (checked && !correctAnser) {// checkbox нажат,и есть в correct answer. в correct_answers нет, кнопка не нажата
    error = true
  } else if (!checked && correctAnser) {// кнопка не нажата, в correct_answers есть
    answer.classList.add('done'); //green check зеленый значек
    error =true
  } else if (!checked && !correctAnser) {// кнопка не нажата, в correct_answers нет
  }
  return error
}

function finishBtnInit() {
  let button = $('.test-do__finish-btn')[0]
  if (button) {
    if (window.location.pathname.match('^/test/result/.?')) {
      button.classList.add('inactive')
    }
  }
}

function showFirstQuest() {
  $('.question').removeClass("show")
  $('.question:first-child').addClass("show")
}





