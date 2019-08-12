

//$('#users div[data-id]').on('change', function () {
//   crudUser('UPDATE', $(this));
//});

function crudUser(crud, target) {

    var rights = [];
    $('input:checkbox:checked').each(function () {
        rights.push($(this).data('id'));
    });
    rights = rights.join(',');
    let gxxx =$(target).find('#conf');
//    g=$(target).find('#conf').val();
    var data = {
        id: $.trim($(target).find('#id').text()),
        conf: $(target).find('#conf').val(),
        email: $.trim($(target).find('#email').text()),
        sName: $.trim($(target).find('#s-name').text()),
        name: $.trim($(target).find('#name').text()),
        mName: $.trim($(target).find('#m-name').text()),
        phone: $.trim($(target).find('#phone').text()),
        bday: $.trim($(target).find('#bday').val()),
        hired: $.trim($(target).find('#hired').val()),
        fired: $.trim($(target).find('#fired').val()),
        rights: rights,
        table: 'users',
        action: crud,
        model:'user'
    };
    debugger;
    var param = 'param=' + JSON.stringify(data);

//    debugger;
    $.ajax({
        url: '/adminsc/users',
        method: 'post',
        data: param,
        success: function (data) {
        }
    }).
            fail(function (err) {
                alert('сервер ответил ошибкой' + err)
            });
//      post('/adminsc/users', data);
}
;



$('.wrap').on('click', '.save', function () {
    var self = $('.wrap')[0];
    if (self.classList.contains('new')) {
        crudUser('INSERT', self);
    } else {
        crudUser('UPDATE', self);
    }
});


$('.wrap').on('click', '.btnadd-user', function () {
    var data = {
        action: 'addUser'
    };
    post('/adminsc/users', data).then(function (str) {
        $('tbody').append(str);
    });
});

function post(url, data) {
//      debugger;
    return new Promise(function (resolve, reject) {
        var req = new XMLHttpRequest();
        req.open('POST', url);
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        req.setRequestHeader('Content-Type', 'application/json');
        req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        req.send('param=' + JSON.stringify(data));
        req.onerror = function () {
            reject(Error("Network Error"));
        };
        req.onload = function () {
            resolve(req.response);
        };
    });
}



