
   
   $('#users').on('change', function(){
      crudUser('UPDATE',event.target);
   });
   
   function crudUser(crud, self) {

   debugger;
      var rightsStr = '',
      userId = self.prop('id'),
      tr = $('.' + userId)[0];
      rights = $(tr).find('.right')
      ;

      for (var i = 0; i < rights.length; i++) {
         if (rights[i].checked == true) {
            rightsStr += i + 1 + ',';
         };
      }
      rightsStr = rightsStr.replace(/,\s*$/, "");
//debugger;

      var data = {
         name: $(tr).find('.name').val(),
         sName: $(tr).find('.s-name').val(),
         mName: $(tr).find('.m-name').val(),
         bday: $(tr).find('.bday').val(),
         phone: $(tr).find('.phone').val(),
         conf: $(tr).find('.confirm').val(),
         email: $(tr).find('.email').val(),
         rightsStr: rightsStr,
         hired: $(tr).find('.hired').val(),
         fired: $(tr).find('.fired').val(),
         userId: userId,
         action: 'save',
         crud: crud,
      }
      post(PROJ + '/adminsc/users', data);
   };
   


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
      }
      post(PROJ + '/adminsc/users', data).then(function (str) {
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



