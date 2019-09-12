$(function () {

   function obj(action) {
      return {
         token: $('#token').val(),
         url: '/adminsc',
         model: 'product',
         table: 'products',
         action: action ? action : 'update',
         pkey: 'id',
         pkeyVal: 'nul',
         values: {}
      }
   }
   ;
// сохранить изменения
   $('#product-update-btn').on('click', async function () {

      var Obj = new obj();
      Obj.pkeyVal = $('#id').text();

      Obj.values.act = document.querySelector('#act').checked ? 'Y' : 'N';
      Obj.values.name = $('#name').text();
      Obj.values.alias = $('#alias').text();
      Obj.values.dpic = $('#dpic').val();
      Obj.values.dtxt = $('#text').text();
      Obj.values.title = $('#title').text();
      Obj.values.keywords = $('#keywords').text();
      Obj.values.description = $('#description').text();
      Obj.values.core = $('#core').text();

      var props = $('.work-area .category-properties');
      var prop = ({});
      props = uniq(props);
      props.map((i) => {
         var el = '';
         if (el = i.querySelector('select')) {
            if (el.multiple) {
               debugger;
               var name = i.querySelector('span').innerText,
               len = el.options.length
               ;
               prop[name] = {};
               for (var d = 0; d < len; d++) {
                  if (el.options[d].selected === true) {
                     prop[name][d] = el.options[d].text;
                  }
               }
            }
            else {
               var name = i.querySelector('span').innerText,
               selectedInd = el.options.selectedIndex;
               prop[name] = el.options[selectedInd].text;
            }
         }
         else if (el = i.querySelector('input')) {
            var name = i.querySelector('span').innerText;
            prop[name] = el.value;
         }
         ;
      });
      prop = JSON.stringify(prop);
      Obj.values.props = prop;

      var d = await post(Obj.url, Obj);
      debugger;
   });


   function check() {

      var holder = document.getElementsByClassName('holder'),
      tests = {
         filereader: typeof FileReader != 'undefined',
         dnd: 'draggable' in document.createElement('span'),
         formdata: !!window.FormData,
      },
      acceptedTypes = {
         'image/png': true,
         'image/jpeg': true,
         'image/gif': true
      },
      fileupload = document.getElementById('choose-main-pic')

      if (tests.dnd) {

         for (i = 0; i < holder.length; i++) {
            holder[i].ondragover = function () {
               this.classList.add('hover');
               return false;
            };
            holder[i].ondragleave = function () {
               this.classList.remove('hover');
               return false;
            };
            holder[i].ondrop = function (e) {
               e.preventDefault();
               readfiles(e.dataTransfer.files, this);
            };
         }
      }
      else {
         fileupload.className = 'hidden'; // прячем кнопку загрузки
         fileupload.querySelector('input').onchange = function () {// загружаем файлы
            readfiles(this.files);
         };
      }

      function previewfile(file, elem) {

         var imageContainer = document.querySelector('.js-pic-main'),
         reader = new FileReader();
         reader.onload = function (event) {

            if (!imageContainer.getElementsByTagName('img').length == 0) {
               var elem = imageContainer.getElementsByTagName('img')[0];
               elem.remove();
            }
            var image = new Image();

            image.src = event.target.result;
            image.width = 150; // a fake resize
            image.fileName = file['name'];
            imageContainer.appendChild(image);
         };
         reader.readAsDataURL(file);
      }

      async function readfiles(files, elem) {

         var Obj = new obj();
         Obj.pkeyVal = $('#id').text();
         Obj.action = 'updateMainPic';
         
         Obj.imgRole = 'main';
         Obj.alias = $('#alias').text();
         Obj.values.dpic = files[0]['name'];

         var formData = tests.formdata ? new FormData() : null;
//            debugger;
         for (var i = 0; i < files.length; i++) {

            if (tests.formdata) {
               formData.append('ajax', 'true');
               formData.append('param', JSON.stringify(Obj));
               formData.append('file', files[i], files[i]['name']);
               previewfile(files[i], elem);
            }
         }
         if (tests.formdata) {
//            debugger;
            let promise = await fetch(`/adminsc`, {
               body: formData,
               method: 'post',
            });
         }
      }
   }

   check();

});