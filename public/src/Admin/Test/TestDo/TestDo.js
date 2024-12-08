import './TestDo.scss'
import {$, cachePage, post} from '@src/common.js'
import {qa} from "@src/constants.js";

export default class TestDo {
   constructor(test) {
      this.navs = $('[data-pagination]') ?? ''
      this.finishBtn = $('.finish-test').first();

      $('.question').first().classList.add("show")
      this.inactivateFinishBtn();
      test.addEventListener('click', this.handleClick.bind(this))
   }

   handleClick({target}) {
      const id = +$('.question.show').first()?.dataset.id ?? 0;
      const navIndex = this.navs.findIndex(el => el.classList.contains('active')) ?? 0;

      if (target.type === "checkbox") {
         this.handleCheckboxChange(target)
         target.labels[0].classList.toggle('pushed')
      } else if (target.id === 'prev') {
         this.prevQ(id, navIndex)
      } else if (target.id === 'next') {
         this.nextQ(id, navIndex)
      } else if (target === this.finishBtn) {
         this.finishTest(target).then()
      }
   }

   handleCheckboxChange(target) {
      const checkboxes = target.closest('.question')[qa](`[type='checkbox']`);
      const checkedCheckboxes = [].filter.call(checkboxes, check => check.checked === true)

      const questionId = target.closest('.question').dataset.id
      const navItem = $('.navigation').find(`[data-pagination="${questionId}"]`)
      if (checkedCheckboxes) {
         navItem.classList.add('filled')
      } else {
         navItem.classList.remove('filled')
      }
   }

   prevQ(id, navIndex) {
      if (navIndex < 1) return false;
      const aimId = +this.navs[navIndex - 1].dataset.pagination;
      this.pushNav(id, aimId);
      this.pushQ(aimId)
   }

   nextQ(id, navIndex) {
      if (navIndex + 1 === this.navs.length) return false;
      const aimId = +this.navs[navIndex + 1].dataset.pagination;

      this.pushNav(id, aimId);
      this.pushQ(aimId)
   }

   pushNav(currentId, aimNavId) {
      $(`[data-pagination="${currentId}"]`).first().classList.toggle('active');
      $(`[data-pagination="${aimNavId}"]`).first().classList.toggle('active');
   }

   pushQ(aimId) {
      $('.question.show').first().classList.toggle('show')
      $(`.question[data-id="${aimId}"]`).first().classList.toggle('show');
   }

   async finishTest(target) {

      if (target.innerText === "ПРОЙТИ ТЕСТ ЗАНОВО") {
         location.reload();
         return;
      }
      target.innerText = "ПРОЙТИ ТЕСТ ЗАНОВО";
      target.classList.add('inactive');

      const corrAnswers = await post('/adminsc/test/getCorrectAnswers', {});
      this.colorView(corrAnswers.arr);
      const errorCnt = $('.redShadow').length;

      const data = this.DTO(errorCnt);
      const res = await post('/adminsc/testresult/create', data);
      if (res) {
         target.href = location.href;
         target.innerText = "ПРОЙТИ ТЕСТ ЗАНОВО"
      }
   }

   DTO(errorCnt) {
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
         let errors = this.colorQuestions(question, correctAnswers);
         this.colorPgination(question, errors)
      })
   }

   colorPgination(question, errors) {
      const id = question.dataset['id'];
      const paginItem = $(`.pagination [data-pagination='${+id}']`)[0];
      if (errors.length) {
         $(paginItem).addClass('redShadow')
      } else {
         $(paginItem).addClass('greenShadow')
      }
   }

   colorQuestions(question, correctAnswers) {
      const answers = question.querySelectorAll('.a');
      const errors = [];
      [].map.call(answers, (answer) => {
         const input = $(answer).find('input');
         const id = answer.dataset.id;
         const error = this.checkCorrectAnswers(id, correctAnswers, input, answer);
         if (error) errors.push(true)
      });
      return errors
   }

   checkCorrectAnswers(id, correctAnswers, input, answer) {
      const correctAnser = correctAnswers.indexOf(+id) !== -1;
      const checked = input.checked;
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

   inactivateFinishBtn() {
      if (window.location.pathname.match('^/test/result/.?')) {
         this.finishBtn.classList.add('inactive')
      }
   }
}