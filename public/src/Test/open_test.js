import './open_test.scss'
import {$, post, cachePage} from "../common";

import '../components/accordion-show';

let openTest = $('.opentest-do')[0]
if (openTest) {
  showFirstQuest()
  $(openTest).on('click', handleClick)
  $(openTest).on('keyup', handleKeyup)
}

function showFirstQuest() {
  $('.question')[0].classList.add('show')
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

  if (target.id === 'finish') {
    finish(target)
  }

  async function finish(target) {
    if (target.innerText === "ПРОЙТИ ТЕСТ ЗАНОВО") {
      location.reload();
      return;
    }
    let questions = await post('/adminsc/opentestresult/getanswers', testid)
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
      testId: +testid,
      questionCnt: paginations.length,
      html: cachePage('.test'),
      testname: $('.test-name')[0].innerText,
      username: $('.user-menu .fio')[0].innerText,
      rightAnswers,
    }
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
    correct += hiliter(`${word}`, textarea, true)

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

// function paginate() {
//   new Pagination({
//     paginateItemClass:'pagination',
//     paginateItemActive:'active',
//     objecClass:'question',
//     nextButtonId:'next',
//     prevButtonId:'prev',
//   })
// }

