import {post} from '../../common'
import './dnd.scss'


export function check(url) {

    let holder = document.getElementsByClassName('holder'),
        tests = {
            filereader: typeof FileReader != 'undefined',
            dnd: 'draggable' in document.createElement('span'),
            formdata: !!window.FormData,
            progress: "upload" in new XMLHttpRequest
        },
        support = {
            filereader: document.querySelectorAll('.filereader'),
            formdata: document.querySelectorAll('.formdata'),
            progress: document.querySelectorAll('.progress')
        },
        acceptedTypes = {
            'image/png': true,
            'image/jpeg': true,
            'image/gif': true
        },
        progress = document.getElementById('uploadprogress'),
        fileupload = document.getElementById('upload'),
        message = "filereader formdata progress".split(' '); // преобразует строку в массив, разбив по сепаратору


    for (var key in message) { //(function (api)
        if (tests[message[key]] === false) {
            support[message[key]].className = 'fail'; // присвоим класс
        } else {
            let collItem = support[message[key]];
            for (var key1 = 0; key1 < collItem.length; ++key1) {
                var item = collItem[key1]; // Вызов myNodeList.item(i) необязателен в JavaScript
                item.className = 'hidden';
            }
        }
    }

    if (tests.dnd) {

        for (let i = 0; i < holder.length; i++) {
            holder[i].ondragover = function () {
                this.className = 'hover';
                this.style.width = '234px';
                this.style.height = '162px';
                return false;
            };
            holder[i].ondragleave = function () {
                this.className = 'holder';
                return false;
            };
            holder[i].ondragend = function () {
                this.className = '';
                return false;
            };
            holder[i].ondrop = function (e) {
                this.className = 'holder';
                e.preventDefault();
                readfiles(e.dataTransfer.files, this);
            };
        }

    } else {
        fileupload.className = 'hidden'; // прячем кнопку загрузки
        fileupload.querySelector('input').onchange = function () {// загружаем файлы
            readfiles(this.files);
        };
    }

    function previewfile(file, elem) {
        if (tests.filereader === true && acceptedTypes[file.type] === true) {
            var imageContainer = elem, //document.querySelector('#'+fid+' [data-prefix = "'+pref+'"]');
                reader = new FileReader();
            reader.onload = function (event) {

                if (imageContainer.getElementsByTagName('img').length) {
                    var elem = imageContainer.getElementsByTagName('img')[0];
                    elem.remove();
                }
                var image = new Image();
                if (imageContainer.getAttribute('data-prefix') === 'q') {
                    image.id = 'imq' + imageContainer.getAttribute('id');
                } else if (imageContainer.getAttribute('data-prefix') === 'a') {
                    image.id = 'ima' + imageContainer.getAttribute('id');
                }
                image.src = event.target.result;
                // image.width = 150; // a fake resize
                imageContainer.appendChild(image);
            };
            reader.readAsDataURL(file);
        } else {
            holder.innerHTML += '<p>Загружен ' + file.name + ' ' + (file.size ? (file.size / 1024 | 0) + 'K' : '');
            console.log(file);
        }
    }

    async function readfiles(files, elem) {
        let formData = new FormData()
        for (var i = 0; i < files.length; i++) {

            formData.append('file', files[i],  files[i]['name'])
            formData.append('type', elem.dataset['prefix'])
            formData.append('typeId', elem.id)

            previewfile(files[i], elem);
        }

        let res = await fetch(url,{
            method:'POST',
            body:formData})
    }


}
