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
      del = document.querySelectorAll('.pic span'),
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

      for (i = 0; i < del.length; i++) {
         del[i].onclick = function () {
            debugger;
            let id = this.getAttribute('data-del-id')
            picType = this.parentNode.getAttribute('data-del-id')


         }
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
         holder[i].ondrop = async function (e) {
            e.preventDefault();
            this.classList.remove('hover');
            let file = e.dataTransfer.files[0];
            let imageContainer = this.parentNode.querySelector('.pic');
            const fileContents = await readUploadedFileAsURI(file);
            insert(file, fileContents, imageContainer);
            updateImg(file, this);
         };
      }

      fileupload.map(i => i.onchange = async (e) => {
            let file = this.files[0];
            let imageContainer = this.parentNode.parentNode.querySelector('.pic');
            const fileContents = await readUploadedFileAsURI(file);
            insert(file, fileContents, imageContainer);
            updateImg(this.files[0], this);
         }
      )

      function insert(file, cont, imageContainer) {
         let clone = imageContainer.cloneNode(true)
         if (!imageContainer.getElementsByTagName('img').length == 0) {
            var elem = imageContainer.getElementsByTagName('img')[0];
            elem.remove();
         }
         var image = new Image();
         image.src = cont;
         image.width = 150; // a fake resize
//         debugger;
//         image.setAttribute('data-pic-type', imageContainer.getAttribute('data-pic-type'));
         imageContainer.appendChild(image);
         if (!imageContainer.classList.contains('js-one')) {
            imageContainer.classList.add('w200');
            imageContainer.parentNode.appendChild(clone);
         }
      }

      const readUploadedFileAsURI = (inputFile) => {
         const temporaryFileReader = new FileReader();
         return new Promise((resolve, reject) => {
            temporaryFileReader.onerror = () => {
               temporaryFileReader.abort();
               reject(new DOMException("Problem parsing input file."));
            };
            temporaryFileReader.onload = () => {
               resolve(temporaryFileReader.result);
            };
            temporaryFileReader.readAsDataURL(inputFile);
         });
      };
      async function deleteImg(id, elem) {
         var Obj = new obj();
         var productName = document.querySelector('#alias').innerText;
         Obj.pkeyVal = $('#id').text();
         Obj.action = 'updateProductIMG';
         Obj.alias = $('#alias').text();
         Obj.picType = elem.getAttribute('data-pic-type');
         Obj.isOnly = !!elem.parentNode.querySelector('.js-one');
//         debugger;
         Obj.values.img = imgs(productName, file, elem);
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

      async function updateImg(file, elem) {
         var Obj = new obj();
         var productName = document.querySelector('#alias').innerText;
         Obj.pkeyVal = $('#id').text();
         Obj.action = 'updateProductIMG';
         Obj.alias = $('#alias').text();
         Obj.picType = elem.getAttribute('data-pic-type');
         Obj.isOnly = !!elem.parentNode.querySelector('.js-one');
//         debugger;
         Obj.values.img = imgs(productName, file, elem);
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


      function imgs(productName, file, elem) {

         const row = Array.from(document.querySelectorAll('.js-pic'))
         .reduce((acc, row, i) => {
            let saveInSizes = row.getAttribute('data-save-in-sizes');
            let name = row.getAttribute('data-pic-type'),
            paths = Array.from(row.querySelectorAll('img'))
            .reduce((prev, next, i) => {
               debugger;
               let productName = document.querySelector('#alias').innerText,
               obj = {};
//               obj['pic']= productName + '/' + name + '/' + (i + 1) + '/' + productName;
               let saveInSizes = row.getAttribute('data-save-in-sizes');
               dd = saveInSizes.split(',').reduce((start, next, i, arr) => {
//                  obj = {};
                  start[i] = productName + '/'+ name + '/' + (i + 1) + '/'+arr[i] +'/' + productName;
                  return start;
               }, {});

               obj['pics'] = dd;
               obj['title'] = productName + ' сбоку';
               obj['alt'] = productName + ' просто';
               prev[i] = obj;
               return prev;
            }, {});
//            let saveInSizes = row.getAttribute('data-save-in-sizes');
            acc['saveInSizes'] = saveInSizes,
            acc['title'] = 'дополнительные картинки',
            acc[name] = paths;
            return acc;

         }, {})
         return JSON.stringify(row);
      }
   }

   check();
}
);