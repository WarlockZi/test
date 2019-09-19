$(function () {

   function objProd(action) {
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

      var Obj = new objProd();
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
      for (var i = 0; i < del.length; i++) {
         del[i].onclick = function () {
            delImg(this)
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
            let file = e.dataTransfer.files[0],
            isOnly = !!this.parentNode.querySelector('.js-one');
            if (isOnly) {
               var imageContainer = this.parentNode.querySelector('.new');
            }
            else {
               var imageContainer = this.parentNode.querySelector('.new');
            }
            const fileContents = await readUploadedFileAsURI(file);
            insert(file, fileContents, imageContainer);
            updateImg(file, this);
         }
      }

      fileupload.map(function (i) {
         i.onchange = async function () {
            let file = i.files[0];
            let imageContainer = i.closest('.js-pic').querySelector('.new');
            const fileContents = await readUploadedFileAsURI(file);
            insert(file, fileContents, imageContainer);
            updateImg(this.files[0], i);
         }
      })


      async function delImg(self) {
         var Obj = new objProd();
         Obj.pkeyVal = $('#id').text();
         Obj.action = 'delProductImg';
         Obj.alias = $('#alias').text();
         Obj.picType = self.parentNode.parentNode.getAttribute('data-pic-type');
         Obj.isOnly = !!self.parentNode.querySelector('.js-one');
         Obj.deletableImgId = self.getAttribute('data-del-id');
         self.parentNode.remove();
         Obj.values.img = imgs(Obj.alias, null, self);
         fetchWrap(Obj);
      }



      function insert(file, cont, imageContainer) {
//            debugger;
         let clone = imageContainer.cloneNode(true),
         isOnly = !!imageContainer.parentNode.querySelector('.js-one')
         if (isOnly) {
            var elem = imageContainer.querySelector('img');
            elem.remove();
         }
         var image = new Image();
         image.width = 150; // a fake resize
         image.src = cont;
         imageContainer.appendChild(image);
         imageContainer.classList.add('w200');
         imageContainer.classList.remove('new');
//         debugger;
         if (!isOnly) {
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


      async function updateImg(file, elem) {
         var Obj = new objProd();
         var productName = document.querySelector('#alias').innerText;
         Obj.pkeyVal = $('#id').text();
         Obj.action = 'updateProductIMG';
         Obj.alias = $('#alias').text();
//         debugger;

         Obj.picType = elem.closest(".js-pic").getAttribute('data-pic-type');
         Obj.isOnly = !!elem.parentNode.querySelector('.js-one');
         Obj.values.img = imgs(productName, file, elem);

         fetchWrap(Obj, file);
      }
   }


   function imgs(productName, file, elem) {

      const row = Array.from(document.querySelectorAll('.js-pic'))
      .reduce((acc, row, i) => {
         let saveInSizes = row.getAttribute('data-save-in-sizes'),
         name = row.getAttribute('data-pic-type'),
         obj1 = {},
         paths = Array.from(row.querySelectorAll('img'))
         .reduce((prev, next, i) => {

            debugger;
            let productName = document.querySelector('#alias').innerText,
            fsId = next.closest('.pic').querySelector('[data-del-id]').getAttribute('data-del-id'),
  
            obj = {},
            saveInSizes = row.getAttribute('data-save-in-sizes'),
            dd = saveInSizes.split(',').reduce((start, next, i, arr) => {
               start[arr[i]] = productName + '-' + arr[i];
               return start;
            }, {});
            obj['pics'] = dd;
            obj['title'] = productName + ' сбоку';
            obj['alt'] = productName + ' просто';
//            obj['fsPicId'] = fsPicId;
            prev[fsId] = obj;
            return prev;
         }, {});
         obj1['saveInSizes'] = saveInSizes,
         obj1['title'] = row.getAttribute('data-title'),
         obj1['pics'] = paths;
         acc[name] = obj1;
         return acc;

      }, {})
      return JSON.stringify(row);
   }
      async function fetchWrap(Obj, file) {

         let data = new FormData;
         data.append('ajax', true);
         data.append('param', JSON.stringify(Obj));
         file ? data.append('file', file) : '';
         let promise = await fetch(`/adminsc`, {
            body: data,
            method: 'post',
         })
      }

   check();

});