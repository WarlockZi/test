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
         image.setAttribute('data-pic-type', imageContainer.getAttribute('data-pic-type'));
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
      
      async function updateImg(file, elem) {
         var Obj = new obj();
         var productName = document.querySelector('#name').innerText;
         Obj.pkeyVal = $('#id').text();
         Obj.action = 'updateProductIMG';
         let f = pics(productName, file, elem);
         Obj.alias = $('#alias').text();
//         debugger;
         Obj.picType = elem.getAttribute('data-pic-type');
         Obj.isOnly = !!elem.parentNode.querySelector('.js-one');
         Obj.values.img = f;
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

      function picNamesToJson(productName, file) {
         var ext = file['name'].slice(-4);
         return filePath = '/pic/' + productName + '/' + productName + ext;
      }
      
      function pics(productName, file, elem) {
         let row = {},
         arr = Array.from(document.querySelectorAll('.js-pic')),
         picArr = arr.map(row => {
            let obj = {};
            let name = row.querySelector('.holder').getAttribute('data-pic-type');
            let picA = Array.from(row.querySelectorAll('img'));
            let pics = picA.map((item, ind) => {
               let d = {};
               return d[ind] = picNamesToJson(productName, file)
            });
            obj[name] = pics;
            return obj;
         })
         debugger;
         return JSON.stringify(picArr);
      }
   }

   check();
}
);