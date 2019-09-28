$(function () {

   function objProd(action) {
      return {
         token: $('#token').val(),
         url: '/adminsc',
         model: 'product',
         table: 'products',
         action: action ? action : 'update',
         pkey: 'id',
         pkeyVal: $('#id').text(),
         alias: $('#alias').text(),
         values: {}
      };
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
               var name = i.querySelector('span').innerText,
               len = el.options.length;
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
         filereader: typeof FileReader !== 'undefined',
         dnd: 'draggable' in document.createElement('span'),
         formdata: !!window.FormData
      },
      acceptedTypes = {
         'image/png': true,
         'image/jpeg': true,
         'image/gif': true
      };


      for (var i = 0; i < del.length; i++) {
         del[i].onclick = function () {
            delImg(this);
         };
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
            debugger;
            const fileContents = await readUploadedFileAsURI(file);
            const imgPath = await updateImg(file, this);
            if (imgPath!== 'Такая картинка уже есть!') {
               await insert(fileContents, this, imgPath);
            }
         };
      }

      fileupload.map(async function (i) {
         i.onchange = async function () {
            let file = i.files[0];
            let imageContainer = i.closest('.js-pic').querySelector('.new');
            const fileContents = readUploadedFileAsURI(file);
            let imgPath = await updateImg(this.files[0], i);
            if (imgPath) {
               await insert(fileContents, imageContainer, imgPath);
            }
         };
      });

      async function delImg(self) {
         var Obj = new objProd();
         debugger;
         Obj.action = 'delProductImg';
         Obj.isOnly = !!self.parentNode.querySelector('.js-one');
         Obj.delPath = self.getAttribute('data-del-id');
         Obj.sub = self.closest(".js-pic").getAttribute('data-pic-type');
         self.parentNode.querySelector('img').setAttribute('src', '/pic/srvc/nophoto-min.jpg');
         let sent = await fetchWrap(Obj);
         return sent;

      }

      function insert(cont, drop, imgPath) {

         let isOnly = !!drop.parentNode.querySelector('.js-one');
         if (isOnly) {
            drop.nextElementSibling.querySelector('img').setAttribute('src', cont);
         }
         else {
            let container = drop.nextElementSibling;
               debugger;
            if (container.querySelector('img').getAttribute('src')== '/pic/srvc/nophoto-min.jpg'){
               let container = drop.nextElementSibling;
               container.querySelector('span').onclick = function () {
                  delImg(this);
               };
               container.querySelector('img').setAttribute('src', cont);
               container.querySelector('span').setAttribute('data-del-id', imgPath);
               drop.after(container);
               
            }else{
               let container = drop.nextElementSibling.cloneNode(true);
               container.querySelector('span').onclick = function () {
                  delImg(this);
               };
               container.querySelector('img').setAttribute('src', cont);
               container.querySelector('span').setAttribute('data-del-id', imgPath);
               drop.after(container);
               
            } 

//            let spanDatas = Array.from(drop.parentNode.querySelectorAll('span'), i => {
//               return i.getAttribute('data-del-id')
//            }),
//            spanLastChild = +Math.max.apply(null, spanDatas)
//            drop.querySelector('span').setAttribute('data-del-id', spanLastChild + 1)
//         
//            var image = new Image();
//            image.width = 150; // a fake resize
//            image.src = cont;
//            drop.appendChild(image);
//            drop.classList.add('w200');
//            drop.classList.remove('new');
         }
      }

      async function fetchWrap(Obj, file) {
         let data = new FormData;
         data.append('ajax', true);
         data.append('param', JSON.stringify(Obj));
         file ? data.append('file', file) : '';
         let prom = await fetch(`/adminsc`, {
            body: data,
            method: 'post'
         });
         return prom.text();
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
         Obj.action = 'updateProductIMG';
         Obj.picType = elem.closest(".js-pic").getAttribute('data-pic-type');
         Obj.isOnly = !!elem.parentNode.querySelector('.js-one');
         let sent = await fetchWrap(Obj, file);
         return sent;
      }

   }

   check();
});