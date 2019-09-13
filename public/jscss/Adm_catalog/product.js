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


   function check(input) {

      var holder = document.getElementsByClassName('holder'),
      fileupload = Array.from(document.querySelectorAll('input[type="file"]')),
      tests = {
         filereader: typeof FileReader != 'undefined',
         dnd: 'draggable' in document.createElement('span'),
         formdata: !!window.FormData,
      },
      acceptedTypes = {
         'image/png': true,
         'image/jpeg': true,
         'image/gif': true
      }

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
            this.classList.remove('hover');
            previewfile(e.dataTransfer.files[0], this);
         };
      }

      fileupload.map(i => i.onchange = function () {
            previewfile(this.files[0], this);
         }
      )

      async function previewfile(file, elem) {
//         debugger;
         if (elem.nodeName == 'DIV') {
            var imageContainer = elem.parentNode.querySelector('.pic')
         }
         else {
            var imageContainer = elem.parentNode.parentNode.querySelector('.pic')
         }
         reader = new FileReader(),
         clone = imageContainer.cloneNode(true)
         ;
         let d = reader.onload = await function (event,file, elem) {
            debugger;
            if (!imageContainer.getElementsByTagName('img').length == 0) {
               var elem = imageContainer.getElementsByTagName('img')[0];
               elem.remove();
            }
            var image = new Image();
            image.src = event.target.result;
            image.width = 150; // a fake resize
            image.fileName = file['name'];
            image.setAttribute('data-pic-type', imageContainer.getAttribute('data-pic-type'));
            imageContainer.appendChild(image);
            if (!imageContainer.classList.contains('js-one')) {
               imageContainer.classList.add('w200');
               imageContainer.parentNode.appendChild(clone);
            }
         };
            debugger;
            save(file, elem);
         reader.readAsDataURL(file);

      }


      async function save(file, elem) {
         var Obj = new obj();
         var productName = document.querySelector('#name').innerText;
         Obj.pkeyVal = $('#id').text();
         Obj.action = 'updateMainPic';

         Obj.imgRole = elem.id == 'choose-main-pic' ? 'main' : 'dop';
         f = pics(productName, file, elem),
//         Obj.imgDopRole = picNamesToJson(productName, file, elem);
         Obj.alias = $('#alias').text();
         Obj.values.dpic = file['name'];

         var formData = tests.formdata ? new FormData() : null;

         if (tests.formdata) {
            formData.append('ajax', 'true');
            formData.append('param', JSON.stringify(Obj));
            formData.append('file', file, file['name']);
         }

         if (tests.formdata) {
            let promise = await fetch(`/adminsc`, {
               body: formData,
               method: 'post',
            });
         }
      }

      function picNamesToJson(productName, file, elem, row, ind) {
//         var name = elem.getAttribute('data-pic-type');
//         var obj = {};
         var ext = file['name'].slice(-4);
         var filePath = '/pic/' + productName + '/' + productName + ext;
//         obj = {filePath};
         return filePath;
      }
      function pics(productName, file, elem) {
         let rows = document.querySelectorAll('.js-pic'),
         row = {},
         arr = Array.from(rows),
         picArr = arr.map(row => {
            debugger;
            let obj = {};
            let name = elem.getAttribute('data-pic-type');
            let pic = row.querySelectorAll('img');
            let picA = Array.from(pic);
            let pics = picA.map((item, ind) => {
               let d = {};
               return d[ind] = picNamesToJson(productName, file, elem, item, ind)
            });
            return obj[name] = pics;
//            return pics;
         })
         return pics;
//         obj = picArr.map()

      }
   }



   check();

});