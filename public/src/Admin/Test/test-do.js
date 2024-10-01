import './test-do.scss'
import {$, cachePage, post} from '../../common.js'

export default class TestDo {
   constructor(test) {
      this.testDo = $('.test-do .content')[0];
      this.navs = $('[data-pagination]') ?? ''
      this.finishBtn = $('.test-do__finish-btn').first();

      this.showFirstQuest();
      this.finishBtnInit();
      this.testDo.addEventListener('click', this.handleClick.bind(this))

   }

   handleClick({target}) {
      const currQuest = $('.question.show')[0] ?? '';
      if (!currQuest) return;
      const id = +currQuest?.dataset.id ?? '';
      const navIndex = this.navs.findIndex(el => el.classList.contains('active')) ?? '';

      if (target.type === "checkbox") {
         const answer = target.labels[0];
         answer.classList.toggle('pushed')
      } else if (target.id === 'prev') {
         this.prevQ(id, navIndex)
      } else if (target.id === 'next') {
         this.nextQ()
      } else if (target === this.finishBtn) {
         this.finishTest(target).then()
      }


   }

   prevQ(id, navIndex) {
      if (navIndex < 1) return false;
      let aimId = +this.navs[navIndex - 1].dataset.pagination;
      this.pushNav(id, aimId);
      this.pushQ(aimId)
   }

   nextQ() {
      if (navIndex === navs.length - 1) return false;
      let aimId = +navs[navIndex + 1].dataset.pagination;

      pushNav(id, aimId);
      pushQ(aimId)
   }

   pushNav(currentId, aimNavId) {
      let currNavEl = $(`[data-pagination="${currentId}"]`)[0];
      currNavEl.classList.toggle('active');

      let NavEl = $(`[data-pagination="${aimNavId}"]`)[0];
      NavEl.classList.toggle('active')
   }

   pushQ(aimId) {
      currQuest.classList.toggle('show');
      let aimQuestion = $(`.question[data-id="${aimId}"]`)[0];
      aimQuestion.classList.toggle('show')
   }

   async finishTest(target) {

      if (target.innerText === "ПРОЙТИ ТЕСТ ЗАНОВО") {
         location.reload();
         return;
      }
      target.innerText = "ПРОЙТИ ТЕСТ ЗАНОВО";
      target.classList.add('inactive');

      let corrAnswers = await post('/adminsc/test/getCorrectAnswers', {});
      colorView(corrAnswers.arr);
      let errorCnt = $('.redShadow').length;

      let data = objToServer(errorCnt);
      let res = await post('/adminsc/testresult/create', data);
      if (res) {
         target.href = location.href;
         target.innerText = "ПРОЙТИ ТЕСТ ЗАНОВО"
      }
   }

   objToServer(errorCnt) {
      return {
         questionCnt: $('.question').length,
         errorCnt: errorCnt,
         html: cachePage('.test-do .content'),
         testid: $('[data-test-id]')[0].dataset.testId,
         testname: $('.test-name')[0].innerText,
         user: $('.user-menu .fio')[0].innerText,
      }
   }


   colorView(correctAnswers) {
      let questions = $('.question');
      [].map.call(questions, (question) => {
         let errors = colorQuestions(question, correctAnswers);
         colorPgination(question, errors)
      })
   }

   colorPgination(question, errors) {
      let id = question.dataset['id'];
      let paginItem = $(`.pagination [data-pagination='${+id}']`)[0];
      if (errors.length) {
         $(paginItem).addClass('redShadow')
      } else {
         $(paginItem).addClass('greenShadow')
      }
   }

   colorQuestions(question, correctAnswers) {
      let answers = question.querySelectorAll('.a');
      let errors = [];
      [].map.call(answers, (answer) => {
         let input = $(answer).find('input');
         let id = answer.dataset.id;
         let error = checkCorrectAnswers(id, correctAnswers, input, answer);
         if (error) errors.push(true)
      });
      return errors
   }

   checkCorrectAnswers(id, correctAnswers, input, answer) {
      let correctAnser = correctAnswers.indexOf(+id) !== -1;
      let checked = input.checked;
      let error = false;

      if (checked && correctAnser) {// checkbox нажат. а в correct answer нету. в correct_answers есть, его всегда подсвечиваем зеленым
         answer.classList.add('done'); //green check зеленый значек
      } else if (checked && !correctAnser) {// checkbox нажат,и есть в correct answer. в correct_answers нет, кнопка не нажата
         error = true
      } else if (!checked && correctAnser) {// кнопка не нажата, в correct_answers есть
         answer.classList.add('done'); //green check зеленый значек
         error = true
      } else if (!checked && !correctAnser) {// кнопка не нажата, в correct_answers нет
      }
      return error
   }

   finishBtnInit() {
      if (window.location.pathname.match('^/test/result/.?')) {
         this.finishBtn.classList.add('inactive')
      }
   }

   showFirstQuest() {
      $('.question').removeClass("show");
      $('.question:first-child').addClass("show")
   }


}







