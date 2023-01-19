import './open_test.scss'
import {$, post, cachePage} from "../common";

import '../components/accordion-show';
import pagination from "../components/pagination/pagination";


let openTest = $('.opentest-do')[0]
if (openTest) {
  pagination()
  showFirstQuest()
  $(openTest).on('click', handleClick)
  $(openTest).on('keyup', handleKeyup)
}

function showFirstQuest() {
  let firstQuest = $('.question')[0]
  if (firstQuest) firstQuest.classList.add('show')
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
  let id = target.dataset.id
  let activeQuestion = $('.question.show')[0]

  if (target.id === 'finish') {
    finish(target)
  }

  async function finish(target) {
    if (target.innerText === "ПРОЙТИ ТЕСТ ЗАНОВО") {
      location.reload();
      return;
    }
    let questions = await post('/adminsc/opentestresult/getanswers', {id})
    let correctAnswers = correctCount(questions.arr)
    let obj = objToServ(correctAnswers)
    let res = await post('/adminsc/opentestresult/finish', obj)
    if (res) {
      target.innerText = "ПРОЙТИ ТЕСТ ЗАНОВО"
      target.classList.add('inactive')
    }
  }

  function objToServ(rightAnswers) {
    $('.buttons')[0].remove()
    return {
      id,
      questionCnt: $('[data-pagination]').length,
      html: cachePage('.test'),
      testname: $('.test-name')[0].innerText,
      username: $('.user-menu .fio')[0].innerText,
      rightAnswers,
    }
  }
}

function correctCount(questions) {
  let correct = 0;
  [].forEach.call(questions, (q) => {
    let q_id = q.id
    let q_el = $(`.question[data-id='${q_id}']`)[0]
    let textarea = $(q_el).find('.textarea')
    if (!q.Openanswer) return
    let word = ''
    q.Openanswer.forEach((a) => {
      word += `(${a.answer})?`
    })
    correct += hilite(`${word}`, textarea, q_id)


  })
  return correct
}

function hilitePagination(id) {
  let pagination = $(`[data-pagination="${id}"]`)
  if (pagination) {
    pagination.css('backgroundColor', 'green')
  }
}

function hilite(word, element, q_id) {
  let text = element.innerHTML
  let rgxp = new RegExp(word, 'g');
  let arr = text.match(rgxp)
  let correct = 0

  arr.forEach((w) => {
    if (!w) return
    correct = 1
    let r = new RegExp(w, 'g')
    let repl = `<span style='color:limegreen;'>` + w + '</span>';
    element.innerHTML = element.innerHTML.replace(r, repl);
    hilitePagination(q_id)
  })
  return correct
}



