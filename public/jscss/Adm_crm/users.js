

$('#users div[data-id]').on('change', function () {
   crudUser('UPDATE', $(this));
});

function crudUser(crud, target) {

   var data = {
      
      name: $(target).find('.name').val(),
      sName: $(target).find('.s-name').val(),
      mName: $(target).find('.m-name').val(),
      bday: $(target).find('.bday').val(),
      phone: $(target).find('.phone').val(),
      conf: $(target).find('.confirm').val(),
      email: $(target).find('.email').val(),
      hired: $(target).find('.hired').val(),
      fired: $(target).find('.fired').val(),
      userId: $(target).data('id'),
      table: 'users',
      crud: crud
   };
var param = JSON.stringify(data);

   debugger;
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
   var self = $(this)[0];
   if (self.classList.contains('new')) {
      crudUser('INSERT', $(this));
   }
   else {
      crudUser('UPDATE', $(this));
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

async function  post(url, data) {
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



