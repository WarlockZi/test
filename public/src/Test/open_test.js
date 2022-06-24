import './open_test.scss'
import {$, post, cachePage, IsJson} from "../common";

import '../components/accordion-show';

let openTest = $('.opentest_wrap')[0]
if (openTest) {
  showFirstQuest()
  $(openTest).on('click', handleClick)

  $(openTest).on('keyup', handleKeyup)
}


function showFirstQuest() {
  let q = $('.question')[0].classList.add('show')
}

function handleKeyup({target}) {
  if (target.classList.contains('textarea')) {
    let activePagination = $('[data-pagination].active')[0]
    if (!target.innerText) {
      activePagination.classList.remove('filled')
    } else {
      activePagination.classList.add('filled')
    }
  }
}

async function handleClick({target}) {
  let testid = target.dataset.id
  let activeQuestion = $('.question.show')[0]
  let paginations = $('[data-pagination]')
  let activePagination = $('[data-pagination].active')[0]
  let i = paginations.indexOf(activePagination)

  if (target.id === 'prev') {
    prevQuest()
  } else if (target.id === 'next') {
    nextQuest()
  } else if (target.dataset.pagination) {
    paginate()
  // } else if (target.classList.contains('led')) {
  //   blink(target)
  } else if (target.id === 'finish') {
    finish(target)
  }

  async function finish(target) {
    if (target.innerText === "ПРОЙТИ ТЕСТ ЗАНОВО") {
      location.reload();
      return;
    }
    let questions = await getAnswers(testid)
    let correctAnswers = correctCount(questions.arr)
    let obj = objToServ(correctAnswers)
    let res = await post('/adminsc/opentestresult/finish', obj)
    if (res) {
      target.innerText = "ПРОЙТИ ТЕСТ ЗАНОВО"
      target.classList.add('inactive')
    }
  }

  function objToServ(rightAnswers) {
    return {
      testId: +testid,
      questionCnt: paginations.length,
      html: cachePage('.test'),
      testname: $('.test-name')[0].innerText,
      username: $('.user-menu .fio')[0].innerText,
      rightAnswers,
      // html: `<!DOCTYPE ${document.doctype.name}>` + document.documentElement.outerHTML,
    }

  }


  function paginate() {
    if (target === activePagination) return false
    let aimPagination = target
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  }

  function prevQuest() {
    if (i < 1) return false
    let aimPagination = paginations[i - 1]
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  }

  function nextQuest() {
    if (i > paginations.length - 2) return false
    let aimPagination = paginations[i + 1]
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  }
}


function correctCount(questions) {
  let correct = 0;
  [].forEach.call(questions,(q) => {
    let q_id = q.id
    let q_el = $(`.question[data-id='${q_id}']`)[0]
    let textarea = $(q_el).find('.textarea')
    if (!q.Openanswer) return
    let word = ''
    q.Openanswer.forEach((a) => {
      word += `(${a.answer})?`
    })
    correct += highlight(`${word}`, textarea, true)
  })
  return correct
}

function hiliter(word, element, addEventLis) {
  let text = element.innerHTML
  let rgxp = new RegExp(word, 'g');
  let arr = text.match(rgxp)
  let correct = 0

  arr.forEach((w) => {
    if (!w) return
    correct = 1
    let r = new RegExp(w, 'g')
    let repl = `<span style='color:red;'>` + w + '</span>';
    element.innerHTML = element.innerHTML.replace(r, repl);
  })
  return correct

}

function getAnswers(id) {
  return post('/adminsc/opentestresult/getanswers', {id})
}

function toggleNav(aimPagination, activePagination) {
  activePagination.classList.toggle('active')
  aimPagination.classList.toggle('active')
}

function toggleQuestion(aimPaginationId, activeQuestion) {
  let aimQuestionId = aimPaginationId.dataset.pagination
  let aimQuestion = $(`.question[data-id='${aimQuestionId}']`)[0]
  aimQuestion.classList.toggle('show')
  activeQuestion.classList.toggle('show')
}

function highlight(word, el, addEventLis) {
  return hiliter(word, el, addEventLis);
}

