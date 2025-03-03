

window.onload = function () {


//////////////////////  ADD KEY Кнопка добавить ключевик ///////////////
   document.querySelector('.content').addEventListener('click', '.button_key', function () {
      document.querySelector('<input class = "input_key" type="text">').insertBefore(document.querySelector(this));
   },true)

///////////////////////   При изменении KEY_WORDS   ///////////////
   document.querySelector('.content').addEventListener('change', '.input_key', function () {
      var qid = this.parentNode.parentNode.querySelector('textarea').dataset.questionId,
          str = '', k,
          arrKeyWords = this.parentNode.querySelectorAll('.input_key');
      for (k = 0; k < arrKeyWords.length; k++) {
//                    debugger;
         var val = arrKeyWords[k].value;
         if (val) {
            str += (!k ? '' : ',') + val.trim();
         }
      }
      $.post("/freetest/edit", {"action": 'addKey', "qid": qid, "str": str});
   },true);
//////////////////////////////// Параметры Freetest///////////////



};