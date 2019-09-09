$(function () {

    function obj(action) {
        return {
            token: $('#token').val(),
            url: '/adminsc',
            model: 'category',
            table: 'category',
            action: action ? action : 'update',
            pkey: 'id',
            pkeyVal: 'nul',
            values: {}
        }
    }
    ;
// сохранить изменения
    $('#product-update-btn').on('click', function () {

        var Obj = new obj();
        Obj.pkeyVal = $('#id').text();

        Obj.values.act = document.querySelector('#act').checked ? 'Y' : 'N';
        Obj.values.name = $('#name').text();
        Obj.values.alias = $('#alias').text();
        Obj.values.dpic = $('#dpic').val();
        Obj.values.text = $('#text').text();
        Obj.values.title = $('#title').text();
        Obj.values.keywords = $('#keywords').text();
        Obj.values.description = $('#description').text();
        Obj.values.core = $('#core').text();

        var props = $('.work-area .category-properties');
        var prop = ({});
        var u = uniq(props);
        u.map((i) => {
            var d = i;
            var el = '';
            debugger;
            if (el = i.querySelector('select')) {
                prop.el.name = el.selected;
            } else if (el = i.querySelector('input')) {
//              prop.i.querySelector('span'):'dd';
            }
            ;
        });

        for (let val of props) {
            if (val.value)
                prop.push(val.value);
        }

        prop = uniq(prop);
        Obj.values.props = prop.join(',');
//      debugger;
        setTimeout(function () {
            post(Obj.url, Obj)
        }, 800);
    });


    function check() {

        var holder = document.getElementsByClassName('holder'),
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
                collItem = support[message[key]];
                for (var key1 = 0; key1 < collItem.length; ++key1) {
                    var item = collItem[key1]; // Вызов myNodeList.item(i) необязателен в JavaScript
                    item.className = 'hidden';
                }
            }
        }

        if (tests.dnd) {

            for (i = 0; i < holder.length; i++) {
                holder[i].ondragover = function () {
//               debugger;
                    this.classList.add('hover');
                    return false;
                };
                holder[i].ondragleave = function () {
                    this.classList.remove('hover');
                    return false;
                };
                holder[i].ondrop = function (e) {
//                    debugger;
//                    var fade = holder.querySelecror('svg, input, label')
//                    for (var i in fade){i.style.display = 'none'}
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

                    if (!imageContainer.getElementsByTagName('img').length == 0) {
                        var elem = imageContainer.getElementsByTagName('img')[0];
                        elem.remove();
                    }
                    var image = new Image();
                    if (imageContainer.getAttribute('data-prefix') == 'q') {
                        image.id = 'imq' + imageContainer.getAttribute('id');
                    } else if (imageContainer.getAttribute('data-prefix') == 'a') {
                        image.id = 'ima' + imageContainer.getAttribute('id');
                    }
                    image.src = event.target.result;
                    image.width = 150; // a fake resize
                    debugger;
                    imageContainer.style.justifyContent='center';
                    imageContainer.style.alignItems='center';
                    imageContainer.querySelector('svg').style.display='none';
                    imageContainer.querySelector('label').style.display='none';
//                    imageContainer.querySelector('svg').style.display='none';
                    imageContainer.appendChild(image);
                };
                reader.readAsDataURL(file);
            } else {
                holder.innerHTML += '<p>Загружен ' + file.name + ' ' + (file.size ? (file.size / 1024 | 0) + 'K' : '');
                console.log(file);
            }
        }

        function readfiles(files, elem) {

            var formData = tests.formdata ? new FormData() : null;
            for (var i = 0; i < files.length; i++) {
                var pref = elem.getAttribute('data-prefix');
                var fid = elem.id;
                if (tests.formdata) {
                    formData.append('file', files[i]);
//window.alert( files[i]['name']);
                    previewfile(files[i], elem);
                }
            }
            formData.append('pref', pref);
            formData.append('fid', fid);
// now post a new XHR request
            if (tests.formdata) {
                var xhr = new XMLHttpRequest();
//            controller = 'test';
//            if (window.location.pathname.indexOf('freetest') + 1) {
//               controller = 'freetest';
//            }
//            xhr.open('POST', `${PROJ}/${controller}/edit`, true);
                xhr.open('POST', `/adminsc`, true);
                xhr.send(formData);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState != 4) {
                        return
                    }
                    if (xhr.status != 200) {
                        alert(xhr.status + ': Ошибка' + xhr.statusText); // пример вывода: 404: Not Found
                    }
                }
            }
        }

    }

    check();

});